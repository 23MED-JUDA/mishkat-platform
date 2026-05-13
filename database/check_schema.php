<?php
/**
 * ملف فحص بنية الجداول
 * يستخدم لعرض تفاصيل أعمدة جدول الحلقات (episodes) للتأكد من أنواع البيانات والأسماء
 */
require_once __DIR__ . '/../includes/db.php';

// استعلام لعرض هيكلية جدول الحلقات
$r = $conn->query("DESCRIBE episodes");
while($row = $r->fetch_assoc()) {
    print_r($row);
}
?>
