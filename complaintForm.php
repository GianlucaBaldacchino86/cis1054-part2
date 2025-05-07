<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $complaint = trim($_POST['complaint'] ?? '');

    if ($name && $email && $complaint) {
        $data = [$name, $email, $complaint];
        $file = fopen("CSVF/complaint.csv", "a");
        fputcsv($file, $data);
        fclose($file);
    }

    header("Location: contactUs.html");
    exit();
}
?>
