<?php
require_once 'includes/db.php';
$cid = $_GET['id'] ?? 1;

// Detailed course data (Mock)
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
            'جلسات تصحيح تلاوة فردية مع المعلم.',
            'اختبارات دورية لقياس مستوى الإتقان.',
            'شهادة إتمام معتمدة من منصة مشكاة.'
        ],
        'details' => [
            ['label' => 'المدة', 'val' => '3 أشهر'],
            ['label' => 'المستوى', 'val' => 'مبتدئ'],
            ['label' => 'الحصص', 'val' => 'حصة أسبوعياً'],
            ['label' => 'الشهادة', 'val' => 'متوفرة']
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
            'خطة حفظ يومية مخصصة لكل طالب.',
            'مراجعة تراكمية لضمان عدم النسيان.',
            'شرح مبسط لمعاني الآيات وأسباب النزول.',
            'مسابقات تحفيزية وجوائز للطلاب المتميزين.'
        ],
        'details' => [
            ['label' => 'المدة', 'val' => 'شهران'],
            ['label' => 'المستوى', 'val' => 'للجميع'],
            ['label' => 'الحصص', 'val' => '2 حصة/أسبوع'],
            ['label' => 'الشهادة', 'val' => 'متوفرة']
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
        .luxury-card { background: white; border-radius: 2.5rem; border: 1px solid #f0f0f0; box-shadow: 0 10px 40px rgba(0,0,0,0.03); }
        .btn-luxury { @apply px-10 py-5 bg-emerald-700 text-white rounded-[2rem] font-black text-lg hover:bg-emerald-800 transition-all shadow-xl shadow-emerald-900/20 active:scale-95; }
    </style>
</head>
<body class="bg-[#fafafa]">

    <div class="min-h-screen flex flex-col lg:flex-row">
        
        <!-- Sidebar Detail Section -->
        <div class="lg:w-1/3 bg-<?php echo $c['color']; ?>-900 p-8 md:p-16 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <a href="index.php" class="inline-flex items-center gap-2 text-white/50 hover:text-white mb-16 transition-all group">
                    <span class="material-icons-outlined text-sm group-hover:translate-x-1">arrow_forward</span>
                    العودة للرئيسية
                </a>
                
                <div class="w-20 h-20 bg-white/10 rounded-[2rem] flex items-center justify-center mb-10 backdrop-blur-xl border border-white/10">
                    <span class="material-icons-outlined text-4xl"><?php echo $c['icon']; ?></span>
                </div>
                
                <span class="px-4 py-1.5 bg-emerald-500/20 text-emerald-400 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 inline-block border border-emerald-500/20">
                    <?php echo $c['type']; ?>
                </span>
                
                <h1 class="text-4xl md:text-6xl font-black mb-8 leading-tight"><?php echo $c['title']; ?></h1>
                <p class="text-white/60 text-lg leading-relaxed font-medium mb-12">
                    <?php echo $c['desc']; ?>
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <?php foreach($c['details'] as $det): ?>
                    <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                        <p class="text-[10px] text-white/40 font-black uppercase tracking-widest mb-1"><?php echo $det['label']; ?></p>
                        <p class="font-bold text-sm"><?php echo $det['val']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-16 p-8 bg-gradient-to-br from-white/10 to-transparent rounded-[2.5rem] border border-white/10 backdrop-blur-md relative z-10">
                <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-2">الاستثمار الشهري</p>
                <p class="text-4xl font-black"><?php echo $c['price']; ?> <span class="text-lg font-bold opacity-40">ج.م</span></p>
            </div>

            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full translate-x-32 -translate-y-32 blur-[100px]"></div>
        </div>

        <!-- Main Content Section -->
        <div class="flex-1 p-8 md:p-20 lg:p-32 flex flex-col justify-center">
            <h2 class="text-3xl font-black text-gray-900 mb-12">مميزات هذا البرنامج</h2>
            
            <div class="grid grid-cols-1 gap-6 mb-16">
                <?php foreach($c['features'] as $f): ?>
                <div class="luxury-card p-8 flex items-center gap-6 group hover:border-emerald-500/30 transition-all duration-500">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <span class="material-icons-outlined">verified</span>
                    </div>
                    <p class="text-xl font-bold text-gray-700 leading-snug"><?php echo $f; ?></p>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="luxury-card p-12 bg-gray-950 text-white border-none relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-10">
                    <div class="text-center md:text-right">
                        <h3 class="text-3xl font-black mb-3">ابدأ رحلتك المعرفية الآن</h3>
                        <p class="text-gray-400 text-lg">انضم إلى مجتمع مشكاة التعليمي وتميز في علوم القرآن.</p>
                    </div>
                    <a href="register.php" class="btn-luxury whitespace-nowrap">
                        سجل في الدورة
                    </a>
                </div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-emerald-600 rounded-full translate-x-20 translate-y-20 blur-[120px] opacity-10"></div>
                <div class="absolute top-0 left-0 w-48 h-48 bg-blue-600 rounded-full -translate-x-20 -translate-y-20 blur-[100px] opacity-5"></div>
            </div>
        </div>

    </div>

</body>
</html>
