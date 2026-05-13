<?php
/**
 * ملف فحص قاعدة البيانات الشامل
 * يستخدم لاستعراض كافة الدورات والحلقات التي تحتوي على محتوى (فيديو أو روابط)
 */
require_once __DIR__ . '/../includes/db.php';

echo "--- الدورات التي تحتوي على محتوى تعليمي ---\n";
// استعلام لجلب الدورات التي تم رفع محتوى لها
$r = $conn->query("SELECT id, title, content_type, content_data FROM courses WHERE content_data != '' AND content_data IS NOT NULL");
while($row = $r->fetch_assoc()) {
    print_r($row);
}

echo "--- قائمة كافة الحلقات المرفوعة ---\n";
// استعلام لجلب كافة الحلقات المسجلة في النظام
$r = $conn->query("SELECT id, course_id, title, content_type, content_data FROM episodes");
while($row = $r->fetch_assoc()) {
    print_r($row);
}
?>
