<?php
// Student Dashboard Home - Overview
$userId = $_SESSION['user_id'];

// Get counts
$enrollCount = $conn->query("SELECT COUNT(*) as c FROM enrollments WHERE user_id=$userId")->fetch_assoc()['c'];
$taskCount = $conn->query("SELECT COUNT(*) as c FROM user_tasks WHERE user_id=$userId AND completed=1")->fetch_assoc()['c'];
$totalTasks = $conn->query("SELECT COUNT(*) as c FROM tasks")->fetch_assoc()['c'];
$totalPoints = $taskCount * 10;

// Courses
$courses = $conn->query("SELECT e.*, c.title, c.color FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE e.user_id = $userId LIMIT 3");

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
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 relative bg-mishkat-green-900 rounded-[3rem] p-10 md:p-14 text-white overflow-hidden shadow-2xl">
            <div class="relative z-10">
                <h1 class="text-3xl md:text-5xl font-black mb-4 font-tajawal leading-tight">مرحباً بك، <span class="text-mishkat-gold-400"><?php echo explode(' ', $userName)[0]; ?></span> 👋</h1>
                <p class="text-mishkat-green-200 text-lg font-medium max-w-xl leading-relaxed mb-8">نحن فخورون بتقدمك المستمر. استمر في السعي نحو العلم والتميز.</p>
                
                <div class="flex gap-4">
                    <a href="?page=tasks" class="px-8 py-3 bg-white text-mishkat-green-900 rounded-2xl font-black text-sm shadow-xl hover:scale-105 transition-all">المهام اليومية</a>
                    <a href="?page=courses" class="px-8 py-3 bg-mishkat-green-700 text-white rounded-2xl font-black text-sm hover:bg-mishkat-green-600 transition-all">دوراتي</a>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-80 h-80 bg-mishkat-green-600 rounded-full -translate-x-10 -translate-y-20 blur-[100px] opacity-30"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-64 h-64 bg-mishkat-gold-500 rounded-full blur-[100px] opacity-10"></div>
        </div>

        <!-- Daily Inspiration Card -->
        <div class="luxury-card p-10 flex flex-col justify-center items-center text-center border-none shadow-xl bg-gradient-to-br from-mishkat-beige-50 to-white dark:from-mishkat-green-900/40 dark:to-mishkat-green-950">
            <span class="material-icons-outlined text-mishkat-gold-500 text-4xl mb-4">format_quote</span>
            <h3 class="text-2xl font-amiri font-bold text-mishkat-green-900 dark:text-mishkat-gold-200 mb-2 leading-relaxed italic">"<?php echo $dailyVerse['text']; ?>"</h3>
            <p class="text-[10px] font-black text-mishkat-gold-600 uppercase tracking-widest"><?php echo $dailyVerse['ref']; ?></p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="luxury-card p-8 group hover:-translate-y-2 transition-all">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-600 dark:text-mishkat-green-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-3xl">auto_stories</span>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">المسارات</p>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $enrollCount; ?></h4>
                </div>
            </div>
        </div>
        <div class="luxury-card p-8 group hover:-translate-y-2 transition-all">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-3xl">task_alt</span>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">المهام المنجزة</p>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $taskCount; ?></h4>
                </div>
            </div>
        </div>
        <div class="luxury-card p-8 group hover:-translate-y-2 transition-all">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/30 text-amber-500 dark:text-amber-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-3xl">military_tech</span>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">نقاط الخبرة</p>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $totalPoints; ?></h4>
                </div>
            </div>
        </div>
        <div class="luxury-card p-8 group hover:-translate-y-2 transition-all">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:rotate-12 transition-transform">
                    <span class="material-icons-outlined text-3xl">notifications</span>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">إشعارات</p>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white">3</h4>
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
