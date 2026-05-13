<?php
// Parent Reports - Dynamic
$children = $conn->query("SELECT u.id,u.name FROM parent_student ps JOIN users u ON ps.student_id=u.id WHERE ps.parent_id=$uid");
$childrenArr = []; while($c=$children->fetch_assoc()) $childrenArr[]=$c;
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-black text-gray-900">تقارير الأبناء</h2>
        <button onclick="document.getElementById('linkModal').classList.add('active')" class="bg-mishkat-green-600 hover:bg-mishkat-green-700 text-white px-6 py-2 rounded-[1.5rem] font-bold flex items-center gap-2 transition-all shadow-md">
            <span class="material-icons-outlined">person_add</span>
            ربط حساب ابن
        </button>
    </div>

    <?php if(empty($childrenArr)): ?>
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-12 text-center">
        <span class="material-icons-outlined text-5xl text-gray-200 mb-3">family_restroom</span>
        <p class="text-gray-400 font-bold">لا يوجد أبناء مسجلون حالياً</p>
    </div>
    <?php else: ?>
    <?php foreach($childrenArr as $child): 
        $cid = $child['id'];
        $completedTasks = $conn->query("SELECT COUNT(*) as c FROM user_tasks WHERE user_id=$cid AND completed=1")->fetch_assoc()['c'];
        $totalTasks = $conn->query("SELECT COUNT(*) as c FROM tasks")->fetch_assoc()['c'];
        $tracking = $conn->query("SELECT * FROM student_tracking WHERE student_id=$cid ORDER BY created_at DESC LIMIT 5");
        $evals = $conn->query("SELECT ev.*,t.name as teacher_name FROM evaluations ev JOIN users t ON ev.teacher_id=t.id WHERE ev.student_id=$cid ORDER BY ev.created_at DESC LIMIT 3");
        $enrollments = $conn->query("SELECT e.progress,c.title,c.color FROM enrollments e JOIN courses c ON e.course_id=c.id WHERE e.user_id=$cid");
    ?>
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-[1.5rem] bg-mishkat-green-100 text-mishkat-green-700 flex items-center justify-center text-xl font-black"><?php echo mb_substr($child['name'],0,1,'UTF-8'); ?></div>
            <div><h3 class="text-lg font-black text-gray-900"><?php echo htmlspecialchars($child['name']); ?></h3>
                <p class="text-xs text-gray-400">المهام المكتملة: <?php echo $completedTasks; ?>/<?php echo $totalTasks; ?></p></div>
        </div>

        <!-- Progress -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <?php while($e=$enrollments->fetch_assoc()): $clr=$e['color']??'emerald'; ?>
            <div class="p-3 rounded-[1.5rem] bg-gray-50">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-bold text-gray-700"><?php echo htmlspecialchars($e['title']); ?></span>
                    <span class="text-sm font-black text-<?php echo $clr; ?>-600"><?php echo $e['progress']; ?>%</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden"><div class="h-full bg-<?php echo $clr; ?>-500 rounded-full" style="width:<?php echo $e['progress']; ?>%"></div></div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Recent Evaluations -->
        <?php if($evals->num_rows > 0): ?>
        <h4 class="text-sm font-bold text-gray-500 mb-3 mt-4">آخر التقييمات</h4>
        <div class="space-y-2">
            <?php while($ev=$evals->fetch_assoc()): $avg=round(($ev['memorization']+$ev['tajweed']+$ev['behavior']+$ev['attendance'])/4); ?>
            <div class="flex items-center justify-between p-3 rounded-[1.5rem] bg-gray-50">
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-400"><?php echo date('m/d', strtotime($ev['created_at'])); ?></span>
                    <span class="text-xs font-bold text-gray-600">بواسطة <?php echo htmlspecialchars($ev['teacher_name']); ?></span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-[10px] text-gray-400">حفظ:<?php echo $ev['memorization']; ?></span>
                    <span class="text-[10px] text-gray-400">تجويد:<?php echo $ev['tajweed']; ?></span>
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black <?php echo $avg>=75?'bg-mishkat-green-50 text-mishkat-green-600':($avg>=50?'bg-amber-50 text-amber-600':'bg-red-50 text-red-600'); ?>"><?php echo $avg; ?>%</span>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <!-- Tracking -->
        <?php if($tracking->num_rows > 0): ?>
        <h4 class="text-sm font-bold text-gray-500 mb-3 mt-4">سجل الحفظ</h4>
        <div class="space-y-2">
            <?php while($tr=$tracking->fetch_assoc()): $qc=['ممتاز'=>'emerald','جيد جداً'=>'blue','جيد'=>'cyan','مقبول'=>'amber','ضعيف'=>'red'][$tr['quality']]??'gray'; ?>
            <div class="flex items-center justify-between p-3 rounded-[1.5rem] bg-gray-50">
                <span class="text-sm font-bold text-gray-700">سورة <?php echo $tr['surah']; ?> (<?php echo $tr['from_ayah']; ?>-<?php echo $tr['to_ayah']; ?>)</span>
                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $qc; ?>-50 text-<?php echo $qc; ?>-600"><?php echo $tr['quality']; ?></span>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; endif; ?>
</div>

<!-- Link Student Modal -->
<div id="linkModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 [&.active]:opacity-100 [&.active]:pointer-events-auto" dir="rtl">
    <div class="luxury-card rounded-[2.5rem] w-full max-w-md p-8 md:p-10 shadow-2xl transform scale-95 transition-transform duration-300 [&.active_>_&]:scale-100">
        <div class="flex justify-between items-center mb-8">
            <h3 class="text-2xl font-black text-gray-900">ربط حساب ابن</h3>
            <button onclick="document.getElementById('linkModal').classList.remove('active')" class="w-10 h-10 rounded-[1.5rem] bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 flex items-center justify-center transition-all">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        
        <form id="linkForm" onsubmit="handleLinkStudent(event)" class="space-y-6">
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">اسم الطالب (كما هو مسجل)</label>
                <div class="relative">
                    <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">person</span>
                    <input type="text" id="linkName" required class="w-full bg-gray-50 border-2 border-gray-100 rounded-[2rem] py-3 pr-12 pl-4 text-gray-900 font-bold focus:border-mishkat-green-500 focus:luxury-card outline-none transition-all" placeholder="الاسم بالكامل">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-black text-gray-700 mb-2">البريد الإلكتروني للطالب</label>
                <div class="relative">
                    <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">email</span>
                    <input type="email" id="linkEmail" required class="w-full bg-gray-50 border-2 border-gray-100 rounded-[2rem] py-3 pr-12 pl-4 text-gray-900 font-bold focus:border-mishkat-green-500 focus:luxury-card outline-none transition-all" placeholder="example@mail.com">
                </div>
            </div>
            
            <button type="submit" id="linkSubmitBtn" class="w-full bg-mishkat-green-600 hover:bg-mishkat-green-700 text-white rounded-[2rem] py-4 font-black shadow-lg shadow-mishkat-green-200 transition-all flex justify-center items-center gap-2">
                <span class="material-icons-outlined">link</span>
                تأكيد الربط
            </button>
        </form>
    </div>
</div>

<script>
function handleLinkStudent(e) {
    e.preventDefault();
    const btn = document.getElementById('linkSubmitBtn');
    const name = document.getElementById('linkName').value;
    const email = document.getElementById('linkEmail').value;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="material-icons-outlined animate-spin">autorenew</span> جاري التحقق...';
    
    apiCall('link_student', {
        student_name: name,
        student_email: email
    }).then(res => {
        if(res.success) {
            showToast(res.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast(res.message, 'error');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-icons-outlined">link</span> تأكيد الربط';
        }
    }).catch(err => {
        showToast('حدث خطأ في الاتصال بالخادم', 'error');
        btn.disabled = false;
        btn.innerHTML = '<span class="material-icons-outlined">link</span> تأكيد الربط';
    });
}
</script>
