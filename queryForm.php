<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //The if-statement checks if the form has been submitted
    $name = trim($_POST['name'] ?? '');//Get the inputted name and store it into the variable $name
    $email = trim($_POST['email'] ?? '');//Get the inputted name and store it into the variable $email
    $question = trim($_POST['question'] ?? '');//Get the inputted name and store it into the variable $question
    //the trim() function removes whitespace (such as tabs) from the beginning and end of a string in order to clean up the user input.

    if ($name && $email && $question) {
        //The if statement above is used to check if the name, email, and question fields are not empty and have been inputted by the user 
        $file = fopen("CSVF/query.csv", "a");//open the CSV file in append mode.The 'a' mode allows you to write to the end of the file without overwriting existing data as that is not desirable .
        fputcsv($file, $data);//overhere the form data (stored inside the $data array) is written to the CSV file as a new row using the fputcsv() function.
        fclose($file);//the file is then closed.
    }//end if-statement

    header("Location: contactUs.html");//once the data is written to the CSV file, the user is redirected to the contactUs html page.
    exit();//used to stp the script.
}//end if
?>
