<?php
header('Content-Type: text/plain');
echo "MYSQLHOST: " . ($_ENV['MYSQLHOST'] ?? 'غير موجود') . "\n";
echo "MYSQLUSER: " . ($_ENV['MYSQLUSER'] ?? 'غير موجود') . "\n";
?>