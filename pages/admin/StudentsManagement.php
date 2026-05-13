<?php
// Admin Students Management - Dynamic
$students = $conn->query("SELECT u.id,u.name,u.email,u.phone,u.status,u.created_at,
    IFNULL(e.progress,0) as progress, IFNULL(c.title,'غير مسجل') as course_title, IFNULL(c.color,'gray') as course_color
    FROM users u LEFT JOIN enrollments e ON u.id=e.user_id LEFT JOIN courses c ON e.course_id=c.id 
    WHERE u.role='student' ORDER BY u.created_at DESC");
$totalStudents = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='student'")->fetch_assoc()['c'];
$activeStudents = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='student' AND status='active'")->fetch_assoc()['c'];
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div><h2 class="text-2xl font-black text-gray-900">إدارة الطلاب</h2><p class="text-gray-500 text-sm mt-1"><?php echo $totalStudents; ?> طالب • <?php echo $activeStudents; ?> نشط</p></div>
        <button onclick="document.getElementById('addStudentModal').classList.add('active')" class="flex items-center gap-2 px-5 py-2.5 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined text-sm">person_add</span> إضافة طالب
        </button>
    </div>

    <div class="luxury-card p-3 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row gap-3 items-center">
        <div class="flex-1 relative w-full">
            <span class="material-icons-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            <input type="text" id="searchStudents" placeholder="البحث عن طالب..." class="w-full pr-10 pl-4 py-2.5 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold">
        </div>
    </div>

    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-right">
            <thead><tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-xs font-bold text-gray-500">الطالب</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 hidden md:table-cell">المسار</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 hidden md:table-cell">التقدم</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500">الحالة</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500">إجراءات</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50" id="studentsTable">
                <?php while($s = $students->fetch_assoc()): ?>
                <tr class="student-row hover:bg-gray-50/50 transition-all" data-name="<?php echo htmlspecialchars($s['name']); ?>">
                    <td class="px-6 py-4"><div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-mishkat-green-100 text-mishkat-green-700 rounded-[1.5rem] flex items-center justify-center font-bold"><?php echo mb_substr($s['name'],0,1,'UTF-8'); ?></div>
                        <div><p class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($s['name']); ?></p><p class="text-[10px] text-gray-400"><?php echo $s['email']; ?></p></div>
                    </div></td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-600 hidden md:table-cell"><?php echo htmlspecialchars($s['course_title']); ?></td>
                    <td class="px-6 py-4 hidden md:table-cell"><div class="flex items-center gap-2"><div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-mishkat-green-500 rounded-full" style="width:<?php echo $s['progress']; ?>%"></div></div><span class="text-xs font-bold text-gray-500"><?php echo $s['progress']; ?>%</span></div></td>
                    <td class="px-6 py-4">
                        <button onclick="toggleStudentStatus(<?php echo $s['id']; ?>)" class="flex items-center gap-1">
                            <div class="w-2 h-2 rounded-full <?php echo $s['status']==='active'?'bg-mishkat-green-500':'bg-red-500'; ?>"></div>
                            <span class="text-xs font-bold"><?php echo $s['status']==='active'?'نشط':'معلق'; ?></span>
                        </button>
                    </td>
                    <td class="px-6 py-4"><div class="flex gap-1">
                        <button onclick="deleteStudent(<?php echo $s['id']; ?>)" class="p-2 bg-gray-50 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all"><span class="material-icons-outlined text-sm">delete</span></button>
                    </div></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="addStudentModal">
    <div class="modal-box">
        <h3 class="text-lg font-black text-gray-900 mb-4">إضافة طالب جديد</h3>
        <form id="addStudentForm" class="space-y-4">
            <input type="text" name="name" placeholder="الاسم" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="text" name="phone" placeholder="الهاتف" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="hidden" name="role" value="student">
            <input type="password" name="password" placeholder="كلمة المرور" value="123456" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addStudentModal').classList.remove('active')" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[1.5rem] font-bold">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold">إضافة</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('searchStudents').addEventListener('input', function(e) {
    const q=e.target.value.trim().toLowerCase();
    document.querySelectorAll('.student-row').forEach(r => { r.style.display=r.dataset.name.toLowerCase().includes(q)?'':'none'; });
});
function toggleStudentStatus(id) { apiCall('toggle_user_status',{user_id:id}).then(res => { if(res.success) { showToast('تم تغيير الحالة'); setTimeout(()=>location.reload(),500); } }); }
function deleteStudent(id) { confirmDialog('هل تريد حذف هذا الطالب؟').then(ok => { if(ok) apiCall('delete_user',{user_id:id}).then(res => { if(res.success) { showToast('تم الحذف'); setTimeout(()=>location.reload(),500); } }); }); }
document.getElementById('addStudentForm').addEventListener('submit', function(e) {
    e.preventDefault(); const fd=new FormData(this); fd.append('action','add_user');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { showToast('تم إضافة الطالب'); setTimeout(()=>location.reload(),500); }
        else showToast(res.message||'خطأ','error');
    });
});
</script>
