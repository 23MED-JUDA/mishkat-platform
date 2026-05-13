<?php
// Teacher Students Page - Dynamic from DB
$students = $conn->query("SELECT u.id,u.name,u.email,u.phone,u.status,u.created_at,
    IFNULL(e.progress,0) as progress, IFNULL(c.title,'غير مسجل') as course_title
    FROM users u 
    LEFT JOIN enrollments e ON u.id=e.user_id 
    LEFT JOIN courses c ON e.course_id=c.id 
    WHERE u.role='student' ORDER BY u.created_at DESC");
$totalStudents = $students->num_rows;
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div><h2 class="text-2xl font-black text-gray-900">سجل الطلاب</h2><p class="text-gray-500 text-sm mt-1">لديك <?php echo $totalStudents; ?> طالب مسجل</p></div>
    </div>

    <div class="luxury-card p-3 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row gap-3 items-center">
        <div class="flex-1 relative w-full">
            <span class="material-icons-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
            <input type="text" id="searchStudents" placeholder="البحث عن طالب..." class="w-full pr-10 pl-4 py-2.5 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold">
        </div>
    </div>

    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
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
                        <div class="w-9 h-9 rounded-lg bg-mishkat-green-50 text-mishkat-green-600 flex items-center justify-center text-sm font-bold"><?php echo mb_substr($s['name'],0,1,'UTF-8'); ?></div>
                        <div><p class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($s['name']); ?></p><p class="text-[10px] text-gray-400"><?php echo $s['email']; ?></p></div>
                    </div></td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-600 hidden md:table-cell"><?php echo htmlspecialchars($s['course_title']); ?></td>
                    <td class="px-6 py-4 hidden md:table-cell"><div class="flex items-center gap-2"><div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-mishkat-green-500 rounded-full" style="width:<?php echo $s['progress']; ?>%"></div></div><span class="text-xs font-bold text-gray-500"><?php echo $s['progress']; ?>%</span></div></td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded-lg text-[10px] font-black <?php echo $s['status']==='active'?'bg-mishkat-green-50 text-mishkat-green-600':'bg-red-50 text-red-600'; ?>"><?php echo $s['status']==='active'?'نشط':'معلق'; ?></span></td>
                    <td class="px-6 py-4"><div class="flex gap-1">
                        <button class="p-2 bg-gray-50 rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-all"><span class="material-icons-outlined text-sm">visibility</span></button>
                    </div></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('searchStudents').addEventListener('input', function(e) {
    const q = e.target.value.trim().toLowerCase();
    document.querySelectorAll('.student-row').forEach(row => {
        row.style.display = row.dataset.name.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
