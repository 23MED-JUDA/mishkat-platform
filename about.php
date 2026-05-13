<?php
/**
 * صفحة "عن المنصة"
 * تستعرض رؤية ورسالة وقيم أكاديمية مشكاة
 */
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عن مشكاة | رحلتك نحو إتقان القرآن الكريم</title>
    
    <!-- الاستعانة بالمكتبات الخارجية -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    
    <!-- ملف التنسيق الرئيسي -->
    <link rel="stylesheet" href="assets/css/main.css">
    
    <style>
        .gradient-text { background: linear-gradient(135deg, #065f46 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="bg-gray-50/50">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-emerald-700 rounded-xl flex items-center justify-center text-white font-black text-2xl shadow-lg shadow-emerald-200">م</div>
                <span class="text-2xl font-black text-gray-900 tracking-tighter">مشكاة</span>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="index.php" class="text-sm font-bold text-gray-600 hover:text-emerald-700 transition-colors">الرئيسية</a>
                <a href="index.php#courses" class="text-sm font-bold text-gray-600 hover:text-emerald-700 transition-colors">المسارات</a>
                <a href="about.php" class="text-sm font-bold text-emerald-700 transition-colors">عن المنصة</a>
                <a href="index.php#contact" class="text-sm font-bold text-gray-600 hover:text-emerald-700 transition-colors">تواصل معنا</a>
            </div>
            <a href="dashboard.php" class="px-6 py-2.5 bg-emerald-700 text-white rounded-xl text-sm font-black hover:bg-emerald-800 transition-all shadow-lg shadow-emerald-100">اشترك الآن</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <h1 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 leading-tight">قصة <span class="gradient-text">مشكاة</span></h1>
            <p class="text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed mb-12 font-medium">نحن لسنا مجرد منصة تعليمية، بل نحن جسر يربط القلوب بكتاب الله من خلال تقنيات حديثة ومعلمين مجازين.</p>
        </div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-emerald-100/50 rounded-full blur-[120px] -z-10"></div>
    </section>

    <!-- Vision & Mission -->
    <section class="pb-24">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="p-12 bg-emerald-900 rounded-[3rem] text-white shadow-2xl relative overflow-hidden group">
                <span class="material-icons-outlined text-8xl absolute -bottom-4 -right-4 opacity-10 group-hover:scale-110 transition-transform">visibility</span>
                <h2 class="text-3xl font-black mb-6">رؤيتنا</h2>
                <p class="text-emerald-100/80 text-lg leading-relaxed font-medium">أن نكون المنصة الرائدة عالمياً في تعليم القرآن الكريم وعلومه، متمسكين بالأصالة ومواكبين لأحدث تقنيات التعلم عن بعد.</p>
            </div>
            <div class="p-12 bg-white rounded-[3rem] shadow-xl border border-gray-50 group">
                <h2 class="text-3xl font-black text-gray-900 mb-6">رسالتنا</h2>
                <p class="text-gray-500 text-lg leading-relaxed font-medium">تيسير الوصول لتعليم قرآني متميز للجميع في كل مكان، وتوفير بيئة تعليمية تفاعلية تجمع بين جودة المعلم وسهولة التقنية.</p>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-24 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-black text-center text-gray-900 mb-16">قيمنا التي نحيا بها</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center p-8 bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="material-icons-outlined text-3xl">verified</span>
                    </div>
                    <h3 class="font-black text-gray-900 mb-3">الإتقان</h3>
                    <p class="text-xs text-gray-400 font-bold leading-relaxed">نلتزم بأعلى معايير جودة التعليم والأداء الأكاديمي.</p>
                </div>
                <div class="text-center p-8 bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-blue-50 text-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="material-icons-outlined text-3xl">groups</span>
                    </div>
                    <h3 class="font-black text-gray-900 mb-3">المجتمع</h3>
                    <p class="text-xs text-gray-400 font-bold leading-relaxed">نبني بيئة داعمة للطلاب والمعلمين للارتقاء معاً.</p>
                </div>
                <div class="text-center p-8 bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-amber-50 text-amber-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="material-icons-outlined text-3xl">psychology</span>
                    </div>
                    <h3 class="font-black text-gray-900 mb-3">الابتكار</h3>
                    <p class="text-xs text-gray-400 font-bold leading-relaxed">نستخدم أحدث الوسائل التقنية لتسهيل عملية الحفظ.</p>
                </div>
                <div class="text-center p-8 bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all">
                    <div class="w-16 h-16 bg-red-50 text-red-700 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="material-icons-outlined text-3xl">auto_fix_high</span>
                    </div>
                    <h3 class="font-black text-gray-900 mb-3">الأمانة</h3>
                    <p class="text-xs text-gray-400 font-bold leading-relaxed">نحافظ على قدسية النص القرآني ومنهج السلف.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm font-bold text-gray-400">© 2026 منصة مشكاة التعليمية. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

</body>
</html>
