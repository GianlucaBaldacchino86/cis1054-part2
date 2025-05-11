<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //The if-statement checks if the form has been submitted
    $data = [
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['date'] ?? '',
        $_POST['time'] ?? ''];
    //Get the inputted name, email, date, and time and then store them inside the $data array
    //The code below is used to store user submissions from the booking form into a CSV file.

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
        $mail->isHTML(false); // Set to true if you want to use HTML

        // Email to restaurant owner
        $mail->addAddress('gbtest86152@gmail.com'); // Restaurant owner
        $mail->Subject = 'New Booking Request';
        $mail->Body    = $bookingDetails;
        $mail->send();

        // Clear recipients for second email
        $mail->clearAddresses();

        // Email to user
        $mail->addAddress($data[1], $data[0]); // User's email and name
        $mail->Subject = 'Booking Confirmation';
        $mail->Body    = "Thank you for your booking!\n\n" . $bookingDetails;
        $mail->send();

        echo "Booking emails sent.";

    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }  
    header("Location: contactUs.html");//the user is redirected to the contactUs html page once the data is written to the CSV file.
    exit();//Stop the script.
}
?>
