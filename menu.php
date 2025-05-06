<?php



$menu = [];//an empty array is initialised to hold menu items


$csvFile = "menu.csv";

//Code below is used to open the csv file
if (($fileHandle = fopen($csvFile, "r")) !== FALSE) {
    //The if statement above is used tp check if the file was opened successfully

    $columnHeaders = fgetcsv($fileHandle);//This insures that the first row is read as column headers

    //The rest of the CSV rows are then read and processed
    while (($rowData = fgetcsv($fileHandle)) !== FALSE) {
        //The while loop will stop when there are no more rows to read i.e empty rows

        $menuItem = array_combine($columnHeaders, $rowData);//Here headers and data are combined into an associative array

        //The values below will be used as keys to access the menu items
        $region = $menuItem['region'];//The region of the menu item is extracted 
        $placement = $menuItem['placement'];//the placement of the menu item is extracted

        
        $menu[$region][$placement][] = $menuItem;//the item is added to the menu array using the region and placement as keys
    }

    
    fclose($fileHandle);//The file is closed once its been read
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Menu</title>
    <!-- Link the html part to the css files -->
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/menu.css">
</head>
<body>
<nav class = "upnav">
    <div class="topnav">
        <div class="logo">
            <a href = 'home.html'>Lotus Fire</a>
        </div>
        <ul>
            <li><button onclick="location.href='#menu'">Menu</button></li>
            <li><button onclick="location.href='#favourite'">Favourite</button></li>
            <li><button onclick="location.href='#about'">About us</button></li>
            <li><button onclick="location.href='contactUs.html'">Contact Us</button></li>
        </ul>
    </div>
    </nav>
    <div class="content">
    <h1>Restaurant Menu</h1>

    <?php foreach ($menu as $region => $placements): ?>
        <!-- The foreach loop is used to loop through each region in the menu array and assign it to the region variable  -->
        <div class="region"> 
            <h2><?= htmlspecialchars($region) ?></h2> <!-- this is used to display the region name as a header -->
            <?php foreach ($placements as $placement => $dishes): ?>
                <!-- the foreach loop above is used to loop through each placement in the menu array and assign it to variable placement -->
                <div class="placement">

                    <h3><?= htmlspecialchars($placement) ?></h3> <!-- This is used to display the placement name as a header -->
                    
                    <?php foreach ($dishes as $dish): ?> 
                        <!-- The foreach loop is used to loop through each dish in the current placement!-->
                        <div class="dish">
                            <!-- This div is used to display the dish's picture, it'sname, description and price -->
                            <img src="images/<?= htmlspecialchars($dish['image']) ?>" alt="<?= htmlspecialchars($dish['dish_name']) ?>">
                            <div class="dish-text">
                                <strong><?= htmlspecialchars($dish['dish_name']) ?></strong><br>
                                <em><?= htmlspecialchars($dish['description']) ?></em><br>
                                €<?= htmlspecialchars($dish['price']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
</div>

</body>
</html>
