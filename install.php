<?php
// install.php - إعداد قاعدة البيانات (مرة واحدة فقط)

require 'config.php';

// تحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

echo "<h2 style='color: #1d4ed8; text-align: center;'>إعداد قاعدة البيانات...</h2>";

// 1. جدول الدورات
$conn->query("CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    audio VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)") ? print("تم إنشاء جدول <strong>courses</strong><br>") : print("خطأ: " . $conn->error . "<br>");

// 2. جدول التسجيلات
$conn->query("CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
)") ? print("تم إنشاء جدول <strong>registrations</strong><br>") : print("خطأ: " . $conn->error . "<br>");

// 3. جدول المسؤول
$conn->query("CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)") ? print("تم إنشاء جدول <strong>admin</strong><br>") : print("خطأ: " . $conn->error . "<br>");

// إضافة حساب admin
$hash = password_hash('admin123', PASSWORD_DEFAULT);
$conn->query("INSERT IGNORE INTO admin (username, password) VALUES ('admin', '$hash')");
echo "تم إنشاء حساب المسؤول: <strong>admin / admin123</strong><br>";

echo "<hr><p style='color: green; font-weight: bold; text-align: center;'>تم بنجاح!</p>";
echo "<p style='text-align: center;'><a href='/admin/index.php' style='color: blue; font-weight: bold;'>اذهب إلى لوحة التحكم</a></p>";
echo "<p style='color: red; text-align: center;'><strong>احذف هذا الملف بعد التشغيل!</strong></p>";
?>