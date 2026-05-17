<?php /** Hadith Collection */ ?>
<style>
    .hadith-hero {
        background: var(--sidebar-active-bg);
        border: 1px solid var(--border-color);
        border-radius: 2rem;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    html.dark .hadith-hero {
        background: linear-gradient(135deg, rgba(212,168,67,0.06) 0%, transparent 100%);
        border-color: rgba(212,168,67,0.12);
    }
    .hadith-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 1.75rem;
        padding: 1.75rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }
    .hadith-card::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 4px;
        height: 100%;
        background: var(--color-primary);
        border-radius: 0 1.75rem 1.75rem 0;
        opacity: 0;
        transition: opacity 0.25s;
    }
    .hadith-card:hover {
        border-color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
    }
    .hadith-card:hover::before { opacity: 1; }
    html.dark .hadith-card:hover {
        box-shadow: 0 12px 30px rgba(212,168,67,0.08);
    }
    .hadith-num {
        width: 2.5rem; height: 2.5rem;
        border-radius: 0.875rem;
        display: flex; align-items: center; justify-content: center;
        font-weight: 900; font-size: 0.85rem;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        flex-shrink: 0;
        font-family: 'Tajawal', sans-serif;
    }
    .hadith-title {
        font-family: 'Tajawal', sans-serif;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--color-primary);
        letter-spacing: 0.05em;
    }
    .hadith-text {
        font-family: 'Amiri', serif;
        font-size: 1.25rem;
        line-height: 2.2;
        color: var(--color-text-main);
        text-align: right;
        direction: rtl;
    }
    .hadith-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    .hadith-source {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--color-text-muted);
        font-family: 'Tajawal', sans-serif;
        display: flex; align-items: center; gap: 0.3rem;
    }
    .hadith-share-btn {
        display: flex; align-items: center; justify-content: center;
        width: 2rem; height: 2rem;
        border-radius: 50%;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        border: none; cursor: pointer;
        transition: all 0.2s;
    }
    .hadith-share-btn:hover {
        background: var(--color-primary);
        color: white;
        transform: scale(1.1);
    }
    html.dark .hadith-share-btn:hover { color: #000; }
    .filter-tab {
        padding: 0.45rem 1.1rem;
        border-radius: 2rem;
        border: 1px solid var(--border-color);
        background: var(--bg-surface);
        color: var(--color-text-muted);
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Tajawal', sans-serif;
        white-space: nowrap;
    }
    .filter-tab.active, .filter-tab:hover {
        background: var(--color-primary);
        color: white;
        border-color: transparent;
    }
    html.dark .filter-tab.active, html.dark .filter-tab:hover { color: #000; }
</style>

<div class="animate-fadeIn" style="max-width: 1100px; margin: 0 auto;">

    <!-- Hero -->
    <div class="hadith-hero mb-6">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-3"
             style="background: var(--color-primary);">
            <span class="material-icons-outlined text-2xl" style="color:white;">library_books</span>
        </div>
        <h2 class="text-2xl font-black font-tajawal mb-1" style="color: var(--color-text-main);">الأحاديث النبوية الشريفة</h2>
        <p class="text-sm" style="color: var(--color-text-muted);">من جوامع كلم النبي ﷺ</p>
    </div>

    <!-- Filters -->
    <div class="flex gap-2 overflow-x-auto pb-2 mb-6 scrollbar-none">
        <button class="filter-tab active" onclick="filterHadiths('all', this)">الكل</button>
        <button class="filter-tab" onclick="filterHadiths('عقيدة', this)">العقيدة</button>
        <button class="filter-tab" onclick="filterHadiths('أخلاق', this)">الأخلاق</button>
        <button class="filter-tab" onclick="filterHadiths('عبادات', this)">العبادات</button>
        <button class="filter-tab" onclick="filterHadiths('معاملات', this)">المعاملات</button>
        <button class="filter-tab" onclick="filterHadiths('علم', this)">العلم</button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-3 gap-3 mb-6">
        <div class="luxury-card p-4 text-center">
            <p class="text-xl font-black" style="color: var(--color-primary);" id="totalCount">٤٢</p>
            <p class="text-xs mt-1 font-medium" style="color: var(--color-text-muted);">حديث</p>
        </div>
        <div class="luxury-card p-4 text-center">
            <p class="text-xl font-black" style="color: var(--color-primary);">٥</p>
            <p class="text-xs mt-1 font-medium" style="color: var(--color-text-muted);">مصادر</p>
        </div>
        <div class="luxury-card p-4 text-center">
            <p class="text-xl font-black" style="color: var(--color-primary);">٥</p>
            <p class="text-xs mt-1 font-medium" style="color: var(--color-text-muted);">فئات</p>
        </div>
    </div>

    <!-- Grid -->
    <div id="hadithGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-4"></div>
</div>

<script>
const Hadiths = [
    { id:1, cat:'عقيدة', title:'إنما الأعمال بالنيات', source:'متفق عليه',
      text:'عن أمير المؤمنين أبي حفص عمر بن الخطاب رضي الله عنه قال: سمعت رسول الله ﷺ يقول: «إنما الأعمال بالنيات، وإنما لكل امرئ ما نوى، فمن كانت هجرته إلى الله ورسوله، فهجرته إلى الله ورسوله، ومن كانت هجرته لدنيا يصيبها أو امرأة ينكحها، فهجرته إلى ما هاجر إليه».'},
    { id:2, cat:'عقيدة', title:'مراتب الدين', source:'رواه مسلم',
      text:'«أن تؤمن بالله، وملائكته، وكتبه، ورسله، واليوم الآخر، وتؤمن بالقدر خيره وشره».'},
    { id:3, cat:'عبادات', title:'أركان الإسلام', source:'متفق عليه',
      text:'«بُني الإسلام على خمس: شهادة أن لا إله إلا الله وأن محمداً رسول الله، وإقام الصلاة، وإيتاء الزكاة، وحج البيت، وصوم رمضان».'},
    { id:4, cat:'عقيدة', title:'خلق الإنسان', source:'متفق عليه',
      text:'«إن أحدكم يُجمع خلقه في بطن أمه أربعين يوماً نطفة، ثم يكون علقة مثل ذلك، ثم يكون مضغة مثل ذلك، ثم يُرسل إليه الملك فينفخ فيه الروح».'},
    { id:5, cat:'معاملات', title:'النهي عن الابتداع', source:'متفق عليه',
      text:'«مَن أحدث في أمرنا هذا ما ليس منه فهو رد».'},
    { id:6, cat:'معاملات', title:'الحلال بيّن', source:'متفق عليه',
      text:'«إن الحلال بيّن وإن الحرام بيّن، وبينهما أمور مشتبهات لا يعلمهن كثير من الناس، فمن اتقى الشبهات فقد استبرأ لدينه وعرضه».'},
    { id:7, cat:'أخلاق', title:'الدين النصيحة', source:'رواه مسلم',
      text:'«الدين النصيحة». قلنا: لمن؟ قال: «لله، ولكتابه، ولرسوله، ولأئمة المسلمين وعامتهم».'},
    { id:8, cat:'أخلاق', title:'المسلم من سلم الناس', source:'متفق عليه',
      text:'«المسلم من سلم المسلمون من لسانه ويده، والمهاجر من هجر ما نهى الله عنه».'},
    { id:9, cat:'أخلاق', title:'لا يؤمن أحدكم', source:'متفق عليه',
      text:'«لا يؤمن أحدكم حتى يحب لأخيه ما يحب لنفسه».'},
    { id:10, cat:'عبادات', title:'حرمة الدماء', source:'متفق عليه',
      text:'«لا يحل دم امرئ مسلم إلا بإحدى ثلاث: الثيب الزاني، والنفس بالنفس، والتارك لدينه المفارق للجماعة».'},
    { id:11, cat:'عبادات', title:'اتق الله حيثما كنت', source:'رواه الترمذي',
      text:'«اتق الله حيثما كنت، وأتبع السيئة الحسنة تمحها، وخالق الناس بخلق حسن».'},
    { id:12, cat:'معاملات', title:'ما نهيتكم عنه', source:'متفق عليه',
      text:'«ما نهيتكم عنه فاجتنبوه، وما أمرتكم به فأتوا منه ما استطعتم، فإنما أهلك الذين من قبلكم كثرة مسائلهم واختلافهم على أنبيائهم».'},
    { id:13, cat:'عبادات', title:'العبادة في الفتنة', source:'رواه مسلم',
      text:'«العبادة في الهرج كالهجرة إليّ».'},
    { id:14, cat:'أخلاق', title:'من رأى منكم منكراً', source:'رواه مسلم',
      text:'«مَن رأى منكم منكراً فليغيره بيده، فإن لم يستطع فبلسانه، فإن لم يستطع فبقلبه، وذلك أضعف الإيمان».'},
    { id:15, cat:'علم', title:'طلب العلم', source:'رواه ابن ماجه',
      text:'«طلب العلم فريضة على كل مسلم».'},
    { id:16, cat:'علم', title:'من سلك طريقاً', source:'رواه مسلم',
      text:'«مَن سلك طريقاً يلتمس فيه علماً سهّل الله له به طريقاً إلى الجنة».'},
    { id:17, cat:'أخلاق', title:'الرفق', source:'رواه مسلم',
      text:'«إن الله رفيق يحب الرفق، ويعطي على الرفق ما لا يعطي على العنف وما لا يعطي على سواه».'},
    { id:18, cat:'عبادات', title:'أفضل الصلاة', source:'رواه مسلم',
      text:'«أفضل الصلاة بعد الفريضة صلاة الليل».'},
    { id:19, cat:'أخلاق', title:'الصدق والكذب', source:'متفق عليه',
      text:'«عليكم بالصدق، فإن الصدق يهدي إلى البر، وإن البر يهدي إلى الجنة... وإياكم والكذب، فإن الكذب يهدي إلى الفجور، وإن الفجور يهدي إلى النار».'},
    { id:20, cat:'معاملات', title:'المسلم أخو المسلم', source:'متفق عليه',
      text:'«المسلم أخو المسلم، لا يظلمه ولا يُسلمه، ومن كان في حاجة أخيه كان الله في حاجته».'},
    { id:21, cat:'عبادات', title:'الطهور شطر الإيمان', source:'رواه مسلم',
      text:'«الطهور شطر الإيمان، والحمد لله تملأ الميزان، وسبحان الله والحمد لله تملآن ما بين السماء والأرض».'},
    { id:22, cat:'أخلاق', title:'الاستئذان', source:'متفق عليه',
      text:'«لا يدخل أحدكم بيتاً غير بيته حتى يستأذن ثلاثاً، فإن أُذن له فليدخل، وإلا فليرجع».'},
    { id:23, cat:'أخلاق', title:'حق الجار', source:'متفق عليه',
      text:'«من كان يؤمن بالله واليوم الآخر فليكرم جاره».'},
    { id:24, cat:'علم', title:'الحياء من الإيمان', source:'متفق عليه',
      text:'«الحياء من الإيمان، والإيمان في الجنة، والبذاء من الجفاء، والجفاء في النار».'},
    { id:25, cat:'عبادات', title:'أول ما يُحاسب', source:'رواه أبو داود',
      text:'«أول ما يُحاسب عليه العبد يوم القيامة من عمله صلاته، فإن صلحت فقد أفلح وأنجح».'},
    { id:26, cat:'أخلاق', title:'خير الناس', source:'رواه البخاري',
      text:'«خيركم من تعلّم القرآن وعلّمه».'},
    { id:27, cat:'أخلاق', title:'أكمل المؤمنين إيمانا', source:'رواه أبو داود',
      text:'«أكمل المؤمنين إيماناً أحسنهم خلقاً، وخياركم خياركم لنسائهم».'},
    { id:28, cat:'معاملات', title:'لا ضرر ولا ضرار', source:'رواه ابن ماجه',
      text:'«لا ضرر ولا ضرار».'},
    { id:29, cat:'عبادات', title:'الذكر', source:'رواه مسلم',
      text:'«كلمتان خفيفتان على اللسان، ثقيلتان في الميزان، حبيبتان إلى الرحمن: سبحان الله وبحمده، سبحان الله العظيم».'},
    { id:30, cat:'علم', title:'الاستشارة', source:'رواه أحمد',
      text:'«ما خاب من استخار، ولا ندم من استشار، ولا عال من اقتصد».'},
    { id:31, cat:'معاملات', title:'البيع بالخيار', source:'متفق عليه',
      text:'«البيّعان بالخيار ما لم يتفرقا، فإن صدقا وبيّنا بورك لهما في بيعهما، وإن كذبا وكتما محقت بركة بيعهما».'},
    { id:32, cat:'أخلاق', title:'الحسد والتباغض', source:'متفق عليه',
      text:'«لا تحاسدوا، ولا تناجشوا، ولا تباغضوا، ولا تدابروا، وكونوا عباد الله إخواناً».'},
    { id:33, cat:'عبادات', title:'الصيام جُنّة', source:'متفق عليه',
      text:'«الصيام جُنّة، وإذا كان يوم صوم أحدكم فلا يرفث ولا يصخب، فإن سابّه أحد أو قاتله فليقل: إني صائم».'},
    { id:34, cat:'علم', title:'العلم بالتعلم', source:'رواه البيهقي',
      text:'«إنما العلم بالتعلم، والحلم بالتحلم، ومن يتحرّ الخير يُعطه، ومن يتوقّ الشر يُوقَه».'},
    { id:35, cat:'معاملات', title:'أداء الأمانة', source:'رواه أبو داود',
      text:'«أدِّ الأمانة إلى من ائتمنك، ولا تخن من خانك».'},
    { id:36, cat:'أخلاق', title:'التسمية قبل الأكل', source:'متفق عليه',
      text:'«كُل بيمينك، وكُل مما يليك».'},
    { id:37, cat:'عبادات', title:'الدعاء', source:'رواه الترمذي',
      text:'«الدعاء هو العبادة». ثم قرأ: {وَقَالَ رَبُّكُمُ ادْعُونِي أَسْتَجِبْ لَكُمْ}.'},
    { id:38, cat:'أخلاق', title:'التواضع', source:'رواه مسلم',
      text:'«ما نقصت صدقة من مال، وما زاد الله عبداً بعفو إلا عزاً، وما تواضع أحد لله إلا رفعه الله».'},
    { id:39, cat:'معاملات', title:'الشفاعة الحسنة', source:'متفق عليه',
      text:'«من شفع شفاعة حسنة كان له نصيب منها، ومن شفع شفاعة سيئة كان له كفل منها».'},
    { id:40, cat:'عقيدة', title:'التوبة', source:'رواه الترمذي',
      text:'«التائب من الذنب كمن لا ذنب له».'},
    { id:41, cat:'علم', title:'فضل العلماء', source:'رواه أبو داود',
      text:'«فضل العالم على العابد كفضل القمر ليلة البدر على سائر الكواكب».'},
    { id:42, cat:'أخلاق', title:'الابتسامة صدقة', source:'رواه الترمذي',
      text:'«تبسّمك في وجه أخيك صدقة، وأمرك بالمعروف ونهيك عن المنكر صدقة».'},
];

let currentFilter = 'all';

function renderHadiths(list) {
    const grid = document.getElementById('hadithGrid');
    grid.innerHTML = list.map(h => `
        <div class="hadith-card" data-cat="${h.cat}">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:1rem;">
                <div class="hadith-num">${h.id}</div>
                <span class="hadith-title">${h.title}</span>
            </div>
            <p class="hadith-text">${h.text}</p>
            <div class="hadith-footer">
                <span class="hadith-source">
                    <span class="material-icons-outlined" style="font-size:0.9rem;">verified</span>
                    ${h.source}
                </span>
                <div style="display:flex; gap:0.5rem; align-items:center;">
                    <span style="padding:0.2rem 0.7rem; border-radius:2rem; background:var(--sidebar-active-bg); color:var(--color-primary); font-size:0.7rem; font-weight:700; font-family:'Tajawal',sans-serif;">${h.cat}</span>
                    <button class="hadith-share-btn" onclick="copyHadith(${h.id})" title="نسخ">
                        <span class="material-icons-outlined" style="font-size:1rem;">content_copy</span>
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    document.getElementById('totalCount').innerText = toArabic(list.length);
}

function filterHadiths(cat, btn) {
    currentFilter = cat;
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    const filtered = cat === 'all' ? Hadiths : Hadiths.filter(h => h.cat === cat);
    renderHadiths(filtered);
}

function copyHadith(id) {
    const h = Hadiths.find(x => x.id === id);
    if (h) {
        navigator.clipboard.writeText(h.text + '\n— ' + h.source);
        if (window.showToast) showToast('تم نسخ الحديث', 'success');
    }
}

function toArabic(n) {
    return n.toString().replace(/[0-9]/g, d => '٠١٢٣٤٥٦٧٨٩'[d]);
}

renderHadiths(Hadiths);
</script>
