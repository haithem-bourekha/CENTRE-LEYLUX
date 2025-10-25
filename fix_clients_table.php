<?php
// fix_clients_table.php - إضافة عمود status بدون IF NOT EXISTS

require 'config.php';

echo "<h2 style='color: #1d4ed8; text-align: center;'>إصلاح جدول العملاء...</h2>";

// التحقق إذا كان العمود موجودًا أولاً
$result = $conn->query("SHOW COLUMNS FROM registrations LIKE 'status'");
if ($result->num_rows == 0) {
    // إذا لم يكن موجودًا → أضفه
    $sql = "ALTER TABLE registrations 
            ADD COLUMN status ENUM('pending', 'confirmed', 'rejected') DEFAULT 'pending'";
    
    if ($conn->query($sql) === TRUE) {
        echo "تم إضافة العمود <strong>status</strong> بنجاح<br>";
    } else {
        echo "خطأ في الإضافة: " . $conn->error . "<br>";
    }
} else {
    echo "العمود <strong>status</strong> موجود بالفعل<br>";
}

echo "<hr><p style='color: green; font-weight: bold; text-align: center;'>تم الإصلاح!</p>";
echo "<p style='text-align: center;'><a href='admin/manage_clients.php' style='color: blue; font-weight: bold;'>عودة إلى إدارة العملاء</a></p>";
echo "<p style='color: red; text-align: center;'><strong>احذف هذا الملف بعد التشغيل!</strong></p>";
?>