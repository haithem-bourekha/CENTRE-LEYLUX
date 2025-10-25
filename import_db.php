<?php
// import_db.php - إنشاء الجداول مباشرة (بدون ملف خارجي)

require 'config.php';

echo "<div style='font-family: Arial; text-align: center; padding: 30px; background: #f0f8ff; border: 2px solid #007acc; margin: 50px auto; max-width: 700px; border-radius: 12px;'>";
echo "<h2 style='color: #007acc;'>إعداد قاعدة البيانات...</h2>";

// جدول clients
$conn->query("CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    wilaya VARCHAR(100) NOT NULL
)") ? print("تم إنشاء جدول <strong>clients</strong><br>") : print("خطأ: " . $conn->error . "<br>");

// جدول courses
$conn->query("CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    audio VARCHAR(255)
)") ? print("تم إنشاء جدول <strong>courses</strong><br>") : print("خطأ: " . $conn->error . "<br>");

// جدول registrations
$conn->query("CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    course_id INT NOT NULL,
    status ENUM('pending','confirmed','rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
)") ? print("تم إنشاء جدول <strong>registrations</strong><br>") : print("خطأ: " . $conn->error . "<br>");

// جدول admin
$conn->query("CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)") ? print("تم إنشاء جدول <strong>admin</strong><br>") : print("خطأ: " . $conn->error . "<br>");

// إضافة حساب admin
$hash = password_hash('admin123', PASSWORD_DEFAULT);
$conn->query("INSERT IGNORE INTO admin (username, password) VALUES ('admin', '$hash')");
echo "تم إنشاء حساب المسؤول: <strong>admin / admin123</strong><br>";

echo "<hr>";
echo "<p style='color: green; font-weight: bold;'>تم الإعداد بنجاح!</p>";
echo "<p><a href='admin/index.php' style='background:#007acc;color:white;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:bold;'>لوحة التحكم</a></p>";
echo "<p style='color:red;'><strong>احذف <code>import_db.php</code> الآن!</strong></p>";
echo "</div>";
?>