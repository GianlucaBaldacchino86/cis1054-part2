<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
     //The if-statement is used to check if the form has been submitted
    $name = trim($_POST['name'] ?? '');//Get the inputted name and store it into the variable $name
    $email = trim($_POST['email'] ?? '');//Get the inputted name and store it into the variable $email
    $complaint = trim($_POST['complaint'] ?? '');//Get the inputted name and store it into the variable $complaint

    if ($name && $email && $complaint) {
        //The if statement above is used to check if the name, email, and complaint fields are not empty and have been inputted by the user
        $data = [$name, $email, $complaint]; //This is used to store the form data inputted by the user into an array called $data
        $file = fopen("CSVF/complaint.csv", "a");//This is used to open the CSV file in append mode. The 'a' mode is used to write to the end of the file without overwriting existing data as that is not desirable.
        fputcsv($file, $data);//Here the form data (stored inside the $data array) is written to the CSV file as a new row using the fputcsv() function.
        fclose($file);//This is used to close the file.
    }

    header("Location: contactUs.html");//This is used to redirect the user to the contactUs html page once the data is written to the CSV file.
    exit();//Used to stop the script.
}
?>
