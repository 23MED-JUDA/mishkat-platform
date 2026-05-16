/* ====== بيانات المعلمين  ====== */
const teachersData = [
    {
        id: 1,
        name: "الشيخ محمود خليل الحصري",
        specialty: "إقراء وتجويد",
        title: "شيخ المقرئين بمصر",
        image: "assets/images/88fac63309bd27b514c4d38152b29f90.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg", 
        experience: "25+",
        students: "1500",
        ijazat: 12,
        rating: 4.9,
        bio: "فضيلة الشيخ من كبار علماء القراءات بالأزهر الشريف، حاصل على إجازات عالية في القراءات العشر بأسانيد متصلة إلى رسول الله ﷺ. تخرّج على يديه آلاف الطلاب من مختلف أنحاء العالم الإسلامي، وله مساهمات جليلة في خدمة كتاب الله تعالى.",
        qualifications: [
            "ليسانس كلية القرآن الكريم - جامعة الأزهر",
            "ماجستير في القراءات والتجويد",
            "دكتوراه في علوم القرآن بمرتبة الشرف الأولى",
            "عضو لجنة مراجعة المصاحف بالأزهر الشريف"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم بسند متصل",
            "إجازة بالقراءات السبع من طريق الشاطبية",
            "إجازة بالقراءات العشر الكبرى من طريق الطيبة",
            "إجازة في علم التجويد ومتن الجزرية"
        ],
        courses: ["تحفيظ القرآن", "أحكام التجويد", "القراءات العشر", "متن الجزرية", "متن الشاطبية"],
        schedule: [
            { day: "السبت", time: "بعد العصر" },
            { day: "الإثنين", time: "بعد المغرب" },
            { day: "الأربعاء", time: "بعد العشاء" }
        ]
    },
    {
        id: 2,
        name: "الشيخ أحمد محمد عامر",
        specialty: "تحفيظ وتلاوة",
        title: "إمام وخطيب ومحفّظ للقرآن الكريم",
        image: "assets/images/b545daa447427cdd8eafe132f188b959.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "18+",
        students: "950",
        ijazat: 8,
        rating: 4.8,
        bio: "شيخ فاضل متخصص في تحفيظ القرآن الكريم للأطفال والكبار، يتميز بأسلوبه التربوي الراقي وصبره على الطلاب. حاصل على إجازات قرآنية متعددة، ويُشرف على حلقات تحفيظ منذ أكثر من ثمانية عشر عامًا.",
        qualifications: [
            "ليسانس أصول الدين - جامعة الأزهر",
            "دبلوم تخصصي في طرق تحفيظ القرآن",
            "دورات متقدمة في علم النفس التربوي",
            "إمام وخطيب بوزارة الأوقاف المصرية"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم",
            "إجازة برواية ورش عن نافع",
            "إجازة في رواية قالون عن نافع",
            "إجازة في متن تحفة الأطفال"
        ],
        courses: ["تحفيظ للأطفال", "تحفيظ للكبار", "تصحيح التلاوة", "تحفة الأطفال"],
        schedule: [
            { day: "الأحد", time: "بعد الفجر" },
            { day: "الثلاثاء", time: "بعد العصر" },
            { day: "الخميس", time: "بعد المغرب" }
        ]
    },
    {
        id: 3,
        name: "الشيخ عبد الباسط عبد الصمد",
        specialty: "علم القراءات",
        title: "مقرئ ومجاز بالقراءات العشر",
        image: "assets/images/3d1b323a0312ba22cfd12487f7f20f31.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "22+",
        students: "1200",
        ijazat: 10,
        rating: 5.0,
        bio: "من أعلام القراءات في مصر، يتمتع بصوت ندي وأداء متقن. متخصص في تدريس القراءات العشر الصغرى والكبرى، وله طلاب أجازهم في القراءات من شتى بقاع الأرض. يجمع بين الإتقان العلمي والأداء الجمالي للقرآن.",
        qualifications: [
            "دكتوراه في القراءات - جامعة الأزهر",
            "أستاذ مساعد بكلية القرآن الكريم",
            "عضو رابطة القراء العالمية",
            "محكّم في المسابقات الدولية للقرآن"
        ],
        ijazatList: [
            "إجازة بالقراءات العشر الكبرى من طريق الطيبة",
            "إجازة بالقراءات العشر الصغرى من طريق الشاطبية والدرة",
            "إجازة في الأداء بالقراءات الأربع الزائدة",
            "إجازة في علم رسم المصحف وضبطه"
        ],
        courses: ["القراءات العشر", "الشاطبية", "طيبة النشر", "رسم المصحف", "ضبط المصحف"],
        schedule: [
            { day: "السبت", time: "بعد المغرب" },
            { day: "الإثنين", time: "بعد العشاء" },
            { day: "الخميس", time: "بعد العصر" }
        ]
    },
    {
        id: 4,
        name: "الشيخ مصطفى إسماعيل",
        specialty: "تجويد وأحكام",
        title: "معلم تجويد ومجوّد محترف",
        image: "assets/images/c894b961bca74dbc88409f718c57d994.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "15+",
        students: "780",
        ijazat: 6,
        rating: 4.9,
        bio: "متخصص في تعليم أحكام التجويد بأسلوب مبسط وميسر، يتميز بمنهجية تعليمية فريدة تجمع بين الجانب النظري والتطبيق العملي. يُشرف على دورات تجويد متعددة المستويات، وله طريقة مميزة في إيصال المعلومة.",
        qualifications: [
            "ليسانس قراءات - جامعة الأزهر",
            "ماجستير في علوم التجويد",
            "دبلوم في طرق تدريس التجويد",
            "محاضر معتمد من نقابة القراء"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم",
            "إجازة في متن تحفة الأطفال للجمزوري",
            "إجازة في متن المقدمة الجزرية",
            "إجازة في متن السلسبيل الشافي"
        ],
        courses: ["تجويد المبتدئين", "تجويد المتقدمين", "تحفة الأطفال", "المقدمة الجزرية", "أحكام النون والميم"],
        schedule: [
            { day: "الأحد", time: "بعد المغرب" },
            { day: "الثلاثاء", time: "بعد العشاء" },
            { day: "الجمعة", time: "بعد العصر" }
        ]
    },
    {
        id: 5,
        name: "الشيخ محمد صديق المنشاوي",
        specialty: "تلاوة ومقامات",
        title: "قارئ ومرتل للقرآن الكريم",
        image: "assets/images/e1a96888bae866d3ddb61f00eddc0704.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "20+",
        students: "1050",
        ijazat: 9,
        rating: 5.0,
        bio: "صاحب صوت عذب وأداء متميز، يجمع بين إتقان أحكام التجويد وجمال الترتيل. متخصص في تعليم المقامات الصوتية القرآنية بطريقة شرعية لا تخرج عن أحكام التجويد. له تسجيلات قرآنية معتمدة من الإذاعة المصرية.",
        qualifications: [
            "ليسانس كلية القرآن الكريم بطنطا",
            "دبلوم في المقامات الصوتية",
            "قارئ معتمد بالإذاعة المصرية",
            "حاصل على المركز الأول في عدة مسابقات دولية"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم بسند عالٍ",
            "إجازة برواية الدوري عن أبي عمرو",
            "إجازة في علم المقامات الصوتية",
            "إجازة في الأداء الصوتي للقرآن"
        ],
        courses: ["تلاوة وترتيل", "المقامات الصوتية", "تحسين الصوت", "أداء القراءة"],
        schedule: [
            { day: "السبت", time: "بعد العشاء" },
            { day: "الأربعاء", time: "بعد المغرب" },
            { day: "الجمعة", time: "بعد العصر" }
        ]
    },
    {
        id: 6,
        name: "الشيخ راغب مصطفى غلوش",
        specialty: "علوم القرآن",
        title: "أستاذ علوم القرآن والتفسير",
        image: "assets/images/aed18e1f589afcbef8df2401bf3d71c2.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "30+",
        students: "1800",
        ijazat: 14,
        rating: 4.9,
        bio: "من كبار العلماء المتخصصين في علوم القرآن والتفسير، له مؤلفات عديدة في هذا المجال. يجمع بين العلم الشرعي والمنهج الأكاديمي، ويتميز بأسلوبه العلمي الرصين الذي يربط بين النص القرآني والواقع المعاصر.",
        qualifications: [
            "دكتوراه في التفسير وعلوم القرآن",
            "أستاذ بكلية أصول الدين - الأزهر",
            "عضو هيئة كبار العلماء",
            "مؤلف لأكثر من 15 كتابًا في علوم القرآن"
        ],
        ijazatList: [
            "إجازة بالقراءات العشر الكبرى",
            "إجازة في علم التفسير",
            "إجازة في علوم القرآن",
            "إجازة في علم أصول الفقه"
        ],
        courses: ["علوم القرآن", "أصول التفسير", "إعجاز القرآن", "أسباب النزول", "الناسخ والمنسوخ"],
        schedule: [
            { day: "الإثنين", time: "بعد المغرب" },
            { day: "الأربعاء", time: "بعد العشاء" },
            { day: "السبت", time: "بعد العصر" }
        ]
    }
];


document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    }

    const teachersGrid = document.getElementById('teachersGrid');
    const profileHero = document.getElementById('profileHero');

    if (teachersGrid) {
        renderTeachers();
    }

    if (profileHero) {
        loadTeacherProfile();
    }
});

/* ======== عرض كروت المعلمين=========== */
function renderTeachers() {
    const grid = document.getElementById('teachersGrid');
    if (!grid) return;
    grid.innerHTML = teachersData.map((teacher, index) => createTeacherCard(teacher, index)).join('');
}

function createTeacherCard(teacher, index) {
    return `
        <div class="teacher-card" data-aos="fade-up" data-aos-delay="${index * 100}">
            <div class="card-pattern"></div>

            <div class="teacher-image-wrapper">
                <img src="${teacher.image}" alt="${teacher.name}" class="teacher-image" loading="lazy">
            </div>

            <div class="teacher-info">
                <h3 class="teacher-name">${teacher.name}</h3>
                <p class="teacher-specialty">
                    <i class="fas fa-book-quran"></i>
                    ${teacher.specialty}
                </p>

                <div class="teacher-extra">
                    <div class="teacher-stats">
                        <div class="stat">
                            <i class="fas fa-graduation-cap"></i>
                            <span class="num">${teacher.experience}</span>
                            <span class="lbl">سنة خبرة</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-users"></i>
                            <span class="num">${teacher.students}</span>
                            <span class="lbl">طالب</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-star"></i>
                            <span class="num">${teacher.rating}</span>
                            <span class="lbl">تقييم</span>
                        </div>
                    </div>
                </div>

                <button class="view-more-btn" onclick="goToProfile(${teacher.id})">
                    <span>عرض الملف الشخصي</span>
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
        </div>
    `;
}

/* =========  الانتقال لصفحة المعلم========== */
function goToProfile(teacherId) {
    localStorage.setItem('selectedTeacherId', teacherId);
    window.location.href = `teacher_profile.php?id=${teacherId}`;
}

/* =========== تحميل بيانات المعلم في صفحة البروفايل =========== */
function loadTeacherProfile() {
    const urlParams = new URLSearchParams(window.location.search);
    let teacherId = parseInt(urlParams.get('id')) || parseInt(localStorage.getItem('selectedTeacherId')) || 1;

    const teacher = teachersData.find(t => t.id === teacherId);

    if (!teacher) {
        console.error('المعلم غير موجود');
        return;
    }

    fillHeroSection(teacher);
    fillProfileContent(teacher);
    document.title = `${teacher.name} - مشكاة`;
}

/* ====== ملء قسم الهيرو ====== */
function fillHeroSection(teacher) {
    const setText = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    };

    const setImage = (id, src) => {
        const el = document.getElementById(id);
        if (el) el.src = src;
    };

        //  تحديث صورة الخلفية (لكل معلم خلفيته)
    if (teacher.coverImage) {
        setImage('heroBgImage', teacher.coverImage);
    }

    // باقي البيانات
    setImage('heroImage', teacher.image);
    setText('heroSpecialty', teacher.specialty);
    setText('heroName', teacher.name);
    setText('heroTitle', teacher.title);
    setText('heroExperience', teacher.experience);
    setText('heroStudents', teacher.students + '+');
    setText('heroIjazat', teacher.ijazat);
}

/* ====== ملء محتوى البروفايل ====== */
function fillProfileContent(teacher) {
    // النبذة
    const bioEl = document.getElementById('profileBio');
    if (bioEl) bioEl.textContent = teacher.bio;

    // المؤهلات
    const qualEl = document.getElementById('profileQualifications');
    if (qualEl) {
        qualEl.innerHTML = teacher.qualifications.map(q => `<li>${q}</li>`).join('');
    }

    // الإجازات
    const ijazatEl = document.getElementById('profileIjazat');
    if (ijazatEl) {
        ijazatEl.innerHTML = teacher.ijazatList.map(i => `<li>${i}</li>`).join('');
    }

    // المواد
    const coursesEl = document.getElementById('profileCourses');
    if (coursesEl) {
        coursesEl.innerHTML = teacher.courses.map(c => `
            <div class="course-tag">
                <i class="fas fa-book-open"></i>
                ${c}
            </div>
        `).join('');
    }

    // المواعيد
    const scheduleEl = document.getElementById('profileSchedule');
    if (scheduleEl) {
        scheduleEl.innerHTML = teacher.schedule.map(s => `
            <div class="schedule-item">
                <div class="day">
                    <i class="far fa-calendar-alt"></i>
                    ${s.day}
                </div>
                <div class="time">
                    <i class="far fa-clock"></i>
                    ${s.time}
                </div>
            </div>
        `).join('');
    }
}

/* ========= تأثير parallax بسيط على صورة الهيرو ============== */
window.addEventListener('scroll', function() {
    const heroBg = document.getElementById('heroBgImage');
    if (!heroBg) return;

    const scrolled = window.pageYOffset;
    if (scrolled < 800) {
        heroBg.style.transform = `translateY(${scrolled * 0.3}px) scale(1.05)`;
    }
});
