<?php
require_once __DIR__ . '/includes/session.php';

if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $selected_role = trim($_POST['role_choice'] ?? 'student');

    $stmt = $conn->prepare("SELECT id, name, email, password, role, status FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $selected_role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            if ($user['status'] === 'suspended') {
                $error = 'عذراً، هذا الحساب معلق حالياً. يرجى التواصل مع الإدارة.';
            } elseif ($user['status'] === 'pending') {
                $error = 'حسابك قيد المراجعة حالياً، يرجى انتظار موافقة الإدارة لتتمكن من الدخول';
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                
                // تذكرني - حفظ الكوكيز لمدة 30 يوم
                if (isset($_POST['remember'])) {
                    setcookie('mishkat_user', $user['id'], time() + (30 * 24 * 60 * 60), "/");
                }
                
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $error = 'كلمة المرور غير صحيحة';
        }
    } else {
        // Smart feedback: check if the email exists in another role
        $stmt_exists = $conn->prepare("SELECT role FROM users WHERE email = ?");
        $stmt_exists->bind_param("s", $email);
        $stmt_exists->execute();
        $res_exists = $stmt_exists->get_result();
        if ($row_exists = $res_exists->fetch_assoc()) {
            $actual_role = $row_exists['role'];
            $role_names = ['student' => 'طالب', 'teacher' => 'معلم', 'parent' => 'ولي أمر', 'admin' => 'مسؤول'];
            $actual_role_name = $role_names[$actual_role] ?? $actual_role;
            $selected_role_name = $role_names[$selected_role] ?? $selected_role;
            $error = 'البريد الإلكتروني مسجل كـ (' . $actual_role_name . ') وليس كـ (' . $selected_role_name . '). يرجى اختيار نوع الحساب الصحيح.';
        } else {
            $error = 'البريد الإلكتروني غير مسجل لدينا بالمنصة';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | مِشكاة</title>
    <?php include 'includes/header_meta.php'; ?>
</head>
<body class="bg-[#f0f4f3] flex items-center justify-center min-h-screen p-3 md:p-4 overflow-x-hidden relative">

    <!-- Background Elements -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-mishkat-green-100/50 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-mishkat-beige-100/50 rounded-full blur-[120px]"></div>

    <div class="w-full max-w-6xl luxury-card overflow-hidden flex flex-col md:flex-row relative z-10 shadow-2xl md:min-h-[600px]">
        
        <!-- Branding Side -->
        <div class="w-full md:w-1/2 bg-mishkat-green-900 p-6 md:p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-full h-full opacity-10">
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 0 L100 0 L100 100 L0 100 Z" fill="url(#grad)" />
                    <defs>
                        <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#2a7351;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#193d2e;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <div class="relative z-10">
                <a href="index.php" class="flex items-center gap-3 mb-6 md:mb-12">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-mishkat-gold-500 rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg shadow-mishkat-gold-900/20">
                        <i class="fas fa-book-open text-white text-lg md:text-xl"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-black font-tajawal">مِشكاة</span>
                </a>
                <h1 class="text-2xl md:text-4xl font-black mb-3 md:mb-6 leading-tight font-tajawal">نورٌ في طريق<br><span class="text-mishkat-gold-400">العلم والهدى</span></h1>
                <p class="text-mishkat-green-100 text-sm md:text-lg leading-relaxed max-w-sm">انضم إلينا في رحلة معرفية فريدة تهدف إلى تزكية النفس ونشر قيم العلم الشرعي والوسطية.</p>
            </div>

            <div class="relative z-10 pt-8 md:pt-12 hidden sm:block">
                <div class="flex gap-4">
                    <div class="p-3 bg-white/5 rounded-2xl backdrop-blur-sm border border-white/10 text-center flex-1">
                        <p class="text-2xl font-black text-mishkat-gold-300">10k+</p>
                        <p class="text-[10px] uppercase font-bold text-mishkat-green-300">طالب نشط</p>
                    </div>
                    <div class="p-3 bg-white/5 rounded-2xl backdrop-blur-sm border border-white/10 text-center flex-1">
                        <p class="text-2xl font-black text-mishkat-gold-300">50+</p>
                        <p class="text-[10px] uppercase font-bold text-mishkat-green-300">معلم متخصص</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="w-full md:w-1/2 bg-white p-6 md:p-12 flex flex-col justify-center">
            <div class="mb-10 text-center md:text-right">
                <h2 class="text-3xl font-black text-mishkat-green-900 font-tajawal mb-2">تسجيل الدخول</h2>
                <p class="text-gray-400 font-medium">مرحباً بك مجدداً في عائلة مِشكاة</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="bg-red-50 border-r-4 border-red-500 p-4 rounded-xl mb-6 flex items-center gap-3 animate-fadeIn">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                    <p class="text-red-700 text-sm font-bold"><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <!-- Account Type Choice Selector -->
                <div class="mb-6">
                    <label class="block text-xs font-black text-mishkat-green-800 uppercase tracking-widest mb-3 mr-1">نوع الحساب</label>
                    <div class="grid grid-cols-4 gap-2 bg-gray-50 dark:bg-white/5 p-1.5 rounded-2xl border border-gray-100 dark:border-white/5">
                        <label class="cursor-pointer text-center group flex-1">
                            <input type="radio" name="role_choice" value="student" checked class="sr-only peer">
                            <div class="py-3 px-1 rounded-xl font-bold text-xs transition-all duration-300 peer-checked:bg-mishkat-green-700 peer-checked:text-white dark:peer-checked:bg-mishkat-green-600 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex flex-col items-center gap-1.5">
                                <i class="fa-solid fa-graduation-cap text-lg transition-transform group-hover:scale-110"></i>
                                <span>طالب</span>
                            </div>
                        </label>
                        <label class="cursor-pointer text-center group flex-1">
                            <input type="radio" name="role_choice" value="teacher" class="sr-only peer">
                            <div class="py-3 px-1 rounded-xl font-bold text-xs transition-all duration-300 peer-checked:bg-mishkat-green-700 peer-checked:text-white dark:peer-checked:bg-mishkat-green-600 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex flex-col items-center gap-1.5">
                                <i class="fa-solid fa-chalkboard-user text-lg transition-transform group-hover:scale-110"></i>
                                <span>معلم</span>
                            </div>
                        </label>
                        <label class="cursor-pointer text-center group flex-1">
                            <input type="radio" name="role_choice" value="parent" class="sr-only peer">
                            <div class="py-3 px-1 rounded-xl font-bold text-xs transition-all duration-300 peer-checked:bg-mishkat-green-700 peer-checked:text-white dark:peer-checked:bg-mishkat-green-600 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex flex-col items-center gap-1.5">
                                <i class="fa-solid fa-people-roof text-lg transition-transform group-hover:scale-110"></i>
                                <span>ولي أمر</span>
                            </div>
                        </label>
                        <label class="cursor-pointer text-center group flex-1">
                            <input type="radio" name="role_choice" value="admin" class="sr-only peer">
                            <div class="py-3 px-1 rounded-xl font-bold text-xs transition-all duration-300 peer-checked:bg-mishkat-green-700 peer-checked:text-white dark:peer-checked:bg-mishkat-green-600 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex flex-col items-center gap-1.5">
                                <i class="fa-solid fa-user-shield text-lg transition-transform group-hover:scale-110"></i>
                                <span>مسؤول</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-mishkat-green-800 uppercase tracking-widest mb-2 mr-1">البريد الإلكتروني</label>
                    <div class="relative">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" required placeholder="example@mishkat.com" 
                               class="w-full pr-12 pl-4 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 focus:bg-white rounded-2xl outline-none transition-all font-bold text-mishkat-green-900">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-mishkat-green-800 uppercase tracking-widest mb-2 mr-1">كلمة المرور</label>
                    <div class="relative">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required placeholder="••••••••" 
                               class="w-full pr-12 pl-4 py-4 bg-gray-50 border-2 border-transparent focus:border-mishkat-green-100 focus:bg-white rounded-2xl outline-none transition-all font-bold text-mishkat-green-900">
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-mishkat-green-600 focus:ring-mishkat-green-500">
                            <span class="text-[10px] font-bold text-gray-400 group-hover:text-gray-600 transition-colors">تذكرني</span>
                        </label>
                        <a href="#" class="text-[10px] font-bold text-mishkat-gold-600 hover:text-mishkat-gold-700">نسيت كلمة المرور؟</a>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 md:py-4 btn-luxury text-base md:text-lg shadow-xl shadow-mishkat-green-900/10 hover:shadow-mishkat-green-900/20">
                    دخول للمنصة
                </button>

                <div class="pt-8 text-center border-t border-gray-100">
                    <p class="text-sm text-gray-500 font-bold">ليس لديك حساب؟ <a href="register.php" class="text-mishkat-green-600 hover:text-mishkat-green-700 underline underline-offset-4">ابدأ رحلتك الآن</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');

            if (emailInput && passwordInput) {
                emailInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        passwordInput.focus();
                    }
                });
            }
        });
    </script>
</body>
</html>
