<?php
/**
 * ملف الاتصال بقاعدة البيانات (db.php)
 * يدعم الاتصال المحلي والاتصال السحابي (Aiven/Vercel) عبر متغيرات البيئة
 */

// جلب الإعدادات من متغيرات البيئة أو استخدام القيم الافتراضية المحلية
$host = getenv('DB_HOST') ?: "localhost";
$user = getenv('DB_USER') ?: "root";
$pass = getenv('DB_PASS') ?: "";
$dbname = getenv('DB_NAME') ?: "mishkat_db";
$port = getenv('DB_PORT') ?: 3306;

// إنشاء الاتصال باستخدام MySQLi
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// التحقق من نجاح الاتصال
if ($conn->connect_error) {
    // محاولة الاتصال بدون منفذ كخيار بديل
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }
}

// تعيين ترميز البيانات إلى utf8mb4 لدعم اللغة العربية بشكل كامل
$conn->set_charset("utf8mb4");
?>
