<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "database1");

// Retrieve data from places table for Goa only
$sql = "SELECT place, `2011-ftv`, `2012-ftv`, `2013-ftv`, `2014-ftv`, `2015-ftv` FROM places WHERE state = 'Goa'";
$result = mysqli_query($conn, $sql);

// Create arrays for chart data
$places = array();
$ftv2011 = array();
$ftv2012 = array();
$ftv2013 = array();
$ftv2014 = array();
$ftv2015 = array();

while ($row = mysqli_fetch_assoc($result)) {
    $places[] = $row['place'];
    $ftv2011[] = $row['2011-ftv'];
    $ftv2012[] = $row['2012-ftv'];
    $ftv2013[] = $row['2013-ftv'];
    $ftv2014[] = $row['2014-ftv'];
    $ftv2015[] = $row['2015-ftv'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart"></canvas>

    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($places); ?>,
            datasets: [{
                label: '2011 FTV',
                data: <?php echo json_encode($ftv2011); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: '2012 FTV',
                data: <?php echo json_encode($ftv2012); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: '2013 FTV',
                data: <?php echo json_encode($ftv2013); ?>,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: '2014 FTV',
                data: <?php echo json_encode($ftv2014); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: '2015 FTV',
                data: <?php echo json_encode($ftv2015); ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
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
