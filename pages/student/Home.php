<?php
$userId = $_SESSION['user_id'];
$studentQuery = $conn->query("SELECT * FROM students WHERE user_id=$userId")->fetch_assoc();
$studentId = $studentQuery ? $studentQuery['id'] : 0;

$enrollCount  = $conn->query("SELECT COUNT(*) as c FROM student_paths WHERE student_id=$studentId")->fetch_assoc()['c'] ?? 0;
$taskCount    = $conn->query("SELECT COUNT(*) as c FROM homework_submissions WHERE student_id=$studentId AND status IN ('completed','graded')")->fetch_assoc()['c'] ?? 0;
$totalPoints  = $taskCount * 10;

$ev = $conn->query("SELECT AVG(memorization) m, AVG(tajweed) t, AVG(behavior) b, AVG(attendance) a FROM evaluations WHERE student_id=$studentId")->fetch_assoc();
$avgM = $ev && $ev['m'] !== null ? round($ev['m']) : 0;
$avgT = $ev && $ev['t'] !== null ? round($ev['t']) : 0;
$avgB = $ev && $ev['b'] !== null ? round($ev['b']) : 0;
$avgA = $ev && $ev['a'] !== null ? round($ev['a']) : 0;
$overall = ($avgM+$avgT+$avgB+$avgA) > 0 ? round(($avgM+$avgT+$avgB+$avgA)/4) : 0;

$courses = $conn->query("SELECT sp.*, lp.name AS title, lp.description FROM student_paths sp JOIN learning_paths lp ON sp.path_id=lp.id WHERE sp.student_id=$studentId LIMIT 3");

$allPaths = $conn->query("SELECT lp.id, lp.name, lp.description, IFNULL(pp.sessions_count,0) AS sessions, IFNULL(pp.price,0) AS price FROM learning_paths lp LEFT JOIN path_plans pp ON pp.path_id=lp.id LIMIT 6");

$latestEvals = $conn->query("SELECT e.*, u.name AS teacher_name FROM evaluations e JOIN users u ON e.teacher_id=u.id WHERE e.student_id=$studentId ORDER BY e.created_at DESC LIMIT 3");

$verses = [
    ["text"=>"إِنَّ مَعَ الْعُسْرِ يُسْرًا","ref"=>"سورة الشرح - آية 6"],
    ["text"=>"وَقُل رَّبِّ زِدْنِي عِلْمًا","ref"=>"سورة طه - آية 114"],
    ["text"=>"فَاصْبِرْ صَبْرًا جَمِيلًا","ref"=>"سورة المعارج - آية 5"],
];
$verse = $verses[array_rand($verses)];

$pathColors = ['bg-emerald-50 text-emerald-600','bg-blue-50 text-blue-600','bg-purple-50 text-purple-600','bg-amber-50 text-amber-600','bg-rose-50 text-rose-600','bg-cyan-50 text-cyan-600'];
$pathIcons  = ['menu_book','auto_stories','school','star','library_books','bookmark'];
?>

<div class="space-y-10 animate-fadeIn" dir="rtl">

  
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 relative bg-mishkat-green-900 rounded-[2.5rem] p-8 md:p-14 text-white overflow-hidden shadow-2xl">
      <div class="relative z-10">
        <h1 class="text-2xl md:text-4xl font-black mb-3 font-tajawal">مرحباً، <span class="text-yellow-300"><?php echo explode(' ',$userName)[0]; ?></span> 👋</h1>
        <p class="text-green-200 text-sm md:text-base font-medium max-w-lg leading-relaxed mb-6">استمر في رحلتك نحو حفظ كتاب الله. كل خطوة تقربك من الهدف.</p>
        <div class="flex flex-wrap gap-3">
          <a href="?page=tasks" class="px-6 py-3 bg-white text-mishkat-green-900 rounded-2xl font-black text-sm shadow-xl hover:scale-105 transition-all">المهام اليومية</a>
          <a href="?page=courses" class="px-6 py-3 bg-white/10 border border-white/20 text-white rounded-2xl font-black text-sm hover:bg-white/20 transition-all">مساراتي</a>
        </div>
      </div>
      <div class="absolute top-0 right-0 w-72 h-72 bg-green-600 rounded-full -translate-x-8 -translate-y-20 blur-[80px] opacity-30 pointer-events-none"></div>
    </div>
    <div class="luxury-card p-8 flex flex-col justify-center items-center text-center">
      <span class="material-icons-outlined text-4xl mb-4" style="color:var(--color-primary)">format_quote</span>
      <h3 class="text-xl font-amiri font-bold dark:text-yellow-200 mb-2 leading-relaxed italic">"<?php echo $verse['text']; ?>"</h3>
      <p class="text-[10px] font-black uppercase tracking-widest" style="color:var(--color-primary)"><?php echo $verse['ref']; ?></p>
    </div>
  </div>

  
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <?php
    $stats = [
      ['icon'=>'auto_stories','label'=>'المسارات','val'=>$enrollCount,'bg'=>'bg-emerald-50 dark:bg-emerald-900/20','ic'=>'text-emerald-600'],
      ['icon'=>'task_alt','label'=>'المهام المنجزة','val'=>$taskCount,'bg'=>'bg-blue-50 dark:bg-blue-900/20','ic'=>'text-blue-600'],
      ['icon'=>'military_tech','label'=>'النقاط المكتسبة','val'=>$totalPoints,'bg'=>'bg-amber-50 dark:bg-amber-900/20','ic'=>'text-amber-500'],
      ['icon'=>'grade','label'=>'التقييم العام','val'=>$overall.'%','bg'=>'bg-purple-50 dark:bg-purple-900/20','ic'=>'text-purple-600'],
    ];
    foreach($stats as $s): ?>
    <div class="luxury-card p-5 group hover:-translate-y-2 transition-all cursor-default">
      <div class="w-12 h-12 rounded-2xl <?php echo $s['bg']; ?> <?php echo $s['ic']; ?> flex items-center justify-center mb-3 group-hover:rotate-12 transition-transform">
        <span class="material-icons-outlined text-2xl"><?php echo $s['icon']; ?></span>
      </div>
      <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1"><?php echo $s['label']; ?></p>
      <h4 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $s['val']; ?></h4>
    </div>
    <?php endforeach; ?>
  </div>

  
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 luxury-card p-6 md:p-8">
      <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center">
          <span class="material-icons-outlined">insights</span>
        </div>
        <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">مؤشرات الأداء التعليمي</h3>
      </div>
      <div class="space-y-5">
        <?php
        $bars = [
          ['label'=>'جودة الحفظ والتسميع','val'=>$avgM,'color'=>'bg-emerald-500'],
          ['label'=>'تطبيق أحكام التجويد','val'=>$avgT,'color'=>'bg-blue-500'],
          ['label'=>'المواظبة وحضور الحلقات','val'=>$avgA,'color'=>'bg-amber-500'],
          ['label'=>'السلوك والمشاركة','val'=>$avgB,'color'=>'bg-purple-500'],
        ];
        foreach($bars as $bar): ?>
        <div>
          <div class="flex justify-between items-center mb-1">
            <span class="text-sm font-bold text-gray-700 dark:text-gray-300"><?php echo $bar['label']; ?></span>
            <span class="text-sm font-black" style="color:var(--color-primary)"><?php echo $bar['val']; ?>%</span>
          </div>
          <div class="w-full h-2.5 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
            <div class="h-full <?php echo $bar['color']; ?> rounded-full transition-all duration-1000" style="width:<?php echo max($bar['val'],3); ?>%"></div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    
    <div class="luxury-card p-8 flex flex-col justify-center items-center text-center">
      <h3 class="text-base font-black text-gray-900 dark:text-white font-tajawal mb-6">التقييم التراكمي</h3>
      <div class="relative w-36 h-36 flex items-center justify-center">
        <svg class="w-full h-full -rotate-90">
          <circle cx="72" cy="72" r="58" stroke-width="10" stroke="currentColor" class="text-gray-100 dark:text-white/5" fill="transparent"/>
          <circle cx="72" cy="72" r="58" stroke-width="10" stroke="var(--color-primary)" stroke-dasharray="364" stroke-dashoffset="<?php echo 364-(364*$overall/100); ?>" stroke-linecap="round" fill="transparent"/>
        </svg>
        <div class="absolute text-center">
          <span class="text-3xl font-black text-gray-900 dark:text-white"><?php echo $overall; ?>%</span>
          <p class="text-[9px] text-gray-400 font-bold tracking-widest mt-0.5">تراكمي</p>
        </div>
      </div>
      <p class="text-xs text-gray-400 dark:text-white/40 mt-6 leading-relaxed">يتحدث هذا المعدل بناءً على تقييمات معلمك في الحلقات اليومية</p>
    </div>
  </div>

  
  <div>
    <div class="flex items-center justify-between mb-5">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 flex items-center justify-center">
          <span class="material-icons-outlined">rate_review</span>
        </div>
        <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">آخر التقييمات من المعلم</h3>
      </div>
      <a href="?page=tracking" class="text-xs font-bold" style="color:var(--color-primary)">عرض الكل</a>
    </div>
    <?php if($latestEvals && $latestEvals->num_rows > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <?php while($ev2 = $latestEvals->fetch_assoc()):
        $avgEv = round(($ev2['memorization']+$ev2['tajweed']+$ev2['behavior']+$ev2['attendance'])/4);
        $stars = round($avgEv/20);
      ?>
      <div class="luxury-card p-5 hover:shadow-lg transition-all">
        <div class="flex items-center justify-between mb-3">
          <div class="flex items-center gap-2">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-black text-sm">
              <?php echo mb_substr($ev2['teacher_name'],0,1,'UTF-8'); ?>
            </div>
            <div>
              <p class="text-xs font-bold text-gray-900 dark:text-white"><?php echo htmlspecialchars($ev2['teacher_name']); ?></p>
              <p class="text-[10px] text-gray-400"><?php echo date('d M Y', strtotime($ev2['created_at'])); ?></p>
            </div>
          </div>
          <span class="text-lg font-black" style="color:var(--color-primary)"><?php echo $avgEv; ?>%</span>
        </div>
        <div class="flex gap-0.5 mb-3">
          <?php for($i=1;$i<=5;$i++): ?>
          <span class="material-icons-outlined text-sm <?php echo $i<=$stars ? 'text-amber-400' : 'text-gray-200'; ?>">star</span>
          <?php endfor; ?>
        </div>
        <div class="grid grid-cols-2 gap-1 text-[10px]">
          <span class="text-gray-500">حفظ: <b class="text-gray-800 dark:text-white"><?php echo $ev2['memorization']; ?>%</b></span>
          <span class="text-gray-500">تجويد: <b class="text-gray-800 dark:text-white"><?php echo $ev2['tajweed']; ?>%</b></span>
          <span class="text-gray-500">حضور: <b class="text-gray-800 dark:text-white"><?php echo $ev2['attendance']; ?>%</b></span>
          <span class="text-gray-500">سلوك: <b class="text-gray-800 dark:text-white"><?php echo $ev2['behavior']; ?>%</b></span>
        </div>
        <?php if(!empty($ev2['notes'])): ?>
        <p class="mt-3 text-[11px] text-gray-500 dark:text-white/50 italic border-t border-gray-100 dark:border-white/5 pt-2">"<?php echo htmlspecialchars($ev2['notes']); ?>"</p>
        <?php endif; ?>
      </div>
      <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="luxury-card p-10 text-center border-dashed border-2">
      <span class="material-icons-outlined text-4xl text-gray-300 mb-3 block">rate_review</span>
      <p class="text-gray-400 font-bold">لا توجد تقييمات حتى الآن</p>
    </div>
    <?php endif; ?>
  </div>

  
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div>
      <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 flex items-center justify-center">
            <span class="material-icons-outlined">book_online</span>
          </div>
          <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">مساراتي المفعّلة</h3>
        </div>
        <a href="?page=courses" class="text-xs font-bold" style="color:var(--color-primary)">عرض الكل</a>
      </div>
      <div class="space-y-3">
        <?php if($courses && $courses->num_rows > 0):
          $ci = 0;
          while($c=$courses->fetch_assoc()):
            $icol = $pathColors[$ci % count($pathColors)];
            $iico = $pathIcons[$ci % count($pathIcons)];
            $ci++;
        ?>
        <div class="luxury-card p-5 flex items-center gap-4 hover:shadow-md transition-all">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 <?php echo $icol; ?>">
            <span class="material-icons-outlined text-2xl"><?php echo $iico; ?></span>
          </div>
          <div class="flex-1 min-w-0">
            <h4 class="font-black text-gray-900 dark:text-white text-sm mb-1 truncate"><?php echo htmlspecialchars($c['title']); ?></h4>
            <div class="w-full h-2 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
              <div class="h-full rounded-full transition-all duration-1000" style="width:5%;background:var(--color-primary)"></div>
            </div>
          </div>
          <span class="text-xs font-black" style="color:var(--color-primary)">5%</span>
        </div>
        <?php endwhile; else: ?>
        <div class="luxury-card p-10 text-center border-dashed border-2">
          <span class="material-icons-outlined text-4xl text-gray-300 mb-3 block">school</span>
          <p class="text-gray-400 font-bold text-sm">لم تنضم لأي مسار بعد</p>
        </div>
        <?php endif; ?>
      </div>
    </div>

    
    <div class="luxury-card p-6 md:p-8">
      <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal mb-6">نشاطك الأسبوعي</h3>
      <canvas id="activityChart" height="220"></canvas>
    </div>
  </div>

  
  <div>
    <div class="flex items-center gap-3 mb-6">
      <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 flex items-center justify-center">
        <span class="material-icons-outlined">local_offer</span>
      </div>
      <div>
        <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">الدورات والباقات المتاحة</h3>
        <p class="text-xs text-gray-400">اختر المسار المناسب لمستواك وانضم الآن</p>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      <?php
      $pi = 0;
      $badgeLabels = ['الأكثر طلباً','مميز','للمبتدئين','للمتقدمين','موصى به','جديد'];
      $badgeColors = ['bg-amber-100 text-amber-700','bg-purple-100 text-purple-700','bg-emerald-100 text-emerald-700','bg-blue-100 text-blue-700','bg-rose-100 text-rose-700','bg-cyan-100 text-cyan-700'];
      while($p = $allPaths->fetch_assoc()):
        $icol2 = $pathColors[$pi % count($pathColors)];
        $iico2 = $pathIcons[$pi % count($pathIcons)];
        $badge = $badgeLabels[$pi % count($badgeLabels)];
        $badgeC= $badgeColors[$pi % count($badgeColors)];
        $price = floatval($p['price']);
        $pi++;
      ?>
      <div class="luxury-card p-6 flex flex-col justify-between hover:-translate-y-1 hover:shadow-xl transition-all group">
        <div>
          <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center <?php echo $icol2; ?>">
              <span class="material-icons-outlined text-2xl"><?php echo $iico2; ?></span>
            </div>
            <span class="text-[10px] font-black px-3 py-1 rounded-full <?php echo $badgeC; ?>"><?php echo $badge; ?></span>
          </div>
          <h4 class="font-black text-gray-900 dark:text-white mb-2"><?php echo htmlspecialchars($p['name']); ?></h4>
          <p class="text-xs text-gray-500 dark:text-white/50 leading-relaxed mb-4"><?php echo htmlspecialchars($p['description'] ?? 'مسار تعليمي متكامل لحفظ القرآن الكريم وتعلم أحكام التجويد.'); ?></p>
          <div class="flex items-center gap-4 text-xs text-gray-400 mb-5">
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-sm">video_library</span><?php echo $p['sessions']; ?> حصة</span>
            <span class="flex items-center gap-1"><span class="material-icons-outlined text-sm">schedule</span>مرن</span>
          </div>
        </div>
        <div class="border-t border-gray-100 dark:border-white/5 pt-4 flex items-center justify-between">
          <div>
            <?php if($price > 0): ?>
            <p class="text-[10px] text-gray-400 font-bold">السعر الشهري</p>
            <p class="text-xl font-black" style="color:var(--color-primary)"><?php echo number_format($price,0); ?> <span class="text-xs font-bold">ج.م</span></p>
            <?php else: ?>
            <p class="text-xl font-black text-emerald-600">مجاني</p>
            <?php endif; ?>
          </div>
          <a href="?page=courses" class="px-5 py-2.5 rounded-2xl text-white text-xs font-black transition-all hover:opacity-90 hover:scale-105" style="background:var(--color-primary)">انضم الآن</a>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  
  <div class="luxury-card p-6 md:p-10 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/10 dark:to-transparent">
    <div class="flex items-center gap-3 mb-6">
      <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center">
        <span class="material-icons-outlined">workspace_premium</span>
      </div>
      <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">أهمية وفضل طلب العلم وحفظ القرآن</h3>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <?php
      $virtues = [
        ['icon'=>'emoji_events','color'=>'bg-amber-50 text-amber-500','title'=>'الخيرية العظمى','hadith'=>'"خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ"','desc'=>'حفظ القرآن الكريم يضعك في صفوة الأمة ويجعلك من أهل الله وخاصته.'],
        ['icon'=>'trending_up','color'=>'bg-blue-50 text-blue-500','title'=>'رفعة الدرجات','hadith'=>'"اقْرَأْ وَارْتَقِ وَرَتِّلْ كَمَا كُنْتَ تُرَتِّلُ فِي الدُّنْيَا"','desc'=>'كل آية تحفظها ترفعك درجة في الجنة حتى تُقيم عند آخر آية تحفظها.'],
        ['icon'=>'directions','color'=>'bg-purple-50 text-purple-500','title'=>'طريق الجنة','hadith'=>'"مَنْ سَلَكَ طَرِيقًا يَلْتَمِسُ فِيهِ عِلْمًا سَهَّلَ اللَّهُ لَهُ طَرِيقًا إِلَى الْجَنَّةِ"','desc'=>'مشكاة توفر لك أسهل الطرق لطلب العلم والوصول إلى أهدافك.'],
      ];
      foreach($virtues as $v): ?>
      <div class="p-5 bg-white dark:bg-white/[0.02] rounded-2xl border border-gray-100 dark:border-white/5 hover:scale-[1.02] transition-all">
        <div class="w-10 h-10 rounded-xl <?php echo $v['color']; ?> flex items-center justify-center mb-3">
          <span class="material-icons-outlined"><?php echo $v['icon']; ?></span>
        </div>
        <h4 class="font-bold text-gray-900 dark:text-white mb-2"><?php echo $v['title']; ?></h4>
        <p class="text-xs font-bold text-emerald-700 dark:text-yellow-400 mb-2 leading-relaxed"><?php echo $v['hadith']; ?></p>
        <p class="text-xs text-gray-500 dark:text-white/50 leading-relaxed"><?php echo $v['desc']; ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const ctx = document.getElementById('activityChart').getContext('2d');
  const dark = document.documentElement.classList.contains('dark');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['السبت','الأحد','الاثنين','الثلاثاء','الأربعاء','الخميس','الجمعة'],
      datasets: [{
        label: 'المهام',
        data: [2,5,3,7,4,8,5],
        backgroundColor: dark ? '#d4a359' : '#4a8c6e',
        borderRadius: 10, barThickness: 22
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true, grid: { color: dark?'rgba(255,255,255,0.05)':'rgba(0,0,0,0.04)' }, ticks: { color: dark?'#a69a85':'#9ca3af' } },
        x: { grid: { display: false }, ticks: { color: dark?'#a69a85':'#9ca3af' } }
      }
    }
  });
});
</script>
