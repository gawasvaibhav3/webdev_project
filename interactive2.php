<?php
// Connect to database
$conn = mysqli_connect("localhost", "root", "", "database1");

// Retrieve data from places table for Goa
$sql = "SELECT place, `2011-ftv`, `2012-ftv`, `2013-ftv`, `2014-ftv`, `2015-ftv` FROM places WHERE state = 'Goa' AND place = 'Miramar beach'";
$result = mysqli_query($conn, $sql);

// Create arrays for chart data
$years = array();
$ftv = array();

while ($row = mysqli_fetch_assoc($result)) {
    $years = array_keys($row);
    $ftv = array_values($row);
    $place = $row['place'];
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
        type: 'line',
        data: {
            labels: <?php echo json_encode($years); ?>,
            datasets: [{
                label: '<?php echo $place; ?>',
                data: <?php echo json_encode($ftv); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                fill: false
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
