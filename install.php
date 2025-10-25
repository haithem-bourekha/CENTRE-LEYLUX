<?php
// install.php - إنشاء الجداول تلقائيًا (مرة واحدة فقط)

require 'config.php';

echo "<h2 style='color: green; text-align: center;'>جاري إعداد قاعدة البيانات...</h2>";

// 1. جدول الدورات
$sql1 = "CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    audio VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql1) === TRUE) {
    echo "تم إنشاء جدول <strong>courses</strong><br>";
} else {
    echo "خطأ في courses: " . $conn->error . "<br>";
}

// 2. جدول التسجيلات
$sql2 = "CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
)";

if ($conn->query($sql2) === TRUE) {
    echo "تم إنشاء جدول <strong>registrations</strong><br>";
} else {
    echo "خطأ في registrations: " . $conn->error . "<br>";
}

// 3. جدول المسؤول
$sql3 = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sql3) === TRUE) {
    echo "تم إنشاء جدول <strong>admin</strong><br>";
    
    // إضافة حساب admin افتراضي
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $insert = $conn->query("INSERT IGNORE INTO admin (username, password) VALUES ('admin', '$hash')");
    if ($insert) {
        echo "تم إنشاء حساب المسؤول: <strong>admin / admin123</strong><br>";
    }
} else {
    echo "خطأ في admin: " . $conn->error . "<br>";
}

echo "<hr>";
echo "<p style='color: green; font-weight: bold; text-align: center;'>تم الإعداد بنجاح!</p>";
echo "<p style='text-align: center;'><a href='admin/index.php' style='color: blue; text-decoration: underline;'>اذهب إلى لوحة التحكم</a></p>";
echo "<p style='color: red; text-align: center;'><strong>احذف هذا الملف بعد التشغيل!</strong></p>";
?>