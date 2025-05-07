<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        $_POST['name'] ?? '',
        $_POST['email'] ?? '',
        $_POST['date'] ?? '',
        $_POST['time'] ?? ''
    ];

    $filePath = __DIR__ . "/CSVF/booking.csv"; 
    $file = fopen($filePath, "a");
    fputcsv($file, $data);
    fclose($file);

    header("Location: contactUs.html");
    exit();
}
?>
