<?php
// pages/student/CoursesPage.php
$courses = $conn->query("SELECT * FROM courses WHERE status='active' ORDER BY id ASC");
?>
<div class="animate-fadeIn" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-4">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">المسارات التعليمية</h1>
            <p class="text-gray-500 font-medium text-lg">اختر المسار المناسب وابدأ رحلتك في تعلم القرآن الكريم.</p>
        </div>
    </div>

    <!-- Dynamic Courses Grid -->
    <div id="coursesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        
        <?php while($c = $courses->fetch_assoc()): 
            $clr = $c['color'] ?? 'emerald';
            $icon = 'auto_stories';
            if($clr == 'blue') $icon = 'menu_book';
            if($clr == 'amber') $icon = 'record_voice_over';
            
            // Define tailwind classes based on color
            $bgClass = "bg-$clr-50";
            $textClass = "text-$clr-700";
            $btnClass = "bg-$clr-700 shadow-$clr-100 hover:bg-$clr-800";
            $hoverTextClass = "group-hover:text-$clr-700";
        ?>
        <div class="group luxury-card rounded-[3.5rem] p-10 shadow-sm border border-gray-50 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-20 h-20 rounded-[2.5rem] <?php echo $bgClass; ?> <?php echo $textClass; ?> flex items-center justify-center mb-8 group-hover:scale-110 transition-transform duration-500 shadow-sm">
                    <span class="material-icons-outlined text-4xl"><?php echo $icon; ?></span>
                </div>
                <span class="px-4 py-1.5 bg-gray-50 text-gray-400 text-[10px] font-black rounded-full uppercase tracking-widest mb-4 inline-block"><?php echo htmlspecialchars($c['type']); ?></span>
                <h3 class="text-2xl font-black text-gray-900 mb-4 <?php echo $hoverTextClass; ?> transition-colors"><?php echo htmlspecialchars($c['title']); ?></h3>
                <p class="text-gray-400 font-medium text-sm leading-relaxed mb-10 line-clamp-2"><?php echo htmlspecialchars($c['description']); ?></p>
                
                <div class="flex items-center justify-between mb-10 pt-6 border-t border-gray-50">
                    <div class="flex items-center gap-2 text-gray-400">
                        <span class="material-icons-outlined text-sm">schedule</span>
                        <span class="text-xs font-bold"><?php echo htmlspecialchars($c['sessions_count']); ?></span>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-black text-gray-900"><?php echo number_format($c['price']); ?> <span class="text-[10px] text-gray-400">ج.م/شهر</span></p>
                    </div>
                </div>

                <button onclick="enrollCourse(<?php echo $c['id']; ?>)" class="w-full py-5 <?php echo $btnClass; ?> text-white rounded-[2rem] font-black shadow-lg transition-all active:scale-95">
                    اشترك الآن
                </button>
            </div>
            <div class="absolute top-0 right-0 w-32 h-32 <?php echo $bgClass; ?> rounded-full translate-x-16 -translate-y-16 opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>
        </div>
        <?php endwhile; ?>

    </div>
</div>

<script>
async function enrollCourse(id) {
    const ok = await confirmDialog('هل تود الاشتراك في هذا المسار التعليمي؟');
    if(ok) {
        const res = await apiCall('enroll_course', { course_id: id });
        if(res.success) {
            showToast('تم الاشتراك بنجاح! ننتظرك في الحلقة القادمة.');
            setTimeout(() => location.href = '?page=episodes&course_id=' + id, 1000);
        } else {
            showToast(res.message || 'خطأ في عملية الاشتراك', 'error');
        }
    }
}
</script>
