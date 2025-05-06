<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_SESSION['favourites'])) {
    $to = $_POST['email'];
    $subject = "Your Favourite Dishes from Pen-ding";
    $message = "Here are your favourite dishes:\n\n" . implode("\n", $_SESSION['favourites']);
    $headers = "From: noreply@pen-ding.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Email sent successfully!";
    } else {
        echo "Failed to send email.";
    }
} else {
    echo "Invalid request.";
}
?>
