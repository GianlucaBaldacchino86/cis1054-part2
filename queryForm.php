<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //The if-statement checks if the form has been submitted
    $name = trim($_POST['name'] ?? '');//Get the inputted name and store it into the variable $name
    $email = trim($_POST['email'] ?? '');//Get the inputted name and store it into the variable $email
    $question = trim($_POST['question'] ?? '');//Get the inputted name and store it into the variable $question
    //the trim() function removes whitespace (such as tabs) from the beginning and end of a string in order to clean up the user input.

    if ($name && $email && $question) {
        //The if statement above is used to check if the name, email, and question fields are not empty and have been inputted by the user 
        $data = [$name, $email, $question];
        $file = fopen("CSVF/query.csv", "a");
        fputcsv($file, $data);
        fclose($file);

         // Prepare the email message
        $questionDetails = "
        Question Submitted:\n
        Name: $name\n
        Email: $email\n
        Question:\n$question\n";

        $mail = new PHPMailer(true);

        try {
            // Mailtrap SMTP settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.mailtrap.io';
            $mail->SMTPAuth   = true;
            $mail->Username   = '98b88755d14f20'; // your Mailtrap username
            $mail->Password   = '15e6a66a781e00'; // your Mailtrap password
            $mail->Port       = 2525;

            $mail->setFrom('restaurant@example.com', 'Restaurant');
            $mail->isHTML(false); // plain text email

            // Email to restaurant owner
            $mail->addAddress('gbtest86151@gmail.com');
            $mail->Subject = 'New Question Submitted';
            $mail->Body    = $questionDetails;
            $mail->send();

            // Email to user
            $mail->clearAddresses();
            $mail->addAddress($email, $name);
            $mail->Subject = 'We received your question';
            $mail->Body    = "Thank you for reaching out to us!\n\nHere’s a copy of your question:\n\n" . $questionDetails;
            $mail->send();

        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }
    }//end if-statement

    header("Location: contactUs.html");//once the data is written to the CSV file, the user is redirected to the contactUs html page.
    exit();//used to stp the script.
?>
