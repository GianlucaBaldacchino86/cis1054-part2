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
    $data = [
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['date'] ?? '',
        $_POST['time'] ?? ''];
    //Get the inputted name, email, date, and time and then store them inside the $data array
    //The code below is used to store user submissions from the booking form into a CSV file

    $filePath = __DIR__ . "/CSVF/booking.csv";//Used to define the path to the CSV file to make sure the data is sent to the right file.
    $file = fopen($filePath, "a");//Open the CSV file in append mode. The 'a' mode allows you to write to the end of the file without overwriting existing data as that is not desirable.
    fputcsv($file, $data);//write the form data (stored inside the $data array) to the CSV file as a new row using the fputcsv() function.
    fclose($file);//Close the file.

    $bookingDetails = "
    Booking Details:\n
    Name: {$data[0]}\n
    Email: {$data[1]}\n
    Date: {$data[2]}\n
    Time: {$data[3]}\n";
    //This is used to store the booking details using the string data type.
    
    //The code below is used to send an email to the restaurant owner and the user.
    //owner part
    $mail = new PHPMailer(true);//initalise the PHPMailer class

    try {
        //Mailtrap SMTP settings to test email functionality of the form
        $mail->isSMTP();//set mailer to use SMTP
        $mail->Host       = 'smtp.mailtrap.io';//Set the SMTP host name
        $mail->SMTPAuth   = true;//Enable smtp authentication
        $mail->Username   = '98b88755d14f20'; //Mailtrap username
        $mail->Password   = '15e6a66a781e00'; //Mailtrap password
        $mail->Port       = 2525;//the smtp port number

        $mail->setFrom($resEmail, 'Restaurant');//Set the sender's email address and name
        $mail->isHTML(false);//Set the email format to plain text

        //email to restaurant owner
        $mail->addAddress($ownerEmail); // Restaurant owner
        $mail->Subject = 'New Booking Request';
        $mail->Body    = $bookingDetails;//output the booking details in the email's body
        $mail->send();//send email to restaurant owner

        $mail->clearAddresses();//clear the previous recipient

        //email to user
        $mail->addAddress($data[1], $data[0]); //this is used to add the user's email address
        $mail->Subject = 'Booking Confirmation';
        $mail->Body    = "Thank you for your booking!\n\n" . $bookingDetails;
        $mail->send();

        echo "Booking emails sent.";

    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";//used to catch any errors that occur during the sending of the email
    }  
    header("Location: contactUs.php");//the user is redirected to the contactUs html page once the data is written to the CSV file
    exit();//Stop the script.
}
?>
