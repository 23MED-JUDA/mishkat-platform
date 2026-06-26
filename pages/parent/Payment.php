<?php
// Parent Payment - Dynamic
$payments = $conn->query("SELECT * FROM payments WHERE user_id=$uid ORDER BY created_at DESC");
$subs = $conn->query("SELECT * FROM subscriptions WHERE user_id=$uid ORDER BY created_at DESC");
$totalPaid = $conn->query("SELECT IFNULL(SUM(amount),0) as s FROM payments WHERE user_id=$uid AND status='completed'")->fetch_assoc()['s'];
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <h2 class="text-2xl font-black text-gray-900">الاشتراكات والدفع</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-l from-mishkat-green-700 to-mishkat-green-800 p-6 rounded-[2rem] text-white shadow-lg">
            <p class="text-mishkat-green-200 text-xs font-bold mb-1">إجمالي المدفوعات</p>
            <h3 class="text-3xl font-black"><?php echo number_format($totalPaid); ?> <span class="text-lg">ج.م</span></h3>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs font-bold mb-1">الاشتراكات</p>
            <h3 class="text-3xl font-black text-gray-900"><?php echo $subs->num_rows; ?></h3>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs font-bold mb-1">عمليات الدفع</p>
            <h3 class="text-3xl font-black text-blue-700"><?php echo $payments->num_rows; ?></h3>
        </div>
    </div>

    <!-- Subscriptions -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
        <h3 class="font-black text-gray-900 mb-4">اشتراكاتي</h3>
        <div class="space-y-3">
            <?php while($s = $subs->fetch_assoc()): $sc=$s['status']==='active'?'emerald':'gray'; ?>
            <div class="flex items-center justify-between p-4 rounded-[1.5rem] bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-[1.5rem] bg-<?php echo $sc; ?>-50 text-<?php echo $sc; ?>-600 flex items-center justify-center"><span class="material-icons-outlined">card_membership</span></div>
                    <div><h4 class="font-bold text-gray-800 text-sm"><?php echo $s['plan_name']; ?></h4>
                        <p class="text-xs text-gray-400"><?php echo $s['start_date']; ?> → <?php echo $s['end_date']; ?></p></div>
                </div>
                <div class="text-left">
                    <span class="font-black text-mishkat-green-700"><?php echo number_format($s['amount']); ?> ج.م</span>
                    <span class="block px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $sc; ?>-50 text-<?php echo $sc; ?>-600 mt-1"><?php echo $s['status']==='active'?'نشط':'منتهي'; ?></span>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Payment History -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-black text-gray-900">سجل المدفوعات</h3></div>
        <div class="divide-y divide-gray-50">
            <?php $payments->data_seek(0); while($p = $payments->fetch_assoc()): ?>
            <div class="p-4 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-<?php echo $p['status']==='completed'?'emerald':'amber'; ?>-50 text-<?php echo $p['status']==='completed'?'emerald':'amber'; ?>-600 flex items-center justify-center"><span class="material-icons-outlined text-sm"><?php echo $p['status']==='completed'?'check_circle':'pending'; ?></span></div>
                    <div><p class="text-sm font-bold text-gray-700"><?php echo $p['description']??'عملية دفع'; ?></p>
                        <p class="text-[10px] text-gray-400"><?php echo date('Y/m/d H:i', strtotime($p['created_at'])); ?></p></div>
                </div>
                <span class="font-black text-sm text-<?php echo $p['status']==='completed'?'emerald':'amber'; ?>-700"><?php echo number_format($p['amount']); ?> ج.م</span>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
