<?php
ob_start();
require_once __DIR__ . '/includes/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];
$userQuery = $conn->query("SELECT * FROM users WHERE id = $uid");
$userData = $userQuery->fetch_assoc();

$role = strtolower($userData['role'] ?? 'student');
$userName = $userData['name'];
$userImage = $userData['profile_image'] ?? '';
$userRoleName = ($role === 'student' ? 'طالب' : ($role === 'teacher' ? 'معلم' : ($role === 'parent' ? 'ولي أمر' : 'مسؤول')));

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

$currentPage = $_GET['page'] ?? ($links[0]['page'] ?? 'home');

$pageTitle = 'لوحة التحكم';
foreach ($links as $link) {
    if (isset($link['page']) && $link['page'] === $currentPage) {
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
        'quran' => 'student/Quran.php',
        'hadith' => 'student/Hadith.php',
        'seerah' => 'student/Seerah.php',
        'tasbih' => 'student/Tasbih.php',
        'quiz' => 'student/Quiz.php',
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
    $href = isset($link['url']) ? $link['url'] : "?page={$link['page']}";
    
    return <<<HTML
        <div class="px-3 mb-1 sidebar-item-wrap transition-all duration-300">
            <a href="{$href}" title="{$link['name']}"
               class="luxury-sidebar-item group flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-300 ease-out {$activeClass}">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 flex-shrink-0 icon-box">
                    <span class="material-icons-outlined text-[20px]">{$link['icon']}</span>
                </div>
                <div class="flex flex-col sidebar-text transition-all duration-300">
                    <span class="text-sm transition-colors duration-300 font-medium tracking-wide">{$link['name']}</span>
                </div>
            </a>
        </div>
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
            width: 280px;
            transform: translateX(100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, width, top, height;
            z-index: 50;
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

        /* Desktop: always visible, hover-to-expand */
        @media (min-width: 1024px) {
            #sidebar { 
                transform: translateX(0) !important; 
                top: 1.5rem;
                right: 1.5rem;
                height: calc(100vh - 3rem);
                border-radius: 2rem;
                width: 96px;
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
            }
            #sidebarOverlay { display: none !important; }
            
            .page-content {
                margin-right: calc(96px + 3rem);
            }

            #sidebar:hover {
                width: 280px;
                box-shadow: 0 10px 45px rgba(0,0,0,0.12) !important;
            }
            html.dark #sidebar:hover {
                box-shadow: 0 10px 45px rgba(0,0,0,0.6) !important;
            }

            /* Hide text elements smoothly when NOT hovering */
            #sidebar .sidebar-text,
            #sidebar .sidebar-logo-text,
            #sidebar .user-info,
            #sidebar .logout-text,
            #sidebar .sidebar-app-label {
                transition: opacity 0.25s ease, width 0.25s ease;
                white-space: nowrap;
                overflow: hidden;
            }

            #sidebar:not(:hover) .sidebar-text,
            #sidebar:not(:hover) .sidebar-logo-text,
            #sidebar:not(:hover) .user-info,
            #sidebar:not(:hover) .logout-text {
                opacity: 0;
                width: 0;
            }

            #sidebar:not(:hover) .sidebar-app-label {
                opacity: 0;
                height: 0;
                margin-bottom: 0;
                padding-top: 0;
                padding-bottom: 0;
            }
            
            #sidebar:not(:hover) .user-box {
                padding: 0.75rem;
                background: transparent;
                border-color: transparent;
                justify-content: center;
            }

            #sidebar:not(:hover) .user-avatar {
                margin: 0 auto;
            }

            #sidebar:not(:hover) .logo-box {
                justify-content: center;
            }
            
            #sidebar:not(:hover) .sidebar-item-link {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }

            /* Symmetrical Floating Topbar */
            .glass-nav {
                margin: 1.5rem 1.5rem 0 1.5rem !important;
                border-radius: 2rem !important;
                border: 1px solid var(--border-color) !important;
                top: 1.5rem !important;
                box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03) !important;
                transition: all 0.3s ease;
            }
            html.dark .glass-nav {
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.45) !important;
            }
        }

        /* Mobile */
        @media (max-width: 1023px) {
            .page-content { margin-right: 0 !important; }
        }

        /* Smooth transitions on content */
        .page-content { transition: margin-right 0.4s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Responsive tables */
        .responsive-table { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        /* Touch-friendly targets */
        @media (max-width: 768px) {
            .luxury-sidebar-item { padding: 0.75rem 1rem !important; }
            button, a { min-height: 40px; }
        }

        /* Toast Notifications */

        .toast-container {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            pointer-events: none;
        }
        .luxury-toast {
            pointer-events: auto;
            min-width: 300px;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            display: flex;
            items-center: center;
            gap: 1rem;
            transform: translateX(-120%);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        .dark .luxury-toast {
            background: rgba(20, 20, 20, 0.95);
            border-color: rgba(201, 168, 76, 0.1);
            color: white;
        }
        .luxury-toast.active { transform: translateX(0); }
        .luxury-toast.success { border-right: 4px solid #10b981; }
        .luxury-toast.error { border-right: 4px solid #ef4444; }
        .luxury-toast.info { border-right: 4px solid #c9a84c; }
        /* Smooth Transitions */
        * { transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, opacity 0.3s ease, transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }

        /* Keyframes */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .animate-slide-up { animation: slideUpFade 0.6s ease-out forwards; }
        .animate-slide-in { animation: slideInRight 0.5s ease-out forwards; }
        .animate-scale-in { animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        
        /* Staggered Delay Helpers */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }



        /* Glass Nav blur effect */
        .glass-nav {
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.7);
        }
        .dark .glass-nav {
            background-color: rgba(8, 8, 8, 0.75);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body class="transition-colors duration-500 overflow-x-hidden">

    <!-- ─── MOBILE OVERLAY ─── -->
    <div id="sidebarOverlay" 
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden transition-all duration-300"
         onclick="closeSidebar()"></div>

    <!-- ─── SIDEBAR ─── -->
    <aside id="sidebar" class="fixed top-0 right-0 h-screen luxury-sidebar z-50 overflow-x-hidden overflow-y-auto custom-scrollbar">

        <!-- Brand & Logo -->
        <div class="logo-box flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background: var(--sidebar-active-bg);">
                    <span class="material-icons-outlined" style="color: var(--color-primary); font-size:1.4rem;">mosque</span>
                </div>
                <div class="sidebar-logo-text">
                    <h1 class="text-lg font-black font-tajawal leading-none whitespace-nowrap"
                        style="color: var(--color-text-main);">مِشـكاة</h1>
                    <p class="text-[9px] uppercase tracking-[0.2em] whitespace-nowrap mt-0.5"
                       style="color: var(--color-text-muted);">منصة تعليمية</p>
                </div>
            </div>
            <!-- Mobile close button -->
            <button onclick="closeSidebar()"
                    class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl transition-all flex-shrink-0"
                    style="background: var(--bg-app); border:none; cursor:pointer; color: var(--color-text-muted);">
                <span class="material-icons-outlined text-xl">close</span>
            </button>
        </div>

        <!-- User Card -->
        <div class="px-4 mb-6 mt-4">
            <div class="user-box flex items-center gap-3 p-3">
                <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center font-black text-sm flex-shrink-0"
                     style="background: var(--sidebar-active-bg); color: var(--sidebar-active-text);">
                    <?php if(!empty($userImage)): ?>
                        <img src="<?php echo htmlspecialchars($userImage); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php echo mb_substr($userName, 0, 1, 'UTF-8'); ?>
                    <?php endif; ?>
                </div>
                <div class="user-info flex-1 min-w-0">
                    <p class="text-sm font-bold truncate leading-tight"><?php echo htmlspecialchars($userName); ?></p>
                    <span class="text-[10px] uppercase tracking-wider"><?php echo $userRoleName; ?></span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="pb-6">
            <!-- Section Label -->
            <div class="px-5 mb-2 sidebar-app-label">
                <span class="text-[10px] font-semibold uppercase tracking-[0.25em]"
                      style="color: var(--color-text-muted);">القائمة</span>
            </div>
            
            <div class="space-y-0.5">
                <?php foreach ($links as $link):
                    $isActive = ($currentPage === ($link['page'] ?? null));
                    echo sidebarItem($link, $isActive);
                endforeach; ?>
            </div>

            <!-- Divider -->
            <div class="mx-5 my-5" style="height:1px; background: var(--border-color);"></div>

            <!-- Apps Section -->
            <div class="px-5 mb-2 sidebar-app-label">
                <span class="text-[10px] font-semibold uppercase tracking-[0.25em]"
                      style="color: var(--color-text-muted);">تطبيقات مشكاة</span>
            </div>

            <div class="space-y-0.5">
                <?php 
                $apps = [
                    ['n' => 'القرآن الكريم',    'i' => 'menu_book',    'p' => 'quran'],
                    ['n' => 'الأحاديث النبوية', 'i' => 'library_books','p' => 'hadith'],
                    ['n' => 'السيرة النبوية',   'i' => 'history_edu',  'p' => 'seerah'],
                    ['n' => 'السبحة الرقمية',   'i' => 'track_changes','p' => 'tasbih'],
                    ['n' => 'اختبارات مشكاة',  'i' => 'quiz',         'p' => 'quiz'],
                ];
                foreach($apps as $app): 
                    $isActive = ($currentPage === $app['p']);
                    echo sidebarItem(['name' => $app['n'], 'icon' => $app['i'], 'page' => $app['p']], $isActive);
                endforeach; ?>
            </div>

            <!-- Logout -->
            <div class="px-4 mt-5 pb-4">
                <div class="mx-1" style="height:1px; background: var(--border-color);"></div>
                <a href="logout.php" title="تسجيل الخروج"
                   class="luxury-sidebar-item mt-4"
                   style="color: #ef4444 !important;">
                    <div class="icon-box" style="background: rgba(239,68,68,0.08);">
                        <span class="material-icons-outlined text-xl" style="color: #ef4444 !important; font-size:1.2rem;">logout</span>
                    </div>
                    <span class="text-sm font-medium logout-text whitespace-nowrap" style="color: #ef4444;">تسجيل الخروج</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- ─── MAIN CONTENT ─── -->
    <main class="min-h-screen page-content">

        <!-- Topbar -->
        <header class="glass-nav sticky top-0 z-30 px-4 md:px-6 py-3 flex justify-between items-center gap-3">
            <div class="flex items-center gap-3">
                <!-- Mobile open sidebar button -->
                <button onclick="openSidebar()" class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl transition-all flex-shrink-0"
                        style="background: var(--bg-surface); border: 1px solid var(--border-color); cursor:pointer; color: var(--color-primary);">
                    <span class="material-icons-outlined" style="font-size:1.3rem;">menu</span>
                </button>
                <!-- Brand on mobile -->
                <div class="flex items-center gap-2 lg:hidden">
                    <span class="material-icons-outlined text-2xl" style="color: var(--color-primary);">mosque</span>
                    <span class="font-black font-tajawal text-lg" style="color: var(--color-text-main);">مِشكاة</span>
                </div>
                <!-- Page title on desktop -->
                <h2 class="hidden lg:block text-xl font-black font-tajawal" style="color: var(--color-text-main);"><?php echo $pageTitle; ?></h2>
            </div>

            <div class="flex items-center gap-2 md:gap-3">
                <!-- Clock & Date Display -->
                <div class="hidden md:flex items-center gap-3 px-3 py-1 bg-gray-50/50 dark:bg-white/5 border border-gray-100 dark:border-white/5 rounded-2xl">
                    <div class="flex flex-col items-end pl-3 border-l border-gray-200 dark:border-white/10">
                        <span class="text-[10px] font-black" id="clockDay" style="color: var(--color-primary);"></span>
                        <span class="text-[11px] font-bold" id="clockTime" style="color: var(--color-text-muted);">00:00</span>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="text-[9px] font-bold" id="gregorianDate" style="color: var(--color-text-main);"></span>
                        <span class="text-[9px] font-medium" id="hijriDate" style="color: var(--color-primary);"></span>
                    </div>
                </div>

                <!-- Dark Mode -->
                <button onclick="toggleDarkMode()"
                        style="width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:var(--bg-surface);border:1px solid var(--border-color);cursor:pointer;transition:all .2s;">
                    <span class="material-icons-outlined" id="themeIcon" style="font-size:1.2rem;color:var(--color-primary);">dark_mode</span>
                </button>

                <!-- User avatar -->
                <div class="flex items-center gap-2 md:gap-3">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-xs font-bold leading-tight" style="color: var(--color-text-main);"><?php echo htmlspecialchars(explode(' ', $userName)[0]); ?></span>
                        <span class="text-[10px] font-semibold" style="color: var(--color-primary);"><?php echo $userRoleName; ?></span>
                    </div>
                    <div class="w-10 h-10 rounded-2xl overflow-hidden flex items-center justify-center font-black text-sm flex-shrink-0"
                         style="background: var(--color-primary); color: white;">
                        <?php if(!empty($userImage)): ?>
                            <img src="<?php echo htmlspecialchars($userImage); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <?php echo mb_substr($userName, 0, 1, 'UTF-8'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile page title bar -->
        <div class="lg:hidden px-4 py-2" style="border-bottom: 1px solid var(--border-color);">
            <h2 class="text-sm font-black font-tajawal" style="color: var(--color-text-main);"><?php echo $pageTitle; ?></h2>
        </div>

        <!-- Page content -->
        <div class="p-4 md:p-6 lg:p-10 max-w-7xl mx-auto animate-slide-up">
            <?php 
                if ($pagePath && file_exists($pagePath)) {
                    include $pagePath;
                } else {
                    echo "
                    <div class='flex flex-col items-center justify-center py-20 text-center animate-scale-in'>
                        <div class='w-24 h-24 bg-mishkat-green-50 dark:bg-white/5 text-mishkat-green-600 dark:text-mishkat-gold-500 rounded-[2.5rem] flex items-center justify-center mb-8 shadow-xl animate-pulse'>
                            <span class='material-icons-outlined text-5xl'>construction</span>
                        </div>
                        <h3 class='text-2xl font-black text-mishkat-green-900 dark:text-white mb-3 font-tajawal'>هذه الصفحة قيد التطوير</h3>
                        <p class='text-gray-500 dark:text-white/40 max-w-sm text-sm leading-relaxed'>نحن نعمل حالياً على تجهيز هذا القسم لتوفير أفضل تجربة تعليمية لك.</p>
                        <a href='dashboard.php' class='mt-8 px-8 py-4 bg-mishkat-green-700 text-white rounded-2xl font-black hover:bg-mishkat-green-600 transition-all shadow-xl shadow-mishkat-green-900/10'>العودة للرئيسية</a>
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
            document.body.classList.add('sidebar-open');
            overlay.classList.remove('hidden');
            void overlay.offsetWidth;
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            document.body.classList.remove('sidebar-open');
            overlay.classList.remove('active');
            setTimeout(() => {
                if (!sidebar.classList.contains('open')) overlay.classList.add('hidden');
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

        /* ── Live Clock & Dates ── */
        function updateClock() {
            const now = new Date();
            const days = ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'];
            
            const dayEl = document.getElementById('clockDay');
            const timeEl = document.getElementById('clockTime');
            const gregEl = document.getElementById('gregorianDate');
            const hijriEl = document.getElementById('hijriDate');
            
            if (dayEl) dayEl.innerText = days[now.getDay()];
            if (timeEl) timeEl.innerText = now.toLocaleTimeString('ar-EG', { hour12: true, hour: '2-digit', minute: '2-digit' });
            
            if (gregEl) {
                gregEl.innerText = now.toLocaleDateString('ar-EG', { day: 'numeric', month: 'long', year: 'numeric' });
            }
            if (hijriEl) {
                try {
                    hijriEl.innerText = new Intl.DateTimeFormat('ar-SA-u-ca-islamic-umalqura', { day: 'numeric', month: 'long', year: 'numeric' }).format(now);
                } catch(e) {
                    hijriEl.innerText = '';
                }
            }
        }
        /* ── Toast System ── */
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `luxury-toast ${type} animate-fadeIn`;
            
            const icons = {
                success: 'check_circle',
                error: 'error',
                info: 'info'
            };

            toast.innerHTML = `
                <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-white/5 flex items-center justify-center flex-shrink-0">
                    <span class="material-icons-outlined text-[20px] ${type === 'success' ? 'text-emerald-500' : type === 'error' ? 'text-red-500' : 'text-mishkat-gold-500'}">${icons[type]}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-black">${message}</p>
                </div>
            `;

            container.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => toast.classList.add('active'), 10);

            // Auto remove
            setTimeout(() => {
                toast.classList.remove('active');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // Global alert replacement
        window.alert = function(message) {
            showToast(message, 'info');
        };

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
