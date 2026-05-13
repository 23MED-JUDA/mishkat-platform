<?php
/**
 * ملف تحديث بنية قاعدة البيانات (update_db.php)
 * يستخدم لإضافة أعمدة جديدة لجدول معلومات المعلمين دون حذف البيانات القديمة
 */
require_once __DIR__ . '/../includes/db.php';

// إضافة أعمدة الموقع ورابط السيرة الذاتية لجدول المعلمين
$sql1 = "ALTER TABLE teachers_info ADD COLUMN location VARCHAR(255) AFTER rating";
$sql2 = "ALTER TABLE teachers_info ADD COLUMN cv_url VARCHAR(500) AFTER location";

// تنفيذ الاستعلام الأول (إضافة الموقع)
if ($conn->query($sql1)) {
    echo "تم إضافة عمود الموقع بنجاح.<br>";
} else {
    echo "ملاحظة: عمود الموقع قد يكون موجوداً بالفعل.<br>";
}

// تنفيذ الاستعلام الثاني (إضافة رابط السيرة الذاتية)
if ($conn->query($sql2)) {
    echo "تم إضافة عمود السيرة الذاتية بنجاح.<br>";
} else {
    echo "ملاحظة: عمود السيرة الذاتية قد يكون موجوداً بالفعل.<br>";
}

echo "<h2>✅ تم تحديث هيكل قاعدة البيانات بنجاح!</h2>";
echo "<p><a href='../index.php'>العودة للرئيسية</a></p>";
?>
