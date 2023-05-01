<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style1.css">
    <title>Travel Recommender</title>
</head>
<body>
    <div class="menu_bar">
        <div id="menu_1">
        <a href="index.php">Home</a>
        </div>
        <div id="menu_5">
        <a href="./aboutus.php">About Us&ensp;</a>
        </div>
    </div>
    <div id="background_image">
        <img src="background.jpg" usemap="#workmap">

        <map name="workmap" >
            <area id="travel" target="" alt="" title="" href="./search.php" coords="505,561,446,543,440,365,400,363,400,328,536,328,540,361,497,363,514,565,543,563,563,555,558,330,587,326,615,326,637,326,661,330,684,337,701,354,708,379,708,403,701,423,688,434,673,440,686,469,708,528,725,526,773,324,824,321,873,497,907,484,918,489,877,321,930,321,960,447,982,317,1037,315,991,526,1029,544,1061,539,1053,317,1169,313,1171,348,1114,346,1112,407,1154,409,1156,442,1114,442,1116,513,1178,511,1176,541,1196,541,1191,313,1248,313,1255,511,1310,510,1310,537,1160,541,1050,541,1018,537,925,495,910,484,884,495,864,500,787,502,782,510,734,521,712,532,699,539,659,541,626,449,615,449,620,544,596,550,582,550,563,554,545,565,514,565,505,561" shape="poly">
        </map>
    </div>
    
    <div class="search">
        <form action="search.php" method="post">
            <label for="state">State State</label>
            <select id="state" name="state">
                <option value=""></option>
                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                <option value="Assam">Assam</option>
                <option value="Bihar">Bihar</option>
                <option value="Chandigarh">Chandigarh</option>
                <option value="Daman and Diu">Daman and Diu</option>
                <option value="Delhi">Delhi</option>
                <option value="Goa">Goa</option>
                <option value="Gujarat">Gujarat</option>
                <option value="Haryana">Haryana</option>
                <option value="Himachal Pradesh">Himachal Pradesh</option>
                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                <option value="Jharkhand">Jharkhand</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Lakshdweep">Lakshdweep</option>
                <option value="Madhya Pradesh">Madhya Pradesh</option>
                <option value="Maharashtra">Maharashtra</option>
                <option value="Meghalaya">Meghalaya</option>
                <option value="Mizoram">Mizoram</option>
                <option value="Nagaland">Nagaland</option>
                <option value="Odisha">Odisha</option>
                <option value="Puduchery">Puduchery</option>
                <option value="Punjab">Punjab</option>
                <option value="Rajasthan">Rajasthan</option>
                <option value="Sikkim">Sikkim</option>
                <option value="Tamil nadu">Tamil nadu</option>
                <option value="Tripura">Tripura</option>
                <option value="Uttar Pradesh">Uttar Pradesh</option>
                <option value="Uttarakhand">Uttarakhand</option>
                <option value="West Bengal">West Bengal</option>
            </select>
            <input type="submit" value="Show Places">
        </form>
    <script>
        // Get the select element
        const selectElement = document.getElementById("state");

        // Add event listener to listen for changes
        selectElement.addEventListener("change", (event) => {
            // Get the selected value
            const selectedValue = event.target.value;

            // Store the selected value in session storage
            sessionStorage.setItem("selectedCategory", selectedValue);
        });

    </script>
    </div>
    <div class="containers">
        <div id="c1">
            
        </div>
        <div id="c2">

        </div>
        <div id="c3">

        </div>
        <div id="c4">

        </div>
        <div id="c5">

        </div>
    </div>

</body>
</html>