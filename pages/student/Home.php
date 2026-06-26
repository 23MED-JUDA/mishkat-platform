<?php
// Student Dashboard Home - Overview
$userId = $_SESSION['user_id'];

// Get counts
$studentQuery = $conn->query("SELECT id FROM students WHERE user_id=$userId")->fetch_assoc();
$studentId = $studentQuery ? $studentQuery['id'] : 0;
$enrollCount = $conn->query("SELECT COUNT(*) as c FROM student_paths WHERE student_id=$studentId")->fetch_assoc()['c'] ?? 0;
$taskCount = $conn->query("SELECT COUNT(*) as c FROM homework_submissions WHERE student_id=$studentId AND (status='completed' OR status='graded')")->fetch_assoc()['c'] ?? 0;
$totalTasks = $conn->query("SELECT COUNT(*) as c FROM homeworks h JOIN halaqa_enrollments he ON he.halaqa_id = h.halaqa_id WHERE he.student_id=$studentId")->fetch_assoc()['c'] ?? 0;
$totalPoints = $taskCount * 10;

// Get average evaluations for the student
$evalQuery = $conn->query("SELECT AVG(memorization) as mem, AVG(tajweed) as taj, AVG(behavior) as beh, AVG(attendance) as att FROM evaluations WHERE student_id = $studentId")->fetch_assoc();
$avgMemorization = $evalQuery && $evalQuery['mem'] !== null ? round($evalQuery['mem']) : 0;
$avgTajweed = $evalQuery && $evalQuery['taj'] !== null ? round($evalQuery['taj']) : 0;
$avgBehavior = $evalQuery && $evalQuery['beh'] !== null ? round($evalQuery['beh']) : 0;
$avgAttendance = $evalQuery && $evalQuery['att'] !== null ? round($evalQuery['att']) : 0;
$overallScore = ($avgMemorization + $avgTajweed + $avgBehavior + $avgAttendance) > 0 
    ? round(($avgMemorization + $avgTajweed + $avgBehavior + $avgAttendance) / 4) 
    : 0;

// Courses
$courses = $conn->query("SELECT sp.*, lp.name AS title, 'emerald' AS color, 0 AS progress FROM student_paths sp JOIN learning_paths lp ON sp.path_id = lp.id WHERE sp.student_id = $studentId LIMIT 3");

// Daily Verses (Dummy data for now)
$verses = [
    ["text" => "إِنَّ مَعَ الْعُسْرِ يُسْرًا", "ref" => "سورة الشرح - آية 6"],
    ["text" => "وَقُل رَّبِّ زِدْنِي عِلْمًا", "ref" => "سورة طه - آية 114"],
    ["text" => "فَاصْبِرْ صَبْرًا جَمِيلًا", "ref" => "سورة المعارج - آية 5"]
];
$dailyVerse = $verses[array_rand($verses)];
?>

<div class="space-y-10 animate-fadeIn" dir="rtl">
    
    <!-- Hero Section with Daily Verse -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 relative bg-mishkat-green-900 rounded-[2rem] md:rounded-[3rem] p-6 md:p-14 text-white overflow-hidden shadow-2xl">
            <div class="relative z-10">
                <h1 class="text-2xl md:text-5xl font-black mb-3 font-tajawal leading-tight">مرحباً بك، <span class="text-mishkat-gold-400"><?php echo explode(' ', $userName)[0]; ?></span> 👋</h1>
                <p class="text-mishkat-green-200 text-sm md:text-lg font-medium max-w-xl leading-relaxed mb-6 md:mb-8">نحن فخورون بتقدمك المستمر. استمر في السعي نحو العلم والتميز.</p>
                
                <div class="flex flex-wrap gap-3 md:gap-4">
                    <a href="?page=tasks" class="flex-1 md:flex-none text-center px-6 md:px-8 py-3 bg-white text-mishkat-green-900 rounded-xl md:rounded-2xl font-black text-xs md:text-sm shadow-xl hover:scale-105 transition-all">المهام اليومية</a>
                    <a href="?page=courses" class="flex-1 md:flex-none text-center px-6 md:px-8 py-3 bg-mishkat-green-700 text-white rounded-xl md:rounded-2xl font-black text-xs md:text-sm hover:bg-mishkat-green-600 transition-all">دوراتي</a>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-80 h-80 bg-mishkat-green-600 rounded-full -translate-x-10 -translate-y-20 blur-[100px] opacity-30"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-64 h-64 bg-mishkat-gold-500 rounded-full blur-[100px] opacity-10"></div>
        </div>

        <!-- Daily Inspiration Card -->
        <div class="luxury-card p-6 md:p-10 flex flex-col justify-center items-center text-center border-none shadow-xl bg-gradient-to-br from-mishkat-beige-50 to-white dark:from-mishkat-green-900/40 dark:to-mishkat-green-950">
            <span class="material-icons-outlined text-mishkat-gold-500 text-3xl md:text-4xl mb-4">format_quote</span>
            <h3 class="text-lg md:text-2xl font-amiri font-bold text-mishkat-green-900 dark:text-mishkat-gold-200 mb-2 leading-relaxed italic">"<?php echo $dailyVerse['text']; ?>"</h3>
            <p class="text-[9px] md:text-[10px] font-black text-mishkat-gold-600 uppercase tracking-widest"><?php echo $dailyVerse['ref']; ?></p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="luxury-card p-4 md:p-8 group hover:-translate-y-2 transition-all">
            <div class="flex flex-col md:flex-row items-center md:items-start text-center md:text-right gap-3 md:gap-5">
                <div class="w-10 h-10 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-600 dark:text-mishkat-green-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-xl md:text-3xl">auto_stories</span>
                </div>
                <div>
                    <p class="text-[8px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">المسارات</p>
                    <h4 class="text-lg md:text-2xl font-black text-gray-900 dark:text-white"><?php echo $enrollCount; ?></h4>
                </div>
            </div>
        </div>
        <div class="luxury-card p-4 md:p-8 group hover:-translate-y-2 transition-all">
            <div class="flex flex-col md:flex-row items-center md:items-start text-center md:text-right gap-3 md:gap-5">
                <div class="w-10 h-10 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-xl md:text-3xl">task_alt</span>
                </div>
                <div>
                    <p class="text-[8px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">المهام</p>
                    <h4 class="text-lg md:text-2xl font-black text-gray-900 dark:text-white"><?php echo $taskCount; ?></h4>
                </div>
            </div>
        </div>
        <div class="luxury-card p-4 md:p-8 group hover:-translate-y-2 transition-all">
            <div class="flex flex-col md:flex-row items-center md:items-start text-center md:text-right gap-3 md:gap-5">
                <div class="w-10 h-10 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-500 dark:text-amber-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-xl md:text-3xl">military_tech</span>
                </div>
                <div>
                    <p class="text-[8px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">النقاط</p>
                    <h4 class="text-lg md:text-2xl font-black text-gray-900 dark:text-white"><?php echo $totalPoints; ?></h4>
                </div>
            </div>
        </div>
        <div class="luxury-card p-4 md:p-8 group hover:-translate-y-2 transition-all">
            <div class="flex flex-col md:flex-row items-center md:items-start text-center md:text-right gap-3 md:gap-5">
                <div class="w-10 h-10 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-xl md:text-3xl">notifications</span>
                </div>
                <div>
                    <p class="text-[8px] md:text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">تنبيهات</p>
                    <h4 class="text-lg md:text-2xl font-black text-gray-900 dark:text-white">3</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- تفاصيل الأداء والدرجات -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 luxury-card p-6 md:p-8 flex flex-col justify-between border-none">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-600 dark:text-mishkat-green-400 flex items-center justify-center">
                        <span class="material-icons-outlined text-2xl">insights</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white font-tajawal">مؤشرات الأداء التعليمي</h3>
                </div>
                <div class="space-y-5">
                    <!-- الحفظ -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">جودة الحفظ والتسميع</span>
                            <span class="text-sm font-black text-mishkat-green-600 dark:text-mishkat-gold-400"><?php echo $avgMemorization; ?>%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-mishkat-green-600 rounded-full transition-all duration-1000" style="width: <?php echo max($avgMemorization, 5); ?>%"></div>
                        </div>
                    </div>
                    <!-- التجويد -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">تطبيق أحكام التجويد ومخارج الحروف</span>
                            <span class="text-sm font-black text-mishkat-green-600 dark:text-mishkat-gold-400"><?php echo $avgTajweed; ?>%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-mishkat-green-600 rounded-full transition-all duration-1000" style="width: <?php echo max($avgTajweed, 5); ?>%"></div>
                        </div>
                    </div>
                    <!-- الحضور -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">المواظبة وحضور الحلقات</span>
                            <span class="text-sm font-black text-mishkat-green-600 dark:text-mishkat-gold-400"><?php echo $avgAttendance; ?>%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-mishkat-green-600 rounded-full transition-all duration-1000" style="width: <?php echo max($avgAttendance, 5); ?>%"></div>
                        </div>
                    </div>
                    <!-- السلوك -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">السلوك والمشاركة الفعالة</span>
                            <span class="text-sm font-black text-mishkat-green-600 dark:text-mishkat-gold-400"><?php echo $avgBehavior; ?>%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                            <div class="h-full bg-mishkat-green-600 rounded-full transition-all duration-1000" style="width: <?php echo max($avgBehavior, 5); ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- التقييم العام -->
        <div class="luxury-card p-6 md:p-8 flex flex-col justify-between items-center text-center border-none">
            <div class="w-full">
                <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal mb-6">معدل التقييم العام</h3>
                <div class="relative w-32 h-32 mx-auto flex items-center justify-center">
                    <!-- Circular Progress Ring using SVG -->
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="64" cy="64" r="50" stroke="currentColor" stroke-width="8" class="text-gray-100 dark:text-white/5" fill="transparent" />
                        <circle cx="64" cy="64" r="50" stroke="var(--color-primary)" stroke-width="8" stroke-dasharray="314" stroke-dashoffset="<?php echo 314 - (314 * $overallScore / 100); ?>" class="transition-all duration-1000" stroke-linecap="round" fill="transparent" />
                    </svg>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $overallScore; ?>%</span>
                        <span class="text-[9px] text-gray-400 font-bold tracking-widest mt-1">تراكمي</span>
                    </div>
                </div>
            </div>
            <div class="mt-6 text-xs text-gray-400 dark:text-white/40 leading-relaxed font-tajawal">
                هذا التقييم تراكمي ويتم تحديثه تلقائياً بناءً على تقييمات معلمك في الحلقات اليومية.
            </div>
        </div>
    </div>

    <!-- أهمية وفضل طلب العلم وحفظ القرآن -->
    <div class="luxury-card p-6 md:p-8 border-none bg-gradient-to-br from-mishkat-green-50 to-white dark:from-mishkat-green-900/10 dark:to-mishkat-green-950/20">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-600 dark:text-mishkat-green-400 flex items-center justify-center">
                <span class="material-icons-outlined text-2xl">workspace_premium</span>
            </div>
            <h3 class="text-xl font-black text-gray-900 dark:text-white font-tajawal">أهمية وفضل طلب العلم وحفظ القرآن</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- الفضيلة الأولى -->
            <div class="p-5 bg-white dark:bg-mishkat-green-900/20 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col justify-between hover:scale-[1.02] transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/30 text-amber-500 flex items-center justify-center mb-4">
                        <span class="material-icons-outlined">star_purple500</span>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">الخيرية العظمى</h4>
                    <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal">
                        قال النبي صلى الله عليه وسلم: <span class="font-bold text-mishkat-green-700 dark:text-mishkat-gold-400">"خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ"</span>. حفظ القرآن الكريم يضعك في صفوة الأمة وخيارها، وينير دربك بالخير والبركة.
                    </p>
                </div>
            </div>
            <!-- الفضيلة الثانية -->
            <div class="p-5 bg-white dark:bg-mishkat-green-900/20 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col justify-between hover:scale-[1.02] transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/30 text-blue-500 flex items-center justify-center mb-4">
                        <span class="material-icons-outlined">insights</span>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">رفعة الدرجات</h4>
                    <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal">
                        يقال لقارئ القرآن يوم القيامة: <span class="font-bold text-mishkat-green-700 dark:text-mishkat-gold-400">"اقْرَأْ وَارْتَقِ وَرَتِّلْ كَمَا كُنْتَ تُرَتِّلُ فِي الدُّنْيَا"</span>. كل آية أو سورة تحفظها وترتلها ترفعك درجة رفيعة في جنات النعيم.
                    </p>
                </div>
            </div>
            <!-- الفضيلة الثالثة -->
            <div class="p-5 bg-white dark:bg-mishkat-green-900/20 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col justify-between hover:scale-[1.02] transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/30 text-purple-500 flex items-center justify-center mb-4">
                        <span class="material-icons-outlined">forest</span>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white mb-2">طريق ميسر إلى الجنة</h4>
                    <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal">
                        قال النبي صلى الله عليه وسلم: <span class="font-bold text-mishkat-green-700 dark:text-mishkat-gold-400">"مَنْ سَلَكَ طَرِيقًا يَلْتَمِسُ فِيهِ عِلْمًا سَهَّلَ اللَّهُ لَهُ بِهِ طَرِيقًا إِلَى الْجَنَّةِ"</span>. السعي لطلب العلم والقرآن يقربك إلى رضا الله وجنته.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Courses & Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Active Courses -->
        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <h3 class="text-xl font-black text-gray-900 dark:text-white font-tajawal">آخر المسارات المفتوحة</h3>
                <a href="?page=courses" class="text-xs font-bold text-mishkat-green-600 hover:text-mishkat-green-700">عرض الكل</a>
            </div>
            <div class="space-y-4">
                <?php if($courses->num_rows > 0): ?>
                    <?php while($c = $courses->fetch_assoc()): ?>
                        <div class="luxury-card p-6 flex items-center gap-6 group hover:shadow-lg transition-all border-none bg-white dark:bg-mishkat-green-900/20">
                            <div class="w-16 h-16 rounded-2xl bg-gray-50 dark:bg-mishkat-green-800 flex items-center justify-center">
                                <span class="material-icons-outlined text-3xl" style="color: <?php echo $c['color']; ?>"><?php echo ($c['color'] === '#d48d28' ? 'star' : 'auto_stories'); ?></span>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-black text-gray-900 dark:text-white mb-2"><?php echo htmlspecialchars($c['title']); ?></h4>
                                <div class="w-full h-2 bg-gray-100 dark:bg-mishkat-green-800 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full bg-mishkat-green-600 transition-all duration-1000" style="width: <?php echo $c['progress']; ?>%"></div>
                                </div>
                            </div>
                            <div class="text-left">
                                <span class="text-sm font-black text-mishkat-green-700 dark:text-mishkat-green-400"><?php echo $c['progress']; ?>%</span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="luxury-card p-10 text-center text-gray-400 font-bold border-dashed border-2">لا توجد مسارات نشطة حالياً</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Weekly Activity Chart -->
        <div class="luxury-card p-10">
            <h3 class="text-xl font-black text-gray-900 dark:text-white font-tajawal mb-8">نشاطك الأسبوعي</h3>
            <canvas id="activityChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('activityChart').getContext('2d');
    const isDark = document.documentElement.classList.contains('dark');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'],
            datasets: [{
                label: 'المهام المكتملة',
                data: [2, 5, 3, 7, 4, 8, 5],
                backgroundColor: isDark ? '#d48d28' : '#3e8c6b',
                borderRadius: 10,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true,
                    grid: { color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)' },
                    ticks: { color: isDark ? '#8ec7ad' : '#9ca3af' }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: isDark ? '#8ec7ad' : '#9ca3af' }
                }
            }
        }
    });
});
</script>
