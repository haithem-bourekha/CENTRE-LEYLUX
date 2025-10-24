<?php
// config.php - اتصال مباشر بقاعدة البيانات على Railway

// === بيانات قاعدة البيانات (انسخها من Railway) ===
$servername = "mysql.railway.internal";
$username   = "root";
$password   = "";  // ← الصقها هنا
$dbname     = "railway";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    error_log("فشل الاتصال: " . $conn->connect_error);
    http_response_code(500);
    exit("فشل الاتصال بقاعدة البيانات.");
}
?>