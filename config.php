<?php
// config.php - استخدام getenv() لقراءة المتغيّرات من Railway

$servername = getenv('MYSQLHOST');
$username   = getenv('MYSQLUSER');
$password   = getenv('MYSQLPASSWORD');
$dbname     = getenv('MYSQLDATABASE');

// إذا لم تُقرأ (للأمان)
if (!$servername || !$username || !$password || !$dbname) {
    error_log("فشل قراءة المتغيّرات من Railway");
    http_response_code(500);
    exit("خطأ في الإعدادات. تحقق من المتغيّرات.");
}

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("فشل الاتصال: " . $conn->connect_error);
    http_response_code(500);
    exit("فشل الاتصال بقاعدة البيانات.");
}
?>