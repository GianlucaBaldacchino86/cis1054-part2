<?php
session_start();

// Add new favourites from form submission (checkboxes)
if (isset($_POST['favourites'])) {
    if (!isset($_SESSION['favourites'])) {
        $_SESSION['favourites'] = [];
    }

    foreach ($_POST['favourites'] as $dish) {
        if (!in_array($dish, $_SESSION['favourites'])) {
            $_SESSION['favourites'][] = $dish; // Only add if not already in the list
        }
    }
}

// Handle item removal
if (isset($_GET['remove'])) {
    $removeItem = $_GET['remove'];
    if (($key = array_search($removeItem, $_SESSION['favourites'])) !== false) {
        unset($_SESSION['favourites'][$key]);
        $_SESSION['favourites'] = array_values($_SESSION['favourites']); // re-index array
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Favourite Dishes</title>
    <link rel="stylesheet" href="CSS/menu.css">
</head>
<body>
    <h1>Your Favourite Dishes</h1>

    <?php if (!empty($_SESSION['favourites'])): ?>
        <ul>
            <?php foreach ($_SESSION['favourites'] as $dish): ?>
                <li>
                    <?= htmlspecialchars($dish) ?>
                    <!-- Link to remove an item -->
                    <a href="?remove=<?= urlencode($dish) ?>" style="color: red; text-decoration: none;">&nbsp;❌</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Email form -->
        <form action="send_email.php" method="post">
            <label for="email">Send your favourites to an email:</label><br>
            <input type="email" name="email" required>
            <input type="submit" value="Send Email">
        </form>
    <?php else: ?>
        <p>No favourites selected yet.</p>
        <a href="menu.php">Back to Menu</a>
    <?php endif; ?>
</body>
</html>
