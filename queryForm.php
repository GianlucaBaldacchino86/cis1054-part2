<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$csv = fopen("contacts.csv", "r");
$headers = fgetcsv($csv); 
$data = fgetcsv($csv);
fclose($csv);
$resEmail = $data[1];
$ownerEmail = $data[2]; 


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

    
        $questionDetails = "
        Question Submitted:\n
        Name: $name\n
        Email: $email\n
        Question:\n$question\n";
        //the questionDetails variable is used to store the details of the question that has been submitted by the user.
        
        $mail = new PHPMailer(true); //initalise the PHPMailer class

        try {
            //Mailtrap SMTP settings to test email functionality of the form
            $mail->isSMTP(); //used to set mailer to SMTP
            $mail->Host       = 'smtp.mailtrap.io';//set the smtp host name
            $mail->SMTPAuth   = true;//used to enable SMTP authentication 
            $mail->Username   = '98b88755d14f20'; //Mailtrap username
            $mail->Password   = '15e6a66a781e00'; //Mailtrap password
            $mail->Port       = 2525;//this is the SMTP port number

            $mail->setFrom($resEmail, 'Restaurant');//Set the sender's email address and name
            $mail->isHTML(false);//used to specify that the email's format is plain text

            //this part covers the email to the restaurant
            $mail->addAddress($ownerEmail);//Add the restaurant owner's email address
            $mail->Subject = 'New Question Submitted';
            $mail->Body    = $questionDetails;
            $mail->send();

            //this part covers the email to the user
            $mail->clearAddresses();//clear the previous recipient
            $mail->addAddress($email, $name);//used to add the user's email address
            $mail->Subject = 'We received your question';
            $mail->Body    = "Thank you for reaching out to us!\n\nHere’s a copy of your question:\n\n" . $questionDetails;
            $mail->send();

        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";//used to catch any errors that occur during the sending of the email
        }
    }
    }//end if-statement

    header("Location: contactUs.php");//once the data is written to the CSV file, the user is redirected to the contactUs html page.
    exit();//used to stp the script.
?>
