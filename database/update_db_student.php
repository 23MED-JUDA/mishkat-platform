<?php
/**
 * ملف تحديث بيانات الطلاب (update_db_student.php)
 * يستخدم لإضافة عمود العمر لجدول المستخدمين وإنشاء مجلدات الرفع الضرورية
 */
require_once __DIR__ . '/../includes/db.php';

// إضافة عمود العمر لجدول المستخدمين (users)
$sql = "ALTER TABLE users ADD COLUMN age INT AFTER gender";
if ($conn->query($sql)) {
    echo "تم إضافة عمود العمر لجدول المستخدمين بنجاح.<br>";
} else {
    echo "ملاحظة: عمود العمر قد يكون موجوداً بالفعل.<br>";
}

// إنشاء مجلدات الرفع (uploads) إذا لم تكن موجودة
if (!file_exists('../uploads/cvs')) {
    mkdir('../uploads/cvs', 0777, true);
    echo "تم إنشاء مجلد 'uploads/cvs' بنجاح.<br>";
}

echo "<h2>✅ تم تحديث قاعدة البيانات ونظام الملفات!</h2>";
echo "<p><a href='../index.php'>العودة للرئيسية</a></p>";
?>
