<?php
// Teacher Evaluation - Dynamic
$students = $conn->query("SELECT id,name FROM users WHERE role='student' ORDER BY name");
$evaluations = $conn->query("SELECT ev.*,u.name as student_name FROM evaluations ev JOIN users u ON ev.student_id=u.id WHERE ev.teacher_id=$uid ORDER BY ev.created_at DESC");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <div><h2 class="text-2xl font-black text-gray-900">التقييم الأكاديمي</h2><p class="text-gray-500 text-sm mt-1">تقييم أداء الطلاب في الحفظ والتجويد</p></div>
        <button onclick="document.getElementById('addEvalModal').classList.add('active')" class="flex items-center gap-2 px-5 py-2.5 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined text-sm">add</span> تقييم جديد
        </button>
    </div>

    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-right">
            <thead><tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-xs font-bold text-gray-500">الطالب</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500">الحفظ</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500">التجويد</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500">السلوك</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500">الحضور</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500">التاريخ</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                <?php while($ev = $evaluations->fetch_assoc()): $avg = round(($ev['memorization']+$ev['tajweed']+$ev['behavior']+$ev['attendance'])/4); ?>
                <tr class="hover:bg-gray-50/50 transition-all">
                    <td class="px-6 py-4"><div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-mishkat-green-50 text-mishkat-green-600 flex items-center justify-center text-sm font-bold"><?php echo mb_substr($ev['student_name'],0,1,'UTF-8'); ?></div>
                        <span class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($ev['student_name']); ?></span>
                    </div></td>
                    <td class="px-6 py-4"><div class="flex items-center gap-2"><div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-mishkat-green-500 rounded-full" style="width:<?php echo $ev['memorization']; ?>%"></div></div><span class="text-xs font-bold text-gray-500"><?php echo $ev['memorization']; ?></span></div></td>
                    <td class="px-6 py-4"><div class="flex items-center gap-2"><div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-blue-500 rounded-full" style="width:<?php echo $ev['tajweed']; ?>%"></div></div><span class="text-xs font-bold text-gray-500"><?php echo $ev['tajweed']; ?></span></div></td>
                    <td class="px-6 py-4"><div class="flex items-center gap-2"><div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-amber-500 rounded-full" style="width:<?php echo $ev['behavior']; ?>%"></div></div><span class="text-xs font-bold text-gray-500"><?php echo $ev['behavior']; ?></span></div></td>
                    <td class="px-6 py-4"><div class="flex items-center gap-2"><div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-purple-500 rounded-full" style="width:<?php echo $ev['attendance']; ?>%"></div></div><span class="text-xs font-bold text-gray-500"><?php echo $ev['attendance']; ?></span></div></td>
                    <td class="px-6 py-4 text-xs font-bold text-gray-400"><?php echo date('Y/m/d', strtotime($ev['created_at'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="addEvalModal">
    <div class="modal-box max-w-lg">
        <h3 class="text-lg font-black text-gray-900 mb-4">تقييم طالب</h3>
        <form id="evalForm" class="space-y-4">
            <select name="student_id" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold">
                <option value="">اختر الطالب</option>
                <?php $students->data_seek(0); while($s=$students->fetch_assoc()): ?>
                <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
                <?php endwhile; ?>
            </select>
            <?php foreach(['memorization'=>'الحفظ','tajweed'=>'التجويد','behavior'=>'السلوك','attendance'=>'الحضور'] as $k=>$v): ?>
            <div><label class="text-xs font-bold text-gray-500 mb-1 block"><?php echo $v; ?> (0-100)</label>
                <input type="range" name="<?php echo $k; ?>" min="0" max="100" value="75" class="w-full" oninput="this.nextElementSibling.innerText=this.value+'%'"><span class="text-xs font-bold text-mishkat-green-600">75%</span></div>
            <?php endforeach; ?>
            <textarea name="notes" placeholder="ملاحظات" rows="2" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold outline-none"></textarea>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addEvalModal').classList.remove('active')" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[1.5rem] font-bold">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold">حفظ التقييم</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('evalForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this); fd.append('action','add_evaluation');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { showToast('تم حفظ التقييم'); setTimeout(()=>location.reload(),500); }
        else showToast(res.message||'خطأ','error');
    });
});
</script>
