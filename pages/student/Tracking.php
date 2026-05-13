<?php
// Student Tracking - Dynamic
$tracking = $conn->query("SELECT st.*, u.name as recorder_name FROM student_tracking st LEFT JOIN users u ON st.recorded_by=u.id WHERE st.student_id=$uid ORDER BY st.created_at DESC");
$enrollments = $conn->query("SELECT e.progress, c.title, c.color FROM enrollments e JOIN courses c ON e.course_id=c.id WHERE e.user_id=$uid");
$completedTasks = $conn->query("SELECT COUNT(*) as c FROM user_tasks WHERE user_id=$uid AND completed=1")->fetch_assoc()['c'];
$points = $completedTasks * 10;
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-l from-mishkat-green-700 to-mishkat-green-800 p-6 rounded-[2rem] text-white shadow-lg">
            <p class="text-mishkat-green-200 text-xs font-bold mb-1">نقاط الإنجاز</p>
            <h3 class="text-3xl font-black"><?php echo $points; ?></h3>
            <div class="flex items-center gap-1 mt-2 text-mishkat-green-300 text-xs font-bold"><span class="material-icons-outlined text-sm">trending_up</span>متقدم</div>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs font-bold mb-1">المهام المكتملة</p>
            <h3 class="text-3xl font-black text-gray-900"><?php echo $completedTasks; ?></h3>
        </div>
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-gray-400 text-xs font-bold mb-1">المسارات المسجلة</p>
            <h3 class="text-3xl font-black text-gray-900"><?php echo $enrollments->num_rows; ?></h3>
        </div>
    </div>

    <!-- Enrolled Courses Progress -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-black text-gray-900 mb-4">تقدم المسارات</h3>
        <div class="space-y-4">
            <?php $enrollments->data_seek(0); while($e = $enrollments->fetch_assoc()): $c=$e['color']??'emerald'; ?>
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-bold text-gray-700"><?php echo htmlspecialchars($e['title']); ?></span>
                    <span class="text-sm font-black text-<?php echo $c; ?>-600"><?php echo $e['progress']; ?>%</span>
                </div>
                <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-<?php echo $c; ?>-500 rounded-full transition-all duration-700" style="width:<?php echo $e['progress']; ?>%"></div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Tracking Records -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50">
            <h3 class="text-lg font-black text-gray-900">سجل المتابعة</h3>
            <p class="text-xs text-gray-400 font-medium mt-1">سجل حفظك ومراجعاتك المسجلة من المعلم</p>
        </div>
        <div class="divide-y divide-gray-50">
            <?php while($rec = $tracking->fetch_assoc()): 
                $qualityColors = ['ممتاز'=>'emerald','جيد جداً'=>'blue','جيد'=>'cyan','مقبول'=>'amber','ضعيف'=>'red'];
                $qc = $qualityColors[$rec['quality']]??'gray';
            ?>
            <div class="p-5 hover:bg-gray-50/50 transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-[1.5rem] bg-<?php echo $qc; ?>-50 text-<?php echo $qc; ?>-600 flex items-center justify-center">
                            <span class="material-icons-outlined text-lg">auto_stories</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-sm">سورة <?php echo htmlspecialchars($rec['surah']); ?></h4>
                            <p class="text-xs text-gray-400">الآيات <?php echo $rec['from_ayah']; ?> - <?php echo $rec['to_ayah']; ?></p>
                        </div>
                    </div>
                    <div class="text-left">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black bg-<?php echo $qc; ?>-50 text-<?php echo $qc; ?>-600"><?php echo $rec['quality']; ?></span>
                        <p class="text-[10px] text-gray-400 mt-1"><?php echo date('Y/m/d', strtotime($rec['created_at'])); ?></p>
                    </div>
                </div>
                <?php if($rec['notes']): ?>
                <p class="text-xs text-gray-500 mt-2 pr-14"><?php echo htmlspecialchars($rec['notes']); ?></p>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
