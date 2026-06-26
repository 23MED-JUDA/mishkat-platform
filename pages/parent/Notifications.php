<?php
// Parent Notifications - Dynamic
$notifications = $conn->query("SELECT * FROM notifications WHERE user_id=$uid ORDER BY created_at DESC");
$unreadCount = $conn->query("SELECT COUNT(*) as c FROM notifications WHERE user_id=$uid AND is_read=0")->fetch_assoc()['c'];
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <div><h2 class="text-2xl font-black text-gray-900">الإشعارات</h2>
            <p class="text-gray-500 text-sm mt-1"><?php echo $unreadCount; ?> إشعار غير مقروء</p></div>
        <button onclick="markAllReadParent()" class="px-5 py-2.5 bg-mishkat-green-50 text-mishkat-green-700 rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-100 transition-all">
            <span class="material-icons-outlined text-sm align-middle">done_all</span> قراءة الكل
        </button>
    </div>

    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="divide-y divide-gray-50">
            <?php while($n = $notifications->fetch_assoc()): 
                $ti=['success'=>'check_circle','alert'=>'error','system'=>'info','msg'=>'chat'][$n['type']]??'info';
                $tc=['success'=>'emerald','alert'=>'red','system'=>'blue','msg'=>'purple'][$n['type']]??'gray';
            ?>
            <div class="p-5 flex items-start gap-4 hover:bg-gray-50/50 transition-all <?php echo $n['is_read']?'':'bg-mishkat-green-50/20'; ?>" id="notif-<?php echo $n['id']; ?>">
                <div class="w-10 h-10 rounded-[1.5rem] bg-<?php echo $tc; ?>-50 text-<?php echo $tc; ?>-600 flex items-center justify-center shrink-0">
                    <span class="material-icons-outlined"><?php echo $ti; ?></span>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800"><?php echo htmlspecialchars($n['title']); ?></h4>
                    <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($n['message']); ?></p>
                    <p class="text-[10px] text-gray-400 mt-2"><?php echo date('Y/m/d H:i', strtotime($n['created_at'])); ?></p>
                </div>
                <?php if(!$n['is_read']): ?>
                <button onclick="markOneRead(<?php echo $n['id']; ?>)" class="p-2 text-gray-300 hover:text-mishkat-green-600 transition-colors shrink-0" title="تحديد كمقروء">
                    <span class="material-icons-outlined text-sm">check</span>
                </button>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<script>
function markOneRead(id) {
    apiCall('read_notification',{notif_id:id}).then(res => {
        if(res.success) { document.getElementById('notif-'+id).classList.remove('bg-mishkat-green-50/20'); showToast('تم'); }
    });
}
function markAllReadParent() {
    apiCall('read_all_notifications').then(res => { if(res.success) { showToast('تم قراءة الكل'); setTimeout(()=>location.reload(),500); } });
}
</script>
