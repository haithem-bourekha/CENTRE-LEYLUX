<?php
// import_db.php - استيراد قاعدة البيانات تلقائيًا

require 'config.php';

echo "<div style='font-family: Arial; text-align: center; padding: 30px; background: #f9f9f9; border: 1px solid #ddd; margin: 50px auto; max-width: 600px; border-radius: 10px;'>";
echo "<h2 style='color: #1d4ed8;'>جاري استيراد قاعدة البيانات...</h2>";

// تحقق من وجود الملف
if (!file_exists('training_system.sql')) {
    die("<p style='color: red; font-weight: bold;'>خطأ: ملف <code>training_system.sql</code> غير موجود في الجذر!</p>");
}

// قراءة الملف
$sql = file_get_contents('training_system.sql');
if ($sql === false) {
    die("<p style='color: red;'>فشل في قراءة الملف!</p>");
}

// تنفيذ الأوامر
if ($conn->multi_query($sql)) {
    echo "<p style='color: green; font-weight: bold; font-size: 18px;'>تم استيراد قاعدة البيانات بنجاح!</p>";
    echo "<p>تم إنشاء الجداول: <strong>clients</strong>, <strong>courses</strong>, <strong>registrations</strong></p>";
    
    // تنظيف النتائج
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
    
} else {
    echo "<p style='color: red;'>خطأ في الاستيراد:</p>";
    echo "<pre style='background: #fff; padding: 10px; border: 1px solid #ccc;'>" . htmlspecialchars($conn->error) . "</pre>";
}

echo "<hr style='margin: 20px 0;'>";
echo "<p><a href='admin/index.php' style='background: #1d4ed8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;'>اذهب إلى لوحة التحكم</a></p>";
echo "<p style='color: red; font-weight: bold;'><strong>احذف هذا الملف و <code>training_system.sql</code> بعد التشغيل!</strong></p>";
echo "</div>";
?>