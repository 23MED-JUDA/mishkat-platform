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

        /* Desktop: always visible */
        @media (min-width: 1024px) {
            #sidebar { 
                transform: translateX(0) !important; 
                top: 1.5rem;
                right: 1.5rem;
                height: calc(100vh - 3rem);
                border-radius: 2rem;
            }
            #sidebarOverlay { display: none !important; }
            
            .page-content {
                margin-right: calc(280px + 3rem);
            }

            /* Collapsed State */
            #sidebar.collapsed {
                width: 96px;
            }
            
            #sidebar.collapsed:hover {
                width: 280px;
                box-shadow: 0 0 50px rgba(0,0,0,0.5);
            }

            body.sidebar-collapsed .page-content {
                margin-right: calc(96px + 3rem);
            }

            /* Hide text elements smoothly */
            #sidebar .sidebar-text,
            #sidebar .sidebar-logo-text,
            #sidebar .user-info,
            #sidebar .logout-text,
            #sidebar .sidebar-app-label {
                transition: opacity 0.3s ease, width 0.3s ease;
                white-space: nowrap;
                overflow: hidden;
            }

            #sidebar.collapsed:not(:hover) .sidebar-text,
            #sidebar.collapsed:not(:hover) .sidebar-logo-text,
            #sidebar.collapsed:not(:hover) .user-info,
            #sidebar.collapsed:not(:hover) .logout-text {
                opacity: 0;
                width: 0;
            }

            #sidebar.collapsed:not(:hover) .sidebar-app-label {
                opacity: 0;
                height: 0;
                margin-bottom: 0;
                padding-top: 0;
                padding-bottom: 0;
            }
            
            #sidebar.collapsed:not(:hover) .user-box {
                padding: 0.75rem;
                background: transparent;
                border-color: transparent;
                justify-content: center;
            }

            #sidebar.collapsed:not(:hover) .user-avatar {
                margin: 0 auto;
            }

            #sidebar.collapsed:not(:hover) .logo-box {
                justify-content: center;
            }
            
            #sidebar.collapsed:not(:hover) .sidebar-item-link {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
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

        <!-- Logo Header -->
        <div class="sticky top-0 z-20 px-6 pt-10 pb-8 logo-box flex items-center justify-between transition-all duration-300">
            <div class="flex items-center gap-4">
                <div class="relative group flex-shrink-0">
                        <div class="absolute -inset-1 bg-mishkat-gold-500/20 rounded-2xl blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        <div class="relative w-12 h-12 bg-gradient-to-br from-mishkat-gold-600 to-mishkat-gold-400 rounded-2xl flex items-center justify-center shadow-lg shadow-mishkat-gold-500/20">
                            <span class="material-icons-outlined text-black text-2xl">mosque</span>
                        </div>
                    </div>
                </div>
                <div class="sidebar-logo-text transition-all duration-300">
                    <h1 class="text-2xl font-black font-tajawal leading-none tracking-tighter whitespace-nowrap">مِشـكاة</h1>
                    <div class="flex items-center gap-2 mt-1.5 whitespace-nowrap">
                        <span class="w-2 h-2 rounded-full bg-mishkat-gold-500 animate-pulse"></span>
                        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-white/30 dark:text-mishkat-gold-500/50">النظام الذكي</p>
                    </div>
                </div>
            </div>
            <button onclick="closeSidebar()" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 text-white/40 hover:text-mishkat-gold-500 transition-all flex-shrink-0">
                    <span class="material-icons-outlined text-xl">close</span>
                </button>
            </div>
        </div>

        <!-- User Identity -->
        <div class="px-4 mb-8 transition-all duration-300">
            <div class="user-box relative p-4 rounded-[2rem] overflow-hidden group flex items-center gap-4 transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-mishkat-gold-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                <div class="user-avatar w-12 h-12 rounded-2xl bg-mishkat-gold-500 overflow-hidden flex items-center justify-center font-black text-black text-lg shadow-lg shadow-mishkat-gold-500/20 flex-shrink-0 transition-all duration-300">
                    <?php if(!empty($userImage)): ?>
                        <img src="<?php echo htmlspecialchars($userImage); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php echo mb_substr($userName, 0, 1, 'UTF-8'); ?>
                    <?php endif; ?>
                </div>
                <div class="user-info flex-1 min-w-0 transition-all duration-300">
                    <p class="text-sm font-black text-white truncate leading-tight"><?php echo htmlspecialchars($userName); ?></p>
                    <div class="flex items-center gap-1.5 mt-1 whitespace-nowrap">
                        <span class="text-[8px] font-black uppercase tracking-widest text-mishkat-gold-500/60"><?php echo $userRoleName; ?></span>
                        <span class="w-1 h-1 rounded-full bg-white/20"></span>
                        <span class="text-[8px] font-black uppercase tracking-widest text-white/20">متصل الآن</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="pb-10">
            <div class="px-6 mb-4 sidebar-app-label transition-all duration-300">
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white/20 whitespace-nowrap">القائمة الأساسية</span>
            </div>
            
            <div class="space-y-1">
                <?php foreach ($links as $link):
                    $isActive = ($currentPage === ($link['page'] ?? null));
                    echo sidebarItem($link, $isActive);
                endforeach; ?>
            </div>

            <!-- Apps Section -->
            <div class="mt-8">
                <div class="px-6 mb-4 flex items-center justify-between sidebar-app-label transition-all duration-300">
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white/20 whitespace-nowrap">تطبيقات مشكاة</span>
                    <span class="w-10 h-[1px] bg-white/5"></span>
                </div>
                
                <div class="space-y-1">
                    <?php 
                    $apps = [
                        ['n' => 'القرآن الكريم', 'i' => 'menu_book', 'p' => 'quran'],
                        ['n' => 'الأحاديث النبوية', 'i' => 'library_books', 'p' => 'hadith'],
                        ['n' => 'السيرة النبوية', 'i' => 'history_edu', 'p' => 'seerah'],
                        ['n' => 'السبحة الرقمية', 'i' => 'track_changes', 'p' => 'tasbih'],
                        ['n' => 'اختبارات مشكاة', 'i' => 'quiz', 'p' => 'quiz']
                    ];
                    foreach($apps as $app): 
                        $isActive = ($currentPage === $app['p']);
                        echo sidebarItem(['name' => $app['n'], 'icon' => $app['i'], 'page' => $app['p']], $isActive);
                    endforeach; ?>
                </div>
            </div>

            <!-- Logout Bottom -->
            <div class="mt-10 px-4 pb-6">
                <a href="logout.php" title="تسجيل الخروج"
                   class="sidebar-item-link flex items-center gap-4 px-4 py-3 rounded-[1.5rem] bg-red-500/5 border border-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-300 group shadow-lg shadow-red-500/5">
                    <div class="w-10 h-10 rounded-xl bg-red-500/10 group-hover:bg-white/20 flex items-center justify-center transition-colors flex-shrink-0">
                        <span class="material-icons-outlined text-[20px]">logout</span>
                    </div>
                    <span class="font-black text-sm logout-text transition-all duration-300 whitespace-nowrap">تسجيل الخروج</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- ─── MAIN CONTENT ─── -->
    <main class="min-h-screen page-content">

        <!-- Topbar -->
        <header class="glass-nav sticky top-0 z-30 px-4 md:px-6 py-3 flex justify-between items-center gap-3">
            <div class="flex items-center gap-3">
                <!-- Hamburger / Toggle Sidebar -->
                <button id="menuBtn" onclick="toggleSidebar()" 
                        class="p-2 bg-white dark:bg-black rounded-xl shadow-sm text-mishkat-green-800 dark:text-mishkat-gold-500 border border-gray-100 dark:border-mishkat-gold-500/20 flex-shrink-0 hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                    <span class="material-icons-outlined">menu_open</span>
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
                <div class="flex items-center gap-2 md:gap-3 pl-2">
                    <div class="hidden sm:flex flex-col items-end">
                        <span class="text-xs font-black text-mishkat-green-900 dark:text-white leading-tight"><?php echo htmlspecialchars(explode(' ', $userName)[0]); ?></span>
                        <span class="text-[9px] text-mishkat-gold-600 font-bold uppercase tracking-tighter"><?php echo $userRoleName; ?></span>
                    </div>
                    <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl md:rounded-2xl bg-mishkat-gold-500 overflow-hidden flex items-center justify-center text-black font-black text-sm flex-shrink-0 shadow-lg shadow-mishkat-gold-500/10">
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
        <div class="lg:hidden px-4 py-3 glass-nav border-t border-gray-100 dark:border-mishkat-gold-500/10">
            <h2 class="text-base font-black text-mishkat-green-900 dark:text-white font-tajawal"><?php echo $pageTitle; ?></h2>
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
        function toggleSidebar() {
            if (window.innerWidth >= 1024) {
                // Desktop toggle collapse
                const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
                document.getElementById('sidebar').classList.toggle('collapsed');
                localStorage.setItem('sidebarCollapsed', isCollapsed);
                
                // Update icon
                const btnIcon = document.querySelector('#menuBtn .material-icons-outlined');
                if (btnIcon) {
                    btnIcon.textContent = isCollapsed ? 'menu' : 'menu_open';
                }
            } else {
                // Mobile open
                openSidebar();
            }
        }

        // Initialize sidebar state on load
        document.addEventListener('DOMContentLoaded', () => {
            if (window.innerWidth >= 1024 && localStorage.getItem('sidebarCollapsed') === 'true') {
                document.body.classList.add('sidebar-collapsed');
                document.getElementById('sidebar').classList.add('collapsed');
                const btnIcon = document.querySelector('#menuBtn .material-icons-outlined');
                if (btnIcon) btnIcon.textContent = 'menu';
            }
        });

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
