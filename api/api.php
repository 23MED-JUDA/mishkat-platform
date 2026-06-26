<?php
// ── إخفاء الأخطاء وتشغيل output buffer قبل أي شيء ──
error_reporting(0);
ini_set('display_errors', 0);
ob_start();

header('Content-Type: application/json');
require_once __DIR__ . '/../includes/session.php';

// دالة إرجاع JSON — تمسح الـ buffer لتجنب أي HTML خاطئ
function jsonOut($data) {
    if (ob_get_level()) ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit();
}

// اصطياد الأخطاء الحرجة وإرجاعها كـ JSON
register_shutdown_function(function() {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        if (ob_get_level()) ob_end_clean();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'خطأ في الخادم: ' . $err['message']]);
    }
});

// التحقق من الصلاحيات
if (!isset($_SESSION['user_id'])) {
    jsonOut(['success' => false, 'message' => 'غير مصرح لك بالوصول - يرجى تسجيل الدخول']);
}

$uid = $_SESSION['user_id'];
// جلب الدور من قاعدة البيانات، مع fallback للـ session إذا فشل الاتصال
$role = '';
if ($conn) {
    $userQuery = $conn->query("SELECT r.name AS role FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = $uid");
    $userData = $userQuery ? $userQuery->fetch_assoc() : null;
    $role = strtolower($userData['role'] ?? '');
    if ($role) {
        $_SESSION['user_role'] = $role;
    }
}
// fallback: استخدام الدور المحفوظ في الـ session
if (!$role) {
    $role = strtolower($_SESSION['user_role'] ?? '');
}
$action = $_REQUEST['action'] ?? '';

// رفع الملفات
function handleUpload($field, &$error_msg = null) {
    if (!isset($_FILES[$field])) {
        $error_msg = "لم يتم اختيار أي ملف";
        return null;
    }
    
    $file_error = $_FILES[$field]['error'];
    if ($file_error !== UPLOAD_ERR_OK) {
        switch ($file_error) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error_msg = "حجم الصورة كبير جداً، الحد الأقصى المسموح به هو 25 ميجابايت.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_msg = "حدث انقطاع أثناء رفع الصورة، يرجى المحاولة مرة أخرى.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_msg = "لم يتم اختيار أي ملف للرفع.";
                break;
            default:
                $error_msg = "حدث خطأ غير معروف أثناء الرفع (رمز الخطأ: $file_error).";
                break;
        }
        return null;
    }
    
    $dir = __DIR__ . '/../uploads/';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    
    $client_name = $_FILES[$field]['name'] ?? 'unknown';
    $tmp_name    = $_FILES[$field]['tmp_name'] ?? '';

    $ext = strtolower(pathinfo($client_name, PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowed_exts)) {
        $error_msg = "نوع الملف ($ext) غير مدعوم، يرجى رفع صورة بصيغة (JPG, PNG, WEBP, GIF).";
        return null;
    }

    $name   = uniqid('file_') . '.' . $ext;
    $target = $dir . $name;

    if (move_uploaded_file($tmp_name, $target)) {
        return 'uploads/' . $name;
    }

    $error_msg = "فشل نقل الصورة المرفوعة. يرجى مراجعة صلاحيات خادم الويب.";
    return null;
}

function denied() {
    jsonOut(['success' => false, 'message' => 'عذراً، ليس لديك صلاحية تنفيذ هذا الإجراء. دورك الحالي: ' . $_SESSION['user_role']]);
}

switch ($action) {

    // debug: يكشف معلومات الجلسة والدور الحالي (للتشخيص فقط)
    case 'debug_session':
        jsonOut([
            'success'      => true,
            'session_id'   => session_id(),
            'user_id'      => $_SESSION['user_id'] ?? null,
            'user_role'    => $_SESSION['user_role'] ?? null,
            'role_from_db' => $role,
            'db_ok'        => ($conn && !$conn->connect_error),
            'db_error'     => $conn ? $conn->error : 'no connection',
        ]);
        break;

    // المهام
    case 'get_tasks':
        $r = $conn->query("SELECT hs.*, h.title, h.type, h.due_date AS deadline, IF(hs.status = 'completed' OR hs.status = 'graded', 1, 0) AS completed 
                           FROM homework_submissions hs 
                           JOIN homeworks h ON hs.homework_id = h.id 
                           JOIN students s ON hs.student_id = s.id
                           WHERE s.user_id = $uid 
                           ORDER BY completed ASC, h.due_date ASC");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    case 'toggle_task':
        $tid = intval($_POST['id']);
        $status = intval($_POST['status']);
        $status_str = $status ? 'completed' : 'pending';
        
        // جلب معرف الطالب
        $s_res = $conn->query("SELECT id FROM students WHERE user_id = $uid")->fetch_assoc();
        $student_id = $s_res ? $s_res['id'] : 0;
        
        $conn->query("INSERT INTO homework_submissions (homework_id, student_id, status) VALUES ($tid, $student_id, '$status_str') 
                      ON DUPLICATE KEY UPDATE status = '$status_str'");
        jsonOut(['success' => true]);
        break;

    // الإشعارات
    case 'get_notifications':
        $r = $conn->query("SELECT * FROM notifications WHERE user_id = $uid ORDER BY created_at DESC LIMIT 10");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    // التقويم
    case 'get_events':
        // جلب الحصص كأحداث في التقويم بناء على دور المستخدم
        $d = [];
        if ($role === 'student') {
            $r = $conn->query("SELECT s.id, h.name AS title, s.session_link AS description, DATE(s.session_date) AS event_date, TIME(s.session_date) AS event_time, s.session_type AS type, 'emerald' AS color
                               FROM sessions s
                               JOIN halaqat h ON s.halaqa_id = h.id
                               JOIN halaqa_enrollments he ON he.halaqa_id = h.id
                               JOIN students st ON he.student_id = st.id
                               WHERE st.user_id = $uid ORDER BY s.session_date ASC");
            while($row = $r->fetch_assoc()) $d[] = $row;
        } elseif ($role === 'teacher') {
            $r = $conn->query("SELECT s.id, h.name AS title, s.session_link AS description, DATE(s.session_date) AS event_date, TIME(s.session_date) AS event_time, s.session_type AS type, 'emerald' AS color
                               FROM sessions s
                               JOIN halaqat h ON s.halaqa_id = h.id
                               JOIN teachers t ON h.teacher_id = t.id
                               WHERE t.user_id = $uid ORDER BY s.session_date ASC");
            while($row = $r->fetch_assoc()) $d[] = $row;
        } else {
            $r = $conn->query("SELECT s.id, h.name AS title, s.session_link AS description, DATE(s.session_date) AS event_date, TIME(s.session_date) AS event_time, s.session_type AS type, 'emerald' AS color
                               FROM sessions s
                               JOIN halaqat h ON s.halaqa_id = h.id ORDER BY s.session_date ASC");
            while($row = $r->fetch_assoc()) $d[] = $row;
        }
        jsonOut(['success' => true, 'data' => $d]);
        break;

    // الدورات
    case 'get_courses':
        $r = $conn->query("SELECT lp.id, lp.name AS title, lp.description, IFNULL(pp.sessions_count, 0) AS sessions_count, IFNULL(pp.price, 0) AS price, 'emerald' AS color, 'active' AS status 
                           FROM learning_paths lp 
                           LEFT JOIN path_plans pp ON pp.path_id = lp.id");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    case 'add_course':
        if($role!=='admin') denied();
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $sessions = intval($_POST['sessions_count'] ?? 0);
        $price = floatval($_POST['price'] ?? 0);
        
        $stmt = $conn->prepare("INSERT INTO learning_paths (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $desc);
        $stmt->execute();
        $path_id = $stmt->insert_id;
        
        $stmt_plan = $conn->prepare("INSERT INTO path_plans (path_id, sessions_count, price) VALUES (?, ?, ?)");
        $stmt_plan->bind_param("iid", $path_id, $sessions, $price);
        $stmt_plan->execute();
        
        jsonOut(['success'=>true]);
        break;

    case 'delete_course':
        if($role!=='admin') denied();
        $cid = intval($_POST['course_id']);
        $conn->query("DELETE FROM learning_paths WHERE id=$cid");
        jsonOut(['success'=>true]);
        break;

    // المواد التعليمية
    case 'get_episodes':
        $cid = intval($_GET['course_id'] ?? 0);
        $r = $conn->query("SELECT lm.id, lm.title, lm.description, lm.type AS content_type, lm.file_path AS content_data, lm.path_id AS course_id,
                           0 as has_quiz, 0 as completed
                           FROM learning_materials lm WHERE lm.path_id = $cid ORDER BY lm.id ASC");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    case 'add_episode':
        if($role!=='admin' && $role!=='teacher') denied();
        $target = handleUpload('video_file');
        $cdata = $target ? $target : ($_POST['content_data'] ?? '');
        $ctype = $target ? 'video' : ($_POST['content_type'] ?? 'pdf');
        if ($ctype === 'text') $ctype = 'pdf'; // ملاءمة الأنواع للـ ENUM الجديد
        
        $stmt=$conn->prepare("INSERT INTO learning_materials (path_id, title, description, type, file_path) VALUES (?,?,?,?,?)");
        $stmt->bind_param("issss", $_POST['course_id'], $_POST['title'], $_POST['description'], $ctype, $cdata);
        $stmt->execute();
        jsonOut(['success'=>true]);
        break;

    case 'update_episode':
        if($role!=='admin' && $role!=='teacher') denied();
        $eid = intval($_POST['episode_id']);
        $target = handleUpload('video_file');
        if($target) {
            $stmt=$conn->prepare("UPDATE learning_materials SET title=?, description=?, path_id=?, file_path=?, type='video' WHERE id=?");
            $stmt->bind_param("ssisi", $_POST['title'], $_POST['description'], $_POST['course_id'], $target, $eid);
        } else {
            $ctype = $_POST['content_type'] ?? 'pdf';
            if ($ctype === 'text') $ctype = 'pdf';
            $stmt=$conn->prepare("UPDATE learning_materials SET title=?, description=?, path_id=?, file_path=?, type=? WHERE id=?");
            $stmt->bind_param("ssissi", $_POST['title'], $_POST['description'], $_POST['course_id'], $_POST['content_data'], $ctype, $eid);
        }
        $stmt->execute();
        jsonOut(['success'=>true]);
        break;

    case 'delete_episode':
        if($role!=='admin' && $role!=='teacher') denied();
        $eid = intval($_POST['episode_id']);
        $conn->query("DELETE FROM learning_materials WHERE id=$eid");
        jsonOut(['success'=>true]);
        break;

    case 'complete_episode':
        // لا يوجد جدول إكمال للمواد التعليمية في الهيكل الجديد، يتم إرجاع نجاح مباشرة
        jsonOut(['success'=>true]);
        break;

    // الاختبارات
    case 'get_episode_quiz':
        jsonOut(['success'=>false, 'message' => 'لا يوجد اختبارات حالياً في الهيكل الجديد']);
        break;

    case 'add_quiz':
        jsonOut(['success'=>true]);
        break;

    case 'submit_quiz_result':
        jsonOut(['success'=>true]);
        break;

    // إدارة المستخدمين
    case 'toggle_user_status':
        if($role!=='admin') denied();
        $uid_t = intval($_POST['user_id']);
        if (isset($_POST['force_status'])) {
            $newS = $_POST['force_status'];
            if ($newS === 'suspended') {
                $newS = 'inactive';
            }
        } else {
            $u = $conn->query("SELECT status FROM users WHERE id=$uid_t")->fetch_assoc();
            $newS = ($u['status']==='active') ? 'inactive' : 'active';
        }
        $stmt = $conn->prepare("UPDATE users SET status=? WHERE id=?");
        $stmt->bind_param("si", $newS, $uid_t);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        } else {
            jsonOut(['success'=>false, 'message'=>'فشل تحديث الحالة: ' . $conn->error]);
        }
        break;

    case 'approve_teacher':
        if($role!=='admin') denied();
        $uid_t = intval($_POST['user_id']);
        // نتحقق من أن المستخدم معلم فعلاً
        $chk = $conn->query("SELECT id, status FROM users WHERE id=$uid_t AND role_id=2");
        if (!$chk || $chk->num_rows === 0) {
            jsonOut(['success'=>false, 'message'=>'لم يتم العثور على معلم بهذا المعرّف']);
        }
        $stmt = $conn->prepare("UPDATE users SET status='active' WHERE id=?");
        $stmt->bind_param("i", $uid_t);
        if($stmt->execute() && $stmt->affected_rows >= 0) {
            jsonOut(['success'=>true, 'message'=>'تم قبول المعلم وتفعيل حسابه بنجاح']);
        } else {
            jsonOut(['success'=>false,'message'=>'فشل اعتماد المعلم: '.$conn->error]);
        }
        break;

    case 'reject_teacher':
        if($role!=='admin') denied();
        $uid_t = intval($_POST['user_id']);
        // نتحقق من أن المستخدم معلم فعلاً
        $chk2 = $conn->query("SELECT id FROM users WHERE id=$uid_t AND role_id=2");
        if (!$chk2 || $chk2->num_rows === 0) {
            jsonOut(['success'=>false, 'message'=>'لم يتم العثور على معلم بهذا المعرّف']);
        }
        $stmt = $conn->prepare("UPDATE users SET status='inactive' WHERE id=?");
        $stmt->bind_param("i", $uid_t);
        if($stmt->execute() && $stmt->affected_rows >= 0) {
            jsonOut(['success'=>true, 'message'=>'تم رفض طلب المعلم']);
        } else {
            jsonOut(['success'=>false,'message'=>'فشل رفض المعلم: '.$conn->error]);
        }
        break;

    case 'approve_all_teachers':
        if($role!=='admin') denied();
        $result = $conn->query("UPDATE users SET status='active' WHERE role_id=2 AND status='pending'");
        if($result) {
            $count = $conn->affected_rows;
            jsonOut(['success'=>true, 'count'=>$count, 'message'=>"تم قبول $count معلم بنجاح"]);
        } else {
            jsonOut(['success'=>false, 'message'=>'فشل تحديث المعلمين: '.$conn->error]);
        }
        break;

    case 'delete_user':
        if($role!=='admin') denied();
        $uid_t = intval($_POST['user_id']);
        // Determine user role to clean up related tables
        $roleRes = $conn->query("SELECT role_id FROM users WHERE id=$uid_t")->fetch_assoc();
        $roleId = $roleRes['role_id'] ?? null;
        // Delete role‑specific record if exists
        if($roleId == 2) { // teacher
            $conn->query("DELETE FROM teachers WHERE user_id=$uid_t");
        } elseif($roleId == 3) { // student
            $conn->query("DELETE FROM students WHERE user_id=$uid_t");
        } elseif($roleId == 4) { // parent
            $conn->query("DELETE FROM parents WHERE user_id=$uid_t");
        }
        // Finally delete the user row
        $conn->query("DELETE FROM users WHERE id=$uid_t");
        jsonOut(['success'=>true]);
        break;

    case 'add_user':
        if($role!=='admin') denied();
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = password_hash($_POST['password'] ?? '123456', PASSWORD_DEFAULT);
        $user_role = $_POST['role'] ?? 'student';
        
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            jsonOut(['success' => false, 'message' => 'البريد الإلكتروني مسجل بالفعل لمستخدم آخر']);
        }
        
        $role_ids = ['admin' => 1, 'teacher' => 2, 'student' => 3, 'parent' => 4];
        $role_id = $role_ids[$user_role] ?? 3;
        
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id, status) VALUES (?, ?, ?, ?, 'active')");
        $stmt->bind_param("sssi", $name, $email, $password, $role_id);
        if($stmt->execute()) {
            $new_uid = $stmt->insert_id;
            
            // إدراج سجل في جدول الملف الشخصي الخاص بالدور
            if ($user_role === 'student') {
                $conn->query("INSERT INTO students (user_id) VALUES ($new_uid)");
            } elseif ($user_role === 'teacher') {
                $conn->query("INSERT INTO teachers (user_id) VALUES ($new_uid)");
            } elseif ($user_role === 'parent') {
                $conn->query("INSERT INTO parents (user_id) VALUES ($new_uid)");
            }
            
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل إضافة المستخدم في قاعدة البيانات']);
        break;

    case 'add_circle':
        if($role!=='admin' && $role!=='teacher') denied();
        $name = $_POST['name'] ?? '';
        $teacher_user_id = intval($_POST['teacher_id'] ?? 0); // هذا يمثل user_id للمعلم
        if ($role === 'teacher') {
            $teacher_user_id = $uid;
        }
        $max_students = intval($_POST['max_students'] ?? 20);
        
        // جلب معرف المعلم من جدول teachers
        $t_res = $conn->query("SELECT id FROM teachers WHERE user_id = $teacher_user_id")->fetch_assoc();
        $teacher_id = $t_res ? $t_res['id'] : null;
        
        $stmt = $conn->prepare("INSERT INTO halaqat (name, teacher_id, max_students) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $name, $teacher_id, $max_students);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل إضافة الحلقة في قاعدة البيانات']);
        break;

    case 'delete_circle':
        if($role!=='admin' && $role!=='teacher') denied();
        $circle_id = intval($_POST['circle_id'] ?? 0);
        if ($role === 'teacher') {
            $t_res = $conn->query("SELECT id FROM teachers WHERE user_id = $uid")->fetch_assoc();
            $teacher_id = $t_res ? $t_res['id'] : 0;
            $check = $conn->query("SELECT id FROM halaqat WHERE id=$circle_id AND teacher_id=$teacher_id")->fetch_assoc();
            if (!$check) denied();
        }
        $conn->query("DELETE FROM halaqat WHERE id=$circle_id");
        jsonOut(['success'=>true]);
        break;

    case 'send_notification':
        if($role!=='admin') denied();
        $to_user = intval($_POST['to_user'] ?? 0);
        $title = $_POST['title'] ?? '';
        $message = $_POST['message'] ?? '';
        
        $stmt = $conn->prepare("INSERT INTO notifications (user_id, title, message, is_read, created_at) VALUES (?, ?, ?, 0, NOW())");
        $stmt->bind_param("iss", $to_user, $title, $message);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل إرسال الإشعار في قاعدة البيانات']);
        break;

    case 'get_students':
        if($role!=='admin' && $role!=='teacher') denied();
        $r=$conn->query("SELECT u.id, u.name, u.email, '' AS phone, u.status, u.created_at 
                         FROM students s 
                         JOIN users u ON s.user_id = u.id 
                         ORDER BY u.created_at DESC");
        $d=[]; while($row=$r->fetch_assoc()) $d[]=$row;
        jsonOut(['success'=>true,'data'=>$d]);
        break;

    case 'update_profile_image':
        $error_msg = '';
        $target = handleUpload('profile_image', $error_msg);
        if($target) {
            // لا يوجد حقل avatar أو profile_image في جدول users الجديد، نرجع النجاح ليعرض بالواجهة
            jsonOut(['success'=>true, 'image_url'=>$target]);
        }
        jsonOut(['success'=>false, 'message'=>$error_msg]);
        break;

    case 'update_student_profile':
        $name = $_POST['name'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $db_gender = ($gender === 'أنثى' || $gender === 'female') ? 'female' : 'male';
        
        $stmt = $conn->prepare("UPDATE users SET name=?, gender=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $db_gender, $uid);
        if($stmt->execute()) {
            $_SESSION['user_name'] = $name; // تحديث الاسم في الجلسة
            
            // تحديث جدول الطلاب أيضاً
            $stmt_s = $conn->prepare("UPDATE students SET gender=? WHERE user_id=?");
            $stmt_s->bind_param("si", $db_gender, $uid);
            $stmt_s->execute();
            
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل تحديث البيانات']);
        break;

    case 'change_password':
        $old_pass = $_POST['old_password'] ?? '';
        $new_pass = $_POST['new_password'] ?? '';
        if (empty($old_pass) || empty($new_pass)) {
            jsonOut(['success' => false, 'message' => 'جميع الحقول مطلوبة']);
        }
        $u = $conn->query("SELECT password FROM users WHERE id=$uid")->fetch_assoc();
        if (!$u || !password_verify($old_pass, $u['password'])) {
            jsonOut(['success' => false, 'message' => 'كلمة المرور الحالية غير صحيحة']);
        }
        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $new_hash, $uid);
        if ($stmt->execute()) {
            jsonOut(['success' => true]);
        }
        jsonOut(['success' => false, 'message' => 'فشل تحديث كلمة المرور']);
        break;

    case 'update_teacher_profile':
        if ($role !== 'teacher') denied();
        $name = $_POST['name'] ?? '';
        $specialty = $_POST['specialty'] ?? '';
        $experience = intval($_POST['experience'] ?? 0);
        $bio = $_POST['bio'] ?? '';
        $cv_url = $_POST['cv_url'] ?? '';
        
        $stmt = $conn->prepare("UPDATE users SET name=? WHERE id=?");
        $stmt->bind_param("si", $name, $uid);
        $stmt->execute();
        
        $_SESSION['user_name'] = $name;
        
        $stmt_t = $conn->prepare("INSERT INTO teachers (user_id, specialization, experience_years, bio, cv_file) 
                                  VALUES (?, ?, ?, ?, ?) 
                                  ON DUPLICATE KEY UPDATE specialization=?, experience_years=?, bio=?, cv_file=?");
        $stmt_t->bind_param("isississs", $uid, $specialty, $experience, $bio, $cv_url, $specialty, $experience, $bio, $cv_url);
        if ($stmt_t->execute()) {
            jsonOut(['success' => true]);
        }
        jsonOut(['success' => false, 'message' => 'فشل تحديث البيانات المهنية']);
        break;

    case 'link_student':
        if ($role !== 'parent') denied();
        $student_name = $_POST['student_name'] ?? '';
        $student_email = $_POST['student_email'] ?? '';
        
        $r = $conn->query("SELECT u.id, s.id AS s_id 
                           FROM users u 
                           JOIN roles r ON u.role_id = r.id 
                           JOIN students s ON s.user_id = u.id 
                           WHERE u.email='" . $conn->real_escape_string($student_email) . "' AND r.name='student'")->fetch_assoc();
        if (!$r) {
            jsonOut(['success' => false, 'message' => 'لم يتم العثور على طالب بهذا البريد الإلكتروني']);
        }
        
        $p = $conn->query("SELECT id FROM parents WHERE user_id = $uid")->fetch_assoc();
        if (!$p) {
            jsonOut(['success' => false, 'message' => 'لم يتم العثور على ملف ولي الأمر الخاص بك']);
        }
        $parent_id = $p['id'];
        $student_id = $r['s_id'];
        
        $stmt = $conn->prepare("UPDATE students SET parent_id=? WHERE id=?");
        $stmt->bind_param("ii", $parent_id, $student_id);
        if ($stmt->execute()) {
            jsonOut(['success' => true, 'message' => 'تم ربط الطالب بنجاح!']);
        }
        jsonOut(['success' => false, 'message' => 'فشل عملية ربط الطالب']);
        break;

    case 'add_evaluation':
        if($role!=='admin' && $role!=='teacher') denied();
        $student_id = intval($_POST['student_id'] ?? 0);
        $memorization = intval($_POST['memorization'] ?? 0);
        $tajweed = intval($_POST['tajweed'] ?? 0);
        $behavior = intval($_POST['behavior'] ?? 0);
        $attendance = intval($_POST['attendance'] ?? 0);
        $notes = $_POST['notes'] ?? '';
        
        $stmt = $conn->prepare("INSERT INTO evaluations (student_id, teacher_id, memorization, tajweed, behavior, attendance, notes, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiiiiis", $student_id, $uid, $memorization, $tajweed, $behavior, $attendance, $notes);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل حفظ التقييم في قاعدة البيانات']);
        break;

    case 'get_library':
        $category = $_GET['category'] ?? '';
        if ($category !== '') {
            $stmt = $conn->prepare("SELECT * FROM library_items WHERE category = ? ORDER BY id DESC");
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $r = $stmt->get_result();
        } else {
            $r = $conn->query("SELECT * FROM library_items ORDER BY id DESC");
        }
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    case 'add_library_item':
        if($role!=='admin' && $role!=='teacher') denied();
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $type = $_POST['type'] ?? '';
        $file_url = $_POST['file_url'] ?? '';
        $description = $_POST['description'] ?? '';
        
        $stmt = $conn->prepare("INSERT INTO library_items (title, category, type, file_url, description, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $title, $category, $type, $file_url, $description);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل إضافة المادة في المكتبة']);
        break;

    case 'update_library_item':
        if($role!=='admin' && $role!=='teacher') denied();
        $item_id = intval($_POST['item_id'] ?? 0);
        $title = $_POST['title'] ?? '';
        $category = $_POST['category'] ?? '';
        $type = $_POST['type'] ?? '';
        $file_url = $_POST['file_url'] ?? '';
        $description = $_POST['description'] ?? '';
        
        $stmt = $conn->prepare("UPDATE library_items SET title=?, category=?, type=?, file_url=?, description=? WHERE id=?");
        $stmt->bind_param("sssssi", $title, $category, $type, $file_url, $description, $item_id);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل تحديث المادة في المكتبة']);
        break;

    case 'delete_library_item':
        if($role!=='admin' && $role!=='teacher') denied();
        $item_id = intval($_POST['item_id'] ?? 0);
        
        $stmt = $conn->prepare("DELETE FROM library_items WHERE id=?");
        $stmt->bind_param("i", $item_id);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل حذف المادة من المكتبة']);
        break;

    case 'get_profile':
        $r=$conn->query("SELECT u.id, u.name, u.email, '' AS phone, u.gender, '' AS location, r.name AS role, u.status, u.created_at 
                         FROM users u 
                         JOIN roles r ON u.role_id = r.id 
                         WHERE u.id = $uid")->fetch_assoc();
        jsonOut(['success'=>true,'data'=>$r]);
        break;

    default:
        jsonOut(['success'=>false,'message'=>'الإجراء المطلوب غير موجود: '.$action]);
}
