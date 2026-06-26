<?php
// Parent Episods (Circle Schedule) - Dynamic
$parentRow = $conn->query("SELECT id FROM parents WHERE user_id=$uid")->fetch_assoc();
$parentId = $parentRow ? $parentRow['id'] : 0;
$children = $conn->query("SELECT s.id, u.name FROM students s JOIN users u ON s.user_id=u.id WHERE s.parent_id=$parentId");
$childrenArr = []; while($c=$children->fetch_assoc()) $childrenArr[]=$c;
$childIds = array_column($childrenArr, 'id');
$events = [];
if(!empty($childIds)) {
    $idStr = implode(',', $childIds);
    $r = $conn->query("SELECT s.id, h.name AS title, s.session_link AS description, DATE(s.session_date) AS event_date, TIME(s.session_date) AS event_time, s.session_type AS type, u.name as student_name
                       FROM sessions s
                       JOIN halaqat h ON s.halaqa_id = h.id
                       JOIN halaqa_enrollments he ON he.halaqa_id = h.id
                       JOIN students st ON he.student_id = st.id
                       JOIN users u ON st.user_id = u.id
                       WHERE st.id IN($idStr) ORDER BY s.session_date ASC");
    while($e = $r->fetch_assoc()) $events[] = $e;
}
$circles = $conn->query("SELECT ci.*, 'active' AS status, u.name as teacher_name FROM halaqat ci JOIN teachers t ON ci.teacher_id=t.id JOIN users u ON t.user_id=u.id ORDER BY ci.name");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <h2 class="text-2xl font-black text-gray-900">جدول الحلقات</h2>

    <!-- Active Circles -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <?php while($ci = $circles->fetch_assoc()): ?>
        <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-[1.5rem] bg-mishkat-green-50 text-mishkat-green-600 flex items-center justify-center"><span class="material-icons-outlined">groups</span></div>
                <div><h4 class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($ci['name']); ?></h4>
                    <p class="text-[10px] text-gray-400"><?php echo htmlspecialchars($ci['teacher_name']); ?></p></div>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-500"><span class="material-icons-outlined text-sm">schedule</span><?php echo htmlspecialchars($ci['schedule']??''); ?></div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Children Events -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-black text-gray-900">أحداث الأبناء القادمة</h3></div>
        <div class="divide-y divide-gray-50">
            <?php if(empty($events)): ?>
            <div class="p-8 text-center text-gray-400 text-sm">لا توجد أحداث قادمة</div>
            <?php else: foreach($events as $ev): 
                $tc = ['class'=>'emerald','exam'=>'blue','meeting'=>'amber'][$ev['type']]??'gray';
                $tn = ['class'=>'حلقة','exam'=>'اختبار','meeting'=>'اجتماع'][$ev['type']]??$ev['type'];
            ?>
            <div class="p-4 flex items-center justify-between hover:bg-gray-50/50 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-[1.5rem] bg-<?php echo $tc; ?>-50 text-<?php echo $tc; ?>-600 flex items-center justify-center"><span class="material-icons-outlined"><?php echo $ev['type']==='exam'?'quiz':'event'; ?></span></div>
                    <div><h4 class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($ev['title']); ?></h4>
                        <p class="text-xs text-gray-400"><?php echo $ev['student_name']; ?> • <?php echo $ev['event_date']; ?> <?php echo substr($ev['event_time'],0,5); ?></p></div>
                </div>
                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $tc; ?>-50 text-<?php echo $tc; ?>-600"><?php echo $tn; ?></span>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
