<?php
/**
 * ملف فحص قاعدة البيانات - المسار 1
 * يستخدم للتأكد من وجود البيانات في جدول الدورات والحلقات
 */
require_once __DIR__ . '/../includes/db.php';

echo "--- الدورة رقم 1 ---\n";
// جلب بيانات الدورة الأولى
$c = $conn->query("SELECT * FROM courses WHERE id=1")->fetch_assoc();
print_r($c);

echo "--- الحلقات الخاصة بالدورة رقم 1 ---\n";
// جلب كافة الحلقات المرتبطة بالدورة الأولى
$r = $conn->query("SELECT * FROM episodes WHERE course_id=1");
while($row = $r->fetch_assoc()) {
    print_r($row);
}
?>
