<?php
// Student Profile - Dynamic from DB Enhanced
$profile = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
$enrollments = $conn->query("SELECT e.*,c.title,c.color FROM enrollments e JOIN courses c ON e.course_id=c.id WHERE e.user_id=$uid");
$completedTasks = $conn->query("SELECT COUNT(*) as c FROM user_tasks WHERE user_id=$uid AND completed=1")->fetch_assoc()['c'];
$totalTasks = $conn->query("SELECT COUNT(*) as c FROM tasks")->fetch_assoc()['c'];
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <!-- Header -->
    <div class="bg-gradient-to-l from-mishkat-green-800 to-mishkat-green-900 rounded-[2.5rem] p-10 text-white relative overflow-hidden shadow-2xl shadow-mishkat-green-900/20">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2 blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="relative group cursor-pointer" onclick="document.getElementById('profileImageInput').click()">
                <div class="w-32 h-32 bg-white/10 border-4 border-white/20 rounded-[2.5rem] flex items-center justify-center text-5xl font-black shadow-inner overflow-hidden relative">
                    <?php if(!empty($profile['profile_image'])): ?>
                        <img src="<?php echo htmlspecialchars($profile['profile_image']); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php echo mb_substr($profile['name'],0,1,'UTF-8'); ?>
                    <?php endif; ?>
                    
                    <!-- Overlay on Hover -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <span class="material-icons-outlined text-white">camera_alt</span>
                    </div>
                </div>
                <input type="file" id="profileImageInput" class="hidden" accept="image/*" onchange="uploadProfileImage(this)">
            </div>
            <div class="text-center md:text-right">
                <h1 class="text-3xl font-black mb-2"><?php echo htmlspecialchars($profile['name']); ?></h1>
                <p class="text-mishkat-green-200 text-lg font-medium opacity-80"><?php echo $profile['email']; ?></p>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-4">
                    <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold border border-white/10 backdrop-blur-md">طالب مشكاة</span>
                    <span class="px-4 py-1.5 bg-mishkat-green-400/20 rounded-full text-xs font-bold border border-mishkat-green-400/20 flex items-center gap-2">
                        <span class="w-2 h-2 bg-mishkat-green-400 rounded-full animate-pulse"></span>
                        <?php echo $profile['status']==='active' ? 'حساب نشط' : 'قيد المراجعة'; ?>
                    </span>
                    <?php if($profile['age']): ?>
                    <span class="px-4 py-1.5 bg-white/10 rounded-full text-xs font-bold border border-white/10 backdrop-blur-md italic">
                        <?php echo $profile['age']; ?> سنة
                    </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Form -->
        <div class="lg:col-span-2 space-y-6">
            <div class="luxury-card rounded-[2.5rem] shadow-sm border border-gray-100 p-10">
                <h3 class="text-xl font-black text-gray-900 mb-8 flex items-center gap-3">
                    <span class="w-10 h-10 bg-mishkat-green-50 text-mishkat-green-600 rounded-[1.5rem] flex items-center justify-center shadow-sm"><i class="fas fa-user-edit text-sm"></i></span>
                    تعديل البيانات الشخصية
                </h3>
                <form id="profileForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">الاسم الكامل</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" placeholder="الاسم" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">رقم الهاتف</label>
                            <input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone']??''); ?>" placeholder="01XXXXXXXXX" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">النوع</label>
                            <select name="gender" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700 appearance-none">
                                <option value="ذكر" <?php echo $profile['gender']==='ذكر'?'selected':''; ?>>ذكر</option>
                                <option value="أنثى" <?php echo $profile['gender']==='أنثى'?'selected':''; ?>>أنثى</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">العمر</label>
                            <input type="number" name="age" value="<?php echo intval($profile['age']??0); ?>" placeholder="العمر" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mr-2">المكان أو العنوان</label>
                            <input type="text" name="location" value="<?php echo htmlspecialchars($profile['location']??''); ?>" placeholder="المكان" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[2rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                        </div>
                    </div>
                    <button type="submit" class="px-10 py-4 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-xl shadow-mishkat-green-100 flex items-center gap-2">
                        <span class="material-icons-outlined">save</span>
                        حفظ بياناتي الجديدة
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="luxury-card rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                <h4 class="text-sm font-black text-gray-400 mb-6 uppercase tracking-widest">إنجازاتك الدراسية</h4>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-gray-600">المهام المكتملة</span>
                            <span class="text-lg font-black text-mishkat-green-700"><?php echo $completedTasks; ?>/<?php echo $totalTasks; ?></span>
                        </div>
                        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-mishkat-green-500 rounded-full transition-all duration-1000" style="width:<?php echo $totalTasks>0?round(($completedTasks/$totalTasks)*100):0; ?>%"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-amber-50 rounded-[2rem] border border-amber-100">
                        <span class="text-sm font-bold text-amber-900 flex items-center gap-2"><i class="fas fa-medal"></i> نقاط التميز</span>
                        <span class="text-xl font-black text-amber-600"><?php echo $completedTasks*10; ?></span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-[2rem] border border-gray-100">
                        <span class="text-sm font-bold text-gray-500">تاريخ الانضمام</span>
                        <span class="text-xs font-black text-gray-700"><?php echo date('Y/m/d', strtotime($profile['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="luxury-card rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
                <h4 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
                    <span class="material-icons-outlined text-amber-500">lock</span>
                    تغيير كلمة المرور
                </h4>
                <form id="passwordForm" class="space-y-4">
                    <input type="password" name="old_password" placeholder="كلمة المرور الحالية" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                    <input type="password" name="new_password" placeholder="الكلمة الجديدة" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-500/20 font-bold text-gray-700">
                    <button type="submit" class="w-full py-4 bg-gray-100 text-gray-700 rounded-[1.5rem] font-black hover:bg-gray-200 transition-all text-sm">تحديث كلمة السر</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.append('action', 'update_student_profile');
    fetch('api.php', { method:'POST', body:fd }).then(r=>r.json()).then(res => {
        if(res.success) {
            showToast('تم تحديث بياناتك بنجاح');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(res.message || 'حدث خطأ', 'error');
        }
    });
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.append('action', 'change_password');
    fetch('api.php', { method:'POST', body:fd }).then(r=>r.json()).then(res => {
        if(res.success) { 
            showToast('تم تغيير كلمة المرور بنجاح'); 
            this.reset(); 
        } else {
            showToast(res.message || 'حدث خطأ', 'error');
        }
    });
});
function uploadProfileImage(input) {
    if (input.files && input.files[0]) {
        const fd = new FormData();
        fd.append('action', 'update_profile_image');
        fd.append('profile_image', input.files[0]);

        showToast('جاري رفع الصورة...', 'info');

        fetch('api.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            if(res.success) {
                showToast('تم تحديث الصورة الشخصية بنجاح', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(res.message || 'فشل رفع الصورة', 'error');
            }
        });
    }
}
</script>
