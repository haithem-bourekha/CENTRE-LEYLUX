<?php
// config.php - لا تُخرج أي نص أو تحذير
$servername = $_ENV['MYSQLHOST'] ?? 'localhost';
$username   = $_ENV['MYSQLUSER'] ?? 'root';
$password   = $_ENV['MYSQLPASSWORD'] ?? '';
$dbname     = $_ENV['MYSQLDATABASE'] ?? 'training_system';

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال (بدون echo)
if ($conn->connect_error) {
    error_log("فشل الاتصال: " . $conn->connect_error);
    http_response_code(500);
    exit("فشل الاتصال بقاعدة البيانات.");
}
?>