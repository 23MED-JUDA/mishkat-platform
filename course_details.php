<?php
require_once 'includes/db.php';
$cid = $_GET['id'] ?? 1;

$courses = [
    1 => [
        'title' => 'دورة التجويد للمبتدئين',
        'type' => 'أساسي',
        'price' => 300,
        'color' => 'emerald',
        'icon' => 'auto_stories',
        'desc' => 'تعتبر هذه الدورة المدخل الأساسي لكل من يريد إتقان قراءة القرآن الكريم بشكل صحيح. نركز فيها على أحكام النون الساكنة والتنوين والميم الساكنة، مع تدريب عملي مكثف.',
        'features' => [
            'شرح مبسط لكتاب تحفة الأطفال.',
            'جلسات تصحيح تلاوة فردية.',
            'اختبارات دورية لقياس مستوى الإتقان.',
            'شهادة إتمام عند نهاية المستوى.'
        ]
    ],
    2 => [
        'title' => 'مسار حفظ جزء عم',
        'type' => 'حفظ',
        'price' => 500,
        'color' => 'blue',
        'icon' => 'menu_book',
        'desc' => 'برنامج مكثف مصمم لمساعدتك على حفظ جزء عم في فترة زمنية وجيزة مع التركيز على جودة الحفظ ومخارج الحروف. يناسب الأطفال والكبار على حد سواء.',
        'features' => [
            'خطة حفظ يومية مخصصة.',
            'مراجعة تراكمية لضمان عدم النسيان.',
            'شرح مبسط لمعاني الآيات.',
            'مسابقات تحفيزية للطلاب.'
        ]
    ],
    3 => [
        'title' => 'إتقان مخارج الحروف',
        'type' => 'متقدم',
        'price' => 400,
        'color' => 'amber',
        'icon' => 'record_voice_over',
        'desc' => 'دورة تخصصية متعمقة في علم التجويد، تتناول مخارج الحروف السبعة عشر وصفاتها الذاتية والعرضية، وكيفية تجنب اللحون الجلية والخفية في القراءة.',
        'features' => [
            'دراسة مفصلة لمنظومة الجزرية.',
            'تحليل صوتي لمخارج الحروف.',
            'تدريبات مكثفة على الكلمات الصعبة.',
            'إعداد الطالب لمرحلة الإجازة.'
        ]
    ]
];

$c = $courses[$cid] ?? $courses[1];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $c['title']; ?> | مشكاة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .feature-card:hover { transform: translateX(-10px); }
    </style>
</head>
<body class="bg-gray-50/50">

    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar Detail -->
        <div class="md:w-1/3 bg-<?php echo $c['color']; ?>-900 p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <a href="index.php" class="inline-flex items-center gap-2 text-white/60 hover:text-white mb-12 transition-colors">
                    <span class="material-icons-outlined text-sm">arrow_forward</span>
                    العودة للرئيسية
                </a>
                <div class="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center mb-8 backdrop-blur-xl">
                    <span class="material-icons-outlined text-4xl"><?php echo $c['icon']; ?></span>
                </div>
                <span class="px-4 py-1.5 bg-white/10 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 inline-block"><?php echo $c['type']; ?></span>
                <h1 class="text-4xl md:text-5xl font-black mb-8 leading-tight"><?php echo $c['title']; ?></h1>
                <p class="text-<?php echo $c['color']; ?>-100/70 text-lg leading-relaxed font-medium"><?php echo $c['desc']; ?></p>
            </div>
            
            <div class="mt-12 p-8 bg-white/5 rounded-[2.5rem] border border-white/10 backdrop-blur-md relative z-10">
                <p class="text-xs font-black text-white/40 uppercase mb-2">تكلفة الاستثمار في نفسك</p>
                <p class="text-4xl font-black"><?php echo $c['price']; ?> <span class="text-lg font-bold opacity-50">ج.م/شهر</span></p>
            </div>

            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-32 -translate-y-32 blur-3xl"></div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-12 md:p-24">
            <h2 class="text-3xl font-black text-gray-900 mb-12">مزايا هذا المسار التعليمي</h2>
            
            <div class="grid grid-cols-1 gap-6 mb-16">
                <?php foreach($c['features'] as $f): ?>
                <div class="feature-card p-6 bg-white rounded-3xl border border-gray-100 shadow-sm flex items-center gap-6 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-<?php echo $c['color']; ?>-50 text-<?php echo $c['color']; ?>-700 flex items-center justify-center shrink-0">
                        <span class="material-icons-outlined">done_all</span>
                    </div>
                    <p class="text-lg font-bold text-gray-700"><?php echo $f; ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-gray-900 rounded-[3rem] p-12 text-white relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <h3 class="text-2xl font-black mb-2">هل أنت مستعد للبدء؟</h3>
                        <p class="text-gray-400 font-medium">انضم الآن إلى أكثر من 500 طالب في هذا المسار.</p>
                    </div>
                    <a href="register.php" class="px-12 py-5 bg-emerald-700 text-white rounded-[2rem] font-black text-lg hover:bg-emerald-800 transition-all shadow-xl shadow-emerald-900/20 active:scale-95">
                        سجل الآن مجاناً
                    </a>
                </div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-emerald-700 rounded-full translate-x-20 translate-y-20 blur-[100px] opacity-20"></div>
            </div>
        </div>
    </div>

</body>
</html>
