<?php
// Admin Settings - Dynamic
$settings = [];
$r = $conn->query("SELECT * FROM settings ORDER BY id");
while($s = $r->fetch_assoc()) $settings[$s['setting_key']] = $s['setting_value'];
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <h2 class="text-2xl font-black text-gray-900">إعدادات النظام</h2>

    <form id="settingsForm" class="space-y-6">
        <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><span class="material-icons-outlined text-mishkat-green-600">settings</span>الإعدادات العامة</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="text-xs font-bold text-gray-500 mb-1 block">اسم الموقع</label>
                    <input type="text" name="site_name" value="<?php echo htmlspecialchars($settings['site_name']??'أكاديمية مشكاة'); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold"></div>
                <div><label class="text-xs font-bold text-gray-500 mb-1 block">البريد الإلكتروني</label>
                    <input type="email" name="site_email" value="<?php echo htmlspecialchars($settings['site_email']??''); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold"></div>
                <div><label class="text-xs font-bold text-gray-500 mb-1 block">رقم الهاتف</label>
                    <input type="text" name="site_phone" value="<?php echo htmlspecialchars($settings['site_phone']??''); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold"></div>
                <div><label class="text-xs font-bold text-gray-500 mb-1 block">العام الدراسي</label>
                    <input type="text" name="academic_year" value="<?php echo htmlspecialchars($settings['academic_year']??''); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold"></div>
            </div>
        </div>

        <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2"><span class="material-icons-outlined text-blue-600">tune</span>إعدادات التسجيل</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="text-xs font-bold text-gray-500 mb-1 block">التسجيل مفتوح</label>
                    <select name="registration_open" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold">
                        <option value="1" <?php echo ($settings['registration_open']??'1')==='1'?'selected':''; ?>>نعم</option>
                        <option value="0" <?php echo ($settings['registration_open']??'1')==='0'?'selected':''; ?>>لا</option>
                    </select></div>
                <div><label class="text-xs font-bold text-gray-500 mb-1 block">أقصى عدد طلاب لكل حلقة</label>
                    <input type="number" name="max_students_per_circle" value="<?php echo htmlspecialchars($settings['max_students_per_circle']??'20'); ?>" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold"></div>
            </div>
        </div>

        <button type="submit" class="px-8 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100 flex items-center gap-2">
            <span class="material-icons-outlined text-sm">save</span> حفظ الإعدادات
        </button>
    </form>
</div>

<script>
document.getElementById('settingsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this); fd.append('action','update_settings');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) showToast('تم حفظ الإعدادات بنجاح');
        else showToast(res.message||'خطأ','error');
    });
});
</script>
