<?php
require_once 'includes/db.php';
require_once 'includes/session.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشكاة - تفاصيل البرنامج</title>

    
    <link rel="stylesheet" href="assets/css/tailwind.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/bundle.css">
</head>

<body class="font-kufi bg-cream-100 min-h-screen">

    
    <section id="course-detail-section">

        
        <div class="max-w-6xl mx-auto px-4 pt-6">
            <a href="index.php" class="back-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 17l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                <span>العودة للبرامج</span>
            </a>
        </div>

        <main id="courseDetail" class="course-detail max-w-6xl mx-auto px-4 py-8">
            
            <div class="course-detail__loading">
                <div class="course-detail__spinner"></div>
                <p>جارٍ تحميل البيانات...</p>
            </div>
        </main>

    </section>

    
    <script src="assets/js/bundle.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const params = new URLSearchParams(window.location.search);
            const courseId = parseInt(params.get('id'), 10);
            
            const checkInterval = setInterval(() => {
                if (typeof renderCourseDetail === 'function') {
                    renderCourseDetail(courseId);
                    clearInterval(checkInterval);
                }
            }, 50);
            setTimeout(() => clearInterval(checkInterval), 5000);
        });
    </script>
</body>
</html>
