<?php
// Student Tasks - Dynamic
$uid = $_SESSION['user_id'];

// Regular Tasks
$tasksQuery = "SELECT ut.*, t.title, t.description, t.type, t.deadline, t.status as priority 
               FROM user_tasks ut JOIN tasks t ON ut.task_id = t.id 
               WHERE ut.user_id = $uid ORDER BY ut.completed ASC, t.deadline ASC";
$tasksResult = $conn->query($tasksQuery);

// Episodes as Tasks
$episodesQuery = "SELECT e.*, c.title as course_title, 
                  (SELECT COUNT(*) FROM quizzes q WHERE q.episode_id = e.id) as has_quiz,
                  IFNULL((SELECT completed FROM user_episodes WHERE user_id=$uid AND episode_id=e.id), 0) as completed
                  FROM episodes e 
                  JOIN enrollments en ON e.course_id = en.course_id 
                  JOIN courses c ON e.course_id = c.id
                  WHERE en.user_id = $uid
                  ORDER BY completed ASC, e.created_at ASC";
$episodesResult = $conn->query($episodesQuery);

$totalTasks = $tasksResult->num_rows + $episodesResult->num_rows;
$completedTasks = 0;

$tasks = [];
while($t = $tasksResult->fetch_assoc()) {
    $tasks[] = array_merge($t, ['is_episode' => false]);
    if($t['completed']) $completedTasks++;
}
while($e = $episodesResult->fetch_assoc()) {
    $tasks[] = array_merge($e, ['is_episode' => true, 'priority' => 'اعتيادي', 'deadline' => 'مستمر']);
    if($e['completed']) $completedTasks++;
}

$percent = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-900">المهام اليومية</h2>
            <p class="text-gray-500 text-sm mt-1">لديك <?php echo ($totalTasks - $completedTasks); ?> مهام متبقية لليوم</p>
        </div>
        <div class="luxury-card px-6 py-3 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="text-left"><p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">الإنجاز الكلي</p>
                <p class="text-lg font-black text-mishkat-green-700"><?php echo $percent; ?>%</p></div>
            <div class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-mishkat-green-500" style="width: <?php echo $percent; ?>%"></div></div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
        <?php foreach($tasks as $task): 
            $isEpisode = $task['is_episode'];
            $hasQuiz = $task['has_quiz'] ?? 0;
            $pColor = ['عاجل'=>'red','اعتيادي'=>'emerald','متأخر'=>'amber'][$task['priority']] ?? 'gray';
            $typeIcon = $isEpisode ? ($hasQuiz ? 'quiz' : 'play_circle') : (['book'=>'auto_stories','exam'=>'quiz','audio'=>'headset'][$task['type']] ?? 'assignment');
            $link = $isEpisode ? "?page=episodes&course_id=".$task['course_id']."&ep_id=".$task['id'] : ($task['type'] === 'exam' ? "?page=exam" : "#");
            $label = $isEpisode ? ($hasQuiz ? 'امتحان' : 'حلقة') : $task['priority'];
            $actionText = $isEpisode ? ($hasQuiz ? 'أداء الامتحان' : 'مشاهدة الحلقة') : 'ابدأ الآن';
        ?>
        <div class="group luxury-card p-5 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex items-center justify-between <?php echo $task['completed'] ? 'opacity-60' : ''; ?>">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-[2rem] bg-<?php echo $task['completed']?'gray':$pColor; ?>-50 text-<?php echo $task['completed']?'gray':$pColor; ?>-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                    <span class="material-icons-outlined text-2xl"><?php echo $typeIcon; ?></span>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="font-black text-gray-900 <?php echo $task['completed'] ? 'line-through' : ''; ?>"><?php echo htmlspecialchars($task['title']); ?></h3>
                        <span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $pColor; ?>-50 text-<?php echo $pColor; ?>-600"><?php echo $label; ?></span>
                    </div>
                    <p class="text-xs text-gray-400 font-medium"><?php echo htmlspecialchars($task['description'] ?? ($isEpisode ? 'درس تعليمي جديد في '.$task['course_title'] : '')); ?></p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-[10px] font-bold text-gray-400 flex items-center gap-1"><span class="material-icons-outlined text-xs">calendar_today</span> <?php echo $isEpisode ? 'مسار: '.$task['course_title'] : 'موعد التسليم: '.$task['deadline']; ?></span>
                        <?php if(!$task['completed']): ?>
                        <a href="<?php echo $link; ?>" class="text-[10px] font-black text-mishkat-green-600 hover:underline flex items-center gap-1">
                            <span class="material-icons-outlined text-xs">play_circle</span> <?php echo $actionText; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <?php if(!$isEpisode): ?>
                <button onclick="toggleTask(<?php echo $task['id']; ?>, <?php echo $task['completed'] ? 0 : 1; ?>)" 
                    class="w-10 h-10 rounded-[1.5rem] <?php echo $task['completed'] ? 'bg-mishkat-green-500 text-white' : 'bg-gray-50 text-gray-300 hover:bg-mishkat-green-50 hover:text-mishkat-green-500'; ?> flex items-center justify-center transition-all">
                    <span class="material-icons-outlined"><?php echo $task['completed'] ? 'check' : 'radio_button_unchecked'; ?></span>
                </button>
                <?php else: ?>
                    <div class="w-10 h-10 rounded-[1.5rem] <?php echo $task['completed'] ? 'bg-mishkat-green-500 text-white' : 'bg-gray-50 text-gray-200'; ?> flex items-center justify-center">
                        <span class="material-icons-outlined"><?php echo $task['completed'] ? 'check' : 'lock_open'; ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function toggleTask(id, status) {
    apiCall('toggle_task', {id: id, status: status}).then(res => {
        if(res.success) {
            showToast(status ? 'تم إكمال المهمة!' : 'تم التراجع');
            setTimeout(() => location.reload(), 500);
        }
    });
}
</script>
