<?php
/**
 * ملف إصلاح وتغذية البيانات (db_fix.php)
 * يستخدم هذا الملف لإعادة تعبئة المكتبة الإسلامية والمهام وتحديث بنية بعض الجداول
 */
session_start();
// التأكد من المسار الصحيح لملف الاتصال بقاعدة البيانات
require_once __DIR__ . '/../includes/db.php';

echo "<div style='font-family: sans-serif; padding: 20px; direction: rtl;'>";
echo "<h2 style='color: #065f46;'>تغذية المكتبة الإسلامية والمهام...</h2>";

// تعطيل فحص المفاتيح الخارجية للسماح بعمليات الحذف والإضافة الجماعية
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// 1. تحديث عناصر المكتبة الإسلامية
$conn->query("DELETE FROM library_items");
$lib_items = [
    ['شرح الأربعون النووية', 'أحاديث', 'pdf', 'شرح ميسر لأحاديث المصطفى صلى الله عليه وسلم.'],
    ['رياض الصالحين', 'أحاديث', 'pdf', 'كتاب جامع للأحاديث الصحيحة في الرقائق والآداب.'],
    ['موعظة الصبر والشكر', 'مواعظ', 'audio', 'درس مؤثر عن فضل الصبر والشكر في حياة المسلم.'],
    ['قصص الأنبياء - نبيل العوضي', 'قصص', 'video', 'سلسلة مرئية تحكي قصص الأنبياء بأسلوب مشوق.'],
    ['الطريق إلى الجنة', 'مواعظ', 'article', 'مقالة تتناول الأعمال الصالحة الموصلة للجنان.'],
    ['أذكار الصباح والمساء', 'أحاديث', 'audio', 'تسجيل صوتي للأذكار اليومية الصحيحة.'],
    ['تفسير جزء عم', 'تجويد', 'pdf', 'تفسير مبسط للأطفال والمبتدئين.'],
    ['حكاية صحابي - أبو بكر الصديق', 'قصص', 'article', 'سيرة موجزة عن حياة الصديق رضي الله عنه.']
];

foreach ($lib_items as $li) {
    $stmt = $conn->prepare("INSERT INTO library_items (title, category, type, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $li[0], $li[1], $li[2], $li[3]);
    $stmt->execute();
}

// 2. تحديث المهام والواجبات اليومية للطلاب
$conn->query("DELETE FROM user_tasks");
$conn->query("DELETE FROM tasks");

$tasks = [
    ['حفظ سورة النبأ (الوجه الأول)', 'حفظ من الآية 1 إلى الآية 10 مع مراعاة أحكام الغنة.', 'book', 'اليوم', 'عاجل'],
    ['مراجعة سورة النبأ', 'تكرار ما تم حفظه 10 مرات للتثبيت.', 'book', 'اليوم', 'اعتيادي'],
    ['اختبار تجويد (أحكام الميم)', 'اختبار سريع في أحكام الميم الساكنة.', 'exam', 'غداً', 'اعتيادي'],
    ['الاستماع لسورة الملك', 'استماع للتلاوة بتدبر وخشوع.', 'audio', 'اليوم', 'اعتيادي'],
    ['قراءة حديث من رياض الصالحين', 'قراءة حديث واحد وشرحه من المكتبة الإسلامية.', 'book', 'اليوم', 'اعتيادي'],
    ['اختبار نهاية الأسبوع', 'اختبار شامل لكل ما تم حفظه خلال الأسبوع.', 'exam', 'الجمعة', 'عاجل'],
    ['تدريب على مخارج الحلق', 'تطبيق عملي لمخارج الهمزة والهاء والعين والحاء.', 'audio', 'بعد يومين', 'اعتيادي']
];

// إنشاء بعض الجداول الضرورية إذا لم تكن موجودة
$tables = [
    "exam_results" => "CREATE TABLE IF NOT EXISTS exam_results (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        exam_title VARCHAR(255),
        score INT,
        total INT,
        percentage DECIMAL(5,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "episodes" => "CREATE TABLE IF NOT EXISTS episodes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        course_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        video_url VARCHAR(500),
        order_index INT DEFAULT 0,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

    "user_episodes" => "CREATE TABLE IF NOT EXISTS user_episodes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        episode_id INT NOT NULL,
        completed TINYINT(1) DEFAULT 0,
        completed_at DATETIME DEFAULT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
];

// تنفيذ استعلامات إنشاء الجداول
foreach ($tables as $name => $sql) {
    $conn->query($sql);
}

// إدراج المهام الجديدة وتعيينها لكافة الطلاب
foreach ($tasks as $t) {
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, type, deadline, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $t[0], $t[1], $t[2], $t[3], $t[4]);
    $stmt->execute();
    $tid = $stmt->insert_id;
    
    // جلب كافة الطلاب لتعيين المهمة لهم
    $students = $conn->query("SELECT id FROM users WHERE role='student'");
    while($st = $students->fetch_assoc()) {
        $sid = $st['id'];
        $conn->query("INSERT INTO user_tasks (user_id, task_id, completed) VALUES ($sid, $tid, 0)");
    }
}

// إعادة تفعيل فحص المفاتيح الخارجية
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<h3>✅ تمت التغذية بنجاح!</h3>";
echo "<p>تم تحديث المكتبة الإسلامية وإضافة المهام اليومية المكثفة.</p>";
echo "<p><a href='dashboard.php?page=library'>شاهد المكتبة الإسلامية</a> | <a href='dashboard.php?page=tasks'>ابدأ مهامك اليومية</a></p>";
?>
