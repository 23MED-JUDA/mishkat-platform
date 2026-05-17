<?php
ob_start();
session_start();
require_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ? AND role = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            session_write_close();
            header("Location: dashboard.php");
            exit();
        } else {
            $error = 'كلمة المرور غير صحيحة';
        }
    } else {
        $error = 'هذا الحساب لا يمتلك صلاحيات المدير';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول الإدارة - مشكاة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <style>
        * { font-family: 'Cairo', sans-serif; }
        .admin-bg { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
    </style>
</head>
<body class="admin-bg min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    
    <!-- Pattern Background -->
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>

    <div class="max-w-md w-full relative z-10">
        <div class="text-center mb-10">
            <div class="inline-flex w-20 h-20 bg-slate-800/50 backdrop-blur-xl border border-slate-700 rounded-3xl items-center justify-center mb-6 shadow-2xl">
                <span class="material-icons-outlined text-emerald-500 text-4xl">admin_panel_settings</span>
            </div>
            <h1 class="text-3xl font-black text-white">لوحة تحكم الإدارة</h1>
            <p class="text-slate-400 font-medium mt-2">يرجى تسجيل الدخول للوصول إلى النظام</p>
        </div>

        <div class="bg-slate-900/50 backdrop-blur-2xl p-8 rounded-[2.5rem] shadow-2xl border border-slate-800">
            <?php if($error): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-2xl mb-6 text-sm font-bold flex items-center gap-3">
                <span class="material-icons-outlined text-lg">error_outline</span>
                <?php echo $error; ?>
            </div>
            <?php endif; ?>

            <form action="admin_login.php" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 mr-1">بريد المدير</label>
                    <input type="email" name="email" required placeholder="admin@mishkat.com"
                        class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 rounded-2xl outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all font-bold text-white placeholder:text-slate-600">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2 mr-1">كلمة المرور</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 rounded-2xl outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all font-bold text-white placeholder:text-slate-600">
                </div>
                
                <button type="submit" 
                    class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-lg hover:bg-emerald-500 transition-all shadow-xl shadow-emerald-900/20">
                    دخول المسؤول
                </button>
            </form>
        </div>

        <div class="text-center mt-10">
            <a href="index.php" class="text-slate-500 font-bold hover:text-slate-300 transition-colors flex items-center justify-center gap-2">
                <span class="material-icons-outlined text-sm">arrow_forward</span>
                العودة للموقع الرئيسي
            </a>
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
