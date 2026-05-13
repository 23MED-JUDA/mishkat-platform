<?php
// Exam Result Page - Dynamic
$score = intval($_GET['score'] ?? 0);
$total = intval($_GET['total'] ?? 0);
$pct = $total > 0 ? round(($score/$total)*100) : 0;

// Save to DB
if ($total > 0) {
    $stmt = $conn->prepare("INSERT INTO exam_results(user_id,exam_title,score,total,percentage) VALUES(?,?,?,?,?)");
    $title = 'اختبار القرآن الكريم';
    $stmt->bind_param("isiid", $uid, $title, $score, $total, $pct);
    $stmt->execute();
}
$grade = $pct >= 90 ? 'ممتاز' : ($pct >= 75 ? 'جيد جداً' : ($pct >= 60 ? 'جيد' : ($pct >= 50 ? 'مقبول' : 'يحتاج تحسين')));
$gradeColor = $pct >= 75 ? 'emerald' : ($pct >= 50 ? 'amber' : 'red');
?>
<div class="max-w-lg mx-auto animate-fadeIn" dir="rtl">
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-8 text-center">
        <!-- Score Circle -->
        <div class="w-32 h-32 mx-auto mb-6 rounded-full border-4 border-<?php echo $gradeColor; ?>-200 bg-<?php echo $gradeColor; ?>-50 flex items-center justify-center">
            <div>
                <span class="text-4xl font-black text-<?php echo $gradeColor; ?>-700"><?php echo $pct; ?>%</span>
            </div>
        </div>

        <h2 class="text-2xl font-black text-gray-900 mb-2">نتيجة الاختبار</h2>
        <p class="text-gray-500 mb-4">أجبت على <strong class="text-<?php echo $gradeColor; ?>-700"><?php echo $score; ?></strong> من أصل <strong><?php echo $total; ?></strong> أسئلة بشكل صحيح</p>
        
        <span class="inline-block px-6 py-2 rounded-[1.5rem] font-black text-sm bg-<?php echo $gradeColor; ?>-50 text-<?php echo $gradeColor; ?>-700 mb-6"><?php echo $grade; ?></span>

        <div class="flex gap-3">
            <a href="?page=exam" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold hover:bg-mishkat-green-800 transition-all text-center text-sm">إعادة الاختبار</a>
            <a href="?page=tasks" class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-[1.5rem] font-bold hover:bg-gray-200 transition-all text-center text-sm">العودة للمهام</a>
        </div>
    </div>
</div>
