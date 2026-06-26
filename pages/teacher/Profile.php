<?php
$profile     = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
$tq          = $conn->query("SELECT id FROM teachers WHERE user_id=$uid")->fetch_assoc();
$teacherId   = $tq ? $tq['id'] : 0;
$tInfo       = $conn->query("SELECT *, specialization AS specialty, cv_file AS cv_url FROM teachers WHERE user_id=$uid")->fetch_assoc();
$circlesCount= $conn->query("SELECT COUNT(*) c FROM halaqat WHERE teacher_id=$teacherId")->fetch_assoc()['c'] ?? 0;
$studCount   = $conn->query("SELECT COUNT(DISTINCT he.student_id) c FROM halaqa_enrollments he JOIN halaqat h ON he.halaqa_id=h.id WHERE h.teacher_id=$teacherId")->fetch_assoc()['c'] ?? 0;
$evalsCount  = $conn->query("SELECT COUNT(*) c FROM evaluations WHERE teacher_id=$uid")->fetch_assoc()['c'] ?? 0;
$lessonsCount= $conn->query("SELECT COUNT(*) c FROM learning_materials lm JOIN learning_paths lp ON lm.path_id=lp.id")->fetch_assoc()['c'] ?? 0;
$evAvg       = $conn->query("SELECT AVG(memorization) m, AVG(tajweed) t, AVG(attendance) a, AVG(behavior) b FROM evaluations WHERE teacher_id=$uid")->fetch_assoc();
$avgM = $evAvg && $evAvg['m'] ? round($evAvg['m']) : 0;
$avgT = $evAvg && $evAvg['t'] ? round($evAvg['t']) : 0;
$avgA = $evAvg && $evAvg['a'] ? round($evAvg['a']) : 0;
$avgB = $evAvg && $evAvg['b'] ? round($evAvg['b']) : 0;
$overallTeacher = ($avgM+$avgT+$avgA+$avgB)>0 ? round(($avgM+$avgT+$avgA+$avgB)/4) : 0;

// Courses/paths available to manage
$paths = $conn->query("SELECT lp.id, lp.name, lp.description, IFNULL(pp.sessions_count,0) s, IFNULL(pp.price,0) price FROM learning_paths lp LEFT JOIN path_plans pp ON pp.path_id=lp.id LIMIT 6");

// Students in teacher circles
$myStudents = $conn->query("SELECT DISTINCT u.name, u.email FROM users u JOIN students st ON st.user_id=u.id JOIN halaqa_enrollments he ON he.student_id=st.id JOIN halaqat h ON h.id=he.halaqa_id WHERE h.teacher_id=$teacherId LIMIT 5");

// Lessons
$myLessons = $conn->query("SELECT lm.title, lm.type, lp.name AS path_name FROM learning_materials lm JOIN learning_paths lp ON lm.path_id=lp.id ORDER BY lm.id DESC LIMIT 5");
?>

<div class="space-y-8 animate-fadeIn" dir="rtl">

<!-- Hero Banner -->
<div class="relative bg-gradient-to-l from-mishkat-green-800 to-mishkat-green-900 rounded-3xl p-8 md:p-12 text-white overflow-hidden shadow-2xl">
  <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_top_right,_#fff_0%,_transparent_70%)]"></div>
  <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
    <div class="w-28 h-28 bg-white/10 border-4 border-white/20 rounded-[2rem] flex items-center justify-center text-5xl font-black">
      <?php echo mb_substr($profile['name'],0,1,'UTF-8'); ?>
    </div>
    <div class="text-center md:text-right">
      <h1 class="text-2xl md:text-4xl font-black mb-3 font-tajawal"><?php echo htmlspecialchars($profile['name']); ?></h1>
      <div class="flex flex-wrap gap-3 justify-center md:justify-start">
        <span class="px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-xs font-bold">
          <i class="fas fa-certificate text-green-300 ml-1"></i><?php echo htmlspecialchars($tInfo['specialty'] ?? 'معلم معتمد'); ?>
        </span>
        <span class="px-4 py-1.5 bg-white/10 border border-white/20 rounded-full text-xs font-bold">
          <i class="fas fa-clock text-green-300 ml-1"></i><?php echo ($tInfo['experience_years']??0); ?> سنوات خبرة
        </span>
        <span class="px-4 py-1.5 bg-yellow-400/20 border border-yellow-400/30 rounded-full text-xs font-bold text-yellow-300">
          <i class="fas fa-star ml-1"></i><?php echo $tInfo['rating'] ?? '5.0'; ?> تقييم
        </span>
      </div>
    </div>
  </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
  <?php
  $stats=[
    ['icon'=>'groups','label'=>'الحلقات','val'=>$circlesCount,'cls'=>'bg-blue-50 text-blue-600'],
    ['icon'=>'school','label'=>'الطلاب','val'=>$studCount,'cls'=>'bg-emerald-50 text-emerald-600'],
    ['icon'=>'video_library','label'=>'الدروس','val'=>$lessonsCount,'cls'=>'bg-purple-50 text-purple-600'],
    ['icon'=>'assignment_turned_in','label'=>'التقييمات','val'=>$evalsCount,'cls'=>'bg-amber-50 text-amber-500'],
  ];
  foreach($stats as $s): ?>
  <div class="luxury-card p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-2xl <?php echo $s['cls']; ?> flex items-center justify-center">
      <span class="material-icons-outlined text-2xl"><?php echo $s['icon']; ?></span>
    </div>
    <div>
      <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest"><?php echo $s['label']; ?></p>
      <h3 class="text-2xl font-black text-gray-900 dark:text-white"><?php echo $s['val']; ?></h3>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<!-- Performance Bars + Circle -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 luxury-card p-6 md:p-8">
    <div class="flex items-center gap-3 mb-6">
      <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center">
        <span class="material-icons-outlined">analytics</span>
      </div>
      <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">متوسط أداء طلابك</h3>
    </div>
    <div class="space-y-4">
      <?php foreach([['الحفظ',$avgM,'bg-emerald-500'],['التجويد',$avgT,'bg-blue-500'],['الحضور',$avgA,'bg-amber-500'],['السلوك',$avgB,'bg-purple-500']] as [$lbl,$val,$col]): ?>
      <div>
        <div class="flex justify-between mb-1">
          <span class="text-sm font-bold text-gray-700 dark:text-gray-300"><?php echo $lbl; ?></span>
          <span class="text-sm font-black" style="color:var(--color-primary)"><?php echo $val; ?>%</span>
        </div>
        <div class="w-full h-2.5 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
          <div class="h-full <?php echo $col; ?> rounded-full transition-all duration-1000" style="width:<?php echo max($val,3); ?>%"></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="luxury-card p-8 flex flex-col items-center justify-center text-center">
    <h3 class="text-base font-black text-gray-900 dark:text-white font-tajawal mb-5">المعدل العام للطلاب</h3>
    <div class="relative w-36 h-36 flex items-center justify-center">
      <svg class="w-full h-full -rotate-90">
        <circle cx="72" cy="72" r="58" stroke-width="10" stroke="currentColor" class="text-gray-100 dark:text-white/5" fill="transparent"/>
        <circle cx="72" cy="72" r="58" stroke-width="10" stroke="var(--color-primary)" stroke-dasharray="364" stroke-dashoffset="<?php echo 364-(364*$overallTeacher/100); ?>" stroke-linecap="round" fill="transparent"/>
      </svg>
      <div class="absolute text-center">
        <span class="text-3xl font-black text-gray-900 dark:text-white"><?php echo $overallTeacher; ?>%</span>
        <p class="text-[9px] text-gray-400 font-bold mt-0.5">متوسط طلابك</p>
      </div>
    </div>
  </div>
</div>

<!-- My Circles Students + Latest Lessons -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

  <!-- Students Preview -->
  <div class="luxury-card p-6">
    <div class="flex items-center justify-between mb-5">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center">
          <span class="material-icons-outlined">people</span>
        </div>
        <h3 class="font-black text-gray-900 dark:text-white">طلابي في الحلقات</h3>
      </div>
      <a href="?page=students" class="text-xs font-bold" style="color:var(--color-primary)">عرض الكل</a>
    </div>
    <?php if($myStudents && $myStudents->num_rows > 0): ?>
    <div class="space-y-3">
      <?php $idx=0; while($st=$myStudents->fetch_assoc()): $idx++; ?>
      <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-white/[0.02] rounded-2xl">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm" style="background:var(--sidebar-active-bg);color:var(--color-primary)">
          <?php echo mb_substr($st['name'],0,1,'UTF-8'); ?>
        </div>
        <div class="flex-1 min-w-0">
          <p class="font-bold text-sm text-gray-900 dark:text-white truncate"><?php echo htmlspecialchars($st['name']); ?></p>
          <p class="text-[10px] text-gray-400 truncate"><?php echo $st['email']; ?></p>
        </div>
        <span class="text-[10px] font-black px-2 py-1 rounded-full bg-emerald-50 text-emerald-600">نشط</span>
      </div>
      <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-10 text-gray-400">
      <span class="material-icons-outlined text-4xl mb-2 block">group_add</span>
      <p class="font-bold text-sm">لا يوجد طلاب في حلقاتك بعد</p>
    </div>
    <?php endif; ?>
  </div>

  <!-- Latest Lessons -->
  <div class="luxury-card p-6">
    <div class="flex items-center justify-between mb-5">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 flex items-center justify-center">
          <span class="material-icons-outlined">video_library</span>
        </div>
        <h3 class="font-black text-gray-900 dark:text-white">آخر الدروس المضافة</h3>
      </div>
      <a href="?page=episodes" class="text-xs font-bold" style="color:var(--color-primary)">إدارة الدروس</a>
    </div>
    <?php if($myLessons && $myLessons->num_rows > 0): ?>
    <div class="space-y-3">
      <?php while($ls=$myLessons->fetch_assoc()):
        $typeIcon = $ls['type']==='video' ? 'play_circle' : ($ls['type']==='pdf' ? 'picture_as_pdf' : 'article');
        $typeClr  = $ls['type']==='video' ? 'text-red-500' : ($ls['type']==='pdf' ? 'text-blue-500' : 'text-gray-500');
      ?>
      <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-white/[0.02] rounded-2xl">
        <span class="material-icons-outlined text-2xl <?php echo $typeClr; ?>"><?php echo $typeIcon; ?></span>
        <div class="flex-1 min-w-0">
          <p class="font-bold text-sm text-gray-900 dark:text-white truncate"><?php echo htmlspecialchars($ls['title']); ?></p>
          <p class="text-[10px] text-gray-400 truncate"><?php echo htmlspecialchars($ls['path_name']); ?></p>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <?php else: ?>
    <div class="text-center py-10 text-gray-400">
      <span class="material-icons-outlined text-4xl mb-2 block">add_circle_outline</span>
      <p class="font-bold text-sm mb-3">لم تضف دروساً بعد</p>
      <a href="?page=episodes" class="px-5 py-2 rounded-2xl text-white text-xs font-black" style="background:var(--color-primary)">أضف درساً الآن</a>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Available Courses/Packages -->
<div>
  <div class="flex items-center gap-3 mb-6">
    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-500 flex items-center justify-center">
      <span class="material-icons-outlined">local_offer</span>
    </div>
    <div>
      <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">الدورات والمسارات بالأسعار</h3>
      <p class="text-xs text-gray-400">المسارات المتاحة في منصة مشكاة</p>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    <?php
    $colors = ['bg-emerald-50 text-emerald-600','bg-blue-50 text-blue-600','bg-purple-50 text-purple-600','bg-amber-50 text-amber-500','bg-rose-50 text-rose-500','bg-cyan-50 text-cyan-600'];
    $icons  = ['menu_book','auto_stories','school','library_books','bookmark','star'];
    $ci2=0;
    while($pt=$paths->fetch_assoc()):
      $pc=$colors[$ci2%count($colors)]; $pi=$icons[$ci2%count($icons)]; $ci2++;
    ?>
    <div class="luxury-card p-5 hover:-translate-y-1 hover:shadow-xl transition-all">
      <div class="w-12 h-12 rounded-2xl <?php echo $pc; ?> flex items-center justify-center mb-4">
        <span class="material-icons-outlined text-xl"><?php echo $pi; ?></span>
      </div>
      <h4 class="font-black text-gray-900 dark:text-white mb-1"><?php echo htmlspecialchars($pt['name']); ?></h4>
      <p class="text-xs text-gray-500 dark:text-white/50 mb-3 leading-relaxed"><?php echo htmlspecialchars($pt['description'] ?? 'مسار تعليمي متكامل'); ?></p>
      <div class="flex items-center justify-between border-t border-gray-100 dark:border-white/5 pt-3">
        <div>
          <p class="text-[10px] text-gray-400"><?php echo $pt['s']; ?> حصة</p>
          <p class="text-lg font-black" style="color:var(--color-primary)">
            <?php echo $pt['price']>0 ? number_format($pt['price'],0).' ج.م' : 'مجاني'; ?>
          </p>
        </div>
        <a href="?page=episodes" class="px-4 py-2 rounded-xl text-white text-xs font-black" style="background:var(--color-primary)">إدارة الدروس</a>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Importance Section -->
<div class="luxury-card p-6 md:p-10 bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/10 dark:to-transparent">
  <div class="flex items-center gap-3 mb-6">
    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 flex items-center justify-center">
      <span class="material-icons-outlined">workspace_premium</span>
    </div>
    <h3 class="text-lg font-black text-gray-900 dark:text-white font-tajawal">فضل ومكانة معلم القرآن الكريم</h3>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
    <?php
    $virtues=[
      ['icon'=>'emoji_events','color'=>'bg-amber-50 text-amber-500','title'=>'شرف الرسالة','hadith'=>'"إن الله وملائكته وأهل السموات والأرضين... ليصلّون على معلم الناس الخير"','desc'=>'أنت تحمل رسالة الأنبياء وتنشر نور القرآن في قلوب الطلاب.'],
      ['icon'=>'trending_up','color'=>'bg-blue-50 text-blue-500','title'=>'الأجر الجاري','hadith'=>'"خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ"','desc'=>'كل طالب تعلّمه حرفاً من كتاب الله يُجري لك أجراً متصلاً لا ينقطع.'],
      ['icon'=>'favorite','color'=>'bg-purple-50 text-purple-500','title'=>'الأثر في الأجيال','hadith'=>'"من دلَّ على خير فله مثل أجر فاعله"','desc'=>'تعليمك اليوم يبني جيلاً صالحاً يحمل القرآن ويُعلّمه من بعدك.'],
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

<!-- Edit Profile Form -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
  <div class="lg:col-span-2 luxury-card rounded-3xl p-8">
    <h3 class="text-lg font-black text-gray-900 dark:text-white mb-6 flex items-center gap-3">
      <span class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center"><i class="fas fa-user-edit text-sm"></i></span>
      تعديل البيانات المهنية
    </h3>
    <form id="profileForm" class="space-y-5">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div><label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">الاسم</label>
          <input type="text" name="name" value="<?php echo htmlspecialchars($profile['name']); ?>" class="w-full px-5 py-3 bg-gray-50 rounded-2xl font-bold text-gray-700 outline-none"></div>
        <div><label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">الهاتف</label>
          <input type="text" name="phone" value="<?php echo htmlspecialchars($profile['phone']??''); ?>" class="w-full px-5 py-3 bg-gray-50 rounded-2xl font-bold text-gray-700 outline-none"></div>
        <div><label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">التخصص</label>
          <input type="text" name="specialty" value="<?php echo htmlspecialchars($tInfo['specialty']??''); ?>" class="w-full px-5 py-3 bg-gray-50 rounded-2xl font-bold text-gray-700 outline-none"></div>
        <div><label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">سنوات الخبرة</label>
          <input type="number" name="experience" value="<?php echo intval($tInfo['experience_years']??0); ?>" class="w-full px-5 py-3 bg-gray-50 rounded-2xl font-bold text-gray-700 outline-none"></div>
        <div class="md:col-span-2"><label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">نبذة تعريفية</label>
          <textarea name="bio" rows="3" class="w-full px-5 py-3 bg-gray-50 rounded-2xl font-bold text-gray-700 outline-none"><?php echo htmlspecialchars($tInfo['bio']??''); ?></textarea></div>
      </div>
      <button type="submit" class="px-8 py-3 text-white rounded-2xl font-black flex items-center gap-2" style="background:var(--color-primary)">
        <span class="material-icons-outlined text-lg">save</span> حفظ التغييرات
      </button>
    </form>
  </div>
  <div class="luxury-card p-8">
    <h4 class="text-base font-black text-gray-900 dark:text-white mb-5 flex items-center gap-2">
      <span class="material-icons-outlined text-amber-500">lock</span> الأمان
    </h4>
    <form id="passwordForm" class="space-y-4">
      <div><label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">كلمة المرور الحالية</label>
        <input type="password" name="old_password" placeholder="••••••••" class="w-full px-5 py-3 bg-gray-50 rounded-2xl font-bold text-gray-700 outline-none"></div>
      <div><label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">الكلمة الجديدة</label>
        <input type="password" name="new_password" placeholder="••••••••" class="w-full px-5 py-3 bg-gray-50 rounded-2xl font-bold text-gray-700 outline-none"></div>
      <button type="submit" class="w-full py-3 bg-gray-100 text-gray-700 rounded-2xl font-black text-sm hover:bg-gray-200 transition-all">تغيير كلمة المرور</button>
    </form>
  </div>
</div>

</div>
<script>
document.getElementById('profileForm').addEventListener('submit',function(e){
  e.preventDefault();
  const fd=new FormData(this); fd.append('action','update_teacher_profile');
  fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res=>{
    if(res.success){showToast('تم تحديث ملفك المهني بنجاح');setTimeout(()=>location.reload(),1000);}
    else showToast(res.message||'خطأ','error');
  });
});
document.getElementById('passwordForm').addEventListener('submit',function(e){
  e.preventDefault();
  const fd=new FormData(this); fd.append('action','change_password');
  fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res=>{
    if(res.success){showToast('تم تغيير كلمة المرور بنجاح');this.reset();}
    else showToast(res.message||'خطأ','error');
  });
});
</script>
