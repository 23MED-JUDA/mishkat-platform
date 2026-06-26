<?php
// ملف الاتصال بقاعدة البيانات

require_once dirname(__DIR__) . '/config/db_config.php';

// جلب الإعدادات
$dbCfg = dbConfig();

$host    = $dbCfg['host']    ?? 'localhost';
$port    = $dbCfg['port']    ?? 3306;
$dbname  = $dbCfg['name']    ?? 'mishkat_db';
$user    = $dbCfg['user']    ?? 'root';
$pass    = $dbCfg['pass']    ?? '';
$charset = $dbCfg['charset'] ?? 'utf8mb4';

// تفعيل استثناءات الأخطاء
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_connected = false;
$conn = null;

try {
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    $conn->set_charset($charset);
    $db_connected = true;
} catch (mysqli_sql_exception $e) {
    // تسجيل الخطأ في السيرفر
    error_log(sprintf(
        '[Mishkat DB] Connection failed | ENV:%s | Host:%s:%s | DB:%s | Error: %s',
        APP_ENV, $host, $port, $dbname, $e->getMessage()
    ));
    
    // حفظ رسالة الخطأ للرجوع إليها عند الحاجة
    $db_connection_error = $e->getMessage();
}


