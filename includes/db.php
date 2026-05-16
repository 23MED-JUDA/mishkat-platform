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

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // إنشاء الاتصال باستخدام MySQLi
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
} catch (mysqli_sql_exception $e) {
    try {
        // محاولة الاتصال بدون منفذ كخيار بديل
        $conn = new mysqli($host, $user, $pass, $dbname);
    } catch (mysqli_sql_exception $e2) {
        // تسجيل الخطأ الفعلي في سجلات الخادم لمنع عرضه للمستخدم
        error_log("Database connection failed: " . $e2->getMessage());
        die("فشل الاتصال بقاعدة البيانات. يرجى المحاولة لاحقاً أو التحقق من إعدادات الاتصال.");
    }
}

// تعيين ترميز البيانات إلى utf8mb4 لدعم اللغة العربية بشكل كامل
$conn->set_charset("utf8mb4");
?>
