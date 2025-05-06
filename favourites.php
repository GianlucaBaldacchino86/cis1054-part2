<?php
session_start();

// Store selected favourites in session
if (isset($_POST['favourites'])) {
    $_SESSION['favourites'] = $_POST['favourites'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Favourites</title>
    <link rel="stylesheet" href="CSS/menu.css">
</head>
<body>
    <h1>Your Favourite Dishes</h1>

    <?php if (!empty($_SESSION['favourites'])): ?>
        <ul>
            <?php foreach ($_SESSION['favourites'] as $favourite): ?>
                <li><?= htmlspecialchars($favourite) ?></li>
            <?php endforeach; ?>
        </ul>

        <form action="send_email.php" method="post">
            <label for="email">Enter your email to send your favourites:</label>
            <input type="email" name="email" required>
            <input type="submit" value="Send Email">
        </form>
    <?php else: ?>
        <p>No favourites selected.</p>
    <?php endif; ?>
</body>
</html>
