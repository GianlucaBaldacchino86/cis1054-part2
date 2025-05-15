<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Load menu from CSV
$menu = [];
$csvFile = "CSVF/menu.csv";
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

// Initialise favourites if not set
if (!isset($_SESSION['favourites'])) {
    $_SESSION['favourites'] = [];
}

// Handle add/remove favourites via GET
if (isset($_GET['toggle'])) {
    $dishName = $_GET['toggle'];
    if (in_array($dishName, $_SESSION['favourites'])) {
        $_SESSION['favourites'] = array_diff($_SESSION['favourites'], [$dishName]);
    } else {
        $_SESSION['favourites'][] = $dishName;
    }
    header("Location: favourites.php");
    exit();
}

// Handle removing with 'remove'
if (isset($_GET['remove'])) {
    $dishName = $_GET['remove'];
    $_SESSION['favourites'] = array_diff($_SESSION['favourites'], [$dishName]);
    header("Location: favourites.php");
    exit();
}

// Email sending logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    $favs = $_SESSION['favourites'];
    $favDetails = "\nFavourite Dishes:\n" . implode("\n", $favs);

    $mail = new PHPMailer(true);

    try {
        //Mailtrap SMTP settings to test email functionality of the form
        $mail->isSMTP();//set mailer to use SMTP
        $mail->Host       = 'smtp.mailtrap.io';//Set the SMTP host name
        $mail->SMTPAuth   = true;//Enable smtp authentication
        $mail->Username   = '98b88755d14f20'; //Mailtrap username
        $mail->Password   = '15e6a66a781e00'; //Mailtrap password
        $mail->Port       = 2525;//the smtp port number

        
        $mail->addAddress($email, $name); //Recepient
        $mail->setFrom('restaurant@example.com', 'Restaurant');//Set the sender's email address and name
        $mail->isHTML(false);//Set the email format to plain text
        $mail->Subject = 'Your favourite ishes from Lotus Fire';
        $mail->Body = "Thank you, $name! Here are your favourite dishes:\n" . $favDetails;//Sends favourite dishes to customer

        $mail->send();
        $successMessage = "Email sent successfully!";
    } catch (Exception $e) {
        $errorMessage = "Failed to send email: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Favourites</title>
    <link rel="stylesheet" href="css/favourites.css" />
    <link rel="stylesheet" href="css/navbar.css" />
</head>
<body>
<!--Navigation Bar-->
<nav class="upnav">
    <div class="topnav">
        <div class="logo">
            <a href='home.html'>Lotus Fire</a>
        </div>
        <ul>
            <li><button onclick="location.href = 'menu.php'">Menu</button></li>
              <li><button onclick="location.href = 'Description.php'">Description</button></li>
              <li><button onclick="location.href='favourites.php'">Favourites</button></li>
              <li><button onclick="location.href='AboutUs.html'">About us</button></li>
              <li><button onclick="location.href='contactUs.html'">Contact Us</button></li>
        </ul>
    </div>
</nav>

<div class="fav-container">
    <h1>Your Favourite Dishes</h1>
    <!--Printing each favourite dish-->
    <?php if (!empty($_SESSION['favourites'])): ?>
        <?php foreach ($_SESSION['favourites'] as $fav): ?>
            <div class="fav-item">
                <div class="fav-details">
                    <span><?= htmlspecialchars($fav) ?></span>
                </div>
                <form method="get" style="display:inline;">
                    <input type="hidden" name="remove" value="<?= htmlspecialchars($fav) ?>">
                    <button type="submit" class="remove-button" title="Remove">&#10060;</button>
                </form>
            </div>
        <?php endforeach; ?>
        <!--Form to send emails-->
        <div class="email-form">
            <h2>Send Favourites via Email</h2>
            <form method="post">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <button type="submit">Send Email</button>
            </form>
        </div>
    <?php else: ?>
        <p class="empty-msg">You have no favourite dishes selected.</p><!--In case someone doesn't add any favourites-->
    <?php endif; ?>
</div>
    <footer>
        <p>&copy; 2025 Lotus Fire. All rights reserved.</p>
    </footer>
</body>
</html>
