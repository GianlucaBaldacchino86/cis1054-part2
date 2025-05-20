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
     //The if-statement is used to check if the form has been submitted
    $name = trim($_POST['name'] ?? '');//Get the inputted name and store it into the variable $name
    $email = trim($_POST['email'] ?? '');//Get the inputted name and store it into the variable $email
    $complaint = trim($_POST['complaint'] ?? '');//Get the inputted name and store it into the variable $complaint

    if ($name && $email && $complaint) {
        //The if statement above is used to check if the name, email, and complaint fields are not empty and have been inputted by the user
        $data = [$name, $email, $complaint]; //This is used to store the form data inputted by the user into an array called $data
        $file = fopen("CSVF/complaint.csv", "a");//This is used to open the CSV file in append mode. The 'a' mode is used to write to the end of the file without overwriting existing data as that is not desirable
        fputcsv($file, $data);//Here the form data (stored inside the $data array) is written to the CSV file as a new row using the fputcsv() function
        fclose($file);//This is used to close the file
    }
    //The code below is used to send an email to the restaurant owner and the user
    
    
    $complaintDetails = "
    Complaint Received:\n
    Name: $name\n
    Email: $email\n
    Complaint:\n$complaint\n";
    //The complaintDetails variable is used to store the details of the complaint that has been submitted by the user in the form
    $mail = new PHPMailer(true);//initialise the PHPMailer class

    try {
        //This part cpntains the Mailtrap SMTP settings to test email functionality of the form
        $mail->isSMTP();//used to set mailer to SMTP
        $mail->Host       = 'smtp.mailtrap.io';//set the SMTP host name
        $mail->SMTPAuth   = true;//used to enable SMTP authentication
        $mail->Username   = '98b88755d14f20';//the Mailtrap username
        $mail->Password   = '15e6a66a781e00';//the Mailtrap password
        $mail->Port       = 2525;//This is the SMTP port number

        $mail->setFrom($resEmail, 'Restaurant');
        $mail->isHTML(false);//used to specify that the email's format is plain text

        //this part is used to send the complaint to restaurant owner
        $mail->addAddress($ownerEmail);//Add the restaurant owner's email address
        $mail->Subject = 'New Complaint Received';
        $mail->Body    = $complaintDetails;//output the complaint details in the email's body
        $mail->send();

        $mail->clearAddresses();//clear the previous recipient 

        //this part is used to send to the user that the complaint has been received
        $mail->addAddress($email, $name);//used to add the user's email address
        $mail->Subject = 'Complaint Confirmation';
        $mail->Body    = "Thank you for contacting us.\n\nHere is a copy of your complaint:\n\n" . $complaintDetails;
        $mail->send();//used to send the email to the user

    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";//used to catch any errors that occur during the sending of the email
    }


    header("Location: contactUs.php");//This is used to redirect the user to the contactUs html page once the data is written to the CSV file
    exit();//Used to stop the script
}
?>
