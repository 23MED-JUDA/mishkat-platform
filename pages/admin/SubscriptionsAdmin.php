<?php
// Admin Subscriptions - Dynamic
$subs = $conn->query("SELECT s.*,u.name as user_name,u.email FROM subscriptions s JOIN users u ON s.user_id=u.id ORDER BY s.created_at DESC");
$payments = $conn->query("SELECT p.*,u.name as user_name FROM payments p JOIN users u ON p.user_id=u.id ORDER BY p.created_at DESC LIMIT 20");
$totalRevenue = $conn->query("SELECT IFNULL(SUM(amount),0) as s FROM payments WHERE status='completed'")->fetch_assoc()['s'];
$activeSubs = $conn->query("SELECT COUNT(*) as c FROM subscriptions WHERE status='active'")->fetch_assoc()['c'];
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <h2 class="text-2xl font-black text-gray-900">المالية والاشتراكات</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-l from-mishkat-green-700 to-mishkat-green-800 p-6 rounded-[2rem] text-white shadow-lg">
            <p class="text-mishkat-green-200 text-xs font-bold mb-1">إجمالي الإيرادات</p>
            <h3 class="text-3xl font-black"><?php echo number_format($totalRevenue); ?> <span class="text-lg">ج.م</span></h3>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs font-bold mb-1">اشتراكات نشطة</p>
            <h3 class="text-3xl font-black text-mishkat-green-700"><?php echo $activeSubs; ?></h3>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs font-bold mb-1">عمليات الدفع</p>
            <h3 class="text-3xl font-black text-blue-700"><?php echo $payments->num_rows; ?></h3>
        </div>
    </div>

    <!-- Subscriptions Table -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-black text-gray-900">الاشتراكات</h3></div>
        <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead><tr class="bg-gray-50 border-b border-gray-100">
                <th class="px-6 py-3 text-xs font-bold text-gray-500">المشترك</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500">الباقة</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500">المبلغ</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500">الحالة</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500">تاريخ الانتهاء</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                <?php while($s = $subs->fetch_assoc()): 
                    $sc = $s['status']==='active'?'emerald':($s['status']==='expired'?'red':'gray');
                    $sn = $s['status']==='active'?'نشط':($s['status']==='expired'?'منتهي':'ملغي');
                ?>
                <tr class="hover:bg-gray-50/50 transition-all">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-lg bg-mishkat-green-50 text-mishkat-green-600 flex items-center justify-center text-sm font-bold"><?php echo mb_substr($s['user_name'],0,1,'UTF-8'); ?></div><span class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($s['user_name']); ?></span></div></td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-600"><?php echo $s['plan_name']; ?></td>
                    <td class="px-6 py-4 text-sm font-black text-mishkat-green-700"><?php echo number_format($s['amount']); ?> ج.م</td>
                    <td class="px-6 py-4"><span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $sc; ?>-50 text-<?php echo $sc; ?>-600"><?php echo $sn; ?></span></td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-400"><?php echo $s['end_date']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-black text-gray-900">آخر عمليات الدفع</h3></div>
        <div class="divide-y divide-gray-50">
            <?php while($p = $payments->fetch_assoc()): ?>
            <div class="p-4 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-<?php echo $p['status']==='completed'?'emerald':'amber'; ?>-50 text-<?php echo $p['status']==='completed'?'emerald':'amber'; ?>-600 flex items-center justify-center"><span class="material-icons-outlined text-sm"><?php echo $p['status']==='completed'?'check_circle':'pending'; ?></span></div>
                    <div><p class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($p['user_name']); ?></p><p class="text-[10px] text-gray-400"><?php echo date('Y/m/d H:i', strtotime($p['created_at'])); ?></p></div>
                </div>
                <span class="font-black text-<?php echo $p['status']==='completed'?'emerald':'amber'; ?>-700 text-sm"><?php echo number_format($p['amount']); ?> ج.م</span>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
