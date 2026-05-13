/**
 * ملف منطق صفحة التسجيل (Registration Logic)
 * =========================================
 * يتحكم هذا الملف في عملية تسجيل حساب جديد، بما في ذلك اختيار نوع الحساب
 * وتبديل الحقول المطلوبة بناءً على دور المستخدم (طالب، معلم، أو ولي أمر).
 */

// بيانات أنواع الحسابات المتاحة
const roles = {
    student: { title: 'حساب طالب', desc: 'سيتم توفير أدوات ومميزات مخصصة لخدمة احتياجاتك كطالب في المنصة.', icon: 'school' },
    teacher: { title: 'حساب معلم', desc: 'إدارة حلقاتك التعليمية، متابعة الطلاب، وتقييم أدائهم بكل سهولة.', icon: 'person' },
    parent: { title: 'حساب ولي أمر', desc: 'متابعة مستوى أبنائك، تقارير الحفظ، والتواصل المباشر مع المعلمين.', icon: 'group' }
};

/**
 * وظيفة (selectRole): يتم استدعاؤها عند اختيار نوع الحساب من البطاقات المعروضة.
 * تقوم بتحديث الواجهة وإخفاء/إظهار الحقول المناسبة.
 */
function selectRole(role) {
    // تمييز البطاقة المختارة بصرياً
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
    document.getElementById('role_' + role).classList.add('active');
    
    // تخزين الاختيار في حقل مخفي (Hidden Input) ليتم إرساله مع النموذج
    document.getElementById('roleInput').value = role;
    
    // تحديث النصوص في صفحة البيانات بناءً على الاختيار
    document.getElementById('roleTitle').innerText = roles[role].title;
    document.getElementById('roleDesc').innerText = roles[role].desc;
    document.getElementById('roleIcon').innerText = roles[role].icon;
}

/**
 * وظيفة (nextStep): الانتقال من مرحلة "اختيار الحساب" إلى مرحلة "إدخال البيانات الشخصية".
 * تقوم بتجهيز الحقول الإضافية (مثل حقول المعلم أو ولي الأمر) إذا لزم الأمر.
 */
function nextStep() {
    const role = document.getElementById('roleInput').value;
    const teacherFields = document.getElementById('teacherFields');
    const parentFields = document.getElementById('parentFields');
    
    // إظهار حقول المعلم (التخصص والخبرة) إذا كان الحساب "معلم"
    if (role === 'teacher') {
        teacherFields.classList.remove('hidden');
        teacherFields.classList.add('md:contents');
        parentFields.classList.add('hidden');
        parentFields.classList.remove('md:contents');
    } 
    // إظهار حقول ولي الأمر (بيانات الابن) إذا كان الحساب "ولي أمر"
    else if (role === 'parent') {
        parentFields.classList.remove('hidden');
        parentFields.classList.add('md:contents');
        teacherFields.classList.add('hidden');
        teacherFields.classList.remove('md:contents');
    } 
    // إخفاء الحقول الإضافية إذا كان الحساب "طالب"
    else {
        teacherFields.classList.add('hidden');
        teacherFields.classList.remove('md:contents');
        parentFields.classList.add('hidden');
        parentFields.classList.remove('md:contents');
    }

    // تبديل الخطوات مع إضافة حركة أنيميشن
    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('step2').classList.remove('translate-x-12', 'opacity-0');
    }, 10);
}

/**
 * وظيفة (prevStep): العودة من مرحلة إدخال البيانات إلى مرحلة اختيار نوع الحساب.
 */
function prevStep() {
    document.getElementById('step2').classList.add('translate-x-12', 'opacity-0');
    setTimeout(() => {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
    }, 500);
}
