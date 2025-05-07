<?php

$menu = []; // Initialize an empty array

$csvFile = "CSVF/Description.csv";

// Open the CSV file
if (($fileHandle = fopen($csvFile, "r")) !== FALSE) {
    $columnHeaders = fgetcsv($fileHandle); // Read the first row as headers

    while (($rowData = fgetcsv($fileHandle)) !== FALSE) {
        $menuItem = array_combine($columnHeaders, $rowData); // Combine headers and values
        $menu[] = $menuItem; // Add each item to the menu array
    }

    fclose($fileHandle); // Close the file
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Menu Description</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/Description.css">
</head>
<body>

<nav class="upnav">
    <div class="topnav">
        <div class="logo">
            <a href='home.html'>Lotus Fire</a>
        </div>
        <ul>
            <li><button onclick="location.href='#menu'">Menu</button></li>
            <li><button onclick="location.href='#favourite'">Favourite</button></li>
            <li><button onclick="location.href='#about'">About us</button></li>
            <li><button onclick="location.href='#contact'">Contact Us</button></li>
        </ul>
    </div>
</nav>

<div class="content">
    <h1>Restaurant Menu Description</h1>

    <?php foreach ($menu as $dish): ?>
        <div class="dish">
            <div class="dish-text">
                <strong><?= htmlspecialchars($dish['dish_name']) ?></strong><br>
                <em><?= htmlspecialchars($dish['description']) ?></em>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
