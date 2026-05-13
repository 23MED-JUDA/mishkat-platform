<?php
// Admin Circles Management - Dynamic
$circles = $conn->query("SELECT ci.*,u.name as teacher_name,(SELECT COUNT(*) FROM circle_students WHERE circle_id=ci.id) as current_students FROM circles ci JOIN users u ON ci.teacher_id=u.id ORDER BY ci.created_at DESC");
$teachers = $conn->query("SELECT id,name FROM users WHERE role='teacher' ORDER BY name");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-black text-gray-900">تنظيم الحلقات</h2>
        <button onclick="document.getElementById('addCircleModal').classList.add('active')" class="flex items-center gap-2 px-5 py-2.5 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined text-sm">add</span> حلقة جديدة
        </button>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php while($ci = $circles->fetch_assoc()): $sc=['active'=>'emerald','paused'=>'amber','completed'=>'gray'][$ci['status']]??'gray'; $sn=['active'=>'نشطة','paused'=>'متوقفة','completed'=>'مكتملة'][$ci['status']]; ?>
        <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all">
            <div class="flex items-start justify-between mb-3">
                <div class="w-12 h-12 rounded-[1.5rem] bg-mishkat-green-50 text-mishkat-green-600 flex items-center justify-center"><span class="material-icons-outlined">groups</span></div>
                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $sc; ?>-50 text-<?php echo $sc; ?>-600"><?php echo $sn; ?></span>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-1"><?php echo htmlspecialchars($ci['name']); ?></h3>
            <p class="text-xs text-gray-400 mb-3">المعلم: <?php echo htmlspecialchars($ci['teacher_name']); ?></p>
            <div class="space-y-1 text-xs text-gray-500">
                <div class="flex items-center gap-2"><span class="material-icons-outlined text-sm">people</span><?php echo $ci['current_students']; ?>/<?php echo $ci['max_students']; ?> طالب</div>
                <div class="flex items-center gap-2"><span class="material-icons-outlined text-sm">schedule</span><?php echo htmlspecialchars($ci['schedule']??''); ?></div>
            </div>
            <div class="flex gap-2 mt-4 pt-3 border-t border-gray-50">
                <button onclick="deleteCircle(<?php echo $ci['id']; ?>)" class="py-2 px-3 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition-all"><span class="material-icons-outlined text-sm">delete</span></button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<div class="modal-backdrop" id="addCircleModal">
    <div class="modal-box">
        <h3 class="text-lg font-black text-gray-900 mb-4">إضافة حلقة</h3>
        <form id="circleForm" class="space-y-4">
            <input type="text" name="name" placeholder="اسم الحلقة" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <select name="teacher_id" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold">
                <option value="">اختر المعلم</option>
                <?php $teachers->data_seek(0); while($t=$teachers->fetch_assoc()): ?>
                <option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['name']); ?></option>
                <?php endwhile; ?>
            </select>
            <input type="number" name="max_students" placeholder="أقصى عدد" value="20" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="text" name="schedule" placeholder="الجدول" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addCircleModal').classList.remove('active')" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[1.5rem] font-bold">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold">إضافة</button>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('circleForm').addEventListener('submit', function(e) {
    e.preventDefault(); const fd=new FormData(this); fd.append('action','add_circle');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { showToast('تم إضافة الحلقة'); setTimeout(()=>location.reload(),500); } else showToast(res.message||'خطأ','error');
    });
});
function deleteCircle(id) { confirmDialog('هل تريد حذف هذه الحلقة؟').then(ok => { if(ok) apiCall('delete_circle',{circle_id:id}).then(res => { if(res.success) { showToast('تم'); setTimeout(()=>location.reload(),500); } }); }); }
</script>
