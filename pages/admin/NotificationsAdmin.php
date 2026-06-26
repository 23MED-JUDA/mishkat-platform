<?php
// Admin Notifications - Dynamic
$notifications = $conn->query("SELECT n.*,u.name as user_name FROM notifications n JOIN users u ON n.user_id=u.id ORDER BY n.created_at DESC LIMIT 50");
$allUsers = $conn->query("SELECT id,name,role FROM users ORDER BY name");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-black text-gray-900">إدارة الإشعارات</h2>
        <button onclick="document.getElementById('sendNotifModal').classList.add('active')" class="flex items-center gap-2 px-5 py-2.5 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined text-sm">send</span> إرسال إشعار
        </button>
    </div>

    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-black text-gray-900">جميع الإشعارات</h3>
            <span class="text-xs text-gray-400 font-bold"><?php echo $notifications->num_rows; ?> إشعار</span>
        </div>
        <div class="divide-y divide-gray-50">
            <?php while($n = $notifications->fetch_assoc()): 
                $typeIcons=['success'=>'check_circle','alert'=>'error','system'=>'info','msg'=>'chat'];
                $typeColors=['success'=>'emerald','alert'=>'red','system'=>'blue','msg'=>'purple'];
                $ti=$typeIcons[$n['type']]??'info'; $tc=$typeColors[$n['type']]??'gray';
            ?>
            <div class="p-4 flex items-start gap-4 hover:bg-gray-50/50 transition-all <?php echo $n['is_read']?'':'bg-mishkat-green-50/20'; ?>">
                <div class="w-9 h-9 rounded-lg bg-<?php echo $tc; ?>-50 text-<?php echo $tc; ?>-600 flex items-center justify-center shrink-0">
                    <span class="material-icons-outlined text-lg"><?php echo $ti; ?></span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($n['title']); ?></h4>
                        <span class="text-[10px] text-gray-400 font-bold">→ <?php echo htmlspecialchars($n['user_name']); ?></span>
                    </div>
                    <p class="text-xs text-gray-500 line-clamp-1"><?php echo htmlspecialchars($n['message']); ?></p>
                    <p class="text-[10px] text-gray-400 mt-1"><?php echo date('Y/m/d H:i', strtotime($n['created_at'])); ?></p>
                </div>
                <?php if(!$n['is_read']): ?><span class="w-2 h-2 bg-mishkat-green-500 rounded-full shrink-0 mt-2"></span><?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="sendNotifModal">
    <div class="modal-box">
        <h3 class="text-lg font-black text-gray-900 mb-4">إرسال إشعار</h3>
        <form id="notifForm" class="space-y-4">
            <select name="to_user" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold">
                <option value="">اختر المستخدم</option>
                <?php $allUsers->data_seek(0); while($u=$allUsers->fetch_assoc()): $rn=['admin'=>'مدير','teacher'=>'معلم','student'=>'طالب','parent'=>'ولي أمر'][$u['role']]; ?>
                <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['name']); ?> (<?php echo $rn; ?>)</option>
                <?php endwhile; ?>
            </select>
            <input type="text" name="title" placeholder="عنوان الإشعار" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <textarea name="message" placeholder="نص الإشعار" rows="3" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold"></textarea>
            <select name="type" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold">
                <option value="system">نظام</option><option value="success">نجاح</option><option value="alert">تنبيه</option><option value="msg">رسالة</option>
            </select>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('sendNotifModal').classList.remove('active')" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[1.5rem] font-bold">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold">إرسال</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('notifForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd=new FormData(this); fd.append('action','send_notification');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { showToast('تم إرسال الإشعار'); setTimeout(()=>location.reload(),500); }
        else showToast(res.message||'خطأ','error');
    });
});
</script>
