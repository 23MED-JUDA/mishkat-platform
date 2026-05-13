<?php
session_start();
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشكاة | Mishkat - منصة تعليمية إسلامية</title>

    <!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          
          /* ═════════ النافبار والهيدر  ══════════ */
          'mishkat-green': {
            50:  '#f0f7f4', 100: '#dceee5', 200: '#bbdece',
            300: '#8ec7ab', 400: '#5daa83', 500: '#3b8f66',
            600: '#2a7351', 700: '#225c42', 800: '#1d4a36',
            900: '#193d2e', 950: '#0c221a',
          },
          'mishkat-beige': {
            50:  '#fefdfb', 100: '#fdf9f0', 200: '#faf2de',
            300: '#f5e6c4', 400: '#eed5a0', 500: '#e5c07a',
            600: '#d4a54e', 700: '#b8893d', 800: '#956e35',
            900: '#795b2e', 950: '#412f17',
          },
          'mishkat-gold': {
            50:  '#FFF9E6', 100: '#FFF0B3', 200: '#FFE680',
            300: '#FFDB4D', 400: '#FFD11A', 500: '#C9A84C',
            600: '#B8943F', 700: '#9A7B33', 800: '#7C6228',
            900: '#5E4A1E',
          },
          'mishkat-night': {
            50:  '#E8EAF0', 100: '#C5CAD6', 200: '#9FA8BC',
            300: '#7986A2', 400: '#5C6D8F', 500: '#3F547C',
            600: '#374A6E', 700: '#2D3D5B', 800: '#1A2744',
            900: '#0D1728', 950: '#070E1A',
          },

          /* ══════════ قسم البرامج (Programs) ════════════ */
          'programs-primary': {
            50: '#f0fdf4', 100: '#dcfce7', 200: '#b6f2cd',
            300: '#7ae1a8', 400: '#3cc87c', 500: '#1a7a4a',
            600: '#155e3a', 700: '#124a2f', 800: '#0f3b26',
            900: '#0a2919',
          },
          'programs-beige': {
            50: '#fefcf8', 100: '#fdf8ed', 200: '#faf0d6',
            300: '#f5e3b8', 400: '#edd499', 500: '#e0bf72',
          },
          'programs-cream': {
            50: '#fefdfb', 100: '#fdfaf4', 200: '#fbf5e9',
            300: '#f7edda',
          },

          /* ══════════ قسم المعلمين (Teachers) ═════════════ */
          'teachers-primary':       '#1B4332',
          'teachers-primary-light': '#2D6A4F',
          'teachers-secondary':     '#F5EBE0',
          'teachers-accent':        '#D4A373',
          'teachers-cream':         '#FAF7F2',
          'teachers-text':          '#2C3E2D',

          /* ══════════ قسم الباقات (Packages) ═══════════ */
          'packages-gold': {
            50: '#fffef7', 100: '#fef9e7', 200: '#fdf0c4',
            300: '#fce4a0', 400: '#d4a537', 500: '#c49225',
            600: '#a67a1e', 700: '#876118', 800: '#6b4c14',
            900: '#4f380f',
          },
          'packages-cream': {
            50: '#fefdfb', 100: '#fdf9f3', 200: '#faf3e6',
            300: '#f5ead6', 400: '#eedfc3', 500: '#e4d2ac',
            600: '#d4be8e', 700: '#bfa46e', 800: '#a08752',
            900: '#7d6840',
          },
          'packages-sage': {
            50: '#f6f8f5', 100: '#eef2ec', 200: '#dce6d8',
            300: '#c4d6be', 400: '#a3c199', 500: '#83ab77',
            600: '#6b9360', 700: '#567a4e', 800: '#456340',
            900: '#3a5236',
          },
          'packages-warm': {
            50: '#faf9f7', 100: '#f5f3ef', 200: '#ebe7df',
            300: '#ddd7cb', 400: '#c9bfae', 500: '#b3a693',
            600: '#9a8d79', 700: '#7d7264', 800: '#645b52',
            900: '#514a43',
          },

          /* ════════════ قسم نظام الدراسة (Study) ═════════════ */
          'study-primary': {
            50: '#f0f7f4', 100: '#d9ece2', 200: '#b5d9c7',
            300: '#85bfa5', 400: '#5a9f80', 500: '#3a8366',
            600: '#2b6951', 700: '#245543', 800: '#1f4436',
            900: '#1b382e', 950: '#0e201a',
          },
          'study-gold': {
            50: '#fdf9ef', 100: '#f9f0d4', 200: '#f2dea5',
            300: '#eac86d', 400: '#e4b340', 500: '#da9a28',
            600: '#c17a1e', 700: '#a05b1b', 800: '#83491d',
            900: '#6c3d1b',
          },
          'study-cream': {
            50: '#fefdf8', 100: '#fdf9ed', 200: '#faf2d4',
            300: '#f5e6b0',
          },

          /* ═══════════ الفوتر (Footer) ═════════════ */
          'footer-gold': {
            50: '#fdf8e8', 100: '#f5e6b8', 200: '#e8d08a',
            300: '#d4af37', 400: '#c9a020', 500: '#b8910a',
            600: '#9a7a08', 700: '#7c6206', 800: '#5e4a05',
            900: '#403203',
          },
          'footer-dark': {
            50: '#1e1e2e', 100: '#1a1a28', 200: '#151522',
            300: '#12121e', 400: '#0f0f1a', 500: '#0d0d17',
            600: '#0a0a12', 700: '#08080e', 800: '#05050a',
            900: '#030306',
          },
        },

        /* ═════════════ الخطوط (مشتركة لكل الأقسام) ═══════════ */
        fontFamily: {
          'arabic':  ['Tajawal', 'Arial', 'sans-serif'],
          'amiri':   ['Amiri', 'serif'],
          'tajawal': ['Tajawal', 'sans-serif'],
          'cairo':   ['Cairo', 'sans-serif'],
          'kufi':    ['Noto Kufi Arabic', 'sans-serif'],
        },

        /* ═════════ الأنيميشن (للفوتر) ══════════ */
        animation: {
          'float-slow':   'floatSlow 12s ease-in-out infinite',
          'float-medium': 'floatMedium 15s ease-in-out infinite',
          'float-fast':   'floatFast 10s ease-in-out infinite',
          'glow':         'glow 2s ease-in-out infinite alternate',
        },
        keyframes: {
          floatSlow: {
            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
            '50%':      { transform: 'translate(30px, -20px) scale(1.1)' },
          },
          floatMedium: {
            '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
            '50%':      { transform: 'translate(-20px, 15px) scale(1.05)' },
          },
          floatFast: {
            '0%, 100%': { transform: 'translate(-50%, -50%) scale(1)', opacity: '0.3' },
            '50%':      { transform: 'translate(-50%, -50%) scale(1.2)', opacity: '0.6' },
          },
          glow: {
            '0%':   { textShadow: '0 0 5px rgba(212,175,55,0.3)' },
            '100%': { textShadow: '0 0 20px rgba(212,175,55,0.6), 0 0 40px rgba(212,175,55,0.2)' },
          }
        }
      }
    }
  }
</script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
<link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>


    <!-- Custom Styles -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/programs.css">
    <link rel="stylesheet" href="assets/css/teachers.css">
     <link rel="stylesheet" href="assets/css/packages.css">
      <link rel="stylesheet" href="assets/css/study-system.css">
        <link rel="stylesheet" href="assets/css/faq.css">
          <link rel="stylesheet" href="assets/css/footer.css">
    
</head>
<body class="font-arabic bg-mishkat-beige-50 text-mishkat-green-900 overflow-x-hidden">


   <!-- ===== NAVBAR SECTION ===== -->
<section id="navbar-section">

    <!--  NAVBAR  -->
    <nav id="navbar"
         class="navbar fixed top-0 right-0 left-0 z-50 transition-all duration-500 ease-in-out"
         role="navigation"
         aria-label="القائمة الرئيسية">

        <div class="navbar__container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="navbar__wrapper flex items-center justify-between h-20">

               <!-- ===== القسم الأيسر: اللوجو + الاسم ===== -->
<div class="navbar__brand flex items-center gap-3 flex-shrink-0">
    <a href="#" class="navbar__logo-link flex items-center gap-3 group" aria-label="الصفحة الرئيسية - مشكاة">
        <div class="navbar__logo-wrapper relative w-16 h-16 rounded-full overflow-hidden
                    ring-2 ring-mishkat-green-600/30 group-hover:ring-mishkat-green-500
                    transition-all duration-300 shadow-lg group-hover:shadow-xl
                    group-hover:scale-105">
            <img src="assets/images/6046279299901361992.jpg"
                 alt="شعار مشكاة"
                 class="w-full h-full object-cover"
                 loading="eager"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <!-- Fallback -->
            <div class="w-full h-full bg-gradient-to-br from-mishkat-green-600 to-mishkat-green-800
                        items-center justify-center text-white font-bold text-xl hidden">
                م
            </div>
        </div>
        <div class="navbar__brand-text flex flex-col leading-tight">
            <span class="text-xl font-bold text-mishkat-green-800 group-hover:text-mishkat-green-600
                         transition-colors duration-300">
                مِشكَاةُ
            </span>
            <span class="text-sm font-medium text-mishkat-green-600/70 tracking-wide">
                Mishkat
            </span>
        </div>
    </a>
</div>


                <!-- ===== القسم الأوسط: روابط التنقل ===== -->
                <div class="navbar__nav hidden lg:flex items-center gap-1">
                    <ul class="navbar__menu flex items-center gap-1" role="menubar">
                        <li role="none">
                            <a href="#hero"
                               class="navbar__link nav-link relative px-4 py-2 text-sm font-medium
                                      text-mishkat-green-800 hover:text-mishkat-green-600
                                      rounded-lg hover:bg-mishkat-green-50/50
                                      transition-all duration-300 block"
                               role="menuitem"
                               data-active="true">
                                الصفحة الرئيسية
                                <span class="nav-link__underline"></span>
                            </a>
                        </li>
                        <li role="none">
    <a href="#packages-section"
       class="navbar__link nav-link relative px-4 py-2 text-sm font-medium
              text-mishkat-green-800 hover:text-mishkat-green-600
              rounded-lg hover:bg-mishkat-green-50/50
              transition-all duration-300 block"
       role="menuitem">
        الباقات
        <span class="nav-link__underline"></span>
    </a>
</li>

                        <li role="none">
                            <a href="#teachers"
                               class="navbar__link nav-link relative px-4 py-2 text-sm font-medium
                                      text-mishkat-green-800 hover:text-mishkat-green-600
                                      rounded-lg hover:bg-mishkat-green-50/50
                                      transition-all duration-300 block"
                               role="menuitem">
                                المعلمين
                                <span class="nav-link__underline"></span>
                            </a>
                        </li>
                        <li role="none">
                            <a href="#programs"
                               class="navbar__link nav-link relative px-4 py-2 text-sm font-medium
                                      text-mishkat-green-800 hover:text-mishkat-green-600
                                      rounded-lg hover:bg-mishkat-green-50/50
                                      transition-all duration-300 block"
                               role="menuitem">
                                البرامج الدراسية
                                <span class="nav-link__underline"></span>
                            </a>
                        </li>
                        <li role="none">
                            <a href="#faq-section"
                               class="navbar__link nav-link relative px-4 py-2 text-sm font-medium
                                      text-mishkat-green-800 hover:text-mishkat-green-600
                                      rounded-lg hover:bg-mishkat-green-50/50
                                      transition-all duration-300 block"
                               role="menuitem">
                                عن المنصة
                                <span class="nav-link__underline"></span>
                            </a>
                        </li>
                    </ul>
                </div>

                                  <!-- ===== القسم الأيمن: أزرار الإجراءات ===== -->
                <div class="navbar__actions hidden lg:flex items-center gap-3">

                    <!-- زر اشترك الآن مع Dropdown -->
                    <div class="navbar__dropdown relative" data-dropdown>
                        <button id="subscribeBtn"
                                class="navbar__dropdown-trigger flex items-center gap-2 px-5 py-2.5
                                       bg-gradient-to-l from-mishkat-green-700 to-mishkat-green-600
                                       hover:from-mishkat-green-600 hover:to-mishkat-green-500
                                       text-white text-sm font-bold rounded-xl
                                       shadow-lg shadow-mishkat-green-600/25
                                       hover:shadow-xl hover:shadow-mishkat-green-500/30
                                       transition-all duration-300 hover:-translate-y-0.5
                                       active:translate-y-0"
                                aria-expanded="false"
                                aria-haspopup="true"
                                aria-controls="subscribeDropdown">
                            <span>اشترك الآن</span>
                            <!-- سهم -->
                            <svg class="navbar__dropdown-arrow w-4 h-4 transition-transform duration-300"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- قائمة الاشتراك المنسدلة -->
                        <div id="subscribeDropdown"
                             class="navbar__dropdown-menu absolute left-0 mt-3 w-64
                                    bg-white/95 backdrop-blur-xl
                                    rounded-2xl shadow-2xl shadow-mishkat-green-900/10
                                    border border-mishkat-green-100/50
                                    opacity-0 invisible translate-y-2 scale-95
                                    transition-all duration-300 ease-out
                                    overflow-hidden"
                             role="menu"
                             aria-labelledby="subscribeBtn">

                            <!-- رأس الـ Dropdown -->
                            <div class="px-5 py-3 bg-gradient-to-l from-mishkat-green-50 to-mishkat-beige-100
                                        border-b border-mishkat-green-100/50">
                                <p class="text-xs font-bold text-mishkat-green-700">اختر نوع التسجيل</p>
                            </div>

                            <!-- خيارات التسجيل -->
                            <div class="p-2">
                                <a href="/register"
                                   class="navbar__dropdown-item flex items-center gap-3 px-4 py-3
                                          rounded-xl text-sm font-medium text-mishkat-green-800
                                          hover:bg-mishkat-green-50 hover:text-mishkat-green-600
                                          transition-all duration-200 group"
                                   role="menuitem">
                                    <span class="flex items-center justify-center w-10 h-10
                                                 bg-mishkat-green-100 group-hover:bg-mishkat-green-200
                                                 rounded-xl transition-colors duration-200">
                                        <!-- أيقونة الطالب -->
                                        <svg class="w-5 h-5 text-mishkat-green-600" fill="none"
                                             stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987
                                                     8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0
                                                     016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018
                                                     18c-2.305 0-4.408.867-6 2.292m0-14.25v14.25"/>
                                        </svg>
                                    </span>
                                    <div class="flex flex-col">
                                        <span class="font-bold">تسجيل طالب أو طالبة</span>
                                        <span class="text-xs text-mishkat-green-500 mt-0.5">
                                            ابدأ رحلتك التعليمية
                                        </span>
                                    </div>
                                </a>

                                <a href="/register"
                                   class="navbar__dropdown-item flex items-center gap-3 px-4 py-3
                                          rounded-xl text-sm font-medium text-mishkat-green-800
                                          hover:bg-mishkat-green-50 hover:text-mishkat-green-600
                                          transition-all duration-200 group"
                                   role="menuitem">
                                    <span class="flex items-center justify-center w-10 h-10
                                                 bg-mishkat-beige-200 group-hover:bg-mishkat-beige-300
                                                 rounded-xl transition-colors duration-200">
                                        <!-- أيقونة المعلم -->
                                        <svg class="w-5 h-5 text-mishkat-green-600" fill="none"
                                             stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627
                                                     0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0
                                                     00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905
                                                     59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248
                                                     -1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702
                                                     50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000
                                                     1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981
                                                     5.981 0 006.75 15.75v-1.5"/>
                                        </svg>
                                    </span>
                                    <div class="flex flex-col">
                                        <span class="font-bold">تسجيل معلم / معلمة</span>
                                        <span class="text-xs text-mishkat-green-500 mt-0.5">
                                            شارك علمك مع الآخرين
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- زر تسجيل الدخول -->
                    <a href="/login"
                       class="navbar__login-btn px-5 py-2.5 text-sm font-bold
                              text-mishkat-green-700 bg-mishkat-green-50
                              hover:bg-mishkat-green-100 hover:text-mishkat-green-800
                              border border-mishkat-green-200 hover:border-mishkat-green-300
                              rounded-xl transition-all duration-300
                              hover:-translate-y-0.5 hover:shadow-md">
                        تسجيل الدخول
                    </a>
                </div>


                               <!-- ===== زر القائمة للموبايل ===== -->
                <div class="navbar__mobile-toggle lg:hidden">
                    <button id="mobileMenuBtn"
                            class="mobile-menu-btn relative w-10 h-10 flex items-center justify-center
                                   rounded-lg hover:bg-mishkat-green-50/50
                                   transition-all duration-300"
                            aria-expanded="false"
                            aria-controls="mobileMenu"
                            aria-label="فتح القائمة">
                        <div class="hamburger-icon w-6 h-5 flex flex-col justify-between">
                            <span class="hamburger-line block h-0.5 w-full bg-mishkat-green-700 rounded-full
                                         transition-all duration-300 origin-center"></span>
                            <span class="hamburger-line block h-0.5 w-full bg-mishkat-green-700 rounded-full
                                         transition-all duration-300"></span>
                            <span class="hamburger-line block h-0.5 w-3/4 bg-mishkat-green-700 rounded-full
                                         transition-all duration-300 origin-center mr-auto"></span>
                        </div>
                    </button>
                </div>

            </div>
        </div>

        <!-- ===== Mobile Sidebar (Drawer) ===== -->
        <div id="mobileMenuOverlay" class="mobile-overlay lg:hidden" aria-hidden="true"></div>
        
        <div id="mobileMenu"
             class="navbar__mobile-menu lg:hidden"
             role="menu"
             aria-hidden="true">
             
            <!-- Sidebar Header -->
            <div class="px-6 py-6 border-b border-mishkat-green-100/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-mishkat-green-700 rounded-xl flex items-center justify-center text-white">
                        <span class="material-icons-outlined text-xl">mosque</span>
                    </div>
                    <span class="text-xl font-bold text-mishkat-green-800">مِشكاة</span>
                </div>
                <button id="closeMobileBtn" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-mishkat-green-700 hover:bg-mishkat-green-50 transition-all">
                    <span class="material-icons-outlined">close</span>
                </button>
            </div>

            <div class="navbar__mobile-inner px-6 py-8 space-y-3">
                <a href="#hero" class="mobile-nav-link flex items-center gap-4 px-4 py-3.5 text-base font-bold text-mishkat-green-800
                                       hover:text-mishkat-green-600 hover:bg-mishkat-green-50/50
                                       rounded-2xl transition-all duration-300" role="menuitem">
                    <span class="material-icons-outlined text-xl opacity-40">home</span>
                    الصفحة الرئيسية
                </a>
                <a href="#packages-section" class="mobile-nav-link flex items-center gap-4 px-4 py-3.5 text-base font-bold text-mishkat-green-800
                                       hover:text-mishkat-green-600 hover:bg-mishkat-green-50/50
                                       rounded-2xl transition-all duration-300" role="menuitem">
                    <span class="material-icons-outlined text-xl opacity-40">loyalty</span>
                    الباقات
                </a>
                <a href="#teachers" class="mobile-nav-link flex items-center gap-4 px-4 py-3.5 text-base font-bold text-mishkat-green-800
                                          hover:text-mishkat-green-600 hover:bg-mishkat-green-50/50
                                          rounded-2xl transition-all duration-300" role="menuitem">
                    <span class="material-icons-outlined text-xl opacity-40">groups</span>
                    المعلمين
                </a>
                <a href="#programs" class="mobile-nav-link flex items-center gap-4 px-4 py-3.5 text-base font-bold text-mishkat-green-800
                                          hover:text-mishkat-green-600 hover:bg-mishkat-green-50/50
                                          rounded-2xl transition-all duration-300" role="menuitem">
                    <span class="material-icons-outlined text-xl opacity-40">school</span>
                    البرامج الدراسية
                </a>
                <a href="#faq-section" class="mobile-nav-link flex items-center gap-4 px-4 py-3.5 text-base font-bold text-mishkat-green-800
                                       hover:text-mishkat-green-600 hover:bg-mishkat-green-50/50
                                       rounded-2xl transition-all duration-300" role="menuitem">
                    <span class="material-icons-outlined text-xl opacity-40">info</span>
                    عن المنصة
                </a>

                <div class="pt-6 mt-6 border-t border-mishkat-green-100/50 space-y-4">
                    <a href="/login" class="flex items-center justify-center w-full py-4 text-mishkat-green-700 font-bold border border-mishkat-green-200 rounded-2xl hover:bg-mishkat-green-50 transition-all">
                        تسجيل الدخول
                    </a>
                    <a href="/register"
                       class="flex items-center justify-center w-full py-4
                              bg-gradient-to-l from-mishkat-green-700 to-mishkat-green-600
                              text-white font-bold rounded-2xl
                              shadow-lg shadow-mishkat-green-600/25
                              transition-all duration-300">
                        اشترك الآن
                    </a>
                </div>
            </div>
        </div>


    </nav>

</section>

   <!-- ===== HEADER SECTION ===== -->
<section id="header-section">

    <!--  HERO SECTION  -->
    <section id="hero" class="hero-section" aria-label="القسم الرئيسي">

        <!-- Background Image with Parallax -->
        <div class="hero-bg" id="heroBg" aria-hidden="true">
            <img
                src="assets/images/download (2).jfif"
                alt=""
                class="hero-bg-image"
                loading="eager"
                fetchpriority="high"
            >
        </div>

        <!-- Gradient Overlay -->
        <div class="hero-overlay" aria-hidden="true"></div>

        <!-- Animated Light Particles -->
        <canvas id="particlesCanvas" class="hero-particles" aria-hidden="true"></canvas>

        <!-- Decorative Light Rays -->
        <div class="light-ray" aria-hidden="true"></div>
        <div class="light-ray light-ray-2" aria-hidden="true"></div>

        <!-- Decorative Islamic Pattern (Top) -->
        <div class="islamic-pattern-top" aria-hidden="true"></div>

        <!-- Main Content -->
        <div class="hero-content">
            <div class="hero-inner">

                <!-- Bismillah Badge -->
                <div class="hero-badge" id="heroBadge">
                    <span class="badge-icon">﷽</span>
                </div>

                <!-- Main Heading -->
                <h1 class="hero-title" id="heroTitle">
                    <span class="title-line title-line-1">
                        <span class="title-word">مِشْكَاةٌ</span>
                    </span>
                    <span class="title-line title-line-2">
                        <span class="title-word-sub">نورٌ على دربِ المعرفة</span>
                    </span>
                </h1>

                <!-- Decorative Divider -->
                <div class="hero-divider" id="heroDivider">
                    <span class="divider-line"></span>
                    <span class="divider-star">✦</span>
                    <span class="divider-line"></span>
                </div>

                <!-- Subtitle -->
                <p class="hero-subtitle" id="heroSubtitle">
                    رحلةٌ معرفيّة تأخذك في رحابِ العلوم الشرعية والقرآنية،
                    <br class="hidden sm:block">
                    لتُنير بصيرتك وتُزكّي نفسك بنورِ الوحي
                </p>

                <!-- CTA Buttons -->
<div class="hero-buttons" id="heroButtons">
    <a href="/register"
       id="heroStartBtn"
       class="btn-primary" role="button">
        <span class="btn-text">ابدأ رحلتك</span>
        <span class="btn-icon" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 18l-6-6 6-6"/>
            </svg>
        </span>
        <span class="btn-glow" aria-hidden="true"></span>
    </a>
<a href="https://web.facebook.com/judax2/" 
   target="_blank"
   rel="noopener noreferrer"
   class="btn-secondary" 
   role="button">
    <span class="btn-text">تواصل معنا</span>
    <span class="btn-icon" aria-hidden="true">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
    </span>
</a>

</div>

                <!-- Scroll Indicator -->
                <div class="scroll-indicator" id="scrollIndicator" aria-hidden="true">
                    <div class="scroll-mouse">
                        <div class="scroll-wheel"></div>
                    </div>
                    <span class="scroll-text">اكتشف المزيد</span>
                </div>

            </div>
        </div>

    </section>

</section>


     <!-- ===== PROGRAMS SECTION ===== -->
<section id="programs-section">

    <!--=========== قسم البرامج التعليمية =============-->
    <section id="programs" class="programs-section">

        <div class="programs-bg" aria-hidden="true">
            <div class="programs-bg__circle programs-bg__circle--1"></div>
            <div class="programs-bg__circle programs-bg__circle--2"></div>
            <div class="programs-bg__circle programs-bg__circle--3"></div>
            <div class="programs-bg__pattern"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <!-- ========== عنوان القسم ========== -->
            <div class="section-header" data-animate="fade-up">
                <span class="section-header__badge">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-3.486 1.494 2.698 1.159a1 1 0 00.788 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/>
                    </svg>
                    البرامج التعليمية
                </span>
                <h2 class="section-header__title">
                    اكتشف برامجنا
                    <span class="section-header__title-accent">في تعليم القرآن</span>
                </h2>
                <p class="section-header__desc">
                    برامج متنوعة صُمّمت بإتقان لتناسب جميع الأعمار والمستويات،
                    بإشراف نخبة من الشيوخ والمعلمين المُجازين
                </p>
                <div class="section-header__line" aria-hidden="true">
                    <span></span>
                    <svg class="w-5 h-5 text-programs-beige-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L13.09 8.26L18 6L14.74 10.91L21 12L14.74 13.09L18 18L13.09 15.74L12 22L10.91 15.74L6 18L9.26 13.09L3 12L9.26 10.91L6 6L10.91 8.26L12 2Z"/>
                    </svg>
                    <span></span>
                </div>
            </div>

            <!-- ========== فلتر التصنيفات ========== -->
            <div class="filter-bar" data-animate="fade-up">
                <button class="filter-bar__btn filter-bar__btn--active" data-filter="all">الكل</button>
                <button class="filter-bar__btn" data-filter="quran">القرآن الكريم</button>
                <button class="filter-bar__btn" data-filter="tajweed">التجويد</button>
                <button class="filter-bar__btn" data-filter="kids">الأطفال</button>
                <button class="filter-bar__btn" data-filter="islamic">العلوم الشرعية</button>
            </div>

            <!-- ========== شبكة الكروت ========== -->
            <div id="programsGrid" class="programs-grid">

            </div>

        </div>
    </section>

</section>


<!-- ===== TEACHERS SECTION ===== -->
<section id="teachers-section">

    <!-- ====== قسم المعلمين ====== -->
    <section id="teachers" class="teachers-section py-20 px-4">
        <div class="container mx-auto max-w-7xl">

            <!-- العنوان الرئيسي للقسم -->
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="inline-block text-teachers-accent font-amiri text-2xl mb-3">﴿ وَعَلَّمَكَ مَا لَمْ تَكُنْ تَعْلَمُ ﴾</span>
                <h2 class="text-4xl md:text-5xl font-bold text-teachers-primary mb-4">
                    معلمونا الكرام
                </h2>
                <div class="title-divider mx-auto"></div>
                <p class="text-gray-600 mt-6 max-w-2xl mx-auto leading-relaxed">
                    نخبة من خيرة المشايخ والمعلمين المُجازين بأعلى الأسانيد لتعليم كتاب الله بإتقان
                </p>
            </div>

            <!-- شبكة كروت المعلمين -->
            <div id="teachersGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            </div>

        </div>
    </section>

</section>


      <!-- ===== PACKAGES SECTION ===== -->
<section id="packages-section">

    <!-- ===== Particles Canvas ===== -->
    <canvas id="particlesCanvas" class="fixed inset-0 pointer-events-none z-0"></canvas>

    <!-- ===== Ambient Light ===== -->
    <div id="lightBeam" class="fixed inset-0 pointer-events-none z-0"></div>

    <!-- ===== Pricing Section ===== -->
    <section id="pricing" class="relative z-10 min-h-screen py-20 px-4 sm:px-6 lg:px-8">

        <!-- Decorative Top Background Shapes -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-packages-sage-200/30 blur-3xl"></div>
            <div class="absolute -top-20 -left-20 w-[400px] h-[400px] rounded-full bg-packages-gold-200/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] rounded-full bg-packages-sage-100/40 blur-3xl"></div>
        </div>

        <!-- Section Header -->
        <div class="text-center mb-20 relative z-10">
            <!-- Decorative Top Element -->
            <div class="flex items-center justify-center mb-6">
                <div class="h-px w-16 bg-gradient-to-r from-transparent to-packages-gold-400/50"></div>
                <div class="mx-4 relative">
                    <svg class="w-8 h-8 text-packages-gold-400 animate-pulse-slow" viewBox="0 0 24 24" fill="currentColor" opacity="0.8">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                    </svg>
                </div>
                <div class="h-px w-16 bg-gradient-to-l from-transparent to-packages-gold-400/50"></div>
            </div>

            <p class="text-packages-gold-600 text-sm tracking-[0.3em] uppercase mb-4 font-medium">
                اختر ما يناسبك
            </p>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-black mb-6 leading-tight">
                <span class="bg-gradient-to-r from-packages-sage-700 via-packages-sage-600 to-packages-sage-700 bg-clip-text text-transparent">
                    باقات مشكاة
                </span>
            </h2>
            <p class="text-packages-warm-500 text-lg max-w-2xl mx-auto leading-relaxed">
                رحلتك مع القرآن الكريم تبدأ من هنا، اختر الباقة التي تناسب احتياجك
                <br>
                <span class="text-packages-warm-400 text-base">وابدأ رحلة التعلّم والإتقان</span>
            </p>

            <!-- Decorative Bottom Line -->
            <div class="mt-8 flex items-center justify-center gap-2">
                <div class="h-1 w-8 rounded-full bg-packages-gold-400/30"></div>
                <div class="h-1 w-16 rounded-full bg-packages-gold-400/60"></div>
                <div class="h-1 w-8 rounded-full bg-packages-gold-400/30"></div>
            </div>
        </div>

        <!-- Pricing Cards Grid -->
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-6 items-start relative z-10">

            <!-- ========== Card 1: الباقة التأسيسية ========== -->
            <div class="pricing-card group relative" data-aos="fade-up" data-delay="0">
                <div class="card-inner relative bg-white/70 backdrop-blur-xl rounded-3xl border border-packages-sage-200/60 p-8 pt-10 transition-all duration-700 ease-out hover:border-packages-sage-300/80 hover:bg-white/90 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-packages-sage-200/30">
                    
                    <!-- Card Glow -->
                    <div class="card-glow absolute inset-0 rounded-3xl opacity-0 transition-opacity duration-700"></div>

                    <!-- Subtle Islamic Pattern -->
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-[0.04]">
                        <svg viewBox="0 0 100 100" fill="currentColor" class="text-packages-sage-600">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="50" cy="50" r="35" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="50" cy="50" r="25" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <path d="M50 5 L50 95 M5 50 L95 50 M18 18 L82 82 M82 18 L18 82" stroke="currentColor" stroke-width="0.3"/>
                        </svg>
                    </div>

                                       <!-- Header -->
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-11 h-11 rounded-2xl bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-packages-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="text-xs text-packages-sage-600 bg-packages-sage-50 border border-packages-sage-200/50 px-3 py-1 rounded-full font-medium">للمبتدئين</span>
                        </div>
                        <h3 class="text-2xl font-bold text-packages-warm-800 mt-4 mb-1">الباقة التأسيسية</h3>
                        <p class="text-packages-warm-400 text-sm mb-6">للراغبين في بدء رحلة التعلّم</p>
                    </div>

                    <!-- Price -->
                    <div class="relative z-10 mb-8">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-packages-warm-800">300</span>
                            <div class="flex flex-col">
                                <span class="text-packages-warm-500 text-sm font-medium">جنيه</span>
                                <span class="text-packages-warm-400 text-xs">شهرياً</span>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="relative z-10 h-px bg-gradient-to-r from-transparent via-packages-sage-200/70 to-transparent mb-8"></div>

                    <!-- Features -->
                    <ul class="relative z-10 space-y-4 mb-10">
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">4 حصص شهرية (حصة أسبوعياً)</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">تعليم أحكام التجويد الأساسية</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">تصحيح التلاوة مع معلم متخصص</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">تقرير شهري عن مستوى التقدم</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">الوصول لمكتبة التسجيلات</span>
                        </li>
                    </ul>

                    <!-- CTA Button -->
                   <div class="relative z-10">
    <button id="packageBtn1"
            class="btn-basic w-full py-4 px-6 rounded-2xl font-bold text-sm transition-all duration-500 bg-packages-sage-50 border border-packages-sage-200 text-packages-sage-700 hover:bg-packages-sage-100 hover:border-packages-sage-300 hover:shadow-lg hover:shadow-packages-sage-100/50 active:scale-[0.98] relative overflow-hidden">
        ابدأ رحلتك الآن
    </button>
</div>
                </div>
            </div>


                        <!-- ========== Card 2: الباقة المميزة (Featured) ========== -->
            <div class="pricing-card featured group relative lg:-mt-6" data-aos="fade-up" data-delay="150">
                
                <!-- Popular Badge -->
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-30">
                    <div class="relative">
                        <div class="absolute inset-0 bg-packages-gold-400 rounded-full blur-lg opacity-25 animate-pulse-slow"></div>
                        <div class="relative bg-gradient-to-r from-packages-gold-500 via-packages-gold-400 to-packages-gold-500 text-white px-6 py-1.5 rounded-full text-xs font-bold tracking-wider flex items-center gap-1.5 shadow-lg shadow-packages-gold-400/20">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                            الأكثر طلباً
                        </div>
                    </div>
                </div>

                <div class="card-inner featured-inner relative bg-white/80 backdrop-blur-xl rounded-3xl border border-packages-gold-300/50 p-8 pt-12 transition-all duration-700 ease-out hover:border-packages-gold-400/70 hover:bg-white/95 overflow-hidden shadow-lg shadow-packages-gold-200/20 hover:shadow-2xl hover:shadow-packages-gold-300/25">
                    
                    <!-- Featured Card Glow -->
                    <div class="card-glow featured-glow absolute inset-0 rounded-3xl opacity-0 transition-opacity duration-700"></div>

                    <!-- Gold Corner Accents -->
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-[0.06]">
                        <svg viewBox="0 0 100 100" fill="none">
                            <path d="M100 0 L100 100 L0 0 Z" fill="url(#goldCorner1)"/>
                            <defs>
                                <linearGradient id="goldCorner1" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#c49225"/>
                                    <stop offset="100%" style="stop-color:transparent"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 opacity-[0.06] rotate-180">
                        <svg viewBox="0 0 100 100" fill="none">
                            <path d="M100 0 L100 100 L0 0 Z" fill="url(#goldCorner2)"/>
                            <defs>
                                <linearGradient id="goldCorner2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#c49225"/>
                                    <stop offset="100%" style="stop-color:transparent"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>

                                        <!-- Islamic Pattern -->
                    <div class="absolute top-0 right-0 w-40 h-40 opacity-[0.03]">
                        <svg viewBox="0 0 100 100" fill="currentColor" class="text-packages-gold-600">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="50" cy="50" r="35" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="50" cy="50" r="25" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="50" cy="50" r="15" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <path d="M50 5 L50 95 M5 50 L95 50 M18 18 L82 82 M82 18 L18 82" stroke="currentColor" stroke-width="0.3"/>
                        </svg>
                    </div>

                    <!-- Header -->
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-11 h-11 rounded-2xl bg-packages-gold-100/80 border border-packages-gold-200/60 flex items-center justify-center">
                                <svg class="w-5 h-5 text-packages-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                            <span class="text-xs text-packages-gold-600 bg-packages-gold-50 border border-packages-gold-200/50 px-3 py-1 rounded-full font-medium">الأفضل قيمة</span>
                        </div>
                        <h3 class="text-2xl font-bold text-packages-warm-800 mt-4 mb-1">الباقة المميزة</h3>
                        <p class="text-packages-warm-400 text-sm mb-6">للجادّين في حفظ وإتقان القرآن</p>
                    </div>

                    <!-- Price -->
                    <div class="relative z-10 mb-8">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black bg-gradient-to-r from-packages-gold-600 via-packages-gold-500 to-packages-gold-600 bg-clip-text text-transparent">500</span>
                            <div class="flex flex-col">
                                <span class="text-packages-gold-600 text-sm font-medium">جنيه</span>
                                <span class="text-packages-warm-400 text-xs">شهرياً</span>
                            </div>
                        </div>
                        <div class="mt-3 inline-flex items-center gap-1.5 bg-packages-sage-50 border border-packages-sage-200/50 px-3 py-1.5 rounded-full">
                            <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-packages-sage-600 text-[11px] font-medium">وفّر 25% مقارنة بالحصص المنفردة</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="relative z-10 h-px bg-gradient-to-r from-transparent via-packages-gold-300/40 to-transparent mb-8"></div>

                    <!-- Features -->
                    <ul class="relative z-10 space-y-4 mb-10">
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-gold-100/80 border border-packages-gold-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-gold-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">8 حصص شهرية (حصتان أسبوعياً)</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-gold-100/80 border border-packages-gold-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-gold-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">برنامج حفظ مخصص مع خطة متابعة</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-gold-100/80 border border-packages-gold-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-gold-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">تجويد متقدم وتحسين الأداء</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-gold-100/80 border border-packages-gold-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-gold-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">اختبارات دورية وشهادة إتمام</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-gold-100/80 border border-packages-gold-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-gold-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">تسجيلات الحصص للمراجعة</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-gold-100/80 border border-packages-gold-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-gold-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">دعم عبر واتساب مع المعلم</span>
                        </li>
                    </ul>

                                        <!-- CTA Button -->
                    <div class="relative z-10">
    <a href="/register" id="packageBtn2"
            class="btn-featured block text-center w-full py-4 px-6 rounded-2xl font-bold text-sm transition-all duration-500 relative overflow-hidden group/btn">
        <div class="absolute inset-0 bg-gradient-to-r from-packages-gold-500 via-packages-gold-400 to-packages-gold-500 transition-all duration-500"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-packages-gold-400 via-packages-gold-300 to-packages-gold-400 opacity-0 group-hover/btn:opacity-100 transition-opacity duration-500"></div>
        <div class="btn-shine absolute inset-0"></div>
        <span class="relative z-10 text-white flex items-center justify-center gap-2 drop-shadow-sm">
            <span>اشترك الآن</span>
            <svg class="w-4 h-4 transition-transform duration-300 group-hover/btn:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
        </span>
    </a>
</div>
                </div>
            </div>

            <!-- ========== Card 3: الباقة الشاملة ========== -->
            <div class="pricing-card group relative" data-aos="fade-up" data-delay="300">
                <div class="card-inner relative bg-white/70 backdrop-blur-xl rounded-3xl border border-packages-sage-200/60 p-8 pt-10 transition-all duration-700 ease-out hover:border-packages-sage-300/80 hover:bg-white/90 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-packages-sage-200/30">
                    
                    <!-- Card Glow -->
                    <div class="card-glow absolute inset-0 rounded-3xl opacity-0 transition-opacity duration-700"></div>

                    <!-- Subtle Islamic Pattern -->
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-[0.04]">
                        <svg viewBox="0 0 100 100" fill="currentColor" class="text-packages-sage-600">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="50" cy="50" r="35" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <circle cx="50" cy="50" r="25" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            <path d="M50 5 L50 95 M5 50 L95 50 M18 18 L82 82 M82 18 L18 82" stroke="currentColor" stroke-width="0.3"/>
                        </svg>
                    </div>

                    <!-- Header -->
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-11 h-11 rounded-2xl bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-packages-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <span class="text-xs text-packages-sage-600 bg-packages-sage-50 border border-packages-sage-200/50 px-3 py-1 rounded-full font-medium">للمتقدمين</span>
                        </div>
                        <h3 class="text-2xl font-bold text-packages-warm-800 mt-4 mb-1">الباقة الشاملة</h3>
                        <p class="text-packages-warm-400 text-sm mb-6">لمن يريد التميّز والإتقان الكامل</p>
                    </div>

                    <!-- Price -->
                    <div class="relative z-10 mb-8">
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-packages-warm-800">1000</span>
                            <div class="flex flex-col">
                                <span class="text-packages-warm-500 text-sm font-medium">جنيه</span>
                                <span class="text-packages-warm-400 text-xs">شهرياً</span>
                            </div>
                        </div>
                    </div>


                                        <!-- Divider -->
                    <div class="relative z-10 h-px bg-gradient-to-r from-transparent via-packages-sage-200/70 to-transparent mb-8"></div>

                    <!-- Features -->
                    <ul class="relative z-10 space-y-4 mb-10">
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">12 حصة شهرية (3 حصص أسبوعياً)</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">حفظ مكثف مع مراجعة يومية</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">إجازة في التلاوة برواية حفص</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">جلسات فردية مع شيخ متخصص</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">شهادة معتمدة عند إتمام الحفظ</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">أولوية الدعم وجدولة المواعيد</span>
                        </li>
                        <li class="flex items-start gap-3 feature-item">
                            <div class="w-5 h-5 rounded-full bg-packages-sage-100 border border-packages-sage-200/50 flex items-center justify-center mt-0.5 flex-shrink-0">
                                <svg class="w-3 h-3 text-packages-sage-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-packages-warm-600 text-sm leading-relaxed">جميع مميزات الباقة المميزة</span>
                        </li>
                    </ul>

                    <!-- CTA Button -->
                    <div class="relative z-10">
    <button id="packageBtn3"
            class="btn-basic w-full py-4 px-6 rounded-2xl font-bold text-sm transition-all duration-500 bg-packages-sage-50 border border-packages-sage-200 text-packages-sage-700 hover:bg-packages-sage-100 hover:border-packages-sage-300 hover:shadow-lg hover:shadow-packages-sage-100/50 active:scale-[0.98] relative overflow-hidden">
        انضم للباقة الشاملة
    </button>
</div>
                </div>
            </div>

        </div>

        <!-- Bottom Guarantee Note -->
        <div class="max-w-2xl mx-auto mt-16 text-center relative z-10">
            <div class="bg-white/60 backdrop-blur-sm border border-packages-sage-200/40 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-packages-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="text-packages-gold-600 text-sm font-bold">ضمان الجودة</span>
                </div>
                <p class="text-packages-warm-500 text-sm leading-relaxed">
                    جميع المعلمين حاصلون على إجازات في القراءات. يمكنك تجربة حصة مجانية قبل الاشتراك.
                    <br>
                    <span class="text-packages-warm-400">إمكانية استرداد المبلغ خلال أول 7 أيام.</span>
                </p>
            </div>
        </div>

    </section>



   <!-- Study Section -->
<section id="study-section" class="relative z-10 py-20 md:py-32 px-4">

    <!-- Particles Container (Section-specific) -->
    <div id="study-particles-container" class="absolute inset-0 pointer-events-none z-0" aria-hidden="true"></div>

    <div class="max-w-6xl mx-auto relative z-10">

        <!-- Section Header -->
        <div class="text-center mb-20 md:mb-28">
            <div class="inline-flex items-center justify-center gap-3 mb-6 section-header" data-animate="fade-down">
                <span class="block w-12 h-[2px] bg-study-gold-400 rounded-full"></span>
                <span class="text-study-gold-600 text-sm font-bold tracking-widest uppercase">رحلة التعلم</span>
                <span class="block w-12 h-[2px] bg-study-gold-400 rounded-full"></span>
            </div>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-black text-study-primary-800 mb-6 leading-tight" data-animate="fade-up">
                نظام الدراسة في
                <span class="relative inline-block">
                    <span class="relative z-10 text-study-primary-600">مشكاة</span>
                    <span class="absolute bottom-1 right-0 left-0 h-3 bg-study-gold-200/60 rounded-full -z-0"></span>
                </span>
            </h2>
            <p class="text-lg md:text-xl text-study-primary-700/70 max-w-2xl mx-auto leading-relaxed" data-animate="fade-up" data-delay="200">
                منهج متكامل ومدروس يأخذ بيدك خطوة بخطوة في رحلة حفظ القرآن الكريم وإتقان تلاوته بأحكام التجويد
            </p>
        </div>

        <!-- Timeline Container -->
        <div class="relative" id="timeline-wrapper">

            <!-- Animated Line (Center on desktop, Right on mobile) -->
            <div class="timeline-line-track absolute top-0 bottom-0 right-8 md:right-auto md:left-1/2 md:-translate-x-1/2 w-[3px]">
                <div class="timeline-line-glow absolute inset-0 w-full rounded-full bg-study-primary-100"></div>
                <div id="timeline-progress" class="absolute top-0 w-full rounded-full bg-gradient-to-b from-study-primary-400 via-study-primary-500 to-study-gold-500 transition-all duration-100 ease-out" style="height: 0%;"></div>
                <!-- Moving light orb -->
                <div id="timeline-orb" class="absolute w-5 h-5 -right-[9px] rounded-full bg-study-gold-400 shadow-lg shadow-study-gold-400/50 opacity-0 transition-all duration-100 ease-out" style="top: 0%;">
                    <div class="absolute inset-0 rounded-full bg-study-gold-300 animate-ping opacity-40"></div>
                </div>
            </div>

            <!-- Steps -->
            <div class="relative space-y-16 md:space-y-24" id="steps-container">

                <!-- Step 1 -->
                <div class="step-item relative flex items-start gap-6 md:gap-0" data-step="1">
                    <!-- Dot -->
                    <div class="step-dot absolute right-[22px] md:right-auto md:left-1/2 md:-translate-x-1/2 top-2 z-20">
                        <div class="relative">
                            <div class="w-[42px] h-[42px] rounded-full bg-study-cream-50 border-[3px] border-study-primary-200 flex items-center justify-center transition-all duration-700 step-dot-inner">
                                <span class="step-number text-sm font-black text-study-primary-300 transition-all duration-700">١</span>
                            </div>
                            <div class="step-dot-ring absolute -inset-2 rounded-full border-2 border-study-primary-200/0 transition-all duration-700"></div>
                        </div>
                    </div>

                    <!-- Content Card (Right side on desktop for odd steps) -->
                    <div class="step-content mr-20 md:mr-0 md:w-[calc(50%-40px)] md:ml-auto md:pl-0 md:pr-0">
                        <div class="step-card group relative bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-study-primary-100/50 hover:shadow-xl hover:shadow-study-primary-100/30 transition-all duration-700 cursor-default overflow-hidden">
                            <!-- Card glow -->
                            <div class="absolute inset-0 bg-gradient-to-br from-study-primary-50/0 to-study-gold-50/0 group-hover:from-study-primary-50/50 group-hover:to-study-gold-50/30 transition-all duration-700 rounded-3xl"></div>

                            <div class="relative z-10">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="step-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-study-primary-50 to-study-primary-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-7 h-7 text-study-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-study-gold-600 bg-study-gold-50 px-3 py-1 rounded-full">الخطوة الأولى</span>
                                        <h3 class="text-xl font-bold text-study-primary-800 mt-2">التسجيل وتحديد المستوى</h3>
                                    </div>
                                </div>
                                <p class="text-study-primary-700/70 leading-relaxed text-[15px]">
                                    أنشئ حسابك في منصة مشكاة، ثم أجرِ اختبار تحديد المستوى لمعرفة مقدار حفظك الحالي ومستوى تلاوتك، ليتم توجيهك للمسار الأنسب لك في رحلتك القرآنية.
                                </p>
                                <div class="flex flex-wrap gap-2 mt-4">
                                    <span class="text-xs bg-study-primary-50 text-study-primary-600 px-3 py-1.5 rounded-full font-medium">اختبار مستوى</span>
                                    <span class="text-xs bg-study-primary-50 text-study-primary-600 px-3 py-1.5 rounded-full font-medium">مسار مخصص</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                   <!-- Step 2 -->
                <div class="step-item relative flex items-start gap-6 md:gap-0" data-step="2">
                    <div class="step-dot absolute right-[22px] md:right-auto md:left-1/2 md:-translate-x-1/2 top-2 z-20">
                        <div class="relative">
                            <div class="w-[42px] h-[42px] rounded-full bg-study-cream-50 border-[3px] border-study-primary-200 flex items-center justify-center transition-all duration-700 step-dot-inner">
                                <span class="step-number text-sm font-black text-study-primary-300 transition-all duration-700">٢</span>
                            </div>
                            <div class="step-dot-ring absolute -inset-2 rounded-full border-2 border-study-primary-200/0 transition-all duration-700"></div>
                        </div>
                    </div>

                    <!-- Content Card (Left side on desktop for even steps) -->
                    <div class="step-content mr-20 md:mr-0 md:w-[calc(50%-40px)]">
                        <div class="step-card group relative bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-study-primary-100/50 hover:shadow-xl hover:shadow-study-primary-100/30 transition-all duration-700 cursor-default overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-study-primary-50/0 to-study-gold-50/0 group-hover:from-study-primary-50/50 group-hover:to-study-gold-50/30 transition-all duration-700 rounded-3xl"></div>
                            <div class="relative z-10">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="step-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-study-gold-50 to-study-gold-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-7 h-7 text-study-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-study-gold-600 bg-study-gold-50 px-3 py-1 rounded-full">الخطوة الثانية</span>
                                        <h3 class="text-xl font-bold text-study-primary-800 mt-2">اختيار البرنامج الدراسي</h3>
                                    </div>
                                </div>
                                <p class="text-study-primary-700/70 leading-relaxed text-[15px]">
                                    اختر من بين برامجنا المتنوعة: برنامج الحفظ المتقن، برنامج التلاوة والتجويد، برنامج المراجعة والتثبيت، أو البرنامج الشامل الذي يجمع بينها جميعاً بمنهجية علمية مدروسة.
                                </p>
                                <div class="flex flex-wrap gap-2 mt-4">
                                    <span class="text-xs bg-study-gold-50 text-study-gold-700 px-3 py-1.5 rounded-full font-medium">حفظ متقن</span>
                                    <span class="text-xs bg-study-gold-50 text-study-gold-700 px-3 py-1.5 rounded-full font-medium">تجويد</span>
                                    <span class="text-xs bg-study-gold-50 text-study-gold-700 px-3 py-1.5 rounded-full font-medium">مراجعة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-item relative flex items-start gap-6 md:gap-0" data-step="3">
                    <div class="step-dot absolute right-[22px] md:right-auto md:left-1/2 md:-translate-x-1/2 top-2 z-20">
                        <div class="relative">
                            <div class="w-[42px] h-[42px] rounded-full bg-study-cream-50 border-[3px] border-study-primary-200 flex items-center justify-center transition-all duration-700 step-dot-inner">
                                <span class="step-number text-sm font-black text-study-primary-300 transition-all duration-700">٣</span>
                            </div>
                            <div class="step-dot-ring absolute -inset-2 rounded-full border-2 border-study-primary-200/0 transition-all duration-700"></div>
                        </div>
                    </div>

                    <div class="step-content mr-20 md:mr-0 md:w-[calc(50%-40px)] md:ml-auto">
                        <div class="step-card group relative bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-study-primary-100/50 hover:shadow-xl hover:shadow-study-primary-100/30 transition-all duration-700 cursor-default overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-study-primary-50/0 to-study-gold-50/0 group-hover:from-study-primary-50/50 group-hover:to-study-gold-50/30 transition-all duration-700 rounded-3xl"></div>
                            <div class="relative z-10">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="step-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-study-primary-50 to-study-primary-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-7 h-7 text-study-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-study-gold-600 bg-study-gold-50 px-3 py-1 rounded-full">الخطوة الثالثة</span>
                                        <h3 class="text-xl font-bold text-study-primary-800 mt-2">التعلم مع المعلم المتخصص</h3>
                                    </div>
                                </div>
                                <p class="text-study-primary-700/70 leading-relaxed text-[15px]">
                                    ابدأ حلقاتك مع معلم مجاز بالسند المتصل إلى النبي ﷺ. حصص مباشرة فردية أو جماعية مصغرة، مع تصحيح التلاوة والتلقين المباشر، وتطبيق عملي لأحكام التجويد.
                                </p>
                                <div class="flex flex-wrap gap-2 mt-4">
                                    <span class="text-xs bg-study-primary-50 text-study-primary-600 px-3 py-1.5 rounded-full font-medium">معلم مجاز</span>
                                    <span class="text-xs bg-study-primary-50 text-study-primary-600 px-3 py-1.5 rounded-full font-medium">حصص مباشرة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                   <!-- Step 4 -->
                <div class="step-item relative flex items-start gap-6 md:gap-0" data-step="4">
                    <div class="step-dot absolute right-[22px] md:right-auto md:left-1/2 md:-translate-x-1/2 top-2 z-20">
                        <div class="relative">
                            <div class="w-[42px] h-[42px] rounded-full bg-study-cream-50 border-[3px] border-study-primary-200 flex items-center justify-center transition-all duration-700 step-dot-inner">
                                <span class="step-number text-sm font-black text-study-primary-300 transition-all duration-700">٤</span>
                            </div>
                            <div class="step-dot-ring absolute -inset-2 rounded-full border-2 border-study-primary-200/0 transition-all duration-700"></div>
                        </div>
                    </div>

                    <div class="step-content mr-20 md:mr-0 md:w-[calc(50%-40px)]">
                        <div class="step-card group relative bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-study-primary-100/50 hover:shadow-xl hover:shadow-study-primary-100/30 transition-all duration-700 cursor-default overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-study-primary-50/0 to-study-gold-50/0 group-hover:from-study-primary-50/50 group-hover:to-study-gold-50/30 transition-all duration-700 rounded-3xl"></div>
                            <div class="relative z-10">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="step-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-study-gold-50 to-study-gold-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-7 h-7 text-study-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182M2.985 19.644l3.181-3.183"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-study-gold-600 bg-study-gold-50 px-3 py-1 rounded-full">الخطوة الرابعة</span>
                                        <h3 class="text-xl font-bold text-study-primary-800 mt-2">المراجعة والتثبيت اليومي</h3>
                                    </div>
                                </div>
                                <p class="text-study-primary-700/70 leading-relaxed text-[15px]">
                                    نظام مراجعة ذكي يضمن تثبيت ما حفظته. جدول مراجعة مُعدّ وفق منهج التكرار المتباعد، مع متابعة دورية من المعلم لضمان عدم نسيان ما تم حفظه والبناء على أساس متين.
                                </p>
                                <div class="flex flex-wrap gap-2 mt-4">
                                    <span class="text-xs bg-study-gold-50 text-study-gold-700 px-3 py-1.5 rounded-full font-medium">تكرار متباعد</span>
                                    <span class="text-xs bg-study-gold-50 text-study-gold-700 px-3 py-1.5 rounded-full font-medium">متابعة مستمرة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="step-item relative flex items-start gap-6 md:gap-0" data-step="5">
                    <div class="step-dot absolute right-[22px] md:right-auto md:left-1/2 md:-translate-x-1/2 top-2 z-20">
                        <div class="relative">
                            <div class="w-[42px] h-[42px] rounded-full bg-study-cream-50 border-[3px] border-study-primary-200 flex items-center justify-center transition-all duration-700 step-dot-inner">
                                <span class="step-number text-sm font-black text-study-primary-300 transition-all duration-700">٥</span>
                            </div>
                            <div class="step-dot-ring absolute -inset-2 rounded-full border-2 border-study-primary-200/0 transition-all duration-700"></div>
                        </div>
                    </div>

                    <div class="step-content mr-20 md:mr-0 md:w-[calc(50%-40px)] md:ml-auto">
                        <div class="step-card group relative bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-study-primary-100/50 hover:shadow-xl hover:shadow-study-primary-100/30 transition-all duration-700 cursor-default overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-study-primary-50/0 to-study-gold-50/0 group-hover:from-study-primary-50/50 group-hover:to-study-gold-50/30 transition-all duration-700 rounded-3xl"></div>
                            <div class="relative z-10">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="step-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-study-primary-50 to-study-primary-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-7 h-7 text-study-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-study-gold-600 bg-study-gold-50 px-3 py-1 rounded-full">الخطوة الخامسة</span>
                                        <h3 class="text-xl font-bold text-study-primary-800 mt-2">التقييم وتتبع التقدم</h3>
                                    </div>
                                </div>
                                <p class="text-study-primary-700/70 leading-relaxed text-[15px]">
                                    اختبارات دورية لقياس مستوى الحفظ والإتقان، مع لوحة تحكم شخصية تعرض تقدمك بشكل مرئي وواضح. تقارير أسبوعية وشهرية تُرسل لك توضح إنجازاتك ونقاط التحسين.
                                </p>
                                <div class="flex flex-wrap gap-2 mt-4">
                                    <span class="text-xs bg-study-primary-50 text-study-primary-600 px-3 py-1.5 rounded-full font-medium">اختبارات دورية</span>
                                    <span class="text-xs bg-study-primary-50 text-study-primary-600 px-3 py-1.5 rounded-full font-medium">تقارير مفصلة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                                    <!-- Step 6 -->
                <div class="step-item relative flex items-start gap-6 md:gap-0" data-step="6">
                    <div class="step-dot absolute right-[22px] md:right-auto md:left-1/2 md:-translate-x-1/2 top-2 z-20">
                        <div class="relative">
                            <div class="w-[42px] h-[42px] rounded-full bg-study-cream-50 border-[3px] border-study-primary-200 flex items-center justify-center transition-all duration-700 step-dot-inner">
                                <span class="step-number text-sm font-black text-study-primary-300 transition-all duration-700">٦</span>
                            </div>
                            <div class="step-dot-ring absolute -inset-2 rounded-full border-2 border-study-primary-200/0 transition-all duration-700"></div>
                        </div>
                    </div>

                    <div class="step-content mr-20 md:mr-0 md:w-[calc(50%-40px)]">
                        <div class="step-card group relative bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-sm border border-study-primary-100/50 hover:shadow-xl hover:shadow-study-primary-100/30 transition-all duration-700 cursor-default overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-study-primary-50/0 to-study-gold-50/0 group-hover:from-study-primary-50/50 group-hover:to-study-gold-50/30 transition-all duration-700 rounded-3xl"></div>
                            <div class="relative z-10">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="step-icon w-14 h-14 rounded-2xl bg-gradient-to-br from-study-gold-50 to-study-gold-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-500">
                                        <svg class="w-7 h-7 text-study-gold-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.562.562 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.562.562 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-study-gold-600 bg-study-gold-50 px-3 py-1 rounded-full">الخطوة السادسة</span>
                                        <h3 class="text-xl font-bold text-study-primary-800 mt-2">الإجازة والتخرج</h3>
                                    </div>
                                </div>
                                <p class="text-study-primary-700/70 leading-relaxed text-[15px]">
                                    عند إتمام حفظ القرآن الكريم كاملاً وإتقان أحكام التجويد، تحصل على إجازة بالسند المتصل وشهادة إتمام معتمدة من المنصة. لتكون بداية مسيرتك في نشر كتاب الله وتعليمه للآخرين.
                                </p>
                                <div class="flex flex-wrap gap-2 mt-4">
                                    <span class="text-xs bg-study-gold-50 text-study-gold-700 px-3 py-1.5 rounded-full font-medium">إجازة بالسند</span>
                                    <span class="text-xs bg-study-gold-50 text-study-gold-700 px-3 py-1.5 rounded-full font-medium">شهادة معتمدة</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="text-center mt-20 md:mt-28" data-animate="fade-up">
            <div class="inline-flex flex-col items-center gap-6">
               <div id="studyStartBtn" class="flex items-center gap-2 text-study-primary-600/50 cursor-pointer">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
    </svg>
    <span class="text-sm font-medium">ابدأ رحلتك الآن</span>
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.455 2.456L21.75 6l-1.036.259a3.375 3.375 0 00-2.455 2.456z"/>
    </svg>
</div>

                <a href="/register" class="cta-button group relative inline-flex items-center gap-3 bg-gradient-to-l from-study-primary-600 to-study-primary-700 text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-xl shadow-study-primary-600/20 hover:shadow-2xl hover:shadow-study-primary-600/30 transition-all duration-500 hover:-translate-y-1 overflow-hidden">
                    <span class="absolute inset-0 bg-gradient-to-l from-study-primary-500 to-study-primary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                    <span class="relative z-10">سجّل في مشكاة</span>
                    <svg class="relative z-10 w-5 h-5 rotate-180 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <p class="text-study-primary-600/40 text-sm">مجاناً • بدون التزام • ابدأ في أي وقت</p>
            </div>
        </div>

    </div>

    <!-- Decorative Elements -->
    <div class="absolute top-20 right-10 w-72 h-72 bg-study-primary-200/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
    <div class="absolute bottom-20 left-10 w-96 h-96 bg-study-gold-200/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
    <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-study-primary-100/10 rounded-full blur-2xl pointer-events-none" aria-hidden="true"></div>
</section>

   <!-- FAQ Section -->
<section class="faq-section" id="faq-section">

    <!-- Particles Canvas (Section-specific) -->
    <canvas id="faq-particles-canvas"></canvas>

    <!-- Ambient Light Orbs -->
    <div class="ambient-orb ambient-orb-1"></div>
    <div class="ambient-orb ambient-orb-2"></div>
    <div class="ambient-orb ambient-orb-3"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Section Header -->
        <div class="section-header">
            <!-- Decorative Lantern Icon -->
            <div class="lantern-icon">
                <svg viewBox="0 0 80 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M38 8C38 8 40 2 42 8" stroke="url(#faq-goldGrad)" stroke-width="2" stroke-linecap="round"/>
                    <rect x="36" y="8" width="8" height="6" rx="1" fill="url(#faq-goldGrad)"/>
                    <path d="M20 40C20 24 30 14 40 14C50 14 60 24 60 40C60 56 50 66 40 70C30 66 20 56 20 40Z" fill="url(#faq-lanternGrad)" stroke="url(#faq-goldGrad)" stroke-width="1.5"/>
                    <path d="M28 40C28 30 33 22 40 22C47 22 52 30 52 40C52 50 47 58 40 62C33 58 28 50 28 40Z" fill="url(#faq-innerGlow)" opacity="0.6"/>
                    <ellipse cx="40" cy="38" rx="6" ry="8" fill="url(#faq-lightCore)" opacity="0.8"/>
                    <path d="M32 70L40 70L48 70" stroke="url(#faq-goldGrad)" stroke-width="2" stroke-linecap="round"/>
                    <path d="M34 74L40 76L46 74" stroke="url(#faq-goldGrad)" stroke-width="1.5" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="faq-goldGrad" x1="20" y1="0" x2="60" y2="80" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#d4a853"/>
                            <stop offset="1" stop-color="#b8860b"/>
                        </linearGradient>
                        <radialGradient id="faq-lanternGrad" cx="40" cy="40" r="26" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#1a4a3a" stop-opacity="0.3"/>
                            <stop offset="1" stop-color="#0d2e23" stop-opacity="0.6"/>
                        </radialGradient>
                        <radialGradient id="faq-innerGlow" cx="40" cy="38" r="16" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#e8d5a3" stop-opacity="0.4"/>
                            <stop offset="1" stop-color="#d4a853" stop-opacity="0.05"/>
                        </radialGradient>
                        <radialGradient id="faq-lightCore" cx="40" cy="36" r="8" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#fef3c7" stop-opacity="0.9"/>
                            <stop offset="1" stop-color="#d4a853" stop-opacity="0.1"/>
                        </radialGradient>
                    </defs>
                </svg>
                <div class="lantern-glow"></div>
            </div>

            <span class="section-badge">مركز المساعدة</span>
            <h2 class="section-title">الأسئلة الشائعة</h2>
            <p class="section-subtitle">
                نجيبك على كل ما يدور في ذهنك حول منصة
                <span class="brand-highlight">مشكاة</span>
                التعليمية
            </p>
            <div class="title-ornament">
                <span class="ornament-line"></span>
                <span class="ornament-diamond"></span>
                <span class="ornament-line"></span>
            </div>
        </div>

      
        <!-- Accordion Container -->
        <div class="accordion-container" id="accordionContainer">

            <!-- FAQ Item 1 -->
            <div class="accordion-item" data-category="general" data-index="0">
                <button class="accordion-trigger" aria-expanded="false">
                    <div class="trigger-content">
                        <span class="item-number">01</span>
                        <span class="item-question">ما هي منصة مشكاة التعليمية؟</span>
                    </div>
                    <div class="trigger-icon">
                        <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                </button>
                <div class="accordion-content">
                    <div class="content-inner">
                        <p>
                            منصة <strong>مشكاة</strong> هي منصة تعليمية إسلامية متكاملة تهدف إلى نشر العلم الشرعي
                            بأسلوب عصري ومُيسّر. تقدم المنصة دورات متنوعة في علوم القرآن الكريم، والحديث النبوي الشريف،
                            والفقه الإسلامي، والسيرة النبوية، واللغة العربية، وغيرها من العلوم الشرعية والإنسانية.
                        </p>
                        <div class="content-highlight">
                            <span class="highlight-icon">💡</span>
                            <span>اسم "مشكاة" مستوحى من قوله تعالى: ﴿مَثَلُ نُورِهِ كَمِشْكَاةٍ فِيهَا مِصْبَاحٌ﴾ — كرمز لنور العلم والهداية.</span>
                        </div>
                    </div>
                </div>
            </div>

                                <!-- FAQ Item 2 -->
                <div class="accordion-item" data-category="general" data-index="1">
                    <button class="accordion-trigger" aria-expanded="false">
                        <div class="trigger-content">
                            <span class="item-number">02</span>
                            <span class="item-question">من هم المعلمون والشيوخ في المنصة؟</span>
                        </div>
                        <div class="trigger-icon">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                    </button>
                    <div class="accordion-content">
                        <div class="content-inner">
                            <p>
                                تضم منصة مشكاة نخبة من العلماء والمشايخ المتخصصين في مختلف العلوم الشرعية،
                                حاصلين على إجازات علمية معتمدة ولديهم خبرة طويلة في التدريس والتعليم.
                            </p>
                            <ul class="content-list">
                                <li>شيوخ متخصصون في علوم القرآن والتجويد بأسانيد متصلة</li>
                                <li>أساتذة جامعيون في الفقه وأصوله من جامعات عريقة</li>
                                <li>محاضرون في الحديث النبوي ومصطلحه</li>
                                <li>معلمات متخصصات للأقسام النسائية</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="accordion-item" data-category="courses" data-index="2">
                    <button class="accordion-trigger" aria-expanded="false">
                        <div class="trigger-content">
                            <span class="item-number">03</span>
                            <span class="item-question">ما هي الدورات المتاحة على المنصة؟</span>
                        </div>
                        <div class="trigger-icon">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                    </button>
                    <div class="accordion-content">
                        <div class="content-inner">
                            <p>تقدم المنصة مجموعة واسعة من الدورات التعليمية المصنفة حسب المستوى والتخصص:</p>
                            <div class="courses-grid">
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    تحفيظ القرآن الكريم
                                </div>
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    أحكام التجويد
                                </div>
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    التفسير وعلومه
                                </div>
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    الحديث ومصطلحه
                                </div>
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    الفقه الإسلامي
                                </div>
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    العقيدة الإسلامية
                                </div>
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    السيرة النبوية
                                </div>
                                <div class="course-tag">
                                    <span class="tag-dot"></span>
                                    اللغة العربية وآدابها
                                </div>
                            </div>
                            <div class="content-highlight">
                                <span class="highlight-icon">📌</span>
                                <span>تتوفر دورات للمبتدئين والمتوسطين والمتقدمين، مع مسارات تعليمية متدرجة.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="accordion-item" data-category="courses" data-index="3">
                    <button class="accordion-trigger" aria-expanded="false">
                        <div class="trigger-content">
                            <span class="item-number">04</span>
                            <span class="item-question">هل تُمنح شهادات بعد إتمام الدورات؟</span>
                        </div>
                        <div class="trigger-icon">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                    </button>
                    <div class="accordion-content">
                        <div class="content-inner">
                            <p>
                                نعم، تمنح منصة مشكاة شهادات إتمام معتمدة لكل دورة يُكملها الطالب بنجاح.
                                تتضمن الشهادة اسم الدورة، واسم المعلم، وعدد الساعات، ورمز تحقق فريد.
                            </p>
                            <ul class="content-list">
                                <li>شهادة إلكترونية قابلة للتحميل والطباعة بتصميم أنيق</li>
                                <li>رمز QR للتحقق من صحة الشهادة</li>
                                <li>إمكانية مشاركتها على منصات التواصل الاجتماعي</li>
                                <li>شهادات خاصة لبرامج الإجازة في القرآن الكريم</li>
                            </ul>
                        </div>
                    </div>
                </div>

                               <!-- FAQ Item 5 -->
                <div class="accordion-item" data-category="technical" data-index="4">
                    <button class="accordion-trigger" aria-expanded="false">
                        <div class="trigger-content">
                            <span class="item-number">05</span>
                            <span class="item-question">كيف أسجل في المنصة وأبدأ التعلم؟</span>
                        </div>
                        <div class="trigger-icon">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                    </button>
                    <div class="accordion-content">
                        <div class="content-inner">
                            <p>التسجيل في منصة مشكاة سهل ويتم في خطوات بسيطة:</p>
                            <div class="steps-container">
                                <div class="step-item">
                                    <span class="step-number">١</span>
                                    <span>اضغط على زر "إنشاء حساب" في الصفحة الرئيسية</span>
                                </div>
                                <div class="step-item">
                                    <span class="step-number">٢</span>
                                    <span>أدخل بياناتك الأساسية (الاسم، البريد الإلكتروني، كلمة المرور)</span>
                                </div>
                                <div class="step-item">
                                    <span class="step-number">٣</span>
                                    <span>فعّل حسابك عبر رسالة التأكيد المرسلة لبريدك</span>
                                </div>
                                <div class="step-item">
                                    <span class="step-number">٤</span>
                                    <span>اختر المسار التعليمي المناسب وابدأ رحلتك!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="accordion-item" data-category="technical" data-index="5">
                    <button class="accordion-trigger" aria-expanded="false">
                        <div class="trigger-content">
                            <span class="item-number">06</span>
                            <span class="item-question">هل يمكنني التعلم من الهاتف المحمول؟</span>
                        </div>
                        <div class="trigger-icon">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                    </button>
                    <div class="accordion-content">
                        <div class="content-inner">
                            <p>
                                بالتأكيد! منصة مشكاة مصممة بتقنية متجاوبة تعمل بكفاءة على جميع الأجهزة.
                                كما يتوفر تطبيق مخصص للهواتف الذكية يوفر تجربة تعليمية متميزة.
                            </p>
                            <ul class="content-list">
                                <li>تطبيق مخصص لأجهزة Android و iOS</li>
                                <li>إمكانية تحميل الدروس للمشاهدة بدون إنترنت</li>
                                <li>إشعارات ذكية بمواعيد الدروس والحلقات المباشرة</li>
                                <li>مزامنة تلقائية للتقدم بين جميع أجهزتك</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 7 -->
                <div class="accordion-item" data-category="payment" data-index="6">
                    <button class="accordion-trigger" aria-expanded="false">
                        <div class="trigger-content">
                            <span class="item-number">07</span>
                            <span class="item-question">ما هي خطط الاشتراك المتاحة؟</span>
                        </div>
                        <div class="trigger-icon">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                    </button>
                    <div class="accordion-content">
                        <div class="content-inner">
                            <p>توفر منصة مشكاة عدة خطط اشتراك تناسب مختلف الاحتياجات:</p>
                            <div class="plans-grid">
                                <div class="plan-card plan-free">
                                    <h4>المجاني</h4>
                                    <p>وصول محدود للدروس التمهيدية والمحتوى المفتوح</p>
                                </div>
                                <div class="plan-card plan-monthly">
                                    <h4>الشهري</h4>
                                    <p>وصول كامل لجميع الدورات والمحتوى التفاعلي</p>
                                </div>
                                <div class="plan-card plan-yearly">
                                    <h4>السنوي</h4>
                                    <p>توفير 40% مع مزايا حصرية وجلسات خاصة</p>
                                    <span class="plan-badge">الأفضل قيمة</span>
                                </div>
                            </div>
                            <div class="content-highlight">
                                <span class="highlight-icon">🎁</span>
                                <span>نقدم منحًا مجانية لطلاب العلم غير القادرين — تواصل معنا عبر صفحة "المنح الدراسية".</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 8 -->
                <div class="accordion-item" data-category="payment" data-index="7">
                    <button class="accordion-trigger" aria-expanded="false">
                        <div class="trigger-content">
                            <span class="item-number">08</span>
                            <span class="item-question">ما هي طرق الدفع المتاحة؟</span>
                        </div>
                        <div class="trigger-icon">
                            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                    </button>
                    <div class="accordion-content">
                        <div class="content-inner">
                            <p>نوفر طرق دفع متعددة وآمنة لتسهيل عملية الاشتراك:</p>
                            <ul class="content-list">
                                <li>البطاقات البنكية (Visa / Mastercard / مدى)</li>
                                <li>Apple Pay و Google Pay</li>
                                <li>التحويل البنكي المباشر</li>
                                <li>المحافظ الإلكترونية (STC Pay / Paypal)</li>
                                <li>بطاقات الدفع المسبق</li>
                            </ul>
                            <div class="content-highlight">
                                <span class="highlight-icon">🔒</span>
                                <span>جميع المعاملات المالية مشفرة ومؤمنة بأعلى معايير الحماية (SSL 256-bit).</span>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- FAQ Item 9 -->
<div class="accordion-item" data-category="courses" data-index="8">
    <button class="accordion-trigger" aria-expanded="false">
        <div class="trigger-content">
            <span class="item-number">09</span>
            <span class="item-question">هل تتوفر حلقات تحفيظ قرآن مباشرة؟</span>
        </div>
        <div class="trigger-icon">
            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </div>
    </button>
    <div class="accordion-content">
        <div class="content-inner">
            <p>
                نعم، توفر مشكاة حلقات تحفيظ مباشرة يومية مع معلمين ومعلمات مجازين بأسانيد متصلة
                إلى النبي ﷺ. تُعقد الحلقات في أوقات مرنة تناسب مختلف المناطق الزمنية.
            </p>
            <ul class="content-list">
                <li>حلقات فردية (طالب واحد مع المعلم) لتركيز أعلى</li>
                <li>حلقات جماعية صغيرة (3-5 طلاب) لتشجيع التنافس</li>
                <li>برنامج مراجعة يومي منظم لتثبيت الحفظ</li>
                <li>تقارير أسبوعية مفصلة عن مستوى التقدم</li>
                <li>برنامج إجازة في القراءات العشر</li>
            </ul>
        </div>
    </div>
</div>

<!-- FAQ Item 10 -->
<div class="accordion-item" data-category="general" data-index="9">
    <button class="accordion-trigger" aria-expanded="false">
        <div class="trigger-content">
            <span class="item-number">10</span>
            <span class="item-question">كيف أتواصل مع فريق الدعم؟</span>
        </div>
        <div class="trigger-icon">
            <svg class="icon-plus" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </div>
    </button>
    <div class="accordion-content">
        <div class="content-inner">
            <p>فريق دعم مشكاة متاح لمساعدتك على مدار الساعة عبر عدة قنوات:</p>
            <ul class="content-list">
                <li>الدردشة المباشرة على المنصة (متاحة 24/7)</li>
                <li>البريد الإلكتروني: support@mishkat.edu</li>
                <li>واتساب: +201012345678</li>
                <li>نموذج التواصل في صفحة "اتصل بنا"</li>
            </ul>
            <div class="content-highlight">
                <span class="highlight-icon">⏱️</span>
                <span>متوسط وقت الرد: أقل من ساعة واحدة خلال أوقات العمل الرسمية.</span>
            </div>
        </div>
    </div>
</div>

            </div>

            <!-- Bottom CTA -->
            <div class="bottom-cta">
                <div class="cta-content">
                    <div class="cta-icon">❓</div>
                    <h3>لم تجد إجابة لسؤالك؟</h3>
                    <p>فريقنا جاهز لمساعدتك في أي وقت. لا تتردد في التواصل معنا!</p>
                    <a href="https://www.facebook.com/share/1E4XP9h9Pd/"  target="_blank" rel="noopener noreferrer"class="btn-secondary"   role="button">
                        <span>تواصل معنا</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>


 <!-- ===================== FOOTER ===================== -->
<footer class="relative overflow-hidden bg-gradient-to-b from-footer-dark-400 via-footer-dark-500 to-footer-dark-600 border-t border-footer-gold-300/10 min-h-screen flex flex-col justify-center" id="footer-section">

    <!-- Particles Canvas -->
    <canvas id="footerParticles" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

    <!-- Ambient Lights -->
    <div class="absolute -top-48 -right-24 w-[500px] h-[500px] rounded-full bg-footer-gold-300/[0.05] blur-[120px] pointer-events-none z-0 animate-float-slow"></div>
    <div class="absolute -bottom-36 -left-24 w-[400px] h-[400px] rounded-full bg-footer-gold-300/[0.03] blur-[100px] pointer-events-none z-0 animate-float-medium"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] rounded-full bg-footer-gold-200/[0.03] blur-[80px] pointer-events-none z-0 animate-float-fast"></div>

    <!-- Top Gold Line -->
    <div class="absolute top-0 left-0 right-0 h-[2px] z-20 top-gold-line"></div>
    <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-48 h-5 bg-gradient-radial from-footer-gold-300/30 to-transparent blur-sm z-20"></div>

    <!-- Geometric Pattern Overlay -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none z-0 geometric-pattern"></div>

    <!-- ========= CONTENT ========= -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 pb-8 w-full">

        <!-- === 4 Column Grid === -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-12 mb-14">

            <!-- COL 1: Logo + Description -->
            <div class="sm:col-span-2 lg:col-span-1 footer-col" data-animate="fade-up" data-delay="0">
                <div class="flex items-center gap-3 mb-5 group cursor-default">
                    <div class="relative flex-shrink-0">
                        <img
                            src="assets/images/6046279299901361992.jpg"
                            alt="مشكاة"
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-full object-cover ring-2 ring-footer-gold-300/50 ring-offset-2 ring-offset-transparent drop-shadow-lg transition-all duration-500 group-hover:scale-110 group-hover:rotate-3 group-hover:ring-footer-gold-300"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 rounded-full bg-footer-gold-300/20 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    </div>

                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold font-amiri text-footer-gold-300 tracking-wide animate-glow">
                            مشكاة
                        </h2>
                        <span class="text-[10px] sm:text-xs text-footer-gold-300/40 font-tajawal tracking-[0.2em] uppercase block">
                            أكاديمية القرآن
                        </span>
                    </div>
                </div>

                <p class="text-gray-400 text-sm leading-7 mb-6 max-w-xs">
                    منصة تعليمية إسلامية متخصصة في تعليم القرآن الكريم وعلومه،
                    نسعى لنشر النور القرآني وتيسير حفظه وتدبره لكل مسلم
                    في أنحاء العالم.
                </p>

                <div class="relative pr-4 border-r-2 border-footer-gold-300/20">
                    <div class="absolute top-0 right-0 w-[2px] h-full bg-gradient-to-b from-footer-gold-300/50 via-footer-gold-300/20 to-transparent"></div>
                    <p class="text-footer-gold-300/80 font-amiri text-base sm:text-lg leading-loose">
                        ﴿ ٱللَّهُ نُورُ ٱلسَّمَٰوَٰتِ وَٱلۡأَرۡضِۚ مَثَلُ نُورِهِۦ كَمِشۡكَوٰةٖ ﴾
                    </p>
                    <span class="text-footer-gold-300/25 text-xs mt-1 block font-tajawal">
                        سورة النور - الآية 35
                    </span>
                </div>
            </div>

            <!-- COL 2: Quick Links -->
            <div class="footer-col" data-animate="fade-up" data-delay="100">
                <h3 class="flex items-center gap-2 text-white text-base font-bold font-tajawal mb-6 relative pb-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-footer-gold-300/10 text-footer-gold-300 text-xs">
                        <i class="fas fa-compass"></i>
                    </span>
                    روابط سريعة
                    <span class="absolute bottom-0 right-0 w-12 h-[2px] bg-gradient-to-l from-footer-gold-300/60 to-transparent rounded-full"></span>
                </h3>
                <ul class="space-y-[2px]">
                    <li><a href="#hero" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>الرئيسية</span>
                    </a></li>
                    <li><a href="#packages-section" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>الباقات</span>
                    </a></li>
                    <li><a href="#teachers" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>المعلمين</span>
                    </a></li>
                    <li><a href="#programs" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>البرامج الدراسية</span>
                    </a></li>
                    <li><a href="#hero" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>من نحن</span>
                    </a></li>
                </ul>
            </div>

                            <!-- COL 3: Programs -->
            <div class="footer-col" data-animate="fade-up" data-delay="200">
                <h3 class="flex items-center gap-2 text-white text-base font-bold font-tajawal mb-6 relative pb-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-footer-gold-300/10 text-footer-gold-300 text-xs">
                        <i class="fas fa-book-quran"></i>
                    </span>
                    برامجنا
                    <span class="absolute bottom-0 right-0 w-12 h-[2px] bg-gradient-to-l from-footer-gold-300/60 to-transparent rounded-full"></span>
                </h3>
                <ul class="space-y-[2px]">
                    <li><a href="#programs" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>تحفيظ القرآن الكريم</span>
                    </a></li>
                    <li><a href="#programs" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>أحكام التجويد التطبيقي </span>
                    </a></li>
                    <li><a href="#programs" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>القاعدة النورانية</span>
                    </a></li>
                    <li><a href="#programs" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>القراءات العشر المتواترة</span>
                    </a></li>
                    <li><a href="#programs" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>التفسبير الميسر</span>
                    </a></li>
                    <li><a href="#programs" class="footer-link group flex items-center gap-2 py-2 px-3 rounded-lg text-gray-400 text-sm transition-all duration-300 hover:text-footer-gold-300 hover:bg-white/[0.02] hover:pr-5">
                        <span class="text-footer-gold-300/0 group-hover:text-footer-gold-300/80 transition-all duration-300 text-xs">←</span>
                        <span>برنامج النشيء للأطفال</span>
                    </a></li>
                </ul>
            </div>

            <!-- COL 4: Contact -->
            <div class="footer-col" data-animate="fade-up" data-delay="300">
                <h3 class="flex items-center gap-2 text-white text-base font-bold font-tajawal mb-6 relative pb-3">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-footer-gold-300/10 text-footer-gold-300 text-xs">
                        <i class="fas fa-envelope-open-text"></i>
                    </span>
                    تواصل معنا
                    <span class="absolute bottom-0 right-0 w-12 h-[2px] bg-gradient-to-l from-footer-gold-300/60 to-transparent rounded-full"></span>
                </h3>

                <div class="space-y-4">
                    <a href="mailto:info@mishkah.com" class="flex items-center gap-3 group p-3 rounded-xl transition-all duration-300 hover:bg-white/[0.02]">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-footer-gold-300/[0.07] text-footer-gold-300/60 group-hover:bg-footer-gold-300/20 group-hover:text-footer-gold-300 transition-all duration-300 text-sm">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-gray-500 text-[11px] block leading-none mb-1">البريد الإلكتروني</span>
                            <span class="text-gray-300 text-sm group-hover:text-footer-gold-300 transition-colors duration-300">info@mishkah.com</span>
                        </div>
                    </a>

                    <a href="tel:+966500000000" class="flex items-center gap-3 group p-3 rounded-xl transition-all duration-300 hover:bg-white/[0.02]">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-footer-gold-300/[0.07] text-footer-gold-300/60 group-hover:bg-footer-gold-300/20 group-hover:text-footer-gold-300 transition-all duration-300 text-sm">
                            <i class="fas fa-phone-flip"></i>
                        </div>
                        <div>
                            <span class="text-gray-500 text-[11px] block leading-none mb-1">الهاتف</span>
                            <span class="text-gray-300 text-sm group-hover:text-footer-gold-300 transition-colors duration-300" dir="ltr">+2010383783928</span>
                        </div>
                    </a>

                    <div class="flex items-center gap-3 p-3 rounded-xl">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-footer-gold-300/[0.07] text-footer-gold-300/60 text-sm">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div>
                            <span class="text-gray-500 text-[11px] block leading-none mb-1">الموقع</span>
                            <span class="text-gray-300 text-sm">الدقهلية _ المنصورة</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-xl">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-footer-gold-300/[0.07] text-footer-gold-300/60 text-sm">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <span class="text-gray-500 text-[11px] block leading-none mb-1">ساعات العمل</span>
                            <span class="text-gray-300 text-sm">السبت - الخميس | 8ص - 10م</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                       <!-- === Newsletter === -->
            <div class="relative rounded-2xl border border-footer-gold-300/10 bg-white/[0.01] backdrop-blur-sm p-6 sm:p-8 mb-14 overflow-hidden" data-animate="fade-up" data-delay="400">
                <div class="absolute inset-0 bg-gradient-to-l from-footer-gold-300/[0.03] to-transparent pointer-events-none"></div>
                <div class="relative flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="text-center md:text-right flex-shrink-0">
                        <h4 class="text-lg sm:text-xl font-bold font-amiri text-footer-gold-300 mb-1">
                            📬 اشترك في نشرتنا البريدية
                        </h4>
                        <p class="text-gray-500 text-sm">
                            احصل على آخر الدورات والفوائد القرآنية مباشرة في بريدك
                        </p>
                    </div>
                    <form class="flex w-full md:w-auto gap-0 rounded-xl overflow-hidden border border-footer-gold-300/15 focus-within:border-footer-gold-300/40 transition-colors duration-300 newsletter-form-glow" onsubmit="handleSubscribe(event)">
                        <input
                            type="email"
                            placeholder="أدخل بريدك الإلكتروني..."
                            required
                            id="newsletterEmail"
                            class="w-full md:w-72 bg-white/[0.03] text-white text-sm px-5 py-3 outline-none placeholder:text-gray-600 font-tajawal"
                        >
                        <button type="submit" id="newsletterBtn" class="flex-shrink-0 bg-gradient-to-l from-footer-gold-300 to-footer-gold-400 text-footer-dark-600 font-bold text-sm px-6 py-3 hover:from-footer-gold-200 hover:to-footer-gold-300 transition-all duration-300 flex items-center gap-2 font-tajawal">
                            <span id="btnText">اشتراك</span>
                            <i class="fas fa-paper-plane text-xs" id="btnIcon"></i>
                            <span id="btnSuccess" class="hidden items-center gap-1"><i class="fas fa-check"></i> تم!</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- === Stats + Social === -->
            <div class="flex flex-col lg:flex-row items-center justify-between gap-10 mb-12" data-animate="fade-up" data-delay="500">

                <!-- Stats - Auto Counting -->
                <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
                    <div class="text-center stat-box">
                        <span class="block text-2xl sm:text-3xl font-bold text-footer-gold-300 font-tajawal stat-number" data-count="15000">0</span>
                        <span class="text-gray-500 text-xs mt-1 block">طالب وطالبة</span>
                    </div>
                    <div class="w-px h-12 bg-gradient-to-b from-transparent via-footer-gold-300/20 to-transparent hidden sm:block self-center"></div>
                    <div class="text-center stat-box">
                        <span class="block text-2xl sm:text-3xl font-bold text-footer-gold-300 font-tajawal stat-number" data-count="500">0</span>
                        <span class="text-gray-500 text-xs mt-1 block">معلم ومعلمة</span>
                    </div>
                    <div class="w-px h-12 bg-gradient-to-b from-transparent via-footer-gold-300/20 to-transparent hidden sm:block self-center"></div>
                    <div class="text-center stat-box">
                        <span class="block text-2xl sm:text-3xl font-bold text-footer-gold-300 font-tajawal stat-number" data-count="120">0</span>
                        <span class="text-gray-500 text-xs mt-1 block">دورة تعليمية</span>
                    </div>
                    <div class="w-px h-12 bg-gradient-to-b from-transparent via-footer-gold-300/20 to-transparent hidden sm:block self-center"></div>
                    <div class="text-center stat-box">
                        <span class="block text-2xl sm:text-3xl font-bold text-footer-gold-300 font-tajawal stat-number" data-count="45">0</span>
                        <span class="text-gray-500 text-xs mt-1 block">دولة حول العالم</span>
                    </div>
                </div>

                <!-- Social Icons -->
                <div class="flex items-center gap-3 flex-wrap justify-center">
                    <span class="text-gray-500 text-sm ml-1">تابعنا:</span>

                    <!-- فيسبوك -->
                    <a 
                        href="https://www.facebook.com/share/17dVRr4zdF/" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="social-icon-btn group relative w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-400 text-sm transition-all duration-400 hover:bg-[#1877F2]/20 hover:border-[#1877F2]/30 hover:text-[#1877F2] hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#1877F2]/10" 
                        aria-label="فيسبوك"
                        title="تابعنا على فيسبوك"
                    >
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <!-- تويتر / X -->
                    <a 
                        href="https://twitter.com/juda_x2" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="social-icon-btn group relative w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-400 text-sm transition-all duration-400 hover:bg-[#1DA1F2]/20 hover:border-[#1DA1F2]/30 hover:text-[#1DA1F2] hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#1DA1F2]/10" 
                        aria-label="تويتر"
                        title="تابعنا على تويتر"
                    >
                        <i class="fab fa-x-twitter"></i>
                    </a>

                    <!-- يوتيوب -->
                    <a 
                        href="https://youtube.com/@juda_x2" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="social-icon-btn group relative w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-400 text-sm transition-all duration-400 hover:bg-[#FF0000]/20 hover:border-[#FF0000]/30 hover:text-[#FF0000] hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#FF0000]/10" 
                        aria-label="يوتيوب"
                        title="اشترك في قناتنا"
                    >
                        <i class="fab fa-youtube"></i>
                    </a>

                    <!-- إنستغرام -->
                    <a 
                        href="https://www.instagram.com/juda_x2/" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="social-icon-btn group relative w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-400 text-sm transition-all duration-400 hover:bg-[#E4405F]/20 hover:border-[#E4405F]/30 hover:text-[#E4405F] hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#E4405F]/10" 
                        aria-label="إنستغرام"
                        title="تابعنا على إنستغرام"
                    >
                        <i class="fab fa-instagram"></i>
                    </a>

                    <!-- تيليغرام -->
                    <a 
                        href="http://t.me/juda_x2" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="social-icon-btn group relative w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-400 text-sm transition-all duration-400 hover:bg-[#0088cc]/20 hover:border-[#0088cc]/30 hover:text-[#0088cc] hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#0088cc]/10" 
                        aria-label="تيليغرام"
                        title="انضم لقناتنا على تيليغرام"
                    >
                        <i class="fab fa-telegram-plane"></i>
                    </a>

                    <!-- واتساب -->
                    <a 
                        href="https://wa.me/+201095125229" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="social-icon-btn group relative w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-400 text-sm transition-all duration-400 hover:bg-[#25D366]/20 hover:border-[#25D366]/30 hover:text-[#25D366] hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#25D366]/10" 
                        aria-label="واتساب"
                        title="تواصل معنا على واتساب"
                    >
                        <i class="fab fa-whatsapp"></i>
                    </a>

                    <!-- تيك توك -->
                    <a 
                        href="https://www.tiktok.com/@juda_x2" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="social-icon-btn group relative w-10 h-10 rounded-xl bg-white/[0.04] border border-white/[0.06] flex items-center justify-center text-gray-400 text-sm transition-all duration-400 hover:bg-[#ff0050]/20 hover:border-[#ff0050]/30 hover:text-[#ff0050] hover:scale-110 hover:-translate-y-1 hover:shadow-lg hover:shadow-[#ff0050]/10" 
                        aria-label="تيك توك"
                        title="تابعنا على تيك توك"
                    >
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>


                        <!-- === Bottom Bar === -->
            <div class="border-t border-white/[0.05] pt-6 mt-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-gray-500 text-xs sm:text-sm font-tajawal text-center sm:text-right">
                        © <span id="currentYear"></span>
                        <span class="text-footer-gold-300 font-semibold">مشكاة</span> - أكاديمية القرآن. جميع الحقوق محفوظة.
                    </p>
                    <div class="flex items-center gap-4 sm:gap-6 text-xs sm:text-sm">
                        <a href="#" class="text-gray-500 hover:text-footer-gold-300 transition-colors duration-300">سياسة الخصوصية</a>
                        <span class="text-footer-dark-50/30">|</span>
                        <a href="#" class="text-gray-500 hover:text-footer-gold-300 transition-colors duration-300">الشروط والأحكام</a>
                        <span class="text-footer-dark-50/30">|</span>
                        <a href="#" class="text-gray-500 hover:text-footer-gold-300 transition-colors duration-300">خريطة الموقع</a>
                    </div>
                </div>
            </div>
        </div>

       <!-- Scroll to Top -->
<button
    id="scrollTopBtn"
    onclick="footerScrollToTop()"
    class="fixed bottom-6 left-6 z-50 w-12 h-12 rounded-full bg-gradient-to-br from-footer-gold-300 to-footer-gold-500 text-footer-dark-600 flex items-center justify-center text-sm shadow-lg shadow-footer-gold-300/20 opacity-0 translate-y-4 pointer-events-none transition-all duration-500 hover:scale-110 hover:shadow-xl hover:shadow-footer-gold-300/30"
    aria-label="العودة للأعلى">
    <i class="fas fa-chevron-up"></i>
</button>

    </footer>



    <!-- ===== JavaScript  ===== -->
    <script src="assets/js/script.js"></script>
     <script src="assets/js/programs.js"></script>
     <script src="assets/js/teachers.js"></script>
     <script src="assets/js/packages.js"></script>
      <script src="assets/js/study-system.js"></script>
        <script src="assets/js/faq.js"></script>
         <script src="assets/js/footer.js"></script>


</body>
</html>
