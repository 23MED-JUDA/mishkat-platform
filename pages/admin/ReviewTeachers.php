<?php
// Admin Review Teachers - Enhanced for Approval Flow
$teachersQuery = "SELECT u.id, u.name, u.email, u.phone, u.status, u.created_at, u.gender, u.location,
    ti.specialty, ti.experience_years, ti.cv_url, ti.bio, ti.rating
    FROM users u 
    LEFT JOIN teachers_info ti ON u.id = ti.user_id 
    WHERE u.role = 'teacher' 
    ORDER BY FIELD(u.status, 'pending', 'active', 'suspended'), u.created_at DESC";
$teachers = $conn->query($teachersQuery);

if (!$teachers) {
    echo "<div class='p-10 luxury-card rounded-3xl border border-red-100 bg-red-50 text-red-700 font-bold'>خطأ في قاعدة البيانات: " . $conn->error . "</div>";
    return;
}
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-black text-gray-900">مراجعة المعلمين</h2>
            <p class="text-sm text-gray-500 font-bold mt-1">إدارة طلبات الانضمام والموافقة على حسابات المعلمين</p>
        </div>
        <div class="flex gap-2">
            <span class="px-4 py-2 bg-mishkat-green-50 text-mishkat-green-700 rounded-[1.5rem] text-xs font-black border border-mishkat-green-100">بانتظار المراجعة</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if($teachers->num_rows === 0): ?>
            <div class="col-span-full p-20 text-center luxury-card rounded-3xl border border-dashed border-gray-200">
                <span class="material-icons-outlined text-6xl text-gray-200 mb-4">person_search</span>
                <p class="text-gray-400 font-bold">لا توجد طلبات انضمام حالياً</p>
            </div>
        <?php endif; ?>

        <?php while($t = $teachers->fetch_assoc()): 
            $isPending = ($t['status'] === 'pending');
        ?>
        <div class="luxury-card rounded-[2.5rem] shadow-sm border <?php echo $isPending ? 'border-amber-200 bg-amber-50/10' : 'border-gray-100'; ?> p-8 hover:shadow-xl transition-all group relative overflow-hidden">
            
            <?php if($isPending): ?>
            <div class="absolute top-0 left-0 px-4 py-1 bg-amber-500 text-white text-[10px] font-black rounded-br-2xl">طلب جديد</div>
            <?php endif; ?>

            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-[2rem] bg-mishkat-green-700 text-white flex items-center justify-center text-3xl font-black shadow-lg shadow-mishkat-green-100 group-hover:rotate-6 transition-transform">
                        <?php echo mb_substr($t['name'], 0, 1, 'UTF-8'); ?>
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 text-lg"><?php echo htmlspecialchars($t['name']); ?></h3>
                        <p class="text-xs text-mishkat-green-600 font-bold"><?php echo htmlspecialchars($t['specialty'] ?? 'تخصص غير محدد'); ?></p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="p-3 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">الخبرة</p>
                    <p class="text-sm font-black text-gray-700"><?php echo $t['experience_years'] ?? 0; ?> سنوات</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">الموقع</p>
                    <p class="text-sm font-black text-gray-700 line-clamp-1"><?php echo htmlspecialchars($t['location'] ?? '-'); ?></p>
                </div>
                <div class="p-3 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">النوع</p>
                    <p class="text-sm font-black text-gray-700"><?php echo htmlspecialchars($t['gender'] ?? 'ذكر'); ?></p>
                </div>
                <div class="p-3 bg-gray-50 rounded-[2rem] border border-gray-100">
                    <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">التقييم</p>
                    <p class="text-sm font-black text-gray-700 flex items-center gap-1"><span class="material-icons-outlined text-xs text-yellow-500">star</span> <?php echo $t['rating'] ?? '5.00'; ?></p>
                </div>
            </div>

            <?php if($t['cv_url']): ?>
            <a href="<?php echo htmlspecialchars($t['cv_url']); ?>" target="_blank" class="w-full py-3 mb-6 bg-mishkat-green-50 text-mishkat-green-700 rounded-[1.5rem] text-sm font-black flex items-center justify-center gap-2 hover:bg-mishkat-green-100 transition-all border border-mishkat-green-200">
                <span class="material-icons-outlined text-sm">description</span>
                عرض الـ CV الخاص بالمعلم
            </a>
            <?php endif; ?>

            <div class="flex gap-3">
                <?php if($isPending): ?>
                <button onclick="updateStatus(<?php echo $t['id']; ?>, 'active')" class="flex-1 py-4 bg-mishkat-green-600 text-white rounded-[2rem] text-sm font-black hover:bg-mishkat-green-700 shadow-lg shadow-mishkat-green-100 transition-all">قبول المعلم</button>
                <button onclick="updateStatus(<?php echo $t['id']; ?>, 'suspended')" class="px-4 py-4 bg-red-50 text-red-600 rounded-[2rem] text-sm font-black hover:bg-red-100 transition-all"><span class="material-icons-outlined">close</span></button>
                <?php else: ?>
                <button onclick="updateStatus(<?php echo $t['id']; ?>, '<?php echo $t['status'] === 'active' ? 'suspended' : 'active'; ?>')" 
                    class="flex-1 py-3 px-4 border border-gray-100 rounded-[2rem] text-sm font-black <?php echo $t['status'] === 'active' ? 'text-amber-600 bg-amber-50' : 'text-mishkat-green-600 bg-mishkat-green-50'; ?> hover:opacity-80 transition-all">
                    <?php echo $t['status'] === 'active' ? 'تعليق الحساب' : 'تنشيط الحساب'; ?>
                </button>
                <button onclick="deleteTeacher(<?php echo $t['id']; ?>)" class="px-4 py-3 bg-gray-50 text-gray-400 rounded-[2rem] hover:bg-red-50 hover:text-red-500 transition-all border border-gray-100">
                    <span class="material-icons-outlined text-sm">delete</span>
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
function updateStatus(id, newStatus) {
    apiCall('toggle_user_status', {user_id: id, force_status: newStatus}).then(res => {
        if(res.success) {
            showToast(newStatus === 'active' ? 'تم قبول المعلم بنجاح' : 'تم تحديث الحالة');
            setTimeout(() => location.reload(), 800);
        } else {
            showToast(res.message || 'خطأ في تنفيذ الإجراء', 'error');
        }
    });
}

function deleteTeacher(id) {
    confirmDialog('هل أنت متأكد من حذف هذا الحساب نهائياً؟').then(ok => {
        if(ok) apiCall('delete_user', {user_id: id}).then(res => {
            if(res.success) {
                showToast('تم حذف المعلم');
                setTimeout(() => location.reload(), 800);
            }
        });
    });
}
</script>
