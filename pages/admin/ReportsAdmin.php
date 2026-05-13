<?php
// Admin Reports - Dynamic Overview
$stats = [
    'users' => $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'],
    'students' => $conn->query("SELECT COUNT(*) as c FROM users WHERE role='student'")->fetch_assoc()['c'],
    'teachers' => $conn->query("SELECT COUNT(*) as c FROM users WHERE role='teacher'")->fetch_assoc()['c'],
    'revenue' => $conn->query("SELECT IFNULL(SUM(amount),0) as s FROM payments WHERE status='completed'")->fetch_assoc()['s'],
    'courses' => $conn->query("SELECT COUNT(*) as c FROM courses")->fetch_assoc()['c'],
    'circles' => $conn->query("SELECT COUNT(*) as c FROM circles")->fetch_assoc()['c'],
];

$monthlyRevenue = $conn->query("SELECT MONTH(created_at) as m, SUM(amount) as s FROM payments WHERE status='completed' AND YEAR(created_at) = YEAR(CURRENT_DATE) GROUP BY MONTH(created_at) ORDER BY m");
$revenueData = array_fill(1, 12, 0);
while($row = $monthlyRevenue->fetch_assoc()) $revenueData[$row['m']] = $row['s'];

$recentLogs = $conn->query("SELECT u.name, u.role, p.amount, p.created_at FROM payments p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC LIMIT 10");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-black text-gray-900">التقارير العامة والتحليلات</h2>
        <button onclick="window.print()" class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-[1.5rem] font-bold text-sm hover:bg-gray-200 transition-all">
            <span class="material-icons-outlined text-sm">print</span> طباعة التقرير
        </button>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">إجمالي المستخدمين</p>
            <h3 class="text-3xl font-black text-gray-900"><?php echo number_format($stats['users']); ?></h3>
            <div class="mt-2 flex items-center gap-1 text-mishkat-green-500 text-[10px] font-bold">
                <span class="material-icons-outlined text-xs">trending_up</span> +12% هذا الشهر
            </div>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">إجمالي الإيرادات</p>
            <h3 class="text-3xl font-black text-mishkat-green-700"><?php echo number_format($stats['revenue']); ?> <span class="text-sm">ج.م</span></h3>
            <div class="mt-2 flex items-center gap-1 text-mishkat-green-500 text-[10px] font-bold">
                <span class="material-icons-outlined text-xs">payments</span> نمو مستمر
            </div>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">المسارات التعليمية</p>
            <h3 class="text-3xl font-black text-blue-700"><?php echo $stats['courses']; ?></h3>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">الحلقات النشطة</p>
            <h3 class="text-3xl font-black text-amber-700"><?php echo $stats['circles']; ?></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Chart Placeholder -->
        <div class="lg:col-span-2 luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-black text-gray-900 mb-6">تحليل الإيرادات الشهرية (<?php echo date('Y'); ?>)</h3>
            <div class="h-64 flex items-end gap-2 px-4">
                <?php foreach($revenueData as $month => $amount): 
                    $height = $stats['revenue'] > 0 ? ($amount / $stats['revenue']) * 100 * 5 : 0; // scaled
                    $height = min($height, 100);
                ?>
                <div class="flex-1 flex flex-col items-center gap-2 group relative">
                    <div class="w-full bg-mishkat-green-50 rounded-t-lg group-hover:bg-mishkat-green-100 transition-all relative" style="height: <?php echo max($height, 5); ?>%">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                            <?php echo number_format($amount); ?> ج.م
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-gray-400"><?php echo $month; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Latest Transactions -->
        <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-black text-gray-900 mb-6">آخر العمليات</h3>
            <div class="space-y-4">
                <?php while($log = $recentLogs->fetch_assoc()): ?>
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center font-bold text-xs group-hover:bg-mishkat-green-50 group-hover:text-mishkat-green-600 transition-colors">
                            <?php echo mb_substr($log['name'], 0, 1, 'UTF-8'); ?>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800"><?php echo htmlspecialchars($log['name']); ?></p>
                            <p class="text-[9px] text-gray-400"><?php echo date('m/d H:i', strtotime($log['created_at'])); ?></p>
                        </div>
                    </div>
                    <span class="text-xs font-black text-mishkat-green-700"><?php echo number_format($log['amount']); ?>+</span>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>
