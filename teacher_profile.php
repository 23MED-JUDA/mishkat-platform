<?php
require_once 'includes/db.php';
require_once 'includes/session.php';

$teacherId = $_GET['id'] ?? 1;

// Mock data for teachers (Ideally this should come from DB)
$teachers = [
    1 => [
        'name' => 'د. بهاء شبانة',
        'title' => 'أستاذ القراءات وعلوم القرآن',
        'specialty' => 'علوم القرآن',
        'experience' => '15+',
        'students' => '2500+',
        'ijazat' => '12',
        'bio' => 'متخصص في القراءات العشر المتواترة، حاصل على درجة الدكتوراه في التفسير وعلوم القرآن. أشرف على تخريج مئات الحافظين والحافظات بأسانيد متصلة.',
        'qualifications' => [
            'دكتوراه في التفسير وعلوم القرآن - جامعة الأزهر',
            'إجازة في القراءات العشر الكبرى والصغرى',
            'باحث في علوم القرآن وفن التجويد'
        ],
        'ijazat_list' => [
            'إجازة برواية حفص عن عاصم',
            'إجازة في القراءات العشر الصغرى',
            'إجازة في متن الجزرية والتحفة'
        ],
        'image' => 'assets/images/6046279299901361992.jpg',
        'bg' => 'assets/images/88fac63309bd27b514c4d38152b29f90.jpg'
    ]
];

$t = $teachers[$teacherId] ?? $teachers[1];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - <?php echo $t['name']; ?> | مشكاة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .font-amiri { font-family: 'Amiri', serif; }
        .hero-gradient { background: linear-gradient(to bottom, rgba(27, 67, 50, 0.8), rgba(27, 67, 50, 0.95)); }
        .luxury-card { background: white; border-radius: 2rem; border: 1px solid #f0f0f0; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
    </style>
</head>
<body class="bg-[#fafafa]">

    <!-- Back Button -->
    <a href="index.php" class="fixed top-6 right-6 z-50 flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-md text-white border border-white/20 rounded-2xl hover:bg-white hover:text-emerald-900 transition-all group shadow-xl">
        <i class="fas fa-arrow-right transition-transform group-hover:translate-x-1"></i>
        <span class="font-bold text-sm">العودة للرئيسية</span>
    </a>

    <!-- Hero Section -->
    <section class="relative min-h-[70vh] flex items-center overflow-hidden bg-emerald-950">
        <img src="<?php echo $t['bg']; ?>" class="absolute inset-0 w-full h-full object-cover opacity-30" alt="Background">
        <div class="absolute inset-0 hero-gradient"></div>
        
        <div class="container mx-auto px-6 relative z-10 pt-20 pb-12">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1 text-center lg:text-right">
                    <span class="inline-block px-4 py-1.5 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-black uppercase tracking-widest mb-6 border border-emerald-500/30">
                        <?php echo $t['specialty']; ?>
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black text-white mb-4 leading-tight"><?php echo $t['name']; ?></h1>
                    <p class="text-emerald-100/60 text-lg md:text-xl font-medium mb-10"><?php echo $t['title']; ?></p>
                    
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                        <div class="px-8 py-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] text-center">
                            <p class="text-2xl font-black text-white"><?php echo $t['experience']; ?></p>
                            <p class="text-[10px] text-emerald-400 font-black uppercase">سنوات خبرة</p>
                        </div>
                        <div class="px-8 py-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] text-center">
                            <p class="text-2xl font-black text-white"><?php echo $t['students']; ?></p>
                            <p class="text-[10px] text-emerald-400 font-black uppercase">طالب وطالبة</p>
                        </div>
                        <div class="px-8 py-4 bg-white/5 backdrop-blur-md border border-white/10 rounded-[2rem] text-center">
                            <p class="text-2xl font-black text-white"><?php echo $t['ijazat']; ?></p>
                            <p class="text-[10px] text-emerald-400 font-black uppercase">إجازات علمية</p>
                        </div>
                    </div>
                </div>

                <div class="order-1 lg:order-2 flex justify-center">
                    <div class="relative w-64 h-64 md:w-80 md:h-80">
                        <div class="absolute inset-0 bg-emerald-500 rounded-[3rem] rotate-6 opacity-20"></div>
                        <img src="<?php echo $t['image']; ?>" class="relative z-10 w-full h-full object-cover rounded-[3rem] shadow-2xl border-4 border-white/10" alt="Teacher">
                        <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-mishkat-gold-500 rounded-full flex items-center justify-center text-emerald-950 text-3xl z-20 shadow-xl">
                            <i class="fas fa-certificate"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-20 px-6 -mt-20 relative z-20">
        <div class="container mx-auto max-w-6xl">
            <div class="grid lg:grid-cols-3 gap-8">
                
                <!-- Main Bio -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="luxury-card p-10 md:p-14">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-user-graduate text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-emerald-900">نبذة عن المعلم</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg font-medium">
                            <?php echo $t['bio']; ?>
                        </p>
                    </div>

                    <div class="luxury-card p-10 md:p-14">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-award text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-emerald-900">المؤهلات العلمية</h3>
                        </div>
                        <ul class="space-y-4">
                            <?php foreach($t['qualifications'] as $q): ?>
                            <li class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <i class="fas fa-check-circle text-emerald-500"></i>
                                <span class="font-bold text-gray-700"><?php echo $q; ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <!-- Sidebar Content -->
                <div class="space-y-8">
                    <div class="luxury-card p-8 bg-emerald-900 text-white border-none overflow-hidden relative">
                        <div class="relative z-10">
                            <h3 class="text-xl font-black mb-6">الإجازات والأسانيد</h3>
                            <div class="space-y-4">
                                <?php foreach($t['ijazat_list'] as $ij): ?>
                                <div class="p-4 bg-white/10 rounded-2xl border border-white/10 backdrop-blur-sm">
                                    <p class="font-bold text-sm"><?php echo $ij; ?></p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <i class="fas fa-scroll absolute bottom-[-20%] right-[-10%] text-9xl text-white/5"></i>
                    </div>

                    <div class="luxury-card p-8 text-center">
                        <h4 class="text-lg font-black text-emerald-900 mb-2">هل تريد الدراسة معه؟</h4>
                        <p class="text-gray-500 text-sm mb-6">احجز مقعدك الآن في الحلقات المباشرة القادمة.</p>
                        <a href="register.php" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black hover:bg-emerald-700 transition-all shadow-lg block">
                            سجل الآن مجاناً
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 text-center text-gray-400 text-sm">
        <p>© <?php echo date('Y'); ?> مِشكاة - منصة تعليمية إسلامية</p>
    </footer>

</body>
</html>
