<?php
// Teacher Reports - Dynamic
$totalStudents = $conn->query("SELECT COUNT(DISTINCT cs.student_id) as c FROM circle_students cs JOIN circles ci ON cs.circle_id=ci.id WHERE ci.teacher_id=$uid")->fetch_assoc()['c'];
$totalEvals = $conn->query("SELECT COUNT(*) as c FROM evaluations WHERE teacher_id=$uid")->fetch_assoc()['c'];
$avgMem = $conn->query("SELECT IFNULL(AVG(memorization),0) as a FROM evaluations WHERE teacher_id=$uid")->fetch_assoc()['a'];
$avgTaj = $conn->query("SELECT IFNULL(AVG(tajweed),0) as a FROM evaluations WHERE teacher_id=$uid")->fetch_assoc()['a'];
$recentEvals = $conn->query("SELECT ev.*,u.name as student_name FROM evaluations ev JOIN users u ON ev.student_id=u.id WHERE ev.teacher_id=$uid ORDER BY ev.created_at DESC LIMIT 10");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <h2 class="text-2xl font-black text-gray-900">التقارير</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="luxury-card p-5 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">إجمالي الطلاب</p>
            <h3 class="text-2xl font-black text-gray-900"><?php echo $totalStudents; ?></h3>
        </div>
        <div class="luxury-card p-5 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">التقييمات</p>
            <h3 class="text-2xl font-black text-mishkat-green-700"><?php echo $totalEvals; ?></h3>
        </div>
        <div class="luxury-card p-5 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">متوسط الحفظ</p>
            <h3 class="text-2xl font-black text-blue-700"><?php echo round($avgMem); ?>%</h3>
        </div>
        <div class="luxury-card p-5 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-xs text-gray-400 font-bold mb-1">متوسط التجويد</p>
            <h3 class="text-2xl font-black text-amber-700"><?php echo round($avgTaj); ?>%</h3>
        </div>
    </div>

    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-black text-gray-900">آخر التقييمات</h3></div>
        <div class="divide-y divide-gray-50">
            <?php while($ev = $recentEvals->fetch_assoc()): $avg=round(($ev['memorization']+$ev['tajweed']+$ev['behavior']+$ev['attendance'])/4); ?>
            <div class="p-5 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-[1.5rem] bg-mishkat-green-50 text-mishkat-green-600 flex items-center justify-center font-bold"><?php echo mb_substr($ev['student_name'],0,1,'UTF-8'); ?></div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($ev['student_name']); ?></h4>
                        <p class="text-xs text-gray-400"><?php echo date('Y/m/d', strtotime($ev['created_at'])); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-center"><p class="text-[10px] text-gray-400">الحفظ</p><p class="text-sm font-black text-mishkat-green-600"><?php echo $ev['memorization']; ?></p></div>
                    <div class="text-center"><p class="text-[10px] text-gray-400">التجويد</p><p class="text-sm font-black text-blue-600"><?php echo $ev['tajweed']; ?></p></div>
                    <div class="w-12 h-12 rounded-[1.5rem] flex items-center justify-center font-black text-sm <?php echo $avg>=75?'bg-mishkat-green-50 text-mishkat-green-700':($avg>=50?'bg-amber-50 text-amber-700':'bg-red-50 text-red-700'); ?>"><?php echo $avg; ?>%</div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
