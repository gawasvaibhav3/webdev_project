<!DOCTYPE html>
<html>
<head>
    <title>Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <form method="post">
        <label for="state">Select State:</label>
        <select id="state" name="state">
            <option value="" disabled selected>Select State</option>
            <?php foreach($states as $state) { ?>
                <option value="<?php echo $state ?>"><?php echo $state ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="place">Select Place:</label>
        <select id="place" name="place" disabled>
            <option value="" disabled selected>Select Place</option>
        </select>
        <br>
        <label for="chart">Select Chart:</label>
        <select id="chart" name="chart" disabled>
            <option value="" disabled selected>Select Chart</option>
            <option value="bar">Bar Chart</option>
            <option value="line">Line Chart</option>
        </select>
        <br>
        <button type="submit" name="submit" disabled>Submit</button>
    </form>

    <div id="chart-container" style="width: 800px; height: 400px;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        var placeSelect = document.getElementById("place");
        var chartSelect = document.getElementById("chart");
        var submitBtn = document.querySelector('button[type="submit"]');

        document.getElementById("state").addEventListener("change", function() {
            placeSelect.disabled = true;
            chartSelect.disabled = true;
            submitBtn.disabled = true;
            placeSelect.innerHTML = '<option value="" disabled selected>Select Place</option>';

            if (this.value !== "") {
                fetch('get_places.php?state=' + this.value)
                .then(response => response.json())
                .then(function(data) {
                    placeSelect.disabled = false;
                    data.forEach(function(place) {
                        placeSelect.innerHTML += '<option value="' + place + '">' + place + '</option>';
                    });
                });
            }
        });

        document.getElementById("place").addEventListener("change", function() {
            chartSelect.disabled = true;
            submitBtn.disabled = true;

            if (this.value !== "") {
                chartSelect.disabled = false;
            }
        });

        document.getElementById("chart").addEventListener("change", function() {
            if (this.value !== "") {
                submitBtn.disabled = false;
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();

            var state = document.getElementById("state").value;
            var place = document.getElementById("place").value;
            var chart = document.getElementById("chart").value;

            fetch('get_chart_data.php?state=' + state + '&place=' + place)
            .then(response => response.json())
            .then(function(data) {
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: chart,
                    data: {
                        labels: data.years,
                        datasets: [{
                            label: data.place + ' FTV',
                            data: data.ftv,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
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
