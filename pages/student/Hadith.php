<?php
/**
 * Hadith Collection - Native Platform Version
 */
?>

<div class="space-y-8 animate-fadeIn">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-mishkat-green-900 dark:text-white font-tajawal">الأحاديث النبوية</h2>
            <p class="text-gray-500 dark:text-gray-400 font-medium">من جوامع كلم النبي ﷺ</p>
        </div>
        <div class="luxury-card px-6 py-2 bg-mishkat-green-900 text-white font-bold rounded-full text-sm">
            الأربعون النووية
        </div>
    </div>

    <!-- Hadith List -->
    <div id="hadithList" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Hadiths injected here -->
    </div>
</div>

<style>
    .hadith-card {
        @apply luxury-card p-8 flex flex-col gap-6 hover:border-mishkat-gold-500/30 transition-all;
    }
    .hadith-text {
        @apply text-xl font-amiri font-bold text-mishkat-green-900 dark:text-gray-200 leading-relaxed text-right;
    }
    .hadith-label {
        @apply text-[10px] font-black text-mishkat-gold-600 uppercase tracking-widest;
    }
</style>

<script>
    const Hadiths = [
        { id: 1, title: "إنما الأعمال بالنيات", text: "عن أمير المؤمنين أبي حفص عمر بن الخطاب رضي الله عنه قال: سمعت رسول الله ﷺ يقول: «إنما الأعمال بالنيات، وإنما لكل امرئ ما نوى، فمن كانت هجرته إلى الله ورسوله، فهجرته إلى الله ورسوله، ومن كانت هجرته لدنيا يصيبها أو امرأة ينكحها، فهجرته إلى ما هاجر إليه»." },
        { id: 2, title: "مراتب الدين", text: "عن عمر رضي الله عنه أيضاً قال: بينما نحن جلوس عند رسول الله ﷺ ذات يوم، إذ طلع علينا رجل شديد بياض الثياب، شديد سواد الشعر... قال: فأخبرني عن الإيمان؟ قال: «أن تؤمن بالله، وملائكته، وكتبه، ورسله، واليوم الآخر، وتؤمن بالقدر خيره وشره»." },
        { id: 3, title: "أركان الإسلام", text: "عن أبي عبد الرحمن عبد الله بن عمر بن الخطاب رضي الله عنهما قال: سمعت رسول الله ﷺ يقول: «بني الإسلام على خمس: شهادة أن لا إله إلا الله وأن محمداً رسول الله، وإقام الصلاة، وإيتاء الزكاة، وحج البيت، وصوم رمضان»." },
        { id: 4, title: "خلق الإنسان", text: "عن أبي عبد الرحمن عبد الله بن مسعود رضي الله عنه قال: حدثنا رسول الله ﷺ وهو الصادق المصدوق: «إن أحدكم يجمع خلقه في بطن أمه أربعين يوماً نطفة، ثم يكون علقة مثل ذلك، ثم يكون مضغة مثل ذلك، ثم يرسل إليه الملك فينفخ فيه الروح...»." },
        { id: 5, title: "النهي عن الابتداع", text: "عن أم المؤمنين أم عبد الله عائشة رضي الله عنها قالت: قال رسول الله ﷺ: «من أحدث في أمرنا هذا ما ليس منه فهو رد»." },
        { id: 6, title: "البعد عن الشبهات", text: "عن أبي عبد الله النعمان بن بشير رضي الله عنهما قال: سمعت رسول الله ﷺ يقول: «إن الحلال بين وإن الحرام بين، وبينهما أمور مشتبهات لا يعلمهن كثير من الناس، فمن اتقى الشبهات فقد استبرأ لدينه وعرضه...»." }
    ];

    const listEl = document.getElementById('hadithList');
    listEl.innerHTML = Hadiths.map(h => `
        <div class="hadith-card group">
            <div class="flex justify-between items-start">
                <div class="w-10 h-10 rounded-xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-700 dark:text-mishkat-gold-500 flex items-center justify-center font-black">
                    ${h.id}
                </div>
                <span class="hadith-label">${h.title}</span>
            </div>
            <p class="hadith-text">${h.text}</p>
            <div class="pt-4 border-t border-gray-50 dark:border-white/5 flex justify-between items-center">
                <span class="text-[10px] text-gray-400 font-bold">رواه البخاري ومسلم</span>
                <button class="text-mishkat-gold-600 hover:text-mishkat-gold-500 transition-colors">
                    <span class="material-icons-outlined">share</span>
                </button>
            </div>
        </div>
    `).join('');
</script>
