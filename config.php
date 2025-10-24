<?php
// استخدام المتغيّرات من Railway
$servername = $_ENV['MYSQLHOST'] ?? 'localhost';
$username   = $_ENV['MYSQLUSER'] ?? 'root';
$password   = $_ENV['MYSQLPASSWORD'] ?? '';
$dbname     = $_ENV['MYSQLDATABASE'] ?? 'training_system';

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    error_log("فشل الاتصال: " . $conn->connect_error);
    die("فشل الاتصال بقاعدة البيانات. يرجى المحاولة لاحقًا.");
}
?>