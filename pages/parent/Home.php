<?php
// Parent Dashboard Home - Children Overview
$parentId = $_SESSION['user_id'];

// Get children
$children = $conn->query("SELECT u.id, u.name, u.email, u.status 
                          FROM users u 
                          JOIN parent_student ps ON u.id = ps.student_id 
                          WHERE ps.parent_id = $parentId");

?>

<div class="space-y-10 animate-fadeIn" dir="rtl">
    <div class="relative bg-mishkat-green-900 rounded-[3rem] p-10 md:p-14 text-white overflow-hidden shadow-2xl">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-5xl font-black mb-4 font-tajawal leading-tight">مرحباً بك، <span class="text-mishkat-gold-400">ولي الأمر</span> 👋</h1>
            <p class="text-mishkat-green-200 text-lg font-medium max-w-xl leading-relaxed mb-8">يمكنك هنا متابعة تقدم أبنائك في مساراتهم التعليمية وحلقات التحفيظ.</p>
        </div>
        <div class="absolute top-0 right-0 w-80 h-80 bg-mishkat-green-600 rounded-full -translate-x-10 -translate-y-20 blur-[100px] opacity-30"></div>
    </div>

    <div class="space-y-6">
        <h3 class="text-xl font-black text-gray-900 font-tajawal px-4">أبنائي المسجلون</h3>
        
        <?php if($children->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php while($s = $children->fetch_assoc()): 
                    $sid = $s['id'];
                    // Get progress stats for this child
                    $prog = $conn->query("SELECT AVG(progress) as p FROM enrollments WHERE user_id=$sid")->fetch_assoc()['p'] ?? 0;
                    $tasks = $conn->query("SELECT COUNT(*) as c FROM user_tasks WHERE user_id=$sid AND completed=1")->fetch_assoc()['c'];
                ?>
                <div class="luxury-card p-8 group hover:shadow-xl transition-all">
                    <div class="flex items-center gap-6 mb-8">
                        <div class="w-20 h-20 bg-mishkat-green-50 text-mishkat-green-700 rounded-[2.5rem] flex items-center justify-center text-3xl font-black group-hover:rotate-6 transition-transform">
                            <?php echo mb_substr($s['name'],0,1,'UTF-8'); ?>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-gray-900"><?php echo htmlspecialchars($s['name']); ?></h4>
                            <p class="text-sm text-gray-400"><?php echo $s['email']; ?></p>
                            <span class="inline-block mt-2 px-3 py-1 bg-mishkat-green-50 text-mishkat-green-600 rounded-lg text-[10px] font-black uppercase">طالب نشط</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="p-4 bg-gray-50 rounded-[2rem] border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">متوسط الإنجاز</p>
                            <p class="text-xl font-black text-mishkat-green-700"><?php echo round($prog); ?>%</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-[2rem] border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">المهام المنجزة</p>
                            <p class="text-xl font-black text-gray-900"><?php echo $tasks; ?></p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-mishkat-green-600 rounded-full transition-all duration-1000" style="width: <?php echo $prog; ?>%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-bold text-gray-400 px-1">
                            <span>البداية</span>
                            <span>رحلة التعلم</span>
                            <span>الختم بإذن الله</span>
                        </div>
                    </div>

                    <button onclick="showToast('جاري تجهيز تقرير مفصل...')" class="mt-8 w-full py-4 btn-luxury text-sm">عرض التقرير المفصل</button>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="luxury-card p-20 text-center border-dashed border-2 border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-icons-outlined text-4xl text-gray-200">person_add</span>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">لم يتم ربط أي ابن بحسابك</h3>
                <p class="text-gray-400 max-w-sm mx-auto">تأكد من كتابة البريد الإلكتروني الخاص بابنك بشكل صحيح أثناء التسجيل ليتم الربط التلقائي.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
