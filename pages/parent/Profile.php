<?php
// Parent Profile - Dynamic
$profile = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
$children = $conn->query("SELECT u.id,u.name,u.email,u.status FROM parent_student ps JOIN users u ON ps.student_id=u.id WHERE ps.parent_id=$uid");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="bg-gradient-to-l from-mishkat-green-800 to-mishkat-green-900 rounded-[2rem] p-8 text-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="w-24 h-24 bg-white/10 border-2 border-white/20 rounded-[2rem] flex items-center justify-center text-4xl font-black"><?php echo mb_substr($profile['name'],0,1,'UTF-8'); ?></div>
            <div>
                <h1 class="text-2xl font-black"><?php echo htmlspecialchars($profile['name']); ?></h1>
                <p class="text-mishkat-green-200 text-sm font-medium mt-1"><?php echo $profile['email']; ?></p>
                <span class="inline-block px-3 py-1 bg-white/10 rounded-lg text-xs font-bold mt-3">ولي أمر</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-black text-gray-900 mb-6">تعديل البيانات</h3>
            <form id="profileForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="text-xs font-bold text-gray-500 mb-1 block">الاسم</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold"></div>
                    <div><label class="text-xs font-bold text-gray-500 mb-1 block">الهاتف</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone']??''); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold"></div>
                    <div><label class="text-xs font-bold text-gray-500 mb-1 block">الموقع</label>
                        <input type="text" name="location" value="<?php echo htmlspecialchars($profile['location']??''); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold"></div>
                    <div><label class="text-xs font-bold text-gray-500 mb-1 block">النوع</label>
                        <select name="gender" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold">
                            <option value="ذكر" <?php echo $profile['gender']==='ذكر'?'selected':''; ?>>ذكر</option>
                            <option value="أنثى" <?php echo $profile['gender']==='أنثى'?'selected':''; ?>>أنثى</option>
                        </select></div>
                </div>
                <button type="submit" class="px-8 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">حفظ التعديلات</button>
            </form>
        </div>

        <div class="space-y-4">
            <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
                <h4 class="text-sm font-bold text-gray-400 mb-4">الأبناء المسجلون</h4>
                <div class="space-y-3">
                    <?php while($ch = $children->fetch_assoc()): ?>
                    <div class="flex items-center gap-3 p-3 rounded-[1.5rem] bg-gray-50">
                        <div class="w-8 h-8 rounded-lg bg-mishkat-green-100 text-mishkat-green-600 flex items-center justify-center text-sm font-bold"><?php echo mb_substr($ch['name'],0,1,'UTF-8'); ?></div>
                        <div><p class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($ch['name']); ?></p><p class="text-[10px] text-gray-400"><?php echo $ch['email']; ?></p></div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
                <h4 class="text-sm font-bold text-gray-400 mb-3">تغيير كلمة المرور</h4>
                <form id="passwordForm" class="space-y-3">
                    <input type="password" name="old_password" placeholder="الحالية" class="w-full px-4 py-2.5 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
                    <input type="password" name="new_password" placeholder="الجديدة" class="w-full px-4 py-2.5 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
                    <button type="submit" class="w-full py-2.5 bg-gray-100 text-gray-700 rounded-[1.5rem] font-bold hover:bg-gray-200 text-sm">تحديث</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault(); const fd=new FormData(this); fd.append('action','update_profile');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => { if(res.success) showToast('تم التحديث'); else showToast(res.message||'خطأ','error'); });
});
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault(); const fd=new FormData(this); fd.append('action','change_password');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => { if(res.success) { showToast('تم تغيير كلمة المرور'); this.reset(); } else showToast(res.message||'خطأ','error'); });
});
</script>
