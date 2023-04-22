<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Search</title>
</head>
<body>
    <div class="menu_bar">
        <div id="menu_1">
        <a href="index.php">Home</a>
        </div>
        <div id="menu_2">
            Famous Places&ensp;&ensp;
        </div>
        <div id="menu_3">
            Help&ensp;&ensp;
        </div>
        <div id="menu_4">
            Current Location&ensp;&ensp;
        </div>
        <div id="menu_5">
            About Us&ensp;&ensp;
        </div>
    </div>
    <div class="img">
        <img src="background2.jpg">
    </div>

    <?php
        // connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "database1";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // get the selected state from the query string
        $state = $_GET["state"];

        // get the total number of places for the selected state
        $sql_count = "SELECT COUNT(*) FROM places WHERE State='$state'";
        $result_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_row($result_count);
        $total_places = $row_count[0];

        // calculate the total number of pages required to display all the places
        $places_per_page = 3;
        $total_pages = ceil($total_places / $places_per_page);

        // get the current page number from the query string
        $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;

        // calculate the starting index of the places to display on the current page
        $start_index = ($current_page - 1) * $places_per_page;

        // query the database to get the places for the selected state
        $sql = "SELECT place, `2022-FTV`, `2022-DTV`, SUBSTRING_INDEX(`DESC`, '\n', 1) as `DESC`, `RATING` 
        FROM places 
        WHERE State='$state' 
        LIMIT $start_index, $places_per_page";
        $result = mysqli_query($conn, $sql);

        // loop through each row in the result set and generate a chart for each place
        echo '<div class="containers">';
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $place = $row["place"];
            $ftv = $row["2022-FTV"];
            $dtv = $row["2022-DTV"];
            $description = $row["DESC"];
            $rating = $row["RATING"];

            // Prepare data for chart
            $labels = array("FTV", "DTV");
            $data = array($ftv, $dtv);

            // generate chart HTML
            $chart_html = '<canvas id="myChart' . $i . '" width="200" height="200"></canvas>';

            // add chart HTML to container div
            echo '<div class="' . $i . '"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $place .'</b>'  . $chart_html . '<p id="desc">Description: ' . $description . '</p><p id="rating">Rating: ' . $rating . '</p></div>';

            // generate chart JS for this place
            echo '<script>
                var ctx' . $i . ' = document.getElementById("myChart' . $i . '").getContext("2d");
                var chart' . $i . ' = new Chart(ctx' . $i . ', {
                    type: "bar",
                    data: {
                        labels: ' . json_encode($labels) . ',
                        datasets: [{
                            label: "Tourist visits",
                            data: ' . json_encode($data) . ',
                            backgroundColor: "rgba(54, 162, 235, 0.5)",
                            borderColor: "rgba(54, 162, 235, 1)",
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            </script>';

            $i++;
        }

                // display the navigation links to go to the previous and next pages
                echo "<div clas>";
                if ($current_page > 1) {
                    $prev_page = $current_page - 1;
                    echo "<a id='prev' href='search2.php?state=$state&page=$prev_page'>Previous</a> ";
                }
                if ($current_page < $total_pages) {
                    $next_page = $current_page + 1;
                    echo "<a id='next' href='search2.php?state=$state&page=$next_page'>Next</a>";
                }
                echo "</div>";

                // Prepare data for chart
                $labels = array();
                $data = array();
                mysqli_data_seek($result, 0); // reset result pointer
                while ($row = mysqli_fetch_assoc($result)) {
                    $place = $row['place'];
                    $ftv = $row['2022-FTV'];
                    $dtv = $row['2022-DTV'];
                    $total = $ftv + $dtv;
                    array_push($labels, $place);
                    array_push($data, $total);
                }

                // close the database connection
                mysqli_close($conn);
    ?>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Tourist visits',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
						}
					}]
				}
			}
		});
</script>

</body>
</html>
