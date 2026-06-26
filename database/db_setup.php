<?php

require_once __DIR__ . '/../includes/db.php';

$conn->query("SET FOREIGN_KEY_CHECKS = 0");

$tables_to_drop = [
    'personal_access_tokens', 'remember_me_tokens', 'teacher_applications', 'messages', 'faqs', 'announcements',
    'student_reports', 'student_paths', 'learning_materials', 'attendance', 'sessions',
    'teacher_ratings', 'support_tickets', 'subscriptions', 'notifications', 'payments',
    'recitations', 'surahs', 'submission_files', 'homework_submissions', 'homeworks',
    'halaqa_schedule', 'halaqa_enrollments', 'halaqat', 'path_plans', 'path_levels',
    'learning_paths', 'teachers', 'students', 'pa
rents', 'users', 'roles',
    'exam_results', 'parent_student', 'student_tracking', 'evaluations', 
    'circle_students', 'circles', 'library_items', 'calendar_events', 
    'user_tasks', 'tasks', 'enrollments', 'courses', 'teachers_info', 
    'settings', 'episodes', 'quizzes', 'quiz_questions', 'user_episodes'
];

foreach ($tables_to_drop as $table) {
    $conn->query("DROP TABLE IF EXISTS `$table`");
}

$schema_sql = file_get_contents(__DIR__ . '/schema.sql');

$queries = array_filter(array_map('trim', explode(';', $schema_sql)));

foreach ($queries as $query) {
    if (!empty($query)) {
        if (!$conn->query($query)) {
            echo "Error executing query: " . $conn->error . "<br>Query: " . substr($query, 0, 100) . "...<br>";
        }
    }
}

$conn->query("SET FOREIGN_KEY_CHECKS = 1");

$conn->query("INSERT INTO roles (id, name) VALUES 
(1, 'admin'),
(2, 'teacher'),
(3, 'student'),
(4, 'parent')");

$pass = password_hash("123456", PASSWORD_DEFAULT);

$conn->query("INSERT INTO users (id, name, email, password, role_id, status) VALUES 
(1, 'مدير المنصة', 'admin@mishkat.com', '$pass', 1, 'active')");

$conn->query("INSERT INTO users (id, name, email, password, role_id, status) VALUES 
(2, 'المعلم محمد', 'teacher@mishkat.com', '$pass', 2, 'active')");
$conn->query("INSERT INTO teachers (user_id, specialization, qualification, experience_years, bio) VALUES 
(2, 'التجويد وحفظ القرآن', 'ليسانس دراسات إسلامية وعربية', 5, 'معلم قرآن كريم ومجاز برواية حفص عن عاصم')");

$conn->query("INSERT INTO users (id, name, email, password, role_id, status) VALUES 
(3, 'ولي الأمر خالد', 'parent@mishkat.com', '$pass', 4, 'active')");
$conn->query("INSERT INTO parents (user_id, job, national_id, gender, relation, children_count) VALUES 
(3, 'مهندس برمجيات', '12345678901234', 'male', 'أب', 1)");

$conn->query("INSERT INTO users (id, name, email, password, role_id, status) VALUES 
(4, 'الطالب أحمد', 'student@mishkat.com', '$pass', 3, 'active')");
$conn->query("INSERT INTO students (user_id, parent_id, birth_date, level, join_date, national_id, gender) VALUES 
(4, 1, '2012-05-15', 'المستوى الأول', '2026-05-13', '98765432109876', 'male')");

$conn->query("INSERT INTO learning_paths (id, name, description) VALUES 
(1, 'مسار التجويد الأساسي', 'مسار لتعلم أحكام التجويد ومخارج الحروف الصحيحة'),
(2, 'مسار الحفظ والمراجعة', 'مسار مخصص لحفظ القرآن الكريم كاملاً وتثبيته')");

$conn->query("INSERT INTO path_levels (id, path_id, level_name, description) VALUES 
(1, 1, 'المستوى الأول', 'مخارج الحروف والصفات وتطبيقاتها'),
(2, 2, 'جزء عم', 'حفظ وتثبيت جزء عم مع أحكام التلاوة الأساسية')");

$conn->query("INSERT INTO path_plans (path_id, sessions_count, price) VALUES 
(1, 12, 300.00),
(2, 24, 500.00)");

$conn->query("INSERT INTO surahs (id, name, total_ayahs) VALUES 
(1, 'الضحى', 11),
(2, 'الشرح', 8),
(3, 'التين', 8)");

echo "<h2>✅ تمت إعادة تهيئة قاعدة البيانات بالهيكل الجديد وإدخال البيانات الأولية بنجاح!</h2>";
echo "<p>يرجى العودة لصفحة <a href='../login.php'>تسجيل الدخول</a> واستخدام البيانات التالية: <b>admin@mishkat.com</b> / <b>123456</b></p>";
?>
