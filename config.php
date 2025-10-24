<?php
// config.php - يعمل 100% بعد نسخ Host و Password من Connect

$servername = "containers-us-west-142.railway.app";  // ← من Host
$username   = "root";
$password   = "yKvfZEQRwPwPfDBSSNvECPqvtJAfTkjn";     // ← من Password
$dbname     = "railway";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("فشل الاتصال: " . $conn->connect_error);
    http_response_code(500);
    exit("فشل الاتصال بقاعدة البيانات.");
}
?>