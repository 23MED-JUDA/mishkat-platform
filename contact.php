<?php
/**
 * صفحة التواصل مع المنصة
 * تتيح للمستخدمين إرسال استفساراتهم ومعرفة معلومات الاتصال
 */
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تواصل معنا | منصة مشكاة التعليمية</title>
    
    <!-- الاستعانة بالمكتبات الخارجية -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #064e3b; color: white; }
        .emerald-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .input-style { background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white; border-radius: 1rem; padding: 1rem; width: 100%; outline: none; }
        .input-style:focus { border-color: #34d399; background: rgba(255, 255, 255, 0.15); }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-emerald-900/50 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-lg">م</div>
                <span class="text-2xl font-black">مشكاة</span>
            </div>
            <div class="hidden lg:flex items-center gap-10">
                <a href="index.php" class="text-sm font-bold text-white/60 hover:text-white transition-colors">الرئيسية</a>
                <a href="about.php" class="text-sm font-bold text-white/60 hover:text-white transition-colors">عن المنصة</a>
                <a href="contact.php" class="text-sm font-bold text-emerald-400">تواصل معنا</a>
            </div>
            <a href="dashboard.php" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-black hover:bg-emerald-700 transition-all">ابدأ الآن</a>
        </div>
    </nav>

    <!-- Header -->
    <section class="py-20 text-center">
        <h1 class="text-5xl font-black mb-6">يسعدنا تواصلك معنا</h1>
        <p class="text-emerald-200/60 text-xl max-w-2xl mx-auto">فريق مشكاة هنا للرد على كافة استفساراتك ومساعدتك في رحلتك التعليمية.</p>
    </section>

    <!-- Content -->
    <section class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 mb-32">
        <!-- Form -->
        <div class="emerald-card p-10 rounded-[3rem]">
            <h2 class="text-2xl font-black mb-8">أرسل لنا رسالة</h2>
            <form action="#" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" placeholder="الاسم الكامل" class="input-style">
                    <input type="email" placeholder="البريد الإلكتروني" class="input-style">
                </div>
                <input type="text" placeholder="الموضوع" class="input-style">
                <textarea placeholder="رسالتك هنا..." rows="5" class="input-style"></textarea>
                <button class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-lg hover:bg-emerald-500 transition-all shadow-xl shadow-emerald-900/50">إرسال الرسالة</button>
            </form>
        </div>

        <!-- Info -->
        <div class="space-y-8">
            <div class="emerald-card p-8 rounded-[2.5rem] flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-600/20 rounded-2xl flex items-center justify-center text-emerald-400">
                    <span class="material-icons-outlined text-3xl">mail</span>
                </div>
                <div>
                    <p class="text-xs font-black text-white/30 uppercase tracking-widest mb-1">راسلنا عبر البريد</p>
                    <p class="text-xl font-bold">support@mishkat.com</p>
                </div>
            </div>
            <div class="emerald-card p-8 rounded-[2.5rem] flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-600/20 rounded-2xl flex items-center justify-center text-emerald-400">
                    <span class="material-icons-outlined text-3xl">call</span>
                </div>
                <div>
                    <p class="text-xs font-black text-white/30 uppercase tracking-widest mb-1">اتصل بنا هاتفياً</p>
                    <p class="text-xl font-bold" dir="ltr">+20 123 456 789</p>
                </div>
            </div>
            <div class="emerald-card p-8 rounded-[2.5rem] flex items-center gap-6">
                <div class="w-16 h-16 bg-emerald-600/20 rounded-2xl flex items-center justify-center text-emerald-400">
                    <span class="material-icons-outlined text-3xl">location_on</span>
                </div>
                <div>
                    <p class="text-xs font-black text-white/30 uppercase tracking-widest mb-1">المقر الرئيسي</p>
                    <p class="text-xl font-bold">القاهرة، جمهورية مصر العربية</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="mt-auto py-12 text-center text-white/20 text-xs font-bold border-t border-white/5">
        © 2026 منصة مشكاة التعليمية. جميع الحقوق محفوظة.
    </footer>

</body>
</html>
