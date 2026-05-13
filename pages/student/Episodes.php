<?php
// pages/student/Episodes.php
$courseId = intval($_GET['course_id'] ?? 0);
if(!$courseId) {
    echo "<div class='text-center py-20 luxury-card rounded-[3rem] shadow-sm'><p class='text-gray-400 font-bold'>يرجى اختيار دورة تدريبية أولاً.</p></div>";
    return;
}
$course = $conn->query("SELECT * FROM courses WHERE id=$courseId")->fetch_assoc();
if(!$course) {
    echo "<div class='text-center py-20 luxury-card rounded-[3rem] shadow-sm'><p class='text-gray-400 font-bold'>المسار التعليمي غير موجود.</p></div>";
    return;
}
?>
<div class="animate-fadeIn" dir="rtl">
    <!-- Header -->
    <div class="bg-mishkat-green-900 rounded-[3rem] p-8 md:p-12 text-white shadow-2xl relative overflow-hidden mb-10">
        <div class="relative z-10">
            <span class="px-4 py-1.5 bg-mishkat-green-700/50 rounded-full text-[10px] font-black mb-6 inline-block uppercase tracking-widest">مساري التعليمي</span>
            <h1 class="text-3xl md:text-5xl font-black mb-4 leading-tight"><?php echo htmlspecialchars($course['title']); ?></h1>
            <p class="text-mishkat-green-200 font-medium max-w-2xl mb-8 leading-relaxed"><?php echo htmlspecialchars($course['description']); ?></p>
            
            <div class="flex flex-wrap gap-6 items-center">
                <div class="flex items-center gap-3 bg-mishkat-green-800/40 px-6 py-3 rounded-[2rem] backdrop-blur-md">
                    <span class="material-icons-outlined text-mishkat-green-400">auto_stories</span>
                    <span class="text-sm font-black" id="episodeCount">0 حلقة</span>
                </div>
                <div class="flex items-center gap-3 bg-mishkat-green-800/40 px-6 py-3 rounded-[2rem] backdrop-blur-md">
                    <span class="material-icons-outlined text-mishkat-green-400">trending_up</span>
                    <span class="text-sm font-black" id="courseProgress">التقدم: 0%</span>
                </div>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-mishkat-green-800 rounded-full -translate-x-20 -translate-y-20 blur-[120px] opacity-40"></div>
    </div>

    <!-- Episodes List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-4">
            <h3 class="text-xl font-black text-gray-800 mb-6 px-2">محتوى الدورة</h3>
            <div id="episodesSidebar" class="space-y-3">
                <!-- Loading State -->
                <div class="p-6 luxury-card rounded-3xl shadow-sm animate-pulse">
                    <div class="h-4 bg-gray-100 rounded w-3/4 mb-2"></div>
                    <div class="h-3 bg-gray-50 rounded w-1/2"></div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div id="episodeViewer" class="luxury-card rounded-[3rem] shadow-xl border border-gray-100 overflow-hidden min-h-[500px] flex flex-col items-center justify-center text-center p-12">
                <div class="w-24 h-24 bg-mishkat-green-50 text-mishkat-green-700 rounded-[2rem] flex items-center justify-center mb-6">
                    <span class="material-icons-outlined text-5xl">play_circle_filled</span>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">ابدأ التعلم الآن</h3>
                <p class="text-gray-400 font-medium max-w-md">اختر حلقة من القائمة لبدء مشاهدة المحتوى التعليمي والاختبارات.</p>
            </div>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div id="resultModal" class="modal-backdrop">
    <div class="modal-box text-center">
        <div id="resultIcon" class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center"></div>
        <h2 id="resultTitle" class="text-2xl font-black mb-2"></h2>
        <p id="resultMsg" class="text-gray-500 font-medium mb-8"></p>
        
        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-gray-50 p-4 rounded-[2rem]">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-1">الدرجة</p>
                <p class="text-xl font-black text-gray-900" id="resultScore">0/0</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-[2rem]">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-1">النسبة</p>
                <p class="text-xl font-black text-gray-900" id="resultPct">0%</p>
            </div>
        </div>

        <button onclick="closeResultModal()" class="w-full py-4 bg-mishkat-green-700 text-white rounded-[2rem] font-black shadow-lg hover:bg-mishkat-green-800 transition-all">العودة للدروس</button>
    </div>
</div>

<script>
let currentEpisodes = [];
let activeEpId = null;
let currentQuiz = null;
let currentQuestions = [];
let currentQIndex = 0;
let userAnswers = [];

function loadCourseContent() {
    apiGet('get_episodes', '&course_id=<?php echo $courseId; ?>').then(res => {
        console.log('API Response (get_episodes):', res);
        if(res.success) {
            currentEpisodes = res.data;
            document.getElementById('episodeCount').innerText = `${currentEpisodes.length} حلقة`;
            
            // Calculate progress
            const completed = currentEpisodes.filter(e => e.completed == 1).length;
            const prog = currentEpisodes.length > 0 ? Math.round((completed / currentEpisodes.length) * 100) : 0;
            document.getElementById('courseProgress').innerText = `التقدم: ${prog}%`;
            
            renderSidebar();
        } else {
            console.error('API Error:', res.message);
            showToast('خطأ في تحميل الحلقات: ' + (res.message || 'خطأ مجهول'), 'error');
        }
    }).catch(err => {
        console.error('Fetch Error:', err);
        showToast('حدث خطأ في الاتصال بالخادم', 'error');
    });
}

function renderSidebar() {
    const sidebar = document.getElementById('episodesSidebar');
    if(currentEpisodes.length === 0) {
        sidebar.innerHTML = '<div class="p-8 text-center luxury-card rounded-3xl border border-dashed border-gray-100 text-gray-400 font-bold">لا توجد حلقات مضافة لهذا المسار بعد.</div>';
        return;
    }
    sidebar.innerHTML = currentEpisodes.map((ep, idx) => `
        <button onclick="viewEpisode(${ep.id})" class="w-full text-right p-4 rounded-3xl transition-all border ${activeEpId == ep.id ? 'bg-mishkat-green-50 border-mishkat-green-100 shadow-sm' : 'luxury-card border-gray-50 hover:bg-gray-50'} group">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-[1.5rem] flex items-center justify-center font-black text-sm ${ep.completed == 1 ? 'bg-mishkat-green-700 text-white' : 'bg-gray-100 text-gray-400'}">
                    ${ep.completed == 1 ? '<span class="material-icons-outlined text-lg">check</span>' : idx + 1}
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-black ${activeEpId == ep.id ? 'text-mishkat-green-900' : 'text-gray-700'}">${ep.title}</h4>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">${ep.has_quiz > 0 ? 'امتحان' : ((ep.content_type === 'video' || ep.content_type === 'youtube') ? 'فيديو' : ep.content_type === 'file' ? 'ملف' : 'درس نصي')}</p>
                </div>
            </div>
        </button>
    `).join('');
}

function viewEpisode(id) {
    activeEpId = id;
    renderSidebar();
    const ep = currentEpisodes.find(e => e.id == id);
    const viewer = document.getElementById('episodeViewer');
    
    viewer.innerHTML = `
        <div class="flex flex-col h-full w-full animate-fadeIn">
            <div class="p-8 border-b border-gray-50 text-right">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 mb-2">${ep.title}</h2>
                        <p class="text-gray-400 font-medium text-sm">${ep.description || ''}</p>
                    </div>
                    ${ep.completed == 1 ? '<span class="px-3 py-1 bg-mishkat-green-50 text-mishkat-green-700 rounded-lg text-[10px] font-black uppercase">مكتملة ✅</span>' : ''}
                </div>
            </div>
            <div class="flex-1 p-4 md:p-8 overflow-y-auto custom-scrollbar bg-gray-50/50 space-y-8">
                <!-- Video Section -->
                <div class="bg-black rounded-3xl overflow-hidden shadow-2xl">
                    ${renderContent(ep)}
                </div>

                <!-- Quiz Section -->
                <div id="inlineQuizContainer" class="luxury-card rounded-[2.5rem] p-6 md:p-10 shadow-sm border border-gray-100">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-[1.5rem] bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-icons-outlined">quiz</span>
                        </div>
                        <h3 class="text-xl font-black text-gray-900">اختبار الحلقة</h3>
                    </div>
                    <div id="inlineQuizContent">
                        <div class="text-center py-10">
                            <div class="animate-spin w-8 h-8 border-4 border-mishkat-green-700 border-t-transparent rounded-full mx-auto mb-4"></div>
                            <p class="text-gray-400 font-bold">جاري تحميل الاختبار...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    viewer.className = "luxury-card rounded-[3rem] shadow-xl border border-gray-100 overflow-hidden min-h-[500px] flex flex-col text-right";
    loadInlineQuiz(id);
}

function renderContent(ep) {
    if(ep.content_type === 'video' || ep.content_type === 'youtube') {
        const videoId = extractYoutubeId(ep.content_data);
        if(videoId) return `<div class="aspect-video"><iframe class="w-full h-full" src="https://www.youtube.com/embed/${videoId}?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>`;
        return `<div class="p-8 bg-blue-50 text-blue-700 rounded-3xl font-bold flex items-center gap-3"><span class="material-icons-outlined">link</span> <a href="${ep.content_data}" target="_blank" class="hover:underline">مشاهدة الفيديو في نافذة جديدة</a></div>`;
    }
    if(ep.content_type === 'file') {
        return `<video controls class="w-full rounded-3xl shadow-lg bg-black"><source src="${ep.content_data}" type="video/mp4">متصفحك لا يدعم تشغيل الفيديو.</video>`;
    }
    if(ep.content_type === 'link') {
        return `<div class="p-8 bg-gray-100 text-gray-700 rounded-3xl font-bold flex items-center justify-between">
            <div class="flex items-center gap-3"><span class="material-icons-outlined">link</span> رابط خارجي للمحتوى</div>
            <a href="${ep.content_data}" target="_blank" class="px-6 py-2 bg-gray-700 text-white rounded-[1.5rem] text-xs font-black">زيارة الرابط</a>
        </div>`;
    }
    return `<div class="p-10 luxury-card rounded-3xl prose prose-emerald max-w-none text-gray-700 font-medium leading-relaxed whitespace-pre-wrap">${ep.content_data}</div>`;
}

function extractYoutubeId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|live\/)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length == 11) ? match[2] : false;
}

function finishEpisode(id) {
    apiCall('complete_episode', { episode_id: id }).then(res => {
        if(res.success) {
            showToast('تهانينا! لقد أتممت الحلقة بنجاح.');
            loadCourseContent();
            // Reset viewer
            document.getElementById('episodeViewer').innerHTML = `
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="w-20 h-20 bg-mishkat-green-100 text-mishkat-green-700 rounded-full flex items-center justify-center mb-4">
                        <span class="material-icons-outlined text-4xl">check_circle</span>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 mb-2">تم إكمال الحلقة!</h3>
                    <p class="text-gray-400 font-medium">يمكنك الانتقال للحلقة التالية.</p>
                </div>
            `;
        }
    });
}

function loadInlineQuiz(eid) {
    apiGet('get_episode_quiz', `&episode_id=${eid}`).then(res => {
        const container = document.getElementById('inlineQuizContent');
        if(!res.success) {
            container.innerHTML = `
                <div class="text-center py-6">
                    <span class="material-icons-outlined text-4xl text-gray-200 mb-2">assignment_turned_in</span>
                    <p class="text-gray-400 font-bold">لا يوجد اختبار لهذه الحلقة. يمكنك اعتبارها مكتملة.</p>
                    <button onclick="finishEpisode(${eid})" class="mt-4 px-8 py-3 bg-mishkat-green-700 text-white rounded-[2rem] font-black">تحديد كمكتملة</button>
                </div>
            `;
            return;
        }
        currentQuiz = res.quiz;
        currentQuestions = res.questions;
        currentQIndex = 0;
        userAnswers = [];
        renderInlineQuestion();
    });
}

function renderInlineQuestion() {
    const q = currentQuestions[currentQIndex];
    const container = document.getElementById('inlineQuizContent');
    
    container.innerHTML = `
        <div class="animate-fadeIn">
            <div class="flex justify-between items-center mb-6">
                <span class="px-4 py-1 bg-mishkat-green-50 text-mishkat-green-700 text-xs font-black rounded-lg">السؤال ${currentQIndex + 1} من ${currentQuestions.length}</span>
                <div class="h-2 flex-1 mx-4 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-mishkat-green-500 transition-all duration-500" style="width: ${((currentQIndex+1)/currentQuestions.length)*100}%"></div>
                </div>
            </div>
            <h4 class="text-xl font-black text-gray-800 mb-8 leading-relaxed">${q.question}</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                ${q.options.map((opt, i) => `
                    <label class="flex items-center gap-4 p-5 rounded-3xl border-2 cursor-pointer transition-all ${userAnswers[currentQIndex] === i ? 'border-mishkat-green-700 bg-mishkat-green-50' : 'border-gray-50 hover:border-mishkat-green-100 hover:bg-gray-50'} group">
                        <input type="radio" name="quiz_opt" value="${i}" class="hidden" onchange="selectInlineOption(${i})">
                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all ${userAnswers[currentQIndex] === i ? 'border-mishkat-green-700 bg-mishkat-green-700 text-white scale-110' : 'border-gray-200 group-hover:border-mishkat-green-300'}">
                            ${userAnswers[currentQIndex] === i ? '<span class="material-icons-outlined text-[14px]">check</span>' : ''}
                        </div>
                        <span class="text-sm font-bold text-gray-700">${opt}</span>
                    </label>
                `).join('')}
            </div>
            <div class="flex gap-4 mt-10">
                ${currentQIndex > 0 ? `<button onclick="prevInlineQuestion()" class="px-8 py-4 bg-gray-100 text-gray-600 rounded-[2rem] font-black hover:bg-gray-200 transition-all">السابق</button>` : ''}
                <button onclick="${currentQIndex === currentQuestions.length - 1 ? 'submitInlineQuiz()' : 'nextInlineQuestion()'}" 
                        class="flex-1 py-4 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
                    ${currentQIndex === currentQuestions.length - 1 ? 'إنهاء الاختبار' : 'السؤال التالي'}
                </button>
            </div>
        </div>
    `;
}

function selectInlineOption(idx) {
    userAnswers[currentQIndex] = idx;
    renderInlineQuestion();
}

function nextInlineQuestion() {
    if(userAnswers[currentQIndex] === undefined) {
        showToast('يرجى اختيار إجابة أولاً', 'error');
        return;
    }
    currentQIndex++;
    renderInlineQuestion();
}

function prevInlineQuestion() {
    currentQIndex--;
    renderInlineQuestion();
}

function submitInlineQuiz() {
    if(userAnswers[currentQIndex] === undefined) {
        showToast('يرجى اختيار إجابة أولاً', 'error');
        return;
    }
    
    let score = 0;
    currentQuestions.forEach((q, i) => {
        if(userAnswers[i] == q.correct_answer) score++;
    });
    
    const pct = Math.round((score / currentQuestions.length) * 100);
    
    apiCall('submit_quiz_result', {
        episode_id: activeEpId,
        score: score,
        total: currentQuestions.length
    }).then(res => {
        if(res.success) {
            showResult(score, currentQuestions.length, pct);
            loadCourseContent();
        }
    });
}

function showResult(score, total, pct) {
    const isPassed = pct >= 50;
    const modal = document.getElementById('resultModal');
    
    document.getElementById('resultIcon').className = `w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center ${isPassed ? 'bg-mishkat-green-100 text-mishkat-green-700' : 'bg-red-100 text-red-700'}`;
    document.getElementById('resultIcon').innerHTML = `<span class="material-icons-outlined text-4xl">${isPassed ? 'emoji_events' : 'error_outline'}</span>`;
    document.getElementById('resultTitle').innerText = isPassed ? 'عمل رائع!' : 'تحتاج للمزيد من المراجعة';
    document.getElementById('resultMsg').innerText = isPassed ? 'لقد اجتزت اختبار هذه الحلقة بنجاح' : 'للأسف لم تحقق الدرجة المطلوبة، حاول مراجعة المحتوى مرة أخرى';
    document.getElementById('resultScore').innerText = `${score} / ${total}`;
    document.getElementById('resultPct').innerText = `${pct}%`;
    
    modal.classList.add('active');
}

function closeResultModal() {
    document.getElementById('resultModal').classList.remove('active');
    // Reset viewer
    viewEpisode(activeEpId);
}

// Init after DOM is fully loaded to ensure apiGet is defined
document.addEventListener('DOMContentLoaded', () => {
    loadCourseContent();

    // Deep linking
    const urlParams = new URLSearchParams(window.location.search);
    const epId = urlParams.get('ep_id');
    if(epId) {
        // Wait for content to load then view
        const checker = setInterval(() => {
            if(currentEpisodes.length > 0) {
                viewEpisode(epId);
                clearInterval(checker);
            }
        }, 100);
    }
});
</script>
