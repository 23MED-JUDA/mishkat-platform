<?php
// Teacher Profile - Dynamic Enhanced
$profile = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
$teacherQuery = $conn->query("SELECT id FROM teachers WHERE user_id=$uid")->fetch_assoc();
$teacherId = $teacherQuery ? $teacherQuery['id'] : 0;
$teacherInfo = $conn->query("SELECT *, specialization AS specialty, cv_file AS cv_url FROM teachers WHERE user_id=$uid")->fetch_assoc();
$circlesCount = $conn->query("SELECT COUNT(*) as c FROM halaqat WHERE teacher_id=$teacherId")->fetch_assoc()['c'];
$studentsCount = $conn->query("SELECT COUNT(DISTINCT he.student_id) as c FROM halaqa_enrollments he JOIN halaqat ci ON he.halaqa_id=ci.id WHERE ci.teacher_id=$teacherId")->fetch_assoc()['c'];

// Extra Teacher Statistics
$evalsCount = $conn->query("SELECT COUNT(*) as c FROM evaluations WHERE teacher_id = $uid")->fetch_assoc()['c'] ?? 0;
$avgStudentQuery = $conn->query("SELECT AVG(memorization) as mem, AVG(tajweed) as taj, AVG(attendance) as att FROM evaluations WHERE teacher_id = $uid")->fetch_assoc();
$avgStudentMem = $avgStudentQuery && $avgStudentQuery['mem'] !== null ? round($avgStudentQuery['mem']) : 0;
$avgStudentTaj = $avgStudentQuery && $avgStudentQuery['taj'] !== null ? round($avgStudentQuery['taj']) : 0;
$avgStudentAtt = $avgStudentQuery && $avgStudentQuery['att'] !== null ? round($avgStudentQuery['att']) : 0;
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <!-- Header Card -->
    <div class="bg-gradient-to-l from-mishkat-green-800 to-mishkat-green-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl shadow-mishkat-green-900/20">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="w-32 h-32 bg-white/10 border-4 border-white/20 rounded-[2.5rem] flex items-center justify-center text-5xl font-black shadow-inner">
                <?php echo mb_substr($profile['name'],0,1,'UTF-8'); ?>
            </div>
            <div class="text-center md:text-right">
                <h1 class="text-3xl font-black mb-2"><?php echo htmlspecialchars($profile['name']); ?></h1>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                    <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold border border-white/10 backdrop-blur-md">
                        <i class="fas fa-certificate text-mishkat-green-300 ml-1"></i> <?php echo htmlspecialchars($teacherInfo['specialty'] ?? 'معلم معتمد'); ?>
                    </span>
                    <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold border border-white/10 backdrop-blur-md">
                        <i class="fas fa-clock text-mishkat-green-300 ml-1"></i> <?php echo ($teacherInfo['experience_years']??0); ?> سنوات خبرة
                    </span>
                    <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold border border-white/10 backdrop-blur-md text-yellow-400">
                        <i class="fas fa-star ml-1"></i> <?php echo $teacherInfo['rating'] ?? '5.00'; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="luxury-card p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-[2rem] bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm"><span class="material-icons-outlined text-3xl">groups</span></div>
            <div><p class="text-xs text-gray-400 font-bold mb-1 uppercase tracking-widest">الحلقات</p><h3 class="text-2xl font-black text-gray-900"><?php echo $circlesCount; ?></h3></div>
        </div>
        <div class="luxury-card p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-[2rem] bg-mishkat-green-50 text-mishkat-green-600 flex items-center justify-center shadow-sm"><span class="material-icons-outlined text-3xl">school</span></div>
            <div><p class="text-xs text-gray-400 font-bold mb-1 uppercase tracking-widest">الطلاب</p><h3 class="text-2xl font-black text-gray-900"><?php echo $studentsCount; ?></h3></div>
        </div>
        <div class="luxury-card p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-[2rem] bg-amber-50 text-amber-600 flex items-center justify-center shadow-sm"><span class="material-icons-outlined text-3xl">location_on</span></div>
            <div><p class="text-xs text-gray-400 font-bold mb-1 uppercase tracking-widest">الموقع</p><h3 class="text-sm font-black text-gray-900"><?php echo htmlspecialchars($teacherInfo['location'] ?? '-'); ?></h3></div>
        </div>
        <div class="luxury-card p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-5">
            <div class="w-14 h-14 rounded-[2rem] bg-purple-50 text-purple-600 flex items-center justify-center shadow-sm"><span class="material-icons-outlined text-3xl">verified_user</span></div>
            <div><p class="text-xs text-gray-400 font-bold mb-1 uppercase tracking-widest">الحالة</p><h3 class="text-sm font-black text-mishkat-green-600">نشط ومقبول</h3></div>
        </div>
    </div>

    <!-- إحصائيات المعلم وأهمية الرسالة -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- إحصائيات الأداء المهني للمعلم -->
        <div class="lg:col-span-2 luxury-card p-6 md:p-8 border-none flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-600 dark:text-mishkat-green-400 flex items-center justify-center">
                        <span class="material-icons-outlined text-2xl">analytics</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white font-tajawal">مؤشرات إنجاز الحلقات</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-5 bg-gray-50 dark:bg-white/[0.02] rounded-2xl border border-gray-100 dark:border-white/5 text-center">
                        <span class="material-icons-outlined text-mishkat-green-600 text-3xl mb-2">assignment_turned_in</span>
                        <p class="text-xs text-gray-400 font-bold mb-1">التقييمات المنجزة</p>
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $evalsCount; ?></h4>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-white/[0.02] rounded-2xl border border-gray-100 dark:border-white/5 text-center">
                        <span class="material-icons-outlined text-blue-500 text-3xl mb-2">star_rate</span>
                        <p class="text-xs text-gray-400 font-bold mb-1">متوسط حفظ الطلاب</p>
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $avgStudentMem; ?>%</h4>
                    </div>
                    <div class="p-5 bg-gray-50 dark:bg-white/[0.02] rounded-2xl border border-gray-100 dark:border-white/5 text-center">
                        <span class="material-icons-outlined text-purple-500 text-3xl mb-2">co_present</span>
                        <p class="text-xs text-gray-400 font-bold mb-1">متوسط حضور الحلقات</p>
                        <h4 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $avgStudentAtt; ?>%</h4>
                    </div>
                </div>
            </div>
            <div class="mt-6 text-xs text-gray-400 dark:text-white/40 leading-relaxed font-tajawal border-t border-gray-100 dark:border-white/5 pt-4">
                تساعدك هذه المؤشرات على متابعة نشاطك التعليمي وأداء طلابك في الحلقات الموكلة إليك.
            </div>
        </div>

        <!-- فضل وأهمية رسالة التعليم -->
        <div class="luxury-card p-6 md:p-8 border-none bg-gradient-to-br from-mishkat-green-50 to-white dark:from-mishkat-green-900/10 dark:to-mishkat-green-950/20 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="material-icons-outlined text-mishkat-gold-500">menu_book</span>
                    <h4 class="font-black text-gray-900 dark:text-white">شرف تعليم القرآن الكريم</h4>
                </div>
                <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal mb-4">
                    قال النبي ﷺ: <span class="font-bold text-mishkat-green-700 dark:text-mishkat-gold-400">"إن الله وملائكته وأهل السموات والأرضين... ليصلون على معلم الناس الخير"</span>. 
                </p>
                <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal">
                    أنت تحمل رسالة الأنبياء، وتعليمك للقرآن الكريم يبني جيلاً صالحاً ويثمر لك أجوراً جارية لا تنقطع.
                </p>
            </div>
            <div class="text-[10px] text-mishkat-gold-600 font-black tracking-wider border-t border-gray-100 dark:border-white/5 pt-4 uppercase">
                مِشـكاة • فضل رسالة التعليم
            </div>
        </div>
    </div>

    <!-- Details Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <!-- Edit Profile -->
            <div class="luxury-card rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                    <span class="w-10 h-10 bg-mishkat-green-50 text-mishkat-green-600 rounded-[1.5rem] flex items-center justify-center"><i class="fas fa-user-edit text-sm"></i></span>
                    تعديل البيانات المهنية والشخصية
                </h3>
                <form id="profileForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">الاسم بالكامل</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">رقم الهاتف</label>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone']??''); ?>" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">التخصص</label>
                            <input type="text" name="specialty" value="<?php echo htmlspecialchars($teacherInfo['specialty']??''); ?>" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">سنوات الخبرة</label>
                            <input type="number" name="experience" value="<?php echo intval($teacherInfo['experience_years']??0); ?>" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">الموقع الحالي</label>
                            <input type="text" name="location" value="<?php echo htmlspecialchars($teacherInfo['location']??''); ?>" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">رابط الـ CV</label>
                            <input type="url" name="cv_url" value="<?php echo htmlspecialchars($teacherInfo['cv_url']??''); ?>" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">النبذة التعريفية (Bio)</label>
                            <textarea name="bio" rows="4" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700"><?php echo htmlspecialchars($teacherInfo['bio'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="px-10 py-4 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-xl shadow-mishkat-green-100 flex items-center gap-2">
                        <span class="material-icons-outlined">save</span>
                        حفظ التغييرات المهنية
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <!-- CV Preview Card -->
            <?php if(!empty($teacherInfo['cv_url'])): ?>
            <div class="luxury-card rounded-3xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-[2rem] flex items-center justify-center mx-auto mb-4">
                    <span class="material-icons-outlined text-3xl">description</span>
                </div>
                <h4 class="font-black text-gray-900 mb-2">السيرة الذاتية (CV)</h4>
                <p class="text-xs text-gray-400 font-bold mb-6 italic">هذا الملف متاح للمراجعة من قبل الإدارة</p>
                <a href="<?php echo htmlspecialchars($teacherInfo['cv_url']); ?>" target="_blank" class="block w-full py-3 bg-blue-600 text-white rounded-[1.5rem] text-sm font-black hover:bg-blue-700 transition-all">فتح الملف المرفق</a>
            </div>
            <?php endif; ?>

            <!-- Change Password -->
            <div class="luxury-card rounded-3xl shadow-sm border border-gray-100 p-8">
                <h4 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
                    <span class="material-icons-outlined text-amber-500">lock</span>
                    الأمان والخصوصية
                </h4>
                <form id="passwordForm" class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">كلمة المرور الحالية</label>
                        <input type="password" name="old_password" placeholder="••••••••" class="w-full px-5 py-3 bg-gray-50 border-none rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">الكلمة الجديدة</label>
                        <input type="password" name="new_password" placeholder="••••••••" class="w-full px-5 py-3 bg-gray-50 border-none rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                    </div>
                    <button type="submit" class="w-full py-4 bg-gray-100 text-gray-700 rounded-[1.5rem] font-black hover:bg-gray-200 transition-all text-sm">تغيير كلمة المرور</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this); fd.append('action','update_teacher_profile');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) {
            showToast('تم تحديث ملفك المهني بنجاح');
            setTimeout(() => location.reload(), 1000);
        } else {
            showToast(res.message||'خطأ','error');
        }
    });
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this); fd.append('action','change_password');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { 
            showToast('تم تغيير كلمة المرور بنجاح'); 
            this.reset(); 
        } else {
            showToast(res.message||'خطأ','error');
        }
    });
});
</script>
