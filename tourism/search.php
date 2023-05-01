<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style2.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha384-Q0lFDZL7S9XWmVN6HIv1UTG0QH4JB1DzG2IWwvCcNzLk27N/m9CpM3qMZc+T/ckF" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.13.1/theme/default/style.css" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.13.1/OpenLayers.js"></script>
    <title>Search</title>
</head>    
<body>
    <div class="menu_bar">
        <div id="menu_1">
            <a href="index.php">Home</a>
        </div>
        <div id="menu_4">
            Current Location&ensp;&ensp;
            <input type="text" id="place-Input" placeholder="Enter Your Location" onkeydown="if (event.keyCode === 13) addPlace()">
        </div>
        <div id="menu_5">
        <a href="./aboutus.php">About Us&ensp;</a>
        </div>
    </div>
    <div class="img_back">
        <img id="img_back" src="background2.jpg">
    </div>
<script>

    var input = document.getElementById("place-Input");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("add-btn").click();
            }
        });

    function addPlace() {
        var place1 = document.getElementById("place-Input").value;
        localStorage.setItem("currplace", place1);
        window.location.reload();
        
    }
</script>

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

// get the selected state from the form
$state = $_POST["state"];


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
$sql = "SELECT place,`comment`, `2012-FTV`, `2012-DTV`, `2013-FTV`, `2013-DTV`, `2014-FTV`, `2014-DTV`, `2015-FTV`, `2015-DTV`, `2016-FTV`,`2016-DTV`, `2018-FTV`, `2018-DTV`, `2019-FTV`, `2019-DTV`, `2020-FTV`, `2020-DTV`, `2021-FTV`, `2021-DTV`, `2022-FTV`, `2022-DTV`, SUBSTRING_INDEX(SUBSTRING_INDEX(`DESC`, '.', 2), '.', 2) as `DESC`, `RATING` 
FROM places 
WHERE State='$state' 
LIMIT $start_index, $places_per_page";
$result = mysqli_query($conn, $sql);

// loop through each row in the result set and generate a chart for each place
echo '<div class="containers">';
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $place = $row["place"];
    $ftv = array(
        $row["2012-FTV"], $row["2013-FTV"], $row["2014-FTV"], 
        $row["2015-FTV"], $row["2016-FTV"],
        $row["2018-FTV"], $row["2019-FTV"], $row["2020-FTV"], 
        $row["2021-FTV"], $row["2022-FTV"]
    );
    $dtv = array(
        $row["2012-DTV"], $row["2013-DTV"], $row["2014-DTV"], 
        $row["2015-DTV"], $row["2016-DTV"],
        $row["2018-DTV"], $row["2019-DTV"], $row["2020-DTV"], 
        $row["2021-DTV"], $row["2022-DTV"]
    );
    $description = $row["DESC"];
    $rating = $row["RATING"];

    // Prepare data for chart
    $labels = array("FTV", "DTV");
    $data = array($ftv[9], $dtv[9]);

    $ftv_2012 = $ftv[0];
    $dtv_2012 = $dtv[0];
    $ftv_2013 = $ftv[1];
    $dtv_2013 = $dtv[1];
    $ftv_2014 = $ftv[2];
    $dtv_2014 = $dtv[2];
    $ftv_2015 = $ftv[3];
    $dtv_2015 = $dtv[3];
    $ftv_2016 = $ftv[4];
    $dtv_2016 = $dtv[4];
    $ftv_2018 = $ftv[5];
    $dtv_2018 = $dtv[5];
    $ftv_2019 = $ftv[6];
    $dtv_2019 = $dtv[6];
    $ftv_2020 = $ftv[7];
    $dtv_2020 = $dtv[7];
    $ftv_2021 = $ftv[8];
    $dtv_2021 = $dtv[8];
    $ftv_2022 = $ftv[9];
    $dtv_2022 = $dtv[9];

    // generate chart HTML
    $chart_html = '<canvas id="myChart' . $i . '" width="200" height="200"></canvas>';

    // add chart HTML to container div
    echo '<div id="class_id' . $i . '" class="class_' . $i . '"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. $place .'</b>'  . $chart_html . '<p id="desc">' . $description . '</p><div id="place-image' . $i . '"></div><button id="butt1" onclick="openModal(\'modal' . $i . '\')">View Stats</button><button id="map-button" onclick="openModal(\'map-modal' . $i . '\')">Open Map</button></div>';
    
    echo '<div id="modal' . $i . '" class="modal">';
    echo '<div class="modal-content">';
    echo '<canvas id="chart' . $i . '"width="50" height="50"></canvas>';
    echo '<canvas id="2chart' . $i . '"width="50" height="50"></canvas>';
    echo '</div>';
    echo '</div>';
    echo '<p id="rating' . $i . '">Rating: ' . $rating . '</p>';
    
    echo '<div id="map-modal' . $i . '" class="modal">';
    echo '<div class="modal-content">';
    echo '<div id="map' . $i . '" style="width: 120rem; height: 50rem;"></div>';
    echo '</div>';
    echo '</div>';

    echo "<script>localStorage.setItem('place$i', '$place');</script>";

    echo "<script>var place" . $i . " = '" . $place . "';</script>";

    $labels = array("2023 Foreign Tousist Visits", "2023 Domestic Tourist Visits");
    $data = array($ftv, $dtv);


    $chart_script = '<script>var ctx = document.getElementById("chart' . $i . '").getContext("2d"); var myChart = new Chart(ctx, {type: "bar", data: {labels: ' . json_encode($labels) . ', datasets: [{label: "FTV", data: ' . json_encode($ftv) . ', backgroundColor: "rgba(255, 99, 132, 0.2)", borderColor: "rgba(255, 99, 132, 1)", borderWidth: 1}, {label: "DTV", data: ' . json_encode($dtv) . ', backgroundColor: "rgba(54, 162, 235, 0.2)", borderColor: "rgba(54, 162, 235, 1)", borderWidth: 1}]}, options: {scales: {yAxes: [{ticks: {beginAtZero: true}}]}}});</script>';
    echo $chart_script;
    

    $chart_script2 = '<script>var ctx2 = document.getElementById("2chart' . $i . '").getContext("2d"); var myChart2 = new Chart(ctx2, {type: "line", data: {labels: ' . json_encode($labels) . ', datasets: [{label: "FTV", data: ' . json_encode($ftv) . ', borderColor: "rgba(255, 206, 86, 1)", borderWidth: 2, fill: false}, {label: "DTV", data: ' . json_encode($dtv) . ', borderColor: "rgba(54, 162, 235, 1)", borderWidth: 2, fill: false}]}, options: {scales: {yAxes: [{ticks: {beginAtZero: true}}]}}});</script>';
    echo $chart_script2;

    echo "<script>var rating" . $i . " = '" . $rating . "';</script>";
    $i++;


}
echo '</div>';


// close the database connection
mysqli_close($conn);
?>




<script>
window.onload = function() {
    // Code here will run when the page finishes loading
    // Get the value from local storage
    var place1 = localStorage.getItem('place1');
    const unsplashAccessKey = "TpN7ZaQHryLejfFfC3Se29bkIlcPcq3XW_zrbYqxiAQ";
    const placeName = place1;

    // Fetch a random photo from Unsplash that matches the search query
    fetch(`https://api.unsplash.com/photos/random/?query=${placeName}&client_id=${unsplashAccessKey}`)
    .then(response => response.json())
    .then(data => {
        const imageUrl = data.urls.regular;
        const imageElement = document.createElement("img");
        imageElement.src = imageUrl;
        document.getElementById("place-image1").appendChild(imageElement);
    })
    .catch(error => console.error(error));

    // Get the value from local storage
    var place2 = localStorage.getItem('place2');
    const placeName2 = place2;

    // Fetch a random photo from Unsplash that matches the search query
    fetch(`https://api.unsplash.com/photos/random/?query=${placeName2}&client_id=${unsplashAccessKey}`)
    .then(response => response.json())
    .then(data => {
        const imageUrl = data.urls.regular;
        const imageElement = document.createElement("img");
        imageElement.src = imageUrl;
        document.getElementById("place-image2").appendChild(imageElement);
    })
    .catch(error => console.error(error));

    // Get the value from local storage
    var place3 = localStorage.getItem('place3');
    const placeName3 = place3;

    // Fetch a random photo from Unsplash that matches the search query
    fetch(`https://api.unsplash.com/photos/random/?query=${placeName3}&client_id=${unsplashAccessKey}`)
    .then(response => response.json())
    .then(data => {
        const imageUrl = data.urls.regular;
        const imageElement = document.createElement("img");
        imageElement.src = imageUrl;
        document.getElementById("place-image3").appendChild(imageElement);
    })
    .catch(error => console.error(error));
};
</script>





<script>
function openModal(modalId) {
// Get the modal element
var modal = document.getElementById(modalId);

// Show the modal
modal.style.display = "block";

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}
}
</script>





<script>
function createMap(mapId, address) {
    var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(address);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                var lat1 = data[0].lat;
                var lon1 = data[0].lon;

                var map = new OpenLayers.Map(mapId);
                var osm = new OpenLayers.Layer.OSM();
                map.addLayer(osm);
                map.setCenter(new OpenLayers.LonLat(lon1, lat1).transform(
                    new OpenLayers.Projection("EPSG:4326"),
                    map.getProjectionObject()
                ), 12);
                
                // Set the zoom level for the map
                map.zoomTo(12);

                var markerLayer = new OpenLayers.Layer.Markers("Markers");
                map.addLayer(markerLayer);

                var lonLat = new OpenLayers.LonLat(lon1, lat1).transform(
                    new OpenLayers.Projection("EPSG:4326"),
                    map.getProjectionObject()
                );
                var marker = new OpenLayers.Marker(lonLat);
                markerLayer.addMarker(marker);

                var currplace = localStorage.getItem("currplace");
                if (currplace) {
                    var url2 = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(currplace);
                    fetch(url2)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                var lat2 = data[0].lat;
                                var lon2 = data[0].lon;

                                var lonLat2 = new OpenLayers.LonLat(lon2, lat2).transform(
                                    new OpenLayers.Projection("EPSG:4326"),
                                    map.getProjectionObject()
                                );
                                var currMarker = new OpenLayers.Marker(lonLat2);
                                markerLayer.addMarker(currMarker);
                                
                                var vectorLayer = new OpenLayers.Layer.Vector("Road Path");
                                map.addLayer(vectorLayer);
                                
                                var startPoint = new OpenLayers.Geometry.Point(lon1, lat1).transform(
                                    new OpenLayers.Projection("EPSG:4326"),
                                    map.getProjectionObject()
                                );
                                var endPoint = new OpenLayers.Geometry.Point(lon2, lat2).transform(
                                    new OpenLayers.Projection("EPSG:4326"),
                                    map.getProjectionObject()
                                );
                                var lineString = new OpenLayers.Geometry.LineString([startPoint, endPoint]);
                                var feature = new OpenLayers.Feature.Vector(lineString);
                                vectorLayer.addFeatures([feature]);
                            } else {
                                console.log("No results found for current location");
                            }
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }

            } else {
                console.log("No results found");
            }
        })
        .catch(error => {
            console.error(error);
        });
}

var address1 = localStorage.getItem('place1');
var address2 = localStorage.getItem('place2');
var address3 = localStorage.getItem('place3');

createMap('map1', address1);
createMap('map2', address2);
createMap('map3', address3);




// To set color for container

console.log(rating1);

// get the three items
var item1 = document.getElementById("class_id1");
var item2 = document.getElementById("class_id2");
var item3 = document.getElementById("class_id3");


// set the background color based on the rating value
if (rating1 > 4) {
  item1.style.backgroundColor = "green";
} else if (rating1 > 3 && rating1 <= 4) {
  item1.style.backgroundColor = "yellowgreen";
} else if (rating1 > 2 && rating1 <=3) {
  item1.style.backgroundColor = "darkgoldenrod";
} else if ( rating1 <= 2) {
  item1.style.backgroundColor = "red";
} 

if (rating2 > 4) {
  item2.style.backgroundColor = "green";
} else if (rating2 > 3 && rating2 <= 4) {
  item2.style.backgroundColor = "yellowgreen";
} else if (rating2 > 2 && rating2 <=3) {
  item2.style.backgroundColor = "darkgoldenrod";
} else if ( rating2 <= 2) {
  item2.style.backgroundColor = "red";
} 

if (rating3 > 4) {
  item3.style.backgroundColor = "green";
} else if (rating3 > 3 && rating3 <= 4) {
  item3.style.backgroundColor = "yellowgreen";
} else if (rating3 > 2 && rating3 <=3) {
  item3.style.backgroundColor = "darkgoldenrod";
} else if ( rating3 <= 2) {
  item3.style.backgroundColor = "red";
} 





</script>

    
</body>
</html>