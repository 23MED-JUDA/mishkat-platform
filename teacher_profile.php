<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي للمعلم - مشكاة</title>

    
    <link rel="stylesheet" href="assets/css/tailwind.min.css">

    
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    
    <link rel="stylesheet" href="assets/css/bundle.css">
</head>
<body class="font-cairo bg-cream">

    
    <a href="index.php" class="back-btn">
        <i class="fas fa-arrow-right"></i>
        <span>رجوع</span>
    </a>

    
    <section id="profileHero" class="profile-hero">

        
        <img src="assets/images/88fac63309bd27b514c4d38152b29f90.jpg" alt="خلفية" class="hero-bg-image" id="heroBgImage">

        
        <div class="hero-overlay"></div>

        <div class="hero-content container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-10 items-center">

                
                <div class="hero-image-wrapper" data-aos="fade-left">
                    <div class="hero-image-frame">
                        <img id="heroImage" src="" alt="صورة المعلم">
                    </div>
                    <div class="frame-decoration"></div>
                </div>

                
                <div class="hero-text" data-aos="fade-right">
                    <span class="hero-badge" id="heroSpecialty"></span>
                    <h1 id="heroName" class="hero-name"></h1>
                    <p id="heroTitle" class="hero-title"></p>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <i class="fas fa-book-quran"></i>
                            <div>
                                <span id="heroExperience" class="stat-number"></span>
                                <span class="stat-label">سنوات خبرة</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-users"></i>
                            <div>
                                <span id="heroStudents" class="stat-number"></span>
                                <span class="stat-label">طالب وطالبة</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-certificate"></i>
                            <div>
                                <span id="heroIjazat" class="stat-number"></span>
                                <span class="stat-label">إجازات قرآنية</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    
    <section class="profile-content py-20 px-6">
        <div class="container mx-auto max-w-6xl">

            
            <div class="profile-card" data-aos="fade-up">
                <div class="card-header">
                    <i class="fas fa-user-graduate"></i>
                    <h3>نبذة عن المعلم</h3>
                </div>
                <p id="profileBio" class="profile-bio"></p>
            </div>

            
            <div class="grid md:grid-cols-2 gap-8 mt-8">
                <div class="profile-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header">
                        <i class="fas fa-award"></i>
                        <h3>المؤهلات العلمية</h3>
                    </div>
                    <ul id="profileQualifications" class="profile-list"></ul>
                </div>

                <div class="profile-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-header">
                        <i class="fas fa-scroll"></i>
                        <h3>الإجازات والأسانيد</h3>
                    </div>
                    <ul id="profileIjazat" class="profile-list"></ul>
                </div>
            </div>

            
            <div class="profile-card mt-8" data-aos="fade-up">
                <div class="card-header">
                    <i class="fas fa-star"></i>
                    <h3>المواد التي يدرّسها</h3>
                </div>
                <div id="profileCourses" class="courses-grid"></div>
            </div>

            
            <div class="profile-card mt-8" data-aos="fade-up">
                <div class="card-header">
                    <i class="far fa-clock"></i>
                    <h3>مواعيد الحلقات</h3>
                </div>
                <div id="profileSchedule" class="schedule-grid"></div>
            </div>

        </div>
    </section>

    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/bundle.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkInterval = setInterval(() => {
                if (typeof loadTeacherProfile === 'function') {
                    loadTeacherProfile();
                    clearInterval(checkInterval);
                }
            }, 50);
            setTimeout(() => clearInterval(checkInterval), 5000);
        });
    </script>
</body>
</html>
