<?php
// Admin Accounts Management - Dynamic
$totalUsers = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$studentsCount = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='student'")->fetch_assoc()['c'];
$teachersCount = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='teacher'")->fetch_assoc()['c'];
$parentsCount = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='parent'")->fetch_assoc()['c'];
$users = $conn->query("SELECT id,name,email,phone,role,status,created_at FROM users ORDER BY created_at DESC");
$roleNames = ['admin'=>'مدير','teacher'=>'معلم','student'=>'طالب','parent'=>'ولي أمر'];
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div><h2 class="text-2xl font-black text-gray-900">إدارة الحسابات</h2><p class="text-gray-500 text-sm mt-1">التحكم المركزي بجميع مستخدمي المنصة</p></div>
        <button onclick="document.getElementById('addUserModal').classList.add('active')" class="flex items-center gap-2 px-5 py-2.5 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined text-sm">add</span> إضافة حساب
        </button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-mishkat-green-900 p-5 rounded-[2rem] text-white shadow-lg relative overflow-hidden">
            <p class="text-mishkat-green-300 text-[10px] font-bold uppercase tracking-widest mb-1">إجمالي المستخدمين</p>
            <h3 class="text-3xl font-black"><?php echo $totalUsers; ?></h3>
            <span class="material-icons-outlined absolute top-3 left-3 text-mishkat-green-800 opacity-30" style="font-size:40px">people</span>
        </div>
        <div class="luxury-card p-5 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-[1.5rem] bg-blue-50 text-blue-600 flex items-center justify-center mb-2"><span class="material-icons-outlined text-lg">school</span></div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">الطلاب</p><h3 class="text-xl font-black text-gray-900"><?php echo $studentsCount; ?></h3>
        </div>
        <div class="luxury-card p-5 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-[1.5rem] bg-amber-50 text-amber-600 flex items-center justify-center mb-2"><span class="material-icons-outlined text-lg">groups</span></div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">المعلمون</p><h3 class="text-xl font-black text-gray-900"><?php echo $teachersCount; ?></h3>
        </div>
        <div class="luxury-card p-5 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-[1.5rem] bg-purple-50 text-purple-600 flex items-center justify-center mb-2"><span class="material-icons-outlined text-lg">family_restroom</span></div>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">أولياء أمور</p><h3 class="text-xl font-black text-gray-900"><?php echo $parentsCount; ?></h3>
        </div>
    </div>

    <div class="luxury-card p-3 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col md:flex-row gap-3 items-center">
        <div class="flex-1 relative w-full">
            <span class="material-icons-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            <input type="text" id="searchUsers" placeholder="البحث..." class="w-full pr-10 pl-4 py-2.5 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold">
        </div>
        <select id="roleFilter" onchange="filterByRole()" class="px-4 py-2.5 bg-gray-50 rounded-[1.5rem] text-sm font-bold outline-none">
            <option value="">جميع الأدوار</option>
            <option value="student">طلاب</option><option value="teacher">معلمون</option><option value="parent">أولياء أمور</option><option value="admin">مدراء</option>
        </select>
    </div>

    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-right">
            <thead><tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">المستخدم</th>
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">الدور</th>
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest hidden md:table-cell">تاريخ الانضمام</th>
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">الحالة</th>
                <th class="px-6 py-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">إجراءات</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50" id="usersTable">
                <?php while($u = $users->fetch_assoc()): 
                    $roleColor = ['admin'=>'red','teacher'=>'emerald','student'=>'blue','parent'=>'amber'][$u['role']]??'gray';
                ?>
                <tr class="user-row hover:bg-gray-50/50 transition-all" data-name="<?php echo htmlspecialchars($u['name']); ?>" data-role="<?php echo $u['role']; ?>" data-id="<?php echo $u['id']; ?>">
                    <td class="px-6 py-4"><div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-mishkat-green-100 text-mishkat-green-700 rounded-[1.5rem] flex items-center justify-center font-bold"><?php echo mb_substr($u['name'],0,1,'UTF-8'); ?></div>
                        <div><p class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($u['name']); ?></p><p class="text-[10px] text-gray-400"><?php echo $u['email']; ?></p></div>
                    </div></td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $roleColor; ?>-50 text-<?php echo $roleColor; ?>-600"><?php echo $roleNames[$u['role']]; ?></span></td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-400 hidden md:table-cell"><?php echo date('Y/m/d', strtotime($u['created_at'])); ?></td>
                    <td class="px-6 py-4">
                        <button onclick="toggleStatus(<?php echo $u['id']; ?>)" class="flex items-center gap-1 cursor-pointer">
                            <div class="w-2 h-2 rounded-full <?php echo $u['status']==='active'?'bg-mishkat-green-500':'bg-red-500'; ?>"></div>
                            <span class="text-xs font-bold"><?php echo $u['status']==='active'?'نشط':'معلق'; ?></span>
                        </button>
                    </td>
                    <td class="px-6 py-4"><div class="flex gap-1">
                        <button onclick="deleteUser(<?php echo $u['id']; ?>)" class="p-2 bg-gray-50 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all"><span class="material-icons-outlined text-sm">delete</span></button>
                    </div></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-backdrop" id="addUserModal">
    <div class="modal-box">
        <h3 class="text-lg font-black text-gray-900 mb-4">إضافة مستخدم</h3>
        <form id="addUserForm" class="space-y-4">
            <input type="text" name="name" placeholder="الاسم" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="text" name="phone" placeholder="الهاتف" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="password" name="password" placeholder="كلمة المرور" value="123456" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <select name="role" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold"><option value="student">طالب</option><option value="teacher">معلم</option><option value="parent">ولي أمر</option></select>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addUserModal').classList.remove('active')" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[1.5rem] font-bold">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold">إضافة</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('searchUsers').addEventListener('input', function(e) {
    const q=e.target.value.trim().toLowerCase();
    document.querySelectorAll('.user-row').forEach(r => { r.style.display=r.dataset.name.toLowerCase().includes(q)?'':'none'; });
});
function filterByRole() {
    const role=document.getElementById('roleFilter').value;
    document.querySelectorAll('.user-row').forEach(r => { r.style.display=(!role||r.dataset.role===role)?'':'none'; });
}
function toggleStatus(id) {
    apiCall('toggle_user_status',{user_id:id}).then(res => {
        if(res.success) { showToast('تم تغيير الحالة'); setTimeout(()=>location.reload(),500); }
    });
}
function deleteUser(id) {
    confirmDialog('هل تريد حذف هذا المستخدم؟').then(ok => {
        if(ok) apiCall('delete_user',{user_id:id}).then(res => { if(res.success) { showToast('تم الحذف'); setTimeout(()=>location.reload(),500); } });
    });
}
document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd=new FormData(this); fd.append('action','add_user');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { showToast('تم إضافة المستخدم'); setTimeout(()=>location.reload(),500); }
        else showToast(res.message||'خطأ','error');
    });
});
</script>
