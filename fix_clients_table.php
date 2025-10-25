<?php
// fix_clients_table.php - إضافة عمود status إلى جدول registrations

require 'config.php';

echo "<h2 style='color: #1d4ed8; text-align: center;'>إصلاح جدول العملاء...</h2>";

// إضافة عمود status
$sql = "ALTER TABLE registrations ADD COLUMN IF NOT EXISTS status ENUM('pending', 'confirmed', 'rejected') DEFAULT 'pending'";

if ($conn->query($sql) === TRUE) {
    echo "تم إضافة العمود <strong>status</strong> بنجاح<br>";
} else {
    echo "خطأ: " . $conn->error . "<br>";
}

echo "<hr><p style='color: green; font-weight: bold; text-align: center;'>تم الإصلاح!</p>";
echo "<p style='text-align: center;'><a href='admin/manage_clients.php' style='color: blue; font-weight: bold;'>عودة إلى إدارة العملاء</a></p>";
echo "<p style='color: red; text-align: center;'><strong>احذف هذا الملف بعد التشغيل!</strong></p>";
?>