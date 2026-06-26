<?php
require_once __DIR__ . '/includes/session.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = $_POST['role'] ?? 'student';
    $password = trim($_POST['password'] ?? '');
    $gender = $_POST['gender'] ?? 'ذكر';
    $age = intval($_POST['age'] ?? 0);
    $location = trim($_POST['location'] ?? '');
    
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $error = 'البريد الإلكتروني مسجل مسبقاً';
    } else {
        $passHash = password_hash($password, PASSWORD_DEFAULT);
        $status = ($role === 'teacher' || $role === 'parent') ? 'pending' : 'active';
        
        $role_ids = ['admin' => 1, 'teacher' => 2, 'student' => 3, 'parent' => 4];
        $role_id = $role_ids[$role] ?? 3;
        
        $db_gender = ($gender === 'أنثى' || $gender === 'female') ? 'female' : 'male';
        
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id, gender, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $name, $email, $passHash, $role_id, $db_gender, $status);
        
        if ($stmt->execute()) {
            $uid = $stmt->insert_id;
            
            if ($role === 'student') {
                $stmt_student = $conn->prepare("INSERT INTO students (user_id, gender, join_date) VALUES (?, ?, NOW())");
                $stmt_student->bind_param("is", $uid, $db_gender);
                $stmt_student->execute();
            }
            
            if ($role === 'teacher') {
                $stmt2 = $conn->prepare("INSERT INTO teachers (user_id, specialization) VALUES (?, ?)");
                $spec = $_POST['specialty'] ?? '';
                $stmt2->bind_param("is", $uid, $spec);
                $stmt2->execute();
            }
            
            if ($role === 'parent') {
                $stmt_parent = $conn->prepare("INSERT INTO parents (user_id, gender) VALUES (?, ?)");
                $stmt_parent->bind_param("is", $uid, $db_gender);
                $stmt_parent->execute();
                $parent_id = $stmt_parent->insert_id;
                
                if (!empty($_POST['son_email']) && $parent_id) {
                    $sonEmail = trim($_POST['son_email']);
                    $sonCheck = $conn->prepare("SELECT s.id FROM students s JOIN users u ON s.user_id = u.id WHERE u.email = ?");
                    $sonCheck->bind_param("s", $sonEmail);
                    $sonCheck->execute();
                    $sonRes = $sonCheck->get_result();
                    if ($son = $sonRes->fetch_assoc()) {
                        $sonId = $son['id'];
                        $stmt_link = $conn->prepare("UPDATE students SET parent_id = ? WHERE id = ?");
                        $stmt_link->bind_param("ii", $parent_id, $sonId);
                        $stmt_link->execute();
                    }
                }
            }
            
            $success = 'تم إنشاء الحساب بنجاح! ' . ($status === 'pending' ? 'بانتظار مراجعة الإدارة.' : 'يمكنك الآن تسجيل الدخول.');
        } else {
            $error = 'حدث خطأ أثناء التسجيل: ' . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انضم لمشكاة | رحلة نورانية</title>
    <?php include 'includes/header_meta.php'; ?>
    <style>
        .role-card { border: 2px solid transparent; transition: all 0.3s; }
        .role-card.active { border-color: #2a7351; background: #f0f7f4; }
        .role-card:hover:not(.active) { border-color: #dceee5; }
    </style>
</head>
<body class="bg-[#f0f4f3] min-h-screen py-10 px-4">

    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <a href="index.php" class="inline-flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-mishkat-green-900 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-mosque text-white text-xl"></i>
                </div>
                <span class="text-3xl font-black text-mishkat-green-900 font-tajawal">مِشكاة</span>
            </a>
            <h1 class="text-4xl font-black text-mishkat-green-900 font-tajawal">ابدأ رحلتك المعرفية</h1>
            <p class="text-gray-500 mt-2 font-bold italic">"من سلك طريقاً يلتمس فيه علماً، سهل الله له به طريقاً إلى الجنة"</p>
        </div>

        <div class="luxury-card overflow-hidden">
            <div class="p-8 md:p-12">
                
                <?php if ($error): ?>
                    <div class="bg-red-50 border-r-4 border-red-500 p-4 rounded-xl mb-8 flex items-center gap-3 animate-fadeIn">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                        <p class="text-red-700 text-sm font-bold"><?php echo $error; ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="bg-emerald-50 border-r-4 border-emerald-500 p-6 rounded-2xl mb-8 text-center animate-fadeIn">
                        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-emerald-900 mb-2">تهانينا!</h3>
                        <p class="text-emerald-700 font-bold"><?php echo $success; ?></p>
                        <a href="login.php" class="inline-block mt-6 px-10 py-3 btn-luxury">تسجيل الدخول</a>
                    </div>
                <?php else: ?>

                <form method="POST" id="registerForm" class="space-y-8">
                    
                    <div>
                        <label class="block text-sm font-black text-mishkat-green-900 mb-4 text-center">بأي صفة تود الانضمام إلينا؟</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="role-card active cursor-pointer p-6 rounded-3xl text-center group" onclick="selectRole('student')">
                                <input type="radio" name="role" value="student" checked class="hidden">
                                <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-user-graduate text-2xl text-mishkat-green-600"></i>
                                </div>
                                <h4 class="font-black text-mishkat-green-900">طالب علم</h4>
                                <p class="text-[10px] text-gray-400 mt-1">لتعلم العلوم الشرعية</p>
                            </label>
                            
                            <label class="role-card cursor-pointer p-6 rounded-3xl text-center group" onclick="selectRole('teacher')">
                                <input type="radio" name="role" value="teacher" class="hidden">
                                <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-chalkboard-teacher text-2xl text-mishkat-green-600"></i>
                                </div>
                                <h4 class="font-black text-mishkat-green-900">معلم / محفظ</h4>
                                <p class="text-[10px] text-gray-400 mt-1">لنشر العلم والقرآن</p>
                            </label>

                            <label class="role-card cursor-pointer p-6 rounded-3xl text-center group" onclick="selectRole('parent')">
                                <input type="radio" name="role" value="parent" class="hidden">
                                <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-family-restroom text-2xl text-mishkat-green-600"></i>
                                </div>
                                <h4 class="font-black text-mishkat-green-900">ولي أمر</h4>
                                <p class="text-[10px] text-gray-400 mt-1">لمتابعة الأبناء</p>
                            </label>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">الاسم الثلاثي</label>
                            <input type="text" name="name" required placeholder="أدخل اسمك الكامل" 
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">البريد الإلكتروني</label>
                            <input type="email" name="email" required placeholder="example@mishkat.com" 
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">رقم الهاتف</label>
                            <input type="tel" name="phone" placeholder="01xxxxxxxx" 
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">كلمة المرور</label>
                            <input type="password" name="password" required placeholder="••••••••" 
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-gray-50">
                        <div class="space-y-2">
                            <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">الجنس</label>
                            <select name="gender" class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                                <option value="ذكر">ذكر</option>
                                <option value="أنثى">أنثى</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">العمر</label>
                            <input type="number" name="age" placeholder="25" 
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">السكن / المدينة</label>
                            <input type="text" name="location" placeholder="المدينة، الدولة" 
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                        </div>
                    </div>

                    
                    <div id="specialtyField" class="hidden animate-fadeIn space-y-2">
                        <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">التخصص التعليمي</label>
                        <input type="text" name="specialty" placeholder="مثال: تجويد، تفسير، لغة عربية" 
                               class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                    </div>

                    
                    <div id="sonField" class="hidden animate-fadeIn space-y-2">
                        <label class="text-xs font-black text-mishkat-green-800 uppercase px-2">البريد الإلكتروني للابن (المسجل مسبقاً)</label>
                        <input type="email" name="son_email" placeholder="student@mishkat.com" 
                               class="w-full px-6 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 rounded-2xl outline-none font-bold">
                        <p class="text-[10px] text-amber-600 font-bold px-2">ملاحظة: يجب أن يكون حساب الطالب مسجلاً مسبقاً ليتم الربط التلقائي.</p>
                    </div>

                    <div class="flex items-center gap-3 px-2">
                        <input type="checkbox" required class="w-5 h-5 accent-mishkat-green-600">
                        <p class="text-xs text-gray-500 font-bold">أوافق على <a href="#" class="text-mishkat-green-600 underline">شروط الاستخدام</a> و <a href="#" class="text-mishkat-green-600 underline">سياسة الخصوصية</a> لمنصة مشكاة.</p>
                    </div>

                    <button type="submit" class="w-full py-5 btn-luxury text-xl shadow-2xl shadow-mishkat-green-900/20">
                        تأكيد إنشاء الحساب
                    </button>

                    <div class="text-center pt-6">
                        <p class="text-sm text-gray-500 font-bold">لديك حساب بالفعل؟ <a href="login.php" class="text-mishkat-green-600 hover:text-mishkat-green-700 font-black">تسجيل الدخول من هنا</a></p>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function selectRole(role) {
            document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
            const selectedCard = event.currentTarget;
            selectedCard.classList.add('active');
            selectedCard.querySelector('input').checked = true;

            const specialtyField = document.getElementById('specialtyField');
            const sonField = document.getElementById('sonField');
            
            specialtyField.classList.add('hidden');
            sonField.classList.add('hidden');

            if (role === 'teacher') {
                specialtyField.classList.remove('hidden');
            } else if (role === 'parent') {
                sonField.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
