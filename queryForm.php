<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $question = trim($_POST['question'] ?? '');

    if ($name && $email && $question) {
        $data = [$name, $email, $question];
        $file = fopen("CSVF/query.csv", "a");
        fputcsv($file, $data);
        fclose($file);
    }

    header("Location: contactUs.html");
    exit();
}
?>
