<?php
session_start(); // Start the session to store favourites

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // PHPMailer autoloader

// Check if form is submitted to email favourites
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_favourites'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    // Prepare email content
    $favourites = $_SESSION['favourites'] ?? [];
    $favouritesList = "\nFavourite Dishes:\n";
    foreach ($favourites as $fav) {
        $favouritesList .= "- {$fav}\n";
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = '98b88755d14f20'; // Replace with your Mailtrap username
        $mail->Password   = '15e6a66a781e00'; // Replace with your Mailtrap password
        $mail->Port       = 2525;

        $mail->setFrom('restaurant@example.com', 'Restaurant');
        $mail->isHTML(false);

        // Email to restaurant owner
        $mail->addAddress('gbtest86152@gmail.com');
        $mail->Subject = 'User Favourite Dishes';
        $mail->Body    = "User Name: {$name}\nUser Email: {$email}\n" . $favouritesList;
        $mail->send();

        // Clear recipients and send to user
        $mail->clearAddresses();
        $mail->addAddress($email, $name);
        $mail->Subject = 'Your Favourite Dishes';
        $mail->Body    = "Thank you for choosing your favourite dishes!\n" . $favouritesList;
        $mail->send();

        echo "Favourite dishes email sent.";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    exit();
}

// Handle add/remove favourites via GET (AJAX-friendly)
if (isset($_GET['toggle'])) {
    $dish = $_GET['toggle'];
    if (!isset($_SESSION['favourites'])) {
        $_SESSION['favourites'] = [];
    }
    if (in_array($dish, $_SESSION['favourites'])) {
        $_SESSION['favourites'] = array_diff($_SESSION['favourites'], [$dish]);
    } else {
        $_SESSION['favourites'][] = $dish;
    }
    header("Location: favourites.php");
    exit();
}

if (isset($_GET['remove'])) {
    $dish = $_GET['remove'];
    $_SESSION['favourites'] = array_diff($_SESSION['favourites'], [$dish]);
    header("Location: favourites.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Favourites</title>
    <link rel="stylesheet" href="CSS/navbar.css">
    <link rel="stylesheet" href="CSS/menu.css">
    <style>
        .dish-fav { display: flex; align-items: center; justify-content: space-between; }
        .heart, .remove-btn {
            cursor: pointer;
            font-size: 24px;
            color: red;
            text-decoration: none;
            padding: 0 10px;
        }
    </style>
</head>
<body>
<nav class="upnav">
    <div class="topnav">
        <div class="logo">
            <a href='home.html'>Lotus Fire</a>
        </div>
        <ul>
            <li><button onclick="location.href='menu.php'">Menu</button></li>
            <li><button onclick="location.href='favourites.php'">Favourites</button></li>
            <li><button onclick="location.href='contactUs.html'">Contact</button></li>
        </ul>
    </div>
</nav>

<div class="content">
    <h1>Your Favourite Dishes</h1>

    <?php if (!empty($_SESSION['favourites'])): ?>
        <ul>
            <?php foreach ($_SESSION['favourites'] as $fav): ?>
                <li class="dish-fav">
                    <?= htmlspecialchars($fav) ?>
                    <a class="remove-btn" href="?remove=<?= urlencode($fav) ?>" title="Remove">❌</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <form method="post" action="favourites.php">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="submit" name="send_favourites" value="Send Favourites by Email">
        </form>
    <?php else: ?>
        <p>No favourites added yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
