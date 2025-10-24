<?php
// test-env.php - اختبار المتغيّرات
header('Content-Type: text/plain; charset=utf-8');
echo "=== اختبار المتغيّرات ===\n";
echo "MYSQLHOST: " . ($_ENV['MYSQLHOST'] ?? 'غير موجود') . "\n";
echo "MYSQLUSER: " . ($_ENV['MYSQLUSER'] ?? 'غير موجود') . "\n";
echo "MYSQLPASSWORD: " . (isset($_ENV['MYSQLPASSWORD']) ? 'موجود' : 'غير موجود') . "\n";
echo "MYSQLDATABASE: " . ($_ENV['MYSQLDATABASE'] ?? 'غير موجود') . "\n";
?>