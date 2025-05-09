<?php
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
    $emailOwner = "gbtest86151@gmail.com";
    $ownerSubject = "New Booking Request";
    mail($emailOwner, $ownerSubject, $bookingDetails);//The mail() function is used to send an email to the restaurant owner with the booking details.

    //user part
    $userSubject = "Booking Confirmation";
    $userMessage = "Thank you for your booking!\n\n" . $bookingDetails;
    mail($data[1], $userSubject, $userMessage);

    echo "Booking emails sent.";//This is used to display a message to the user to tell them that the booking email has been sent successfully.
    
    header("Location: contactUs.html");//the user is redirected to the contactUs html page once the data is written to the CSV file.
    exit();//Stop the script.
}
?>
