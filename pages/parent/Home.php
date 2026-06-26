<?php
$parentId = $_SESSION['user_id'];

$parentRow = $conn->query("SELECT id FROM parents WHERE user_id=$parentId")->fetch_assoc();
$parentIdVal = $parentRow ? $parentRow['id'] : 0;
$children = $conn->query("SELECT u.id AS user_id, s.id AS student_id, u.name, u.email, u.status 
                          FROM users u 
                          JOIN students s ON u.id = s.user_id
                          WHERE s.parent_id = $parentIdVal");

?>

<div class="space-y-10 animate-fadeIn" dir="rtl">
    <div class="relative bg-mishkat-green-900 rounded-[3rem] p-10 md:p-14 text-white overflow-hidden shadow-2xl">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-5xl font-black mb-4 font-tajawal leading-tight">مرحباً بك، <span class="text-mishkat-gold-400">ولي الأمر</span> 👋</h1>
            <p class="text-mishkat-green-200 text-lg font-medium max-w-xl leading-relaxed mb-8">يمكنك هنا متابعة تقدم أبنائك في مساراتهم التعليمية وحلقات التحفيظ.</p>
        </div>
        <div class="absolute top-0 right-0 w-80 h-80 bg-mishkat-green-600 rounded-full -translate-x-10 -translate-y-20 blur-[100px] opacity-30"></div>
    </div>

    <div class="space-y-6">
        <h3 class="text-xl font-black text-gray-900 font-tajawal px-4">أبنائي المسجلون</h3>
        
        <?php if($children->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php while($s = $children->fetch_assoc()): 
                    $sid = $s['student_id'];
                    $uid = $s['user_id'];
                    $evalQuery = $conn->query("SELECT AVG(memorization) as mem, AVG(tajweed) as taj, AVG(behavior) as beh, AVG(attendance) as att FROM evaluations WHERE student_id = $sid")->fetch_assoc();
                    $avgMemorization = $evalQuery && $evalQuery['mem'] !== null ? round($evalQuery['mem']) : 0;
                    $avgTajweed = $evalQuery && $evalQuery['taj'] !== null ? round($evalQuery['taj']) : 0;
                    $avgBehavior = $evalQuery && $evalQuery['beh'] !== null ? round($evalQuery['beh']) : 0;
                    $avgAttendance = $evalQuery && $evalQuery['att'] !== null ? round($evalQuery['att']) : 0;
                    $prog = ($avgMemorization + $avgTajweed + $avgBehavior + $avgAttendance) > 0 
                        ? round(($avgMemorization + $avgTajweed + $avgBehavior + $avgAttendance) / 4) 
                        : 0;

                    $tasks = $conn->query("SELECT COUNT(*) as c FROM homework_submissions WHERE student_id=$sid AND status IN ('completed', 'graded')")->fetch_assoc()['c'] ?? 0;
                ?>
                <div class="luxury-card p-8 group hover:shadow-xl transition-all">
                    <div class="flex items-center gap-6 mb-8">
                        <div class="w-20 h-20 bg-mishkat-green-50 text-mishkat-green-700 rounded-[2.5rem] flex items-center justify-center text-3xl font-black group-hover:rotate-6 transition-transform">
                            <?php echo mb_substr($s['name'],0,1,'UTF-8'); ?>
                        </div>
                        <div>
                            <h4 class="text-xl font-black text-gray-900"><?php echo htmlspecialchars($s['name']); ?></h4>
                            <p class="text-sm text-gray-400"><?php echo $s['email']; ?></p>
                            <span class="inline-block mt-2 px-3 py-1 bg-mishkat-green-50 text-mishkat-green-600 rounded-lg text-[10px] font-black uppercase">طالب نشط</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="p-3 bg-gray-50 rounded-[2rem] border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">متوسط الإنجاز</p>
                            <p class="text-xl font-black text-mishkat-green-700"><?php echo round($prog); ?>%</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-[2rem] border border-gray-100">
                            <p class="text-[10px] text-gray-400 font-bold mb-1 uppercase tracking-wider">المهام المنجزة</p>
                            <p class="text-xl font-black text-gray-900"><?php echo $tasks; ?></p>
                        </div>
                    </div>

                    
                    <div class="space-y-2 mb-6 bg-gray-50 p-4 rounded-[1.5rem] border border-gray-100">
                        <p class="text-[10px] font-black text-gray-400 mb-2 tracking-widest uppercase">تفاصيل أداء الابن</p>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">الحفظ والتسميع:</span>
                            <span class="font-bold text-gray-900"><?php echo $avgMemorization; ?>%</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">أحكام التجويد:</span>
                            <span class="font-bold text-gray-900"><?php echo $avgTajweed; ?>%</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">السلوك والمشاركة:</span>
                            <span class="font-bold text-gray-900"><?php echo $avgBehavior; ?>%</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">حضور الحلقات:</span>
                            <span class="font-bold text-gray-900"><?php echo $avgAttendance; ?>%</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-mishkat-green-600 rounded-full transition-all duration-1000" style="width: <?php echo $prog; ?>%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[10px] font-bold text-gray-400 px-1">
                            <span>البداية</span>
                            <span>رحلة التعلم</span>
                            <span>الختم بإذن الله</span>
                        </div>
                    </div>

                    <button onclick="showToast('جاري تجهيز تقرير مفصل...')" class="mt-8 w-full py-4 btn-luxury text-sm">عرض التقرير المفصل</button>
                </div>
                <?php endwhile; ?>
            </div>

            
            <div class="luxury-card p-6 md:p-8 border-none bg-gradient-to-br from-mishkat-green-50 to-white dark:from-mishkat-green-900/10 dark:to-mishkat-green-950/20 mt-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-600 dark:text-mishkat-green-400 flex items-center justify-center">
                        <span class="material-icons-outlined text-2xl">family_restroom</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 dark:text-white font-tajawal">أهمية المتابعة ودور الأسرة في تنشئة الأبناء</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="p-5 bg-white dark:bg-mishkat-green-900/20 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col justify-between hover:scale-[1.02] transition-all">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/30 text-amber-500 flex items-center justify-center mb-4">
                                <span class="material-icons-outlined">verified</span>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">أمانة المسؤولية والرعاية</h4>
                            <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal">
                                قال رسول الله صلى الله عليه وسلم: <span class="font-bold text-mishkat-green-700 dark:text-mishkat-gold-400">"كُلُّكُمْ رَاعٍ وَكُلُّكُمْ مَسْؤُولٌ عَنْ رَعِيَّتِهِ"</span>. رعاية الأبناء ومتابعتهم في حفظ القرآن هي من أعظم الأمانات التي يؤجر عليها الوالدان.
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-5 bg-white dark:bg-mishkat-green-900/20 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col justify-between hover:scale-[1.02] transition-all">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/30 text-blue-500 flex items-center justify-center mb-4">
                                <span class="material-icons-outlined">workspace_premium</span>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">تاج الوقار في الآخرة</h4>
                            <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal">
                                تنشئة ولد صالح يحفظ كتاب الله تضمن للوالدين الأجر العظيم والثواب المستمر في الدنيا والآخرة، ويلبسان بسببه تاج الوقار يوم القيامة.
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-5 bg-white dark:bg-mishkat-green-900/20 rounded-2xl border border-gray-100 dark:border-white/5 flex flex-col justify-between hover:scale-[1.02] transition-all">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/30 text-purple-500 flex items-center justify-center mb-4">
                                <span class="material-icons-outlined">favorite</span>
                            </div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">أثر التحفيز والتشجيع</h4>
                            <p class="text-xs text-gray-500 dark:text-white/60 leading-relaxed font-tajawal">
                                تشير الدراسات التربوية إلى أن المتابعة المستمرة والتشجيع الإيجابي من الوالدين يزيدان من همة الأبناء ونسبة إنجازهم لحفظ القرآن بأكثر من <span class="font-bold text-mishkat-green-700 dark:text-mishkat-gold-400">80%</span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="luxury-card p-20 text-center border-dashed border-2 border-gray-100">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="material-icons-outlined text-4xl text-gray-200">person_add</span>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">لم يتم ربط أي ابن بحسابك</h3>
                <p class="text-gray-400 max-w-sm mx-auto">تأكد من كتابة البريد الإلكتروني الخاص بابنك بشكل صحيح أثناء التسجيل ليتم الربط التلقائي.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
