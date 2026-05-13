<?php
// Student Exam Page
?>
<div class="max-w-3xl mx-auto animate-fadeIn" dir="rtl">
    <div id="examIntro" class="luxury-card rounded-3xl shadow-sm border border-gray-100 p-8 text-center">
        <div class="w-20 h-20 bg-mishkat-green-50 text-mishkat-green-600 rounded-[2rem] flex items-center justify-center mx-auto mb-6">
            <span class="material-icons-outlined text-4xl">quiz</span>
        </div>
        <h2 class="text-2xl font-black text-gray-900 mb-2">اختبار القرآن الكريم - المستوى الأول</h2>
        <p class="text-gray-500 mb-8 font-medium">هذا الاختبار يقيس مدى إتقانك لأحكام التجويد الأساسية وحفظ السور المقررة.</p>
        
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="p-4 bg-gray-50 rounded-[2rem] border border-gray-100 text-center">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">عدد الأسئلة</p>
                <p class="text-xl font-black text-gray-800">5</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-[2rem] border border-gray-100 text-center">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">الوقت المقدر</p>
                <p class="text-xl font-black text-gray-800">10 دقائق</p>
            </div>
        </div>

        <button onclick="startExam()" class="w-full py-4 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-xl shadow-mishkat-green-100">
            ابدأ الاختبار الآن
        </button>
    </div>

    <div id="examContent" class="hidden space-y-6">
        <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-mishkat-green-50 text-mishkat-green-600 rounded-[1.5rem] flex items-center justify-center font-black" id="qNumber">1</div>
                <h3 class="font-bold text-gray-800">السؤال <span id="currentQ">1</span> من 5</h3>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-icons-outlined text-gray-400 text-sm">timer</span>
                <span id="timer" class="font-black text-mishkat-green-700">05:00</span>
            </div>
        </div>

        <div class="luxury-card rounded-3xl shadow-sm border border-gray-100 p-8">
            <p id="questionText" class="text-xl font-bold text-gray-900 mb-8 leading-relaxed"></p>
            <div id="options" class="space-y-3"></div>
        </div>

        <div class="flex justify-between items-center">
            <button id="prevBtn" onclick="prevQuestion()" class="px-8 py-3 bg-gray-100 text-gray-400 rounded-[1.5rem] font-bold transition-all disabled:opacity-50" disabled>السابق</button>
            <button id="nextBtn" onclick="nextQuestion()" class="px-8 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold hover:bg-mishkat-green-800 transition-all">التالي</button>
        </div>
    </div>
</div>

<script>
const questions = [
    {
        q: "ما هي مخارج الحروف الرئيسية؟",
        o: ["الجوف والحلق واللسان والشفتان والخيشوم", "العين والأنف والفم", "الصدر والبطن واليدين", "الأذن والعنق والكتف"],
        a: 0
    },
    {
        q: "كم عدد حروف الإدغام؟",
        o: ["4 حروف", "6 حروف (يرملون)", "8 حروف", "حرف واحد"],
        a: 1
    },
    {
        q: "ما هو حكم النون الساكنة في كلمة 'من بعد'؟",
        o: ["إظهار", "إدغام", "إقلاب", "إخفاء"],
        a: 2
    },
    {
        q: "ما هي حروف القلقلة؟",
        o: ["يرملون", "قطب جد", "أنيت", "سكت"],
        a: 1
    },
    {
        q: "أين يقع مخرج حرف 'القاف'؟",
        o: ["طرف اللسان", "وسط اللسان", "أقصى اللسان مما يلي الحلق", "الشفتان"],
        a: 2
    }
];

let currentIdx = 0;
let userAnswers = new Array(questions.length).fill(null);
let timeRemaining = 300;
let timerInterval;

function startExam() {
    document.getElementById('examIntro').classList.add('hidden');
    document.getElementById('examContent').classList.remove('hidden');
    renderQuestion();
    startTimer();
}

function renderQuestion() {
    const q = questions[currentIdx];
    document.getElementById('currentQ').innerText = currentIdx + 1;
    document.getElementById('qNumber').innerText = currentIdx + 1;
    document.getElementById('questionText').innerText = q.q;
    
    const optionsDiv = document.getElementById('options');
    optionsDiv.innerHTML = q.o.map((opt, i) => `
        <label class="block relative cursor-pointer group">
            <input type="radio" name="answer" value="${i}" ${userAnswers[currentIdx] === i ? 'checked' : ''} onchange="saveAnswer(${i})" class="hidden peer">
            <div class="flex items-center gap-4 p-5 rounded-[2rem] border-2 border-gray-50 bg-gray-50 peer-checked:border-mishkat-green-500 peer-checked:bg-mishkat-green-50 transition-all hover:border-mishkat-green-200">
                <div class="w-6 h-6 rounded-full border-2 border-gray-300 peer-checked:border-mishkat-green-500 flex items-center justify-center transition-all">
                    <div class="w-3 h-3 bg-mishkat-green-500 rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                </div>
                <span class="font-bold text-gray-700">${opt}</span>
            </div>
        </label>
    `).join('');

    document.getElementById('prevBtn').disabled = currentIdx === 0;
    document.getElementById('nextBtn').innerText = currentIdx === questions.length - 1 ? 'إنهاء الاختبار' : 'التالي';
}

function saveAnswer(val) {
    userAnswers[currentIdx] = val;
}

function nextQuestion() {
    if (userAnswers[currentIdx] === null) {
        showToast('يرجى اختيار إجابة أولاً', 'error');
        return;
    }
    if (currentIdx < questions.length - 1) {
        currentIdx++;
        renderQuestion();
    } else {
        finishExam();
    }
}

function prevQuestion() {
    if (currentIdx > 0) {
        currentIdx--;
        renderQuestion();
    }
}

function finishExam() {
    clearInterval(timerInterval);
    let score = 0;
    userAnswers.forEach((ans, i) => {
        if (ans === questions[i].a) score++;
    });
    window.location.href = `?page=result&score=${score}&total=${questions.length}`;
}

function startTimer() {
    timerInterval = setInterval(() => {
        timeRemaining--;
        const m = Math.floor(timeRemaining / 60);
        const s = timeRemaining % 60;
        document.getElementById('timer').innerText = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
        if (timeRemaining <= 0) finishExam();
    }, 1000);
}
</script>
