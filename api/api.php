<?php
/**
 * Mishkat Platform API
 * Handles all AJAX requests for dashboard functionality
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/session.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Helper function to output JSON and exit
function jsonOut($data) {
    echo json_encode($data);
    exit();
}

// Check authorization
if (!isset($_SESSION['user_id'])) {
    jsonOut(['success' => false, 'message' => 'غير مصرح لك بالوصول - يرجى تسجيل الدخول']);
}

$uid = $_SESSION['user_id'];
$role = $_SESSION['user_role'] ?? '';
$action = $_REQUEST['action'] ?? '';

// Helper to handle file uploads
function handleUpload($field) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $dir = __DIR__ . '/../uploads/';
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
    $name = uniqid('file_') . '.' . $ext;
    $target = $dir . $name;
    if (move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
        return 'uploads/' . $name;
    }
    return null;
}

function denied() {
    jsonOut(['success' => false, 'message' => 'عذراً، ليس لديك صلاحية تنفيذ هذا الإجراء. دورك الحالي: ' . $_SESSION['user_role']]);
}

switch ($action) {
    // ── قسم المهام (TASKS) ──
    case 'get_tasks':
        $r = $conn->query("SELECT ut.*, t.title, t.type, t.deadline FROM user_tasks ut JOIN tasks t ON ut.task_id = t.id WHERE ut.user_id = $uid ORDER BY ut.completed ASC, t.deadline ASC");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    case 'toggle_task':
        $tid = intval($_POST['id']);
        $status = intval($_POST['status']);
        $conn->query("UPDATE user_tasks SET completed = $status, completion_date = " . ($status ? "NOW()" : "NULL") . " WHERE task_id = $tid AND user_id = $uid");
        jsonOut(['success' => true]);
        break;

    // ── قسم الإشعارات (NOTIFICATIONS) ──
    case 'get_notifications':
        $r = $conn->query("SELECT * FROM notifications WHERE user_id = $uid ORDER BY created_at DESC LIMIT 10");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    // ── قسم التقويم (CALENDAR) ──
    case 'get_events':
        $r = $conn->query("SELECT * FROM calendar_events WHERE user_id = $uid ORDER BY event_date ASC");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    // ── قسم الدورات (COURSES) ──
    case 'get_courses':
        $r = $conn->query("SELECT * FROM courses WHERE status = 'active'");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    case 'add_course':
        if($role!=='admin') denied();
        $stmt=$conn->prepare("INSERT INTO courses (title, type, description, sessions_count, price, color) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("ssssis", $_POST['title'], $_POST['type'], $_POST['description'], $_POST['sessions_count'], $_POST['price'], $_POST['color']);
        $stmt->execute();
        jsonOut(['success'=>true]);
        break;

    case 'delete_course':
        if($role!=='admin') denied();
        $cid = intval($_POST['course_id']);
        $conn->query("DELETE FROM courses WHERE id=$cid");
        jsonOut(['success'=>true]);
        break;

    // ── قسم الحلقات والدروس (EPISODES) ──
    case 'get_episodes':
        $cid = intval($_GET['course_id'] ?? 0);
        $r = $conn->query("SELECT e.*, 
                   (SELECT COUNT(*) FROM quizzes q WHERE q.episode_id = e.id) as has_quiz,
                   IFNULL((SELECT completed FROM user_episodes WHERE user_id=$uid AND episode_id=e.id), 0) as completed
                   FROM episodes e WHERE e.course_id = $cid ORDER BY e.created_at ASC");
        $d = []; while($row = $r->fetch_assoc()) $d[] = $row;
        jsonOut(['success' => true, 'data' => $d]);
        break;

    case 'add_episode':
        if($role!=='admin' && $role!=='teacher') denied();
        $target = handleUpload('video_file');
        $cdata = $target ? $target : ($_POST['content_data'] ?? '');
        $ctype = $target ? 'file' : ($_POST['content_type'] ?? 'text');
        $stmt=$conn->prepare("INSERT INTO episodes (course_id, teacher_id, title, description, content_type, content_data) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("iissss", $_POST['course_id'], $uid, $_POST['title'], $_POST['description'], $ctype, $cdata);
        $stmt->execute();
        jsonOut(['success'=>true]);
        break;

    case 'update_episode':
        if($role!=='admin' && $role!=='teacher') denied();
        $eid = intval($_POST['episode_id']);
        $target = handleUpload('video_file');
        if($target) {
            $stmt=$conn->prepare("UPDATE episodes SET title=?, description=?, course_id=?, content_data=?, content_type='file' WHERE id=?");
            $stmt->bind_param("ssisi", $_POST['title'], $_POST['description'], $_POST['course_id'], $target, $eid);
        } else {
            $stmt=$conn->prepare("UPDATE episodes SET title=?, description=?, course_id=?, content_data=?, content_type=? WHERE id=?");
            $stmt->bind_param("ssissi", $_POST['title'], $_POST['description'], $_POST['course_id'], $_POST['content_data'], $_POST['content_type'], $eid);
        }
        $stmt->execute();
        jsonOut(['success'=>true]);
        break;

    case 'delete_episode':
        if($role!=='admin' && $role!=='teacher') denied();
        $eid = intval($_POST['episode_id']);
        $conn->query("DELETE FROM episodes WHERE id=$eid");
        jsonOut(['success'=>true]);
        break;

    case 'complete_episode':
        $eid = intval($_POST['episode_id']);
        $conn->query("INSERT INTO user_episodes (user_id, episode_id, completed, completed_at) VALUES ($uid, $eid, 1, NOW()) ON DUPLICATE KEY UPDATE completed=1, completed_at=NOW()");
        jsonOut(['success'=>true]);
        break;

    // ── قسم الاختبارات (QUIZZES) ──
    case 'get_episode_quiz':
        $eid = intval($_GET['episode_id'] ?? 0);
        $q = $conn->query("SELECT * FROM quizzes WHERE episode_id=$eid")->fetch_assoc();
        if(!$q) jsonOut(['success'=>false, 'message' => 'لا يوجد اختبار لهذه الحلقة']);
        $res = $conn->query("SELECT * FROM quiz_questions WHERE quiz_id=".$q['id']);
        $qs = []; while($row=$res->fetch_assoc()) {
            $row['options'] = json_decode($row['options']);
            $qs[] = $row;
        }
        jsonOut(['success'=>true, 'quiz'=>$q, 'questions'=>$qs]);
        break;

    case 'add_quiz':
        if($role!=='admin' && $role!=='teacher') denied();
        $eid = intval($_POST['episode_id']);
        $title = $_POST['title'];
        $questions = json_decode($_POST['questions'], true);
        $conn->query("DELETE FROM quizzes WHERE episode_id=$eid"); 
        $conn->query("INSERT INTO quizzes (episode_id, title) VALUES ($eid, '$title')");
        $qid = $conn->insert_id;
        $stmt = $conn->prepare("INSERT INTO quiz_questions (quiz_id, question, options, correct_answer) VALUES (?,?,?,?)");
        foreach($questions as $q) {
            $opts = json_encode($q['options'], JSON_UNESCAPED_UNICODE);
            $stmt->bind_param("isss", $qid, $q['question'], $opts, $q['correct_answer']);
            $stmt->execute();
        }
        jsonOut(['success'=>true]);
        break;

    case 'submit_quiz_result':
        $eid = intval($_POST['episode_id']);
        $score = intval($_POST['score']);
        $total = intval($_POST['total']);
        $pct = ($score / $total) * 100;
        $conn->query("INSERT INTO exam_results (user_id, exam_title, score, total, percentage) VALUES ($uid, 'اختبار الحلقة #$eid', $score, $total, $pct)");
        if($pct >= 50) {
            $conn->query("INSERT INTO user_episodes (user_id, episode_id, completed, completed_at) VALUES ($uid, $eid, 1, NOW()) ON DUPLICATE KEY UPDATE completed=1, completed_at=NOW()");
        }
        jsonOut(['success'=>true]);
        break;

    // ── إدارة المستخدمين (ADMIN) ──
    case 'toggle_user_status':
        if($role!=='admin') denied();
        $uid_t = intval($_POST['user_id']);
        if (isset($_POST['force_status'])) {
            $newS = $_POST['force_status'];
        } else {
            $u = $conn->query("SELECT status FROM users WHERE id=$uid_t")->fetch_assoc();
            $newS = ($u['status']==='active') ? 'suspended' : 'active';
        }
        $stmt = $conn->prepare("UPDATE users SET status=? WHERE id=?");
        $stmt->bind_param("si", $newS, $uid_t);
        if($stmt->execute()) {
            jsonOut(['success'=>true]);
        } else {
            jsonOut(['success'=>false, 'message'=>'فشل تحديث الحالة: ' . $conn->error]);
        }
        break;

    case 'delete_user':
        if($role!=='admin') denied();
        $uid_t = intval($_POST['user_id']);
        $conn->query("DELETE FROM users WHERE id=$uid_t");
        jsonOut(['success'=>true]);
        break;

    case 'get_students':
        if($role!=='admin' && $role!=='teacher') denied();
        $r=$conn->query("SELECT u.id,u.name,u.email,u.phone,u.status,u.created_at FROM users u WHERE u.role='student' ORDER BY u.created_at DESC");
        $d=[]; while($row=$r->fetch_assoc()) $d[]=$row;
        jsonOut(['success'=>true,'data'=>$d]);
        break;

    case 'update_profile_image':
        $target = handleUpload('profile_image');
        if($target) {
            $stmt = $conn->prepare("UPDATE users SET profile_image=? WHERE id=?");
            $stmt->bind_param("si", $target, $uid);
            $stmt->execute();
            jsonOut(['success'=>true, 'image_url'=>$target]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل رفع الصورة']);
        break;

    case 'update_student_profile':
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $age = intval($_POST['age'] ?? 0);
        $location = $_POST['location'] ?? '';
        
        $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, gender=?, age=?, location=? WHERE id=?");
        $stmt->bind_param("sssisi", $name, $phone, $gender, $age, $location, $uid);
        if($stmt->execute()) {
            $_SESSION['user_name'] = $name; // Update session name
            jsonOut(['success'=>true]);
        }
        jsonOut(['success'=>false, 'message'=>'فشل تحديث البيانات']);
        break;

    case 'get_profile':
        $r=$conn->query("SELECT id,name,email,phone,gender,location,role,status,created_at FROM users WHERE id=$uid")->fetch_assoc();
        jsonOut(['success'=>true,'data'=>$r]);
        break;

    default:
        jsonOut(['success'=>false,'message'=>'الإجراء المطلوب غير موجود: '.$action]);
}
