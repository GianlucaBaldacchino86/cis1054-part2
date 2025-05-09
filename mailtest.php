<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composer autoload

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = '98b88755d14f20'; // from SMTP Settings
    $mail->Password   = '15e6a66a781e00'; // from SMTP Settings
    $mail->Port       = 2525;

    // Sender & recipient
    $mail->setFrom('from@example.com', 'Your Name');
    $mail->addAddress('to@example.com', 'Recipient Name');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email via Mailtrap';
    $mail->Body    = 'This is a test email sent using PHPMailer + Mailtrap + XAMPP.';

    $mail->send();
    echo 'Message has been sent successfully!';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
