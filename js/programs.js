(function () {
    "use strict";

    /* ────────── بيانات البرامج التعليمية ──────────── */
    const programsData = [
        {
            id: 1,
            title: "تحفيظ القرآن الكريم",
            description: "برنامج شامل لحفظ كتاب الله تعالى كاملاً بإتقان عن طريق التلقين المباشر والمراجعة المنتظمة مع معلم متخصص ومُجاز.",
            fullDescription: "برنامج تحفيظ القرآن الكريم هو البرنامج الرئيسي في أكاديمية مشكاة، يهدف إلى تمكين الطالب من حفظ كتاب الله تعالى حفظًا متقنًا مع الفهم والتدبر. يعتمد البرنامج على منهجية التلقين المباشر مع المعلم، والمراجعة اليومية المنتظمة، مع اختبارات دورية لضمان ثبات الحفظ. يناسب البرنامج جميع الأعمار والمستويات.",
            image: "images/download (5).jfif",
            category: "quran",
            categoryLabel: "القرآن الكريم",
            teacher: "الشيخ أحمد محمد العلي",
            teacherRole: "حافظ ومُجاز بالقراءات",
            teacherImage: "images/الشيخ عثمان الخميس ❤️❤️.jfif",
            duration: "12 شهر",
            lessons: 96,
            level: "جميع المستويات",
            schedule: "4 حصص أسبوعيًا",
            features: [
                "حفظ مع التلقين المباشر من معلم مُجاز",
                "مراجعة يومية لتثبيت الحفظ",
                "اختبارات شهرية للتقييم",
                "تقارير أداء مفصّلة للطالب",
                "شهادة إتمام الحفظ معتمدة",
                "مرونة في اختيار المواعيد"
            ],
            curriculum: [
                "التهيئة وأساسيات الحفظ",
                "حفظ جزء عمّ مع المراجعة",
                "حفظ جزء تبارك والأجزاء القصيرة",
                "الانتقال للأجزاء الطويلة",
                "المراجعة الشاملة والتثبيت",
                "اختبار الإجازة النهائي"
            ]
        },
        {
            id: 2,
            title: "أحكام التجويد التطبيقي",
            description: "تعلّم أحكام التجويد من الصفر حتى الإتقان مع التطبيق العملي على آيات القرآن الكريم بإشراف متخصصين.",
            fullDescription: "يقدّم هذا البرنامج تعليمًا شاملاً لأحكام التجويد بأسلوب تطبيقي عملي. يبدأ من أحكام النون الساكنة والتنوين، مرورًا بأحكام الميم الساكنة واللام، وصولاً إلى المدود والوقف والابتداء. كل حكم يتم تطبيقه مباشرة على آيات من القرآن الكريم لضمان الفهم والإتقان.",
            image: "images/download (6).jfif",
            category: "tajweed",
            categoryLabel: "التجويد",
            teacher: "الدكتورة هالة سمير",
            teacherRole: "متخصصة في التجويد وعلوم القرآن",
            teacherImage: "images/download (7).jfif",
            duration: "6 أشهر",
            lessons: 48,
            level: "مبتدئ - متوسط",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "شرح نظري مبسّط لكل حكم",
                "تطبيق عملي على آيات القرآن",
                "تمارين تفاعلية وواجبات",
                "اختبارات بعد كل وحدة",
                "شهادة إتمام مستوى التجويد",
                "مادة علمية مسجّلة للمراجعة"
            ],
            curriculum: [
                "مقدمة في علم التجويد وأهميته",
                "أحكام النون الساكنة والتنوين",
                "أحكام الميم الساكنة",
                "أحكام اللام (لام ال، لام الفعل)",
                "المدود بأنواعها",
                "الوقف والابتداء وعلامات المصحف"
            ]
        },
        {
            id: 3,
            title: "القاعدة النورانية",
            description: "الأساس المتين لتعليم القراءة الصحيحة للقرآن الكريم من نطق الحروف من مخارجها الصحيحة للأطفال والكبار.",
            fullDescription: "القاعدة النورانية هي المنهج الأساسي لتعليم القراءة الصحيحة للقرآن الكريم. تبدأ من تعليم الحروف المفردة ونطقها من مخارجها الصحيحة، ثم الانتقال للحروف المركّبة والكلمات، وصولاً لقراءة الآيات بطلاقة.",
            image: "images/القاعدة النورانية.jfif",
            category: "kids",
            categoryLabel: "الأطفال",
            teacher: "الدكتورة هيفاء يونس",
            teacherRole: "معلمة قاعدة نورانية معتمدة",
            teacherImage: "images/د_ هيفاء يونس _ Facebook.jfif",
            duration: "3 أشهر",
            lessons: 36,
            level: "مبتدئ",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "منهج القاعدة النورانية المعتمد",
                "تعليم مخارج الحروف وصفاتها",
                "تدرّج من الحروف للكلمات للآيات",
                "أنشطة تفاعلية ممتعة للأطفال",
                "متابعة فردية لكل طالب",
                "شهادة إتمام القاعدة النورانية"
            ],
            curriculum: [
                "الحروف المفردة ونطقها",
                "الحروف المركّبة",
                "الحروف المقطّعة",
                "الحركات (فتحة، ضمة، كسرة)",
                "التنوين والسكون والشدّة",
                "التطبيق على سور قصيرة"
            ]
        },
        {
            id: 4,
            title: "القراءات العشر المتواترة",
            description: "دراسة القراءات القرآنية العشر مع التعمّق في أصول وفرش كل قراءة للمتقدمين والحفّاظ.",
            fullDescription: "برنامج متقدّم لدراسة القراءات القرآنية العشر المتواترة. يتناول أصول كل قراءة وفرشها مع التطبيق العملي. يشترط في المتقدّم أن يكون حافظًا للقرآن الكريم كاملاً ومُلمًّا بأحكام التجويد.",
            image: "images/Client Challenge.jfif",
            category: "quran",
            categoryLabel: "القرآن الكريم",
            teacher: "الشيخ عبدالله بن سعيد",
            teacherRole: "مُجاز بالقراءات العشر الكبرى",
            teacherImage: "images/e8c512755aea1abefe52b26050ccdd7f.jpg",
            duration: "18 شهر",
            lessons: 144,
            level: "متقدم",
            schedule: "4 حصص أسبوعيًا",
            features: [
                "دراسة أصول القراءات العشر",
                "فرش الحروف لكل قراءة",
                "التطبيق على القرآن كاملاً",
                "إجازة بالسند المتصل",
                "حلقات مذاكرة جماعية",
                "مراجع ومصادر علمية موثّقة"
            ],
            curriculum: [
                "مقدمة في علم القراءات",
                "قراءة نافع (ورش وقالون)",
                "قراءة ابن كثير وأبي عمرو",
                "قراءة ابن عامر وعاصم",
                "قراءة حمزة والكسائي",
                "قراءة أبي جعفر ويعقوب وخلف"
            ]
        },

        {
            id: 5,
            title: "التفسير الميسّر",
            description: "فهم معاني آيات القرآن الكريم بأسلوب ميسّر مع ربط الآيات بالواقع المعاصر واستخراج الدروس والعبر.",
            fullDescription: "يهدف هذا البرنامج إلى تقديم تفسير ميسّر لآيات القرآن الكريم بلغة سهلة وواضحة. يتناول البرنامج تفسير السور بالترتيب مع استخراج الفوائد والأحكام والدروس المستفادة.",
            image: "images/ae508528c5376aeed30f7afdc8da6c86.jpg",
            category: "islamic",
            categoryLabel: "العلوم الشرعية",
            teacher: "الدكتور محمد عبدالرحمن",
            teacherRole: "دكتوراه في التفسير وعلوم القرآن",
            teacherImage: "images/00ee61039099595e831297f0661cdbe2.jpg",
            duration: "8 أشهر",
            lessons: 64,
            level: "متوسط",
            schedule: "حصتان أسبوعيًا",
            features: [
                "تفسير بأسلوب سهل وميسّر",
                "ربط الآيات بالواقع المعاصر",
                "استخراج الفوائد والأحكام",
                "أسباب النزول وسياق الآيات",
                "نقاشات تفاعلية مع المعلم",
                "ملخّصات مكتوبة لكل درس"
            ],
            curriculum: [
                "مقدمة في علم التفسير ومناهجه",
                "تفسير سورة الفاتحة وقصار السور",
                "تفسير سورة البقرة (مختارات)",
                "تفسير سورة آل عمران (مختارات)",
                "تفسير آيات الأحكام",
                "تفسير آيات القصص القرآني"
            ]
        },
        {
            id: 6,
            title: "الإجازة بالسند المتصل",
            description: "الحصول على إجازة في قراءة القرآن بسند متصل إلى رسول الله ﷺ من شيوخ مُجازين ومعتمدين.",
            fullDescription: "برنامج الإجازة بالسند المتصل هو أعلى مراتب التعلّم في الأكاديمية. يقوم الطالب بقراءة القرآن الكريم كاملاً على الشيخ المُجاز، ويحصل بعد إتمام القراءة على سند متصل إلى رسول الله ﷺ.",
            image: "images/854635775f1554aef0e8022c5086de2e.jpg",
            category: "quran",
            categoryLabel: "القرآن الكريم",
            teacher: "الشيخ إبراهيم عبدالباري",
            teacherRole: "مُجاز بالقراءات ومُسنِد",
            teacherImage: "images/dcb44e6ac84f748dc10744fc9ae48bae.jpg",
            duration: "6 أشهر",
            lessons: 60,
            level: "متقدم",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "قراءة القرآن كاملاً على الشيخ",
                "سند متصل إلى النبي ﷺ",
                "تصحيح دقيق للأداء والنطق",
                "اهتمام بالوقف والابتداء",
                "شهادة إجازة معتمدة ومسندة",
                "تأهيل لتعليم الغير وإقراء القرآن"
            ],
            curriculum: [
                "اختبار القبول وتقييم المستوى",
                "قراءة الأجزاء الأولى مع التصحيح",
                "استكمال قراءة النصف الأول",
                "قراءة النصف الثاني",
                "المراجعة الشاملة",
                "الاختبار النهائي ومنح الإجازة"
            ]
        },
        {
            id: 7,
            title: "برنامج النشء والأطفال",
            description: "برنامج تعليمي ترفيهي مخصص للأطفال من سن 5 سنوات لتعليم الحروف والقراءة وحفظ قصار السور بأسلوب ممتع.",
            fullDescription: "برنامج مصمّم خصيصًا للأطفال بأسلوب تعليمي ترفيهي يجمع بين التعلّم والمرح. يستخدم وسائل تعليمية متنوعة مثل الأناشيد والقصص والألعاب التفاعلية لتحبيب الأطفال في القرآن الكريم.",
            image: "images/534b673d4919c186290ed8bf3fdb79b4.jpg",
            category: "kids",
            categoryLabel: "الأطفال",
            teacher: "الدكتورة نورا السيد",
            teacherRole: "متخصصة في تعليم الأطفال",
            teacherImage: "images/bc6c884a1f3ce9da2814faa5f478b11c.jpg",
            duration: "9 أشهر",
            lessons: 72,
            level: "مبتدئ",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "أسلوب تعليمي ترفيهي وممتع",
                "أناشيد وألعاب تعليمية تفاعلية",
                "حصص قصيرة مناسبة للأطفال (30 دقيقة)",
                "تقارير متابعة دورية لولي الأمر",
                "حفظ جزء عمّ كاملاً",
                "شهادات تشجيعية ومكافآت"
            ],
            curriculum: [
                "تعليم الحروف بالأناشيد",
                "تركيب الكلمات البسيطة",
                "حفظ سورة الفاتحة والإخلاص والفلق والناس",
                "حفظ قصار السور (المسد - الفيل)",
                "حفظ سور متوسطة (النبأ - عبس)",
                "مراجعة جزء عمّ كاملاً"
            ]
        },
        {
            id: 8,
            title: "السيرة النبوية والأخلاق",
            description: "دراسة سيرة النبي ﷺ وأخلاقه وصفاته مع استخراج الدروس التربوية والعملية من أحداث السيرة العطرة.",
            fullDescription: "برنامج شامل لدراسة سيرة خير البشر محمد ﷺ من ميلاده حتى وفاته. يتناول الأحداث الرئيسية مع التركيز على الدروس التربوية والأخلاقية المستفادة. يهدف لتعزيز محبة النبي ﷺ والاقتداء به.",
            image: "images/48cbf397fff3e2905819f84db23dcee5.jpg",
            category: "islamic",
            categoryLabel: "العلوم الشرعية",
            teacher: "الشيخ يوسف الحسني",
            teacherRole: "متخصص في السيرة والتاريخ الإسلامي",
            teacherImage: "images/1f1a317d0f410f72cf7bafa71117971a.jpg",
            duration: "4 أشهر",
            lessons: 32,
            level: "جميع المستويات",
            schedule: "حصتان أسبوعيًا",
            features: [
                "سرد ممتع وشيّق للسيرة",
                "ربط الأحداث بدروس عملية",
                "عرض مرئي وخرائط ذهنية",
                "أنشطة وتمارين تفاعلية",
                "مناسب لجميع الأعمار",
                "شهادة إتمام البرنامج"
            ],
            curriculum: [
                "حياة النبي ﷺ قبل البعثة",
                "البعثة والدعوة السرية",
                "الهجرة وبناء الدولة",
                "الغزوات والمعارك الكبرى",
                "فتح مكة وحجة الوداع",
                "أخلاق النبي ﷺ وصفاته"
            ]
        },
        {
            id: 9,
            title: "أحكام التلاوة للنساء",
            description: "برنامج مخصص للأخوات لتعلّم التلاوة الصحيحة وأحكام التجويد في بيئة تعليمية مريحة ومناسبة.",
            fullDescription: "برنامج تعليمي مصمّم خصيصًا للنساء، يوفّر بيئة تعليمية مريحة مع معلمات مؤهلات ومُجازات. يغطي البرنامج أحكام التجويد كاملة مع التطبيق العملي، بالإضافة لتصحيح التلاوة والقراءة الفردية.",
            image: "images/OIP.webp",
            category: "tajweed",
            categoryLabel: "التجويد",
            teacher: "الكتورة ابتسام أيمن",
            teacherRole: "مُجازة بالقراءات ومعلمة تجويد",
            teacherImage: "images/afb713bf886bb3e99f70ceec0bc7fb33.jpg",
            duration: "5 أشهر",
            lessons: 40,
            level: "مبتدئ - متوسط",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "بيئة تعليمية نسائية بالكامل",
                "معلمات مؤهلات ومُجازات",
                "مرونة في المواعيد",
                "حلقات قراءة جماعية",
                "تصحيح فردي للتلاوة",
                "شهادة إتمام معتمدة"
            ],
            curriculum: [
                "أساسيات النطق الصحيح",
                "أحكام النون الساكنة والتنوين",
                "أحكام الميم الساكنة واللام",
                "المدود وأنواعها",
                "أحكام الراء والتفخيم والترقيق",
                "التطبيق الشامل على سور مختارة"
            ]
        }
    ];

    window.programsData = programsData;

        /* ────────  SVG Icons المستخدمة────────── */
    const icons = {
        clock: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        book: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
        level: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        calendar: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        arrow: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17l-4-4m0 0l4-4m-4 4h18"/></svg>',
        play: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        check: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        user: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
        star: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>'
    };

    /* ────── إنشاء كارت برنامج واحد (Reusable) ───────── */
    function createProgramCard(program, index) {
        const card = document.createElement("a");
        card.className = "program-card";
        card.href = "course.html?id=" + program.id;
        card.setAttribute("data-index", index);
        card.setAttribute("data-category", program.category);
        card.setAttribute("role", "article");
        card.setAttribute("aria-label", program.title);

        card.innerHTML = `
            <!-- صورة الكارت -->
            <div class="program-card__image-wrapper">
                <img
                    class="program-card__image"
                    src="${program.image}"
                    alt="${program.title}"
                    loading="lazy"
                />
                <div class="program-card__image-overlay"></div>

                <!-- تصنيف البرنامج -->
                <span class="program-card__category program-card__category--${program.category}">
                    ${program.categoryLabel}
                </span>

                <!-- عدد الدروس -->
                <span class="program-card__lessons-badge">
                    ${icons.play}
                    <span>${program.lessons} درس</span>
                </span>
            </div>

            <!-- محتوى الكارت -->
            <div class="program-card__body">
                <h3 class="program-card__title">${program.title}</h3>
                <p class="program-card__desc">${program.description}</p>

                <!-- المعلومات السريعة -->
                <div class="program-card__meta">
                    <span class="program-card__meta-item">
                        ${icons.clock}
                        <span>${program.duration}</span>
                    </span>
                    <span class="program-card__meta-item">
                        ${icons.level}
                        <span>${program.level}</span>
                    </span>
                    <span class="program-card__meta-item">
                        ${icons.calendar}
                        <span>${program.schedule}</span>
                    </span>
                </div>
            </div>
        `;

        return card;
    }

    /* ────── renderPrograms ───────── */
    function renderPrograms(section) {
        // ✅ استخدام section.querySelector بدل document
        const grid = section.querySelector("#programsGrid");
        if (!grid) return;

        const fragment = document.createDocumentFragment();

        programsData.forEach(function (program, index) {
            const card = createProgramCard(program, index);
            fragment.appendChild(card);
        });

        grid.appendChild(fragment);

        initScrollAnimation(section);
        initFilter(section);
    }

    /* ────── (Fade + Stagger) ──────── */
    function initScrollAnimation(section) {
        // ✅ استخدام section.querySelectorAll بدل document
        const animatedElements = section.querySelectorAll("[data-animate]");
        const cards = section.querySelectorAll(".program-card");

        const observerOptions = {
            root: null,
            rootMargin: "0px 0px -50px 0px",
            threshold: 0.1,
        };

        // Observer للعناصر العامة
        const generalObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-animated");
                    generalObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        animatedElements.forEach(function (el) {
            generalObserver.observe(el);
        });

        // Observer للكروت مع Stagger
        const cardObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const index = parseInt(card.getAttribute("data-index"), 10);
                    const delay = index * 100;

                    setTimeout(function () {
                        card.style.transition =
                            "opacity 0.7s cubic-bezier(0.25,0.46,0.45,0.94), " +
                            "transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94)";
                        card.classList.add("is-visible");
                    }, delay);

                    cardObserver.unobserve(card);
                }
            });
        }, observerOptions);

        cards.forEach(function (card) {
            cardObserver.observe(card);
        });
    }

        /* ──────── فلتر التصنيفات ────────── */
    function initFilter(section) {
        // ✅ استخدام section.querySelectorAll بدل document
        const filterBtns = section.querySelectorAll(".filter-bar__btn");
        const cards = section.querySelectorAll(".program-card");

        if (!filterBtns.length) return;

        filterBtns.forEach(function (btn) {
            btn.addEventListener("click", function () {
                const filter = this.getAttribute("data-filter");

                // تحديث حالة الأزرار
                filterBtns.forEach(function (b) {
                    b.classList.remove("filter-bar__btn--active");
                });
                this.classList.add("filter-bar__btn--active");

                // فلتر الكروت مع أنيميشن
                let visibleIndex = 0;

                cards.forEach(function (card) {
                    const category = card.getAttribute("data-category");
                    const shouldShow = filter === "all" || category === filter;

                    if (shouldShow) {
                        const delay = visibleIndex * 80;
                        visibleIndex++;

                        // إخفاء أولاً
                        card.style.transition = "none";
                        card.classList.remove("is-visible");
                        card.classList.remove("program-card--hidden");
                        card.style.display = "";

                        // إظهار بأنيميشن
                        setTimeout(function () {
                            card.style.transition =
                                "opacity 0.5s ease, transform 0.5s ease";
                            card.classList.add("is-visible");
                        }, delay + 50);
                    } else {
                        card.style.transition = "opacity 0.3s ease, transform 0.3s ease";
                        card.classList.remove("is-visible");

                        setTimeout(function () {
                            card.style.display = "none";
                        }, 300);
                    }
                });
            });
        });
    }

    /* ─────── صفحة تفاصيل الدورة (course.html) ──────────── */
    window.renderCourseDetail = function (courseId) {
        // ✅ course.html صفحة مستقلة - document.getElementById مقبول هنا
        const container = document.getElementById("courseDetail");
        if (!container) return;

        const course = programsData.find(function (p) {
            return p.id === courseId;
        });

        if (!course) {
            container.innerHTML = `
                <div class="course-detail__loading">
                    <p style="color:#9b2c2c;font-weight:700;">عذرًا، لم يتم العثور على هذا البرنامج</p>
                    <a href="index.html" class="back-btn" style="margin-top:1rem;">
                        ${icons.arrow}
                        <span>العودة للبرامج</span>
                    </a>
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <!-- ========== Hero Section ========== -->
            <div class="course-hero">
                <img
                    class="course-hero__image"
                    src="${course.image}"
                    alt="${course.title}"
                />
                <div class="course-hero__overlay">
                    <span class="course-hero__category course-hero__category--${course.category}">
                        ${course.categoryLabel}
                    </span>
                    <h1 class="course-hero__title">${course.title}</h1>
                    <p class="course-hero__subtitle">${course.description}</p>
                </div>
            </div>

            <!-- ========== Content Grid ========== -->
            <div class="course-content">

                <!-- العمود الرئيسي -->
                <div class="course-main">

                    <!-- وصف البرنامج -->
                    <div class="course-info-card">
                        <h2 class="course-info-card__title">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            عن البرنامج
                        </h2>
                        <p class="course-info-card__text">${course.fullDescription}</p>

                        <h3 class="course-info-card__title" style="margin-top:1.5rem;">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            مميزات البرنامج
                        </h3>
                        <ul class="course-features">
                            ${course.features
                                .map(
                                    (f) => `
                                <li class="course-features__item">
                                    <span class="course-features__icon">
                                        ${icons.check}
                                    </span>
                                    <span>${f}</span>
                                </li>
                            `
                                )
                                .join("")}
                        </ul>
                    </div>

                                <!-- المنهج الدراسي -->
                    <div class="course-info-card" style="margin-top:1.5rem;">
                        <h2 class="course-info-card__title">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            المنهج الدراسي
                        </h2>
                        <ul class="curriculum-list">
                            ${course.curriculum
                                .map(
                                    (item, i) => `
                                <li class="curriculum-list__item">
                                    <span class="curriculum-list__num">${i + 1}</span>
                                    <span>${item}</span>
                                </li>
                            `
                                )
                                .join("")}
                        </ul>
                    </div>
                </div>

                <!-- الشريط الجانبي -->
                <div class="course-sidebar">

                    <!-- تفاصيل سريعة -->
                    <div class="course-sidebar__card">
                        <h3 class="course-sidebar__title">تفاصيل البرنامج</h3>
                        <ul class="course-details-list">
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.clock}
                                    <span>المدة</span>
                                </span>
                                <span class="course-details-list__value">${course.duration}</span>
                            </li>
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.book}
                                    <span>عدد الدروس</span>
                                </span>
                                <span class="course-details-list__value">${course.lessons} درس</span>
                            </li>
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.level}
                                    <span>المستوى</span>
                                </span>
                                <span class="course-details-list__value">${course.level}</span>
                            </li>
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.calendar}
                                    <span>الجدول</span>
                                </span>
                                <span class="course-details-list__value">${course.schedule}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- المعلم -->
                    <div class="course-sidebar__card">
                        <h3 class="course-sidebar__title">المعلم</h3>
                        <div class="teacher-card">
                            <img
                                class="teacher-card__avatar"
                                src="${course.teacherImage}"
                                alt="${course.teacher}"
                                loading="lazy"
                            />
                            <div>
                                <p class="teacher-card__name">${course.teacher}</p>
                                <p class="teacher-card__role">${course.teacherRole}</p>
                            </div>
                        </div>
                    </div>

                    <!-- مشاركة -->
                    <div class="course-sidebar__card">
                        <h3 class="course-sidebar__title">شارك البرنامج</h3>
                        <div class="share-buttons">
                            <button class="share-btn share-btn--whatsapp" onclick="shareCourse('whatsapp', '${course.title}')" aria-label="مشاركة عبر واتساب">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </button>
                            <button class="share-btn share-btn--twitter" onclick="shareCourse('twitter', '${course.title}')" aria-label="مشاركة عبر تويتر">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </button>
                            <button class="share-btn share-btn--copy" onclick="shareCourse('copy', '${course.title}')" aria-label="نسخ الرابط">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        `;
    };

    /* ───────── مشاركة الدورة ───────── */
    window.shareCourse = function (platform, title) {
        const url = window.location.href;
        const text = "أنصحكم ببرنامج: " + title + " من أكاديمية مشكاة 🌟";

        switch (platform) {
            case "whatsapp":
                window.open(
                    "https://wa.me/?text=" + encodeURIComponent(text + "\n" + url),
                    "_blank"
                );
                break;
            case "twitter":
                window.open(
                    "https://twitter.com/intent/tweet?text=" +
                        encodeURIComponent(text) +
                        "&url=" +
                        encodeURIComponent(url),
                    "_blank"
                );
                break;
            case "copy":
                navigator.clipboard.writeText(url).then(function () {
                    // ✅ course.html صفحة مستقلة - document.querySelector مقبول هنا
                    var btn = document.querySelector(".share-btn--copy");
                    var originalHTML = btn.innerHTML;
                    btn.innerHTML =
                        '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
                    btn.style.background = "#dcfce7";
                    btn.style.color = "#155e3a";
                    setTimeout(function () {
                        btn.innerHTML = originalHTML;
                        btn.style.background = "";
                        btn.style.color = "";
                    }, 2000);
                });
                break;
        }
    };


    function init() {
        
        const section = document.getElementById("programs-section");

        // تشغيل renderPrograms فقط لو الـ section موجود والـ grid موجود جوّاه
        if (section && section.querySelector("#programsGrid")) {
            renderPrograms(section);
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }

})();
