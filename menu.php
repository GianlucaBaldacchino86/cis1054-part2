<?php
session_start(); // Start the session to store user favourites

$menu = [];
$csvFile = "CSVF/menu.csv";

// Load menu from the CSV
if (($fileHandle = fopen($csvFile, "r")) !== FALSE) {
    $columnHeaders = fgetcsv($fileHandle);
    while (($rowData = fgetcsv($fileHandle)) !== FALSE) {
        $menuItem = array_combine($columnHeaders, $rowData);
        $region = $menuItem['region'];
        $placement = $menuItem['placement'];
        $menu[$region][$placement][] = $menuItem;
    }
    fclose($fileHandle);
}

// Allows users to favourite items as well remove them
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_fav'])) {
    $dish = $_POST['toggle_fav'];
    if (!isset($_SESSION['favourites'])) $_SESSION['favourites'] = [];

    if (in_array($dish, $_SESSION['favourites'])) {
        $_SESSION['favourites'] = array_diff($_SESSION['favourites'], [$dish]);
    } else {
        $_SESSION['favourites'][] = $dish;
    }
    echo 'OK';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu | Lotus Fire</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/menu.css">
    <style>
        .heart {
            cursor: pointer;
            font-size: 24px;
            color: grey;
            user-select: none;
        }
        .heart.fav {
            color: red;
        }
    </style>
</head>
<body>
<!--Navbar at the top-->
<nav class="upnav">
    <div class="topnav">
        <div class="logo">
            <a href='home.html'>Lotus Fire</a>
        </div>
        <ul>
            <li><button onclick="location.href = 'menu.php'">Menu</button></li>
            <li><button onclick="location.href = 'Description.php'">Description</button></li>
            <li><button onclick="location.href='favourites.php'">Favourite</button></li>
            <li><button onclick="location.href='AboutUs.html'">About us</button></li>
            <li><button onclick="location.href='contactUs.php'">Contact Us</button></li>
        </ul>
    </div>
</nav>

<div class="content">
    <h1>Restaurant Menu</h1>
    <!--Sections Every region seperately in the menu-->
    <?php foreach ($menu as $region => $placements): ?>
        <div class="region">
            <h2><?= htmlspecialchars($region) ?></h2>
            <?php foreach ($placements as $placement => $dishes): ?>
                <div class="placement">
                    <h3><?= htmlspecialchars($placement) ?></h3>
                    <?php foreach ($dishes as $dish): 
                        $dishName = $dish['dish_name'];
                        $isFav = isset($_SESSION['favourites']) && in_array($dishName, $_SESSION['favourites']);
                    ?>  <!--Printing each dish-->
                        <div class="dish">
                            <img src="images/<?= htmlspecialchars($dish['image']) ?>" alt="<?= htmlspecialchars($dishName) ?>">
                            <div class="dish-text">
                                <strong><?= htmlspecialchars($dishName) ?></strong><br>
                                <em><?= htmlspecialchars($dish['description']) ?></em><br>
                                €<?= htmlspecialchars($dish['price']) ?><br>
                                <span class="heart <?= $isFav ? 'fav' : '' ?>" data-dish="<?= htmlspecialchars($dishName) ?>">&#10084;</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>

<!--Hearts changing colours + toggling favourites-->
<script>
document.querySelectorAll('.heart').forEach(heart => {
    heart.addEventListener('click', function() {
        const dish = this.dataset.dish;
        fetch('menu.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'toggle_fav=' + encodeURIComponent(dish)
        }).then(() => {
            this.classList.toggle('fav');
        });
    });
});
</script>
<footer>
    <p>&copy; 2025 Lotus Fire Restaurant. All rights reserved.</p>
</footer>

</body>
</html>
