<?php
/**
 * Islamic Quiz - Native Platform Version
 */
?>

<div class="max-w-4xl mx-auto space-y-8 animate-fadeIn">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-black text-mishkat-green-900 dark:text-white font-tajawal">اختبارات مشكاة</h2>
            <p class="text-gray-500 dark:text-gray-400 font-medium">اختبر معلوماتك الإسلامية بأسلوب ممتع</p>
        </div>
        <div id="quizScore" class="hidden luxury-card px-6 py-2 bg-mishkat-gold-500 text-black font-black rounded-full">
            النقاط: <span id="currentPoints">0</span>
        </div>
    </div>

    <!-- Quiz Intro -->
    <div id="quizIntro" class="luxury-card p-10 text-center space-y-6">
        <div class="w-20 h-20 bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-700 dark:text-mishkat-gold-500 rounded-3xl flex items-center justify-center mx-auto">
            <span class="material-icons-outlined text-4xl">quiz</span>
        </div>
        <h3 class="text-2xl font-black text-gray-900 dark:text-white">جاهز للتحدي؟</h3>
        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto">تتكون المسابقة من 10 أسئلة متنوعة في القرآن والسنة والفقه. ستحصل على 10 نقاط لكل إجابة صحيحة.</p>
        <button onclick="QuizApp.start()" class="btn-luxury px-10 py-4 text-lg">ابدأ الاختبار الآن</button>
    </div>

    <!-- Quiz Body (Hidden) -->
    <div id="quizBody" class="hidden space-y-6">
        <!-- Progress -->
        <div class="flex justify-between items-center px-2">
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">السؤال <span id="qNumber">1</span> من 10</span>
            <div class="w-48 h-2 bg-gray-100 dark:bg-white/5 rounded-full overflow-hidden">
                <div id="quizProgress" class="h-full bg-mishkat-gold-500 transition-all duration-500" style="width: 10%"></div>
            </div>
        </div>

        <!-- Question Card -->
        <div class="luxury-card p-8 md:p-12 min-h-[300px] flex flex-col justify-center">
            <h3 id="questionText" class="text-xl md:text-2xl font-black text-mishkat-green-900 dark:text-white text-right leading-relaxed mb-10"></h3>
            
            <div id="optionsGrid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Options injected here -->
            </div>
        </div>
    </div>

    <!-- Results (Hidden) -->
    <div id="quizResult" class="hidden luxury-card p-12 text-center space-y-8">
        <div id="resultIcon" class="w-24 h-24 rounded-full flex items-center justify-center mx-auto text-5xl"></div>
        <div>
            <h3 id="resultTitle" class="text-3xl font-black text-gray-900 dark:text-white mb-2"></h3>
            <p id="resultDesc" class="text-gray-500"></p>
        </div>
        <div class="flex justify-center gap-10">
            <div class="text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">النتيجة</p>
                <p class="text-4xl font-black text-mishkat-green-700 dark:text-mishkat-gold-400"><span id="finalScore">0</span>/10</p>
            </div>
            <div class="text-center border-r border-gray-100 dark:border-white/10 pr-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">النقاط المكتسبة</p>
                <p class="text-4xl font-black text-blue-600 dark:text-blue-400">+<span id="finalPoints">0</span></p>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
            <button onclick="QuizApp.start()" class="btn-luxury px-8 py-3">إعادة الاختبار</button>
            <a href="dashboard.php" class="px-8 py-3 bg-gray-100 text-gray-600 rounded-xl font-black hover:bg-gray-200 transition-all">العودة للرئيسية</a>
        </div>
    </div>
</div>

<style>
    .option-btn {
        @apply w-full text-right p-5 rounded-2xl border-2 border-gray-50 dark:border-white/5 bg-white dark:bg-mishkat-green-900/10 font-bold text-gray-700 dark:text-gray-200 hover:border-mishkat-gold-500 transition-all flex items-center justify-between group active:scale-[0.98];
    }
    .option-btn.correct {
        @apply border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400;
    }
    .option-btn.wrong {
        @apply border-red-500 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400;
    }
</style>

<script>
    const QuizApp = {
        questions: [
            { q: "من هو أول من أسلم من الرجال؟", a: ["أبو بكر الصديق", "عمر بن الخطاب", "عثمان بن عفان", "علي بن أبي طالب"], correct: 0 },
            { q: "ما هي أطول سورة في القرآن الكريم؟", a: ["آل عمران", "البقرة", "النساء", "المائدة"], correct: 1 },
            { q: "كم عدد أركان الإسلام؟", a: ["4", "5", "6", "7"], correct: 1 },
            { q: "في أي شهر نزل القرآن الكريم؟", a: ["رجب", "شعبان", "رمضان", "ذو الحجة"], correct: 2 },
            { q: "ما هو لقب حمزة بن عبد المطلب؟", a: ["الفاروق", "سيف الله المسلول", "أسد الله", "ذو النورين"], correct: 2 },
            { q: "كم عدد السجدات في القرآن الكريم؟", a: ["12", "14", "15", "11"], correct: 2 },
            { q: "ما هي الصلاة التي ليس فيها ركوع ولا سجود؟", a: ["الوتر", "الضحى", "الجنازة", "الخسوف"], correct: 2 },
            { q: "من هو النبي الذي لقب بـ 'كليم الله'؟", a: ["إبراهيم عليه السلام", "موسى عليه السلام", "عيسى عليه السلام", "محمد ﷺ"], correct: 1 },
            { q: "ما هي السورة التي تسمى 'عروس القرآن'؟", a: ["يس", "الرحمن", "الملك", "الواقعة"], correct: 1 },
            { q: "كم عدد أبواب الجنة؟", a: ["7", "8", "9", "10"], correct: 1 }
        ],
        currentIndex: 0,
        score: 0,
        canAnswer: true,

        start() {
            this.currentIndex = 0;
            this.score = 0;
            this.canAnswer = true;
            document.getElementById('quizIntro').classList.add('hidden');
            document.getElementById('quizResult').classList.add('hidden');
            document.getElementById('quizBody').classList.remove('hidden');
            document.getElementById('quizScore').classList.remove('hidden');
            this.renderQuestion();
        },

        renderQuestion() {
            const q = this.questions[this.currentIndex];
            document.getElementById('qNumber').innerText = this.currentIndex + 1;
            document.getElementById('quizProgress').style.width = ((this.currentIndex + 1) / 10 * 100) + '%';
            document.getElementById('questionText').innerText = q.q;
            document.getElementById('currentPoints').innerText = this.score * 10;

            const grid = document.getElementById('optionsGrid');
            grid.innerHTML = q.a.map((opt, i) => `
                <button onclick="QuizApp.checkAnswer(${i})" class="option-btn group">
                    <span>${opt}</span>
                    <span class="material-icons-outlined opacity-0 group-hover:opacity-100 transition-opacity">arrow_back</span>
                </button>
            `).join('');
            this.canAnswer = true;
        },

        checkAnswer(idx) {
            if (!this.canAnswer) return;
            this.canAnswer = false;

            const q = this.questions[this.currentIndex];
            const btns = document.querySelectorAll('.option-btn');
            
            if (idx === q.correct) {
                this.score++;
                btns[idx].classList.add('correct');
            } else {
                btns[idx].classList.add('wrong');
                btns[q.correct].classList.add('correct');
            }

            setTimeout(() => {
                this.currentIndex++;
                if (this.currentIndex < this.questions.length) {
                    this.renderQuestion();
                } else {
                    this.showResults();
                }
            }, 1500);
        },

        showResults() {
            document.getElementById('quizBody').classList.add('hidden');
            document.getElementById('quizResult').classList.remove('hidden');
            
            document.getElementById('finalScore').innerText = this.score;
            document.getElementById('finalPoints').innerText = this.score * 10;
            
            const icon = document.getElementById('resultIcon');
            const title = document.getElementById('resultTitle');
            const desc = document.getElementById('resultDesc');
            
            if (this.score >= 8) {
                icon.innerHTML = '🏆';
                icon.className = 'w-24 h-24 rounded-full bg-yellow-50 flex items-center justify-center mx-auto text-5xl';
                title.innerText = 'ممتاز ومبدع!';
                desc.innerText = 'لقد اجتزت الاختبار بتفوق باهر، استمر في طلب العلم.';
            } else if (this.score >= 5) {
                icon.innerHTML = '⭐';
                icon.className = 'w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center mx-auto text-5xl';
                title.innerText = 'أداء جيد جداً';
                desc.innerText = 'لديك معلومات قيمة، يمكنك المحاولة مرة أخرى للحصول على الدرجة النهائية.';
            } else {
                icon.innerHTML = '📚';
                icon.className = 'w-24 h-24 rounded-full bg-gray-50 flex items-center justify-center mx-auto text-5xl';
                title.innerText = 'محاولة جيدة';
                desc.innerText = 'تحتاج لمراجعة بعض المعلومات، العلم يأتي بالتعلم والمثابرة.';
            }
        }
    };
</script>
