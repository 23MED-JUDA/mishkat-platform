<?php
ob_start();
require_once __DIR__ . '/includes/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];
$role = strtolower($_SESSION['user_role'] ?? 'student');
$userName = $_SESSION['user_name'];

$links = [];
if ($role === 'student') {
    $links = [
        ['name' => 'الرئيسية', 'icon' => 'grid_view', 'page' => 'home'],
        ['name' => 'الملف الشخصي', 'icon' => 'account_circle', 'page' => 'profile'],
        ['name' => 'الدورات التدريبية', 'icon' => 'auto_stories', 'page' => 'courses'],
        ['name' => 'المهام اليومية', 'icon' => 'task_alt', 'page' => 'tasks'],
        ['name' => 'العودة للرئيسية', 'icon' => 'home', 'url' => 'index.php'],
        ['name' => 'نتائج الاختبارات', 'icon' => 'military_tech', 'page' => 'tracking'],
    ];
} elseif ($role === 'teacher') {
    $links = [
        ['name' => 'الرئيسية', 'icon' => 'grid_view', 'page' => 'profile'],
        ['name' => 'إدارة الدروس', 'icon' => 'video_library', 'page' => 'episodes'],
        ['name' => 'متابعة الطلاب', 'icon' => 'people', 'page' => 'students'],
        ['name' => 'التقييمات', 'icon' => 'grade', 'page' => 'evaluation'],
        ['name' => 'المكتبة', 'icon' => 'library_books', 'page' => 'library'],
    ];
} elseif ($role === 'parent') {
    $links = [
        ['name' => 'متابعة الأبناء', 'icon' => 'family_restroom', 'page' => 'home'],
        ['name' => 'الملف الشخصي', 'icon' => 'account_circle', 'page' => 'profile'],
        ['name' => 'التقارير', 'icon' => 'description', 'page' => 'reports'],
    ];
} elseif ($role === 'admin') {
    $links = [
        ['name' => 'إدارة المستخدمين', 'icon' => 'manage_accounts', 'page' => 'accounts'],
        ['name' => 'إدارة الطلاب', 'icon' => 'school', 'page' => 'students'],
        ['name' => 'المحتوى التعليمي', 'icon' => 'library_books', 'page' => 'content'],
        ['name' => 'مراجعة المعلمين', 'icon' => 'verified_user', 'page' => 'review-teachers'],
        ['name' => 'تنظيم الحلقات', 'icon' => 'calendar_month', 'page' => 'circles'],
        ['name' => 'التقارير العامة', 'icon' => 'insights', 'page' => 'reports'],
        ['name' => 'إعدادات النظام', 'icon' => 'settings', 'page' => 'settings'],
    ];
}

$currentPage = $_GET['page'] ?? ($links[0]['page'] ?? 'profile');

$pageTitle = 'لوحة التحكم';
foreach ($links as $link) {
    if ($link['page'] === $currentPage) {
        $pageTitle = $link['name'];
        break;
    }
}

$pageMap = [
    'student' => [
        'home' => 'student/Home.php',
        'profile' => 'student/Profile.php',
        'courses' => 'student/CoursesPage.php',
        'library' => 'student/LibraryStudent.php',
        'tasks' => 'student/Tasks.php',
        'tracking' => 'student/Tracking.php',
        'episodes' => 'student/Episodes.php',
    ],
    'teacher' => [
        'profile' => 'teacher/Profile.php',
        'episodes' => 'teacher/Episodes.php',
        'students' => 'teacher/StudentsPage.php',
        'evaluation' => 'teacher/Evaluation.php',
        'library' => 'teacher/Library.php',
    ],
    'parent' => [
        'home' => 'parent/Home.php',
        'profile' => 'parent/Profile.php',
        'reports' => 'parent/Reports.php',
    ],
    'admin' => [
        'accounts' => 'admin/AccountsManagement.php',
        'students' => 'admin/StudentsManagement.php',
        'content' => 'admin/ContentManagement.php',
        'circles' => 'admin/CirclesManagement.php',
        'review-teachers' => 'admin/ReviewTeachers.php',
        'reports' => 'admin/ReportsAdmin.php',
        'settings' => 'admin/SettingsAdmin.php',
    ],
];

$pageFile = $pageMap[$role][$currentPage] ?? null;
$pagePath = $pageFile ? "pages/$pageFile" : null;

// Sidebar HTML helper
function sidebarItem($link, $isActive) {
    $activeClass = $isActive ? 'active' : '';
    $iconBg = $isActive ? 'bg-black/20 dark:bg-black/30' : 'bg-white/5';
    $dot = $isActive ? '<div class="w-1.5 h-6 bg-black/30 dark:bg-black/40 rounded-full"></div>' : '';
    $href = isset($link['url']) ? $link['url'] : "?page={$link['page']}";
    return <<<HTML
        <a href="{$href}" 
           class="luxury-sidebar-item flex items-center gap-4 px-5 py-3.5 {$activeClass}">
            <div class="w-8 h-8 rounded-xl flex items-center justify-center {$iconBg} flex-shrink-0">
                <span class="material-icons-outlined text-[18px]">{$link['icon']}</span>
            </div>
            <span class="font-bold text-sm flex-1 truncate">{$link['name']}</span>
            {$dot}
        </a>
    HTML;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo $pageTitle; ?> | مشكاة</title>
    <?php include 'includes/header_meta.php'; ?>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        /* Sidebar transitions */
        #sidebar {
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }
        #sidebar.open { transform: translateX(0) !important; }
        
        #sidebarOverlay {
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }
        #sidebarOverlay.active {
            display: block !important;
            opacity: 1 !important;
            pointer-events: auto;
        }

        /* Desktop: always visible */
        @media (min-width: 1024px) {
            #sidebar { transform: translateX(0) !important; }
            #sidebarOverlay { display: none !important; }
        }

        /* Mobile Bottom Tabs */
        @media (max-width: 1023px) {
            #sidebar { width: 280px; }
        }

        /* Smooth transitions on content */
        .page-content { transition: margin 0.35s ease; }

        /* Responsive tables */
        .responsive-table { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* Touch-friendly targets */
        @media (max-width: 768px) {
            .luxury-sidebar-item { padding: 0.75rem 1rem !important; }
            button, a { min-height: 40px; }
        }
    </style>
</head>
<body class="bg-[#f0f4f2] dark:bg-[#080808] transition-colors duration-500 overflow-x-hidden">

    <!-- ─── MOBILE OVERLAY ─── -->
    <div id="sidebarOverlay" 
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden transition-all duration-300"
         onclick="closeSidebar()"></div>

    <!-- ─── SIDEBAR ─── -->
    <aside id="sidebar" class="fixed top-0 right-0 h-screen w-72 luxury-sidebar text-white z-50 overflow-y-auto shadow-2xl">
        
        <!-- Logo -->
        <div class="px-6 pt-8 pb-6 border-b border-white/5 dark:border-mishkat-gold-500/10 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-mishkat-gold-500 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                    <span class="material-icons-outlined text-black text-2xl">mosque</span>
                </div>
                <div>
                    <h1 class="text-xl font-black font-tajawal leading-none">مِشـكاة</h1>
                    <p class="text-[10px] uppercase tracking-widest text-white/30 dark:text-mishkat-gold-500/50 mt-1">منصة تعليمية</p>
                </div>
            </div>
            <!-- Close button (mobile only) -->
            <button onclick="closeSidebar()" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-2xl bg-white/10 text-white/80 hover:text-white transition-all active:scale-90">
                <span class="material-icons-outlined text-xl">close</span>
            </button>
        </div>

        <!-- User Card -->
        <div class="px-4 mt-4">
            <div class="px-4 py-3 rounded-2xl bg-white/5 dark:bg-mishkat-gold-500/5 border border-white/5 dark:border-mishkat-gold-500/10 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-mishkat-gold-500 flex items-center justify-center font-black text-black text-sm flex-shrink-0">
                    <?php echo mb_substr($userName, 0, 1, 'UTF-8'); ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-black text-white truncate"><?php echo htmlspecialchars($userName); ?></p>
                    <p class="text-[9px] uppercase tracking-widest text-white/30 dark:text-mishkat-gold-500/50"><?php echo $role; ?></p>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="mt-4 pb-6">
            <p class="sidebar-label text-[9px] font-black uppercase tracking-[0.2em] text-white/25 px-8 py-2">القائمة الرئيسية</p>
            
            <?php foreach ($links as $link):
                $isActive = ($currentPage === ($link['page'] ?? null));
                echo sidebarItem($link, $isActive);
            endforeach; ?>

            <!-- External platforms -->
            <div class="mx-4 mt-3 pt-3 border-t border-white/5 dark:border-mishkat-gold-500/10">
                <p class="sidebar-label text-[9px] font-black uppercase tracking-[0.2em] text-white/25 px-2 pb-2">صفحات المنصة</p>
                <a href="index.php" 
                   class="luxury-sidebar-item flex items-center gap-3 px-3 py-3">
                    <div class="w-8 h-8 rounded-xl bg-white/5 flex items-center justify-center flex-shrink-0">
                        <span class="material-icons-outlined text-[16px]">home</span>
                    </div>
                    <span class="font-bold text-xs flex-1">الصفحة الرئيسية للمنصة</span>
                    <span class="material-icons-outlined text-[13px] opacity-30">open_in_new</span>
                </a>
            </div>

            <!-- Logout -->
            <div class="mx-4 mt-3 pt-3 border-t border-white/5 dark:border-mishkat-gold-500/10">
                <a href="logout.php" class="luxury-sidebar-item flex items-center gap-3 px-3 py-3 text-red-400/60 hover:text-red-400 hover:bg-red-500/10">
                    <div class="w-8 h-8 rounded-xl bg-red-500/10 flex items-center justify-center flex-shrink-0">
                        <span class="material-icons-outlined text-[18px] text-red-400">logout</span>
                    </div>
                    <span class="font-bold text-sm">تسجيل الخروج</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- ─── MAIN CONTENT ─── -->
    <main class="lg:mr-72 min-h-screen page-content">

        <!-- Topbar -->
        <header class="glass-nav sticky top-0 z-30 px-4 md:px-6 py-3 flex justify-between items-center gap-3">
            <div class="flex items-center gap-3">
                <!-- Hamburger -->
                <button id="menuBtn" onclick="openSidebar()" 
                        class="lg:hidden p-2 bg-white dark:bg-black rounded-xl shadow-sm text-mishkat-green-800 dark:text-mishkat-gold-500 border border-gray-100 dark:border-mishkat-gold-500/20 flex-shrink-0">
                    <span class="material-icons-outlined">menu</span>
                </button>
                <!-- Brand on mobile -->
                <div class="flex items-center gap-2 lg:hidden">
                    <span class="text-mishkat-gold-500 material-icons-outlined text-2xl">mosque</span>
                    <span class="font-black text-mishkat-green-900 dark:text-white font-tajawal text-lg">مِشكاة</span>
                </div>
                <!-- Page title on desktop -->
                <h2 class="hidden lg:block text-xl font-black text-mishkat-green-900 dark:text-white font-tajawal"><?php echo $pageTitle; ?></h2>
            </div>

            <div class="flex items-center gap-2 md:gap-3">
                <!-- Clock (desktop only) -->
                <div class="hidden xl:flex flex-col items-end">
                    <span class="text-[10px] font-black text-mishkat-gold-600 uppercase tracking-widest" id="clockDay"></span>
                    <span class="text-xs font-bold text-mishkat-green-900 dark:text-white/70" id="clockTime">00:00</span>
                </div>

                <!-- Dark Mode -->
                <button onclick="toggleDarkMode()" 
                        class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-xl bg-gray-50 dark:bg-black text-mishkat-green-700 dark:text-mishkat-gold-400 hover:scale-110 transition-all border border-gray-100 dark:border-mishkat-gold-500/20 flex-shrink-0">
                    <span class="material-icons-outlined text-[20px]" id="themeIcon">dark_mode</span>
                </button>

                <!-- User avatar -->
                <div class="flex items-center gap-2">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-xs font-black text-mishkat-green-900 dark:text-white leading-tight"><?php echo htmlspecialchars(explode(' ', $userName)[0]); ?></span>
                        <span class="text-[9px] text-mishkat-gold-600 font-bold uppercase"><?php echo $role; ?></span>
                    </div>
                    <div class="w-9 h-9 md:w-10 md:h-10 rounded-xl md:rounded-2xl bg-mishkat-gold-500 flex items-center justify-center text-black font-black text-sm flex-shrink-0">
                        <?php echo mb_substr($userName, 0, 1, 'UTF-8'); ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile page title bar -->
        <div class="lg:hidden px-4 py-3 glass-nav border-t border-gray-100 dark:border-mishkat-gold-500/10">
            <h2 class="text-base font-black text-mishkat-green-900 dark:text-white font-tajawal"><?php echo $pageTitle; ?></h2>
        </div>

        <!-- Page content -->
        <div class="p-4 md:p-6 lg:p-10 max-w-7xl mx-auto">
            <?php 
                if ($pagePath && file_exists($pagePath)) {
                    include $pagePath;
                } else {
                    echo "
                    <div class='flex flex-col items-center justify-center py-20 text-center animate-fadeIn'>
                        <div class='w-20 h-20 bg-mishkat-green-50 dark:bg-black text-mishkat-green-600 dark:text-mishkat-gold-500 rounded-full flex items-center justify-center mb-5'>
                            <span class='material-icons-outlined text-4xl'>construction</span>
                        </div>
                        <h3 class='text-xl font-black text-mishkat-green-900 dark:text-white mb-2 font-tajawal'>هذه الصفحة قيد التطوير</h3>
                        <p class='text-gray-500 dark:text-white/40 max-w-sm text-sm'>نحن نعمل حالياً على تجهيز هذا القسم.</p>
                        <a href='dashboard.php' class='mt-6 px-6 py-3 btn-luxury text-sm'>العودة للرئيسية</a>
                    </div>";
                }
            ?>
        </div>
    </main>

    <div id="toastContainer" class="toast-container"></div>

    <script>
        /* ── Sidebar ── */
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.add('open');
            overlay.classList.remove('hidden');
            // Force reflow
            void overlay.offsetWidth;
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            setTimeout(() => {
                if (!sidebar.classList.contains('open')) {
                    overlay.classList.add('hidden');
                }
            }, 300);
            document.body.style.overflow = '';
        }

        /* Close on swipe right (mobile) */
        let touchStartX = 0;
        document.getElementById('sidebar').addEventListener('touchstart', e => {
            touchStartX = e.touches[0].clientX;
        });
        document.getElementById('sidebar').addEventListener('touchend', e => {
            const delta = e.changedTouches[0].clientX - touchStartX;
            if (delta > 60) closeSidebar(); // swipe right to close
        });

        /* Open on swipe left from edge */
        document.addEventListener('touchstart', e => {
            if (e.touches[0].clientX > window.innerWidth - 30) {
                touchStartX = e.touches[0].clientX;
            }
        });
        document.addEventListener('touchend', e => {
            const delta = touchStartX - e.changedTouches[0].clientX;
            if (delta > 60 && touchStartX > window.innerWidth - 60) openSidebar();
        });

        /* ── Dark Mode ── */
        function toggleDarkMode() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const icon = document.getElementById('themeIcon');
            icon.innerText = document.documentElement.classList.contains('dark') ? 'light_mode' : 'dark_mode';
        }
        updateThemeIcon();

        /* ── Live Clock ── */
        function updateClock() {
            const now = new Date();
            const days = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
            const dayEl = document.getElementById('clockDay');
            const timeEl = document.getElementById('clockTime');
            if (dayEl) dayEl.innerText = days[now.getDay()];
            if (timeEl) timeEl.innerText = now.toLocaleTimeString('ar-EG', { hour12: true, hour: '2-digit', minute: '2-digit' });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
