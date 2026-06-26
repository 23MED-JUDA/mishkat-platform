<?php
// pages/teacher/Episodes.php
?>
<div class="animate-fadeIn" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 mb-2">إدارة الحلقات والدروس</h1>
            <p class="text-gray-500 font-medium">أضف وتحكم في دروس المسارات التعليمية (تجويد، حفظ، تفسير)</p>
        </div>
        <button onclick="openEpisodeModal()" class="flex items-center gap-2 px-6 py-3 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined">add</span>
            إضافة حلقة جديدة
        </button>
    </div>

    <!-- Filters -->
    <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-100 mb-8 flex flex-wrap gap-4 items-center">
        <span class="text-xs font-black text-gray-400 uppercase tracking-widest">تصفية حسب المسار:</span>
        <select id="courseFilter" onchange="loadEpisodes()" class="bg-gray-50 border-none rounded-[1.5rem] px-4 py-2 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none">
            <option value="">جميع المسارات</option>
        </select>
    </div>

    <!-- Episodes Grid -->
    <div id="episodesList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Loaded via AJAX -->
    </div>
</div>

<!-- Modal -->
<div id="episodeModal" class="modal-backdrop">
    <div class="modal-box max-w-lg">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-gray-900" id="epModalTitle">إدارة الحلقة</h3>
            <button onclick="closeEpisodeModal()" class="text-gray-400 hover:text-gray-600">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        
        <form id="episodeForm" class="space-y-4">
            <input type="hidden" name="episode_id" id="ep_id">
            <div class="space-y-1">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">المسار التعليمي</label>
                <select name="course_id" id="ep_course_id" required class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none">
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">عنوان الحلقة</label>
                <input type="text" name="title" id="ep_title" required class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">المحتوى التعليمي</label>
                <div class="flex gap-2 mb-2">
                    <button type="button" onclick="setContentType('youtube')" id="btn_yt" class="flex-1 py-2 bg-mishkat-green-50 text-mishkat-green-700 rounded-[1.5rem] text-xs font-bold border border-mishkat-green-100">رابط يوتيوب</button>
                    <button type="button" onclick="setContentType('file')" id="btn_file" class="flex-1 py-2 bg-gray-50 text-gray-500 rounded-[1.5rem] text-xs font-bold border border-transparent">رفع فيديو</button>
                </div>
                <input type="hidden" name="content_type" id="ep_content_type" value="youtube">
                
                <div id="yt_input">
                    <input type="text" name="content_data" id="ep_content" placeholder="انسخ رابط اليوتيوب هنا..." class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none">
                </div>
                <div id="file_input" class="hidden">
                    <input type="file" name="video_file" accept="video/*" class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none">
                    <p id="current_file_path" class="text-[10px] text-gray-400 px-2 mt-1"></p>
                </div>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">وصف مختصر</label>
                <textarea name="description" id="ep_desc" rows="3" class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeEpisodeModal()" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[2rem] font-black hover:bg-gray-200 transition-all">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">حفظ الحلقة</button>
            </div>
        </form>
    </div>
</div>

<!-- Quiz Management Modal -->
<div id="quizModal" class="modal-backdrop">
    <div class="modal-box max-w-2xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-black text-gray-900">إدارة اختبار الحلقة</h3>
                <p id="quiz_ep_title" class="text-xs text-mishkat-green-600 font-bold"></p>
            </div>
            <button onclick="closeQuizModal()" class="text-gray-400 hover:text-gray-600">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        
        <form id="quizForm" class="space-y-6">
            <input type="hidden" name="episode_id" id="quiz_ep_id">
            <div id="questionsContainer" class="space-y-6 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                <!-- Questions added here -->
            </div>
            
            <button type="button" onclick="addQuestionUI()" class="w-full py-3 border-2 border-dashed border-gray-200 text-gray-400 rounded-[2rem] font-bold hover:border-mishkat-green-200 hover:text-mishkat-green-600 transition-all flex items-center justify-center gap-2">
                <span class="material-icons-outlined">add</span> إضافة سؤال جديد
            </button>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeQuizModal()" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[2rem] font-black">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[2rem] font-black shadow-lg shadow-mishkat-green-100">حفظ الاختبار</button>
            </div>
        </form>
    </div>
</div>

<script>
let allEpisodes = [];
let allCourses = [];

async function initPage() {
    const res = await apiGet('get_courses');
    if(res.success) {
        allCourses = res.data;
        const filter = document.getElementById('courseFilter');
        const formSelect = document.getElementById('ep_course_id');
        const options = allCourses.map(c => `<option value="${c.id}">${c.title}</option>`).join('');
        filter.innerHTML += options;
        formSelect.innerHTML = options;
        loadEpisodes();
    }
}

async function loadEpisodes() {
    const cid = document.getElementById('courseFilter').value;
    const res = await apiGet('get_episodes', cid ? `&course_id=${cid}` : '');
    if(res.success) {
        allEpisodes = res.data;
        renderEpisodes();
    }
}

function renderEpisodes() {
    const grid = document.getElementById('episodesList');
    if(allEpisodes.length === 0) {
        grid.innerHTML = '<div class="col-span-full py-10 text-center text-gray-400 font-bold luxury-card rounded-3xl border border-dashed">لا توجد حلقات مضافة حالياً</div>';
        return;
    }

    grid.innerHTML = allEpisodes.map(ep => `
        <div class="luxury-card p-6 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-10 h-10 rounded-[1.5rem] bg-mishkat-green-50 text-mishkat-green-700 flex items-center justify-center">
                    <span class="material-icons-outlined">play_circle</span>
                </div>
                <div class="flex gap-1">
                    <button onclick="openQuizModal(${ep.id}, '${ep.title.replace(/'/g, "&apos;")}')" class="p-2 text-gray-300 hover:text-amber-600 transition-colors" title="إدارة الاختبار">
                        <span class="material-icons-outlined text-sm">quiz</span>
                    </button>
                    <button onclick='openEditModal(${JSON.stringify(ep).replace(/'/g, "&apos;")})' class="p-2 text-gray-300 hover:text-mishkat-green-700 transition-colors">
                        <span class="material-icons-outlined text-sm">edit</span>
                    </button>
                    <button onclick="deleteEpisode(${ep.id})" class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                        <span class="material-icons-outlined text-sm">delete</span>
                    </button>
                </div>
            </div>
            <h4 class="text-lg font-black text-gray-900 mb-1">${ep.title}</h4>
            <p class="text-[10px] font-black text-mishkat-green-600 mb-2 uppercase">${ep.course_title}</p>
            <p class="text-xs text-gray-400 line-clamp-2">${ep.description || ''}</p>
        </div>
    `).join('');
}

function setContentType(type) {
    document.getElementById('ep_content_type').value = type;
    const yt = document.getElementById('yt_input');
    const file = document.getElementById('file_input');
    const btnYt = document.getElementById('btn_yt');
    const btnFile = document.getElementById('btn_file');
    
    if(type === 'youtube') {
        yt.classList.remove('hidden');
        file.classList.add('hidden');
        btnYt.className = 'flex-1 py-2 bg-mishkat-green-50 text-mishkat-green-700 rounded-[1.5rem] text-xs font-bold border border-mishkat-green-100';
        btnFile.className = 'flex-1 py-2 bg-gray-50 text-gray-500 rounded-[1.5rem] text-xs font-bold border border-transparent';
    } else {
        yt.classList.add('hidden');
        file.classList.remove('hidden');
        btnFile.className = 'flex-1 py-2 bg-mishkat-green-50 text-mishkat-green-700 rounded-[1.5rem] text-xs font-bold border border-mishkat-green-100';
        btnYt.className = 'flex-1 py-2 bg-gray-50 text-gray-500 rounded-[1.5rem] text-xs font-bold border border-transparent';
    }
}

function openEpisodeModal() {
    document.getElementById('epModalTitle').innerText = 'إضافة حلقة جديدة';
    document.getElementById('episodeForm').reset();
    document.getElementById('ep_id').value = '';
    document.getElementById('current_file_path').innerText = '';
    setContentType('youtube');
    document.getElementById('episodeModal').classList.add('active');
}

function openEditModal(ep) {
    document.getElementById('epModalTitle').innerText = 'تعديل الحلقة';
    document.getElementById('ep_id').value = ep.id;
    document.getElementById('ep_course_id').value = ep.course_id;
    document.getElementById('ep_title').value = ep.title;
    document.getElementById('ep_desc').value = ep.description || '';
    
    if(ep.content_type === 'file') {
        setContentType('file');
        document.getElementById('current_file_path').innerText = 'الملف الحالي: ' + ep.content_data;
    } else {
        setContentType('youtube');
        document.getElementById('ep_content').value = ep.content_data || '';
    }
    
    document.getElementById('episodeModal').classList.add('active');
}

function closeEpisodeModal() {
    document.getElementById('episodeModal').classList.remove('active');
}

document.getElementById('episodeForm').onsubmit = async function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const action = fd.get('episode_id') ? 'update_episode' : 'add_episode';
    fd.append('action', action);
    
    const res = await fetch('api.php', { method: 'POST', body: fd }).then(r => r.json());
    if(res.success) {
        showToast('تم حفظ الحلقة بنجاح');
        closeEpisodeModal();
        loadEpisodes();
    } else {
        showToast(res.message || 'خطأ في الحفظ', 'error');
    }
};

async function deleteEpisode(id) {
    if(await confirmDialog('هل أنت متأكد من حذف هذه الحلقة؟')) {
        const res = await apiCall('delete_episode', { episode_id: id });
        if(res.success) {
            showToast('تم الحذف بنجاح');
            loadEpisodes();
        }
    }
}

// Quiz Management
function openQuizModal(id, title) {
    document.getElementById('quiz_ep_id').value = id;
    document.getElementById('quiz_ep_title').innerText = title;
    document.getElementById('questionsContainer').innerHTML = '';
    
    // Load existing quiz if any
    apiGet('get_episode_quiz', `&episode_id=${id}`).then(res => {
        if(res.success && res.questions) {
            res.questions.forEach(q => addQuestionUI(q));
        } else {
            addQuestionUI(); // Add one empty question
        }
    });
    
    document.getElementById('quizModal').classList.add('active');
}

function closeQuizModal() {
    document.getElementById('quizModal').classList.remove('active');
}

function addQuestionUI(q = null) {
    const container = document.getElementById('questionsContainer');
    const id = Date.now();
    const div = document.createElement('div');
    div.className = 'p-4 bg-gray-50 rounded-[2rem] border border-gray-100 relative group animate-fadeIn';
    div.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -left-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center shadow-md opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="material-icons-outlined text-xs">close</span>
        </button>
        <div class="space-y-3">
            <input type="text" placeholder="نص السؤال" class="q-text w-full px-4 py-2 luxury-card border-none rounded-[1.5rem] text-sm font-bold shadow-sm" value="${q ? q.question : ''}">
            <div class="grid grid-cols-2 gap-2">
                <div class="flex items-center gap-2">
                    <input type="radio" name="correct_${id}" value="0" ${q && q.correct_answer == 0 ? 'checked' : 'checked'} class="q-correct">
                    <input type="text" placeholder="الخيار الأول" class="q-opt w-full px-4 py-2 luxury-card border-none rounded-[1.5rem] text-xs font-bold shadow-sm" value="${q ? q.options[0] : ''}">
                </div>
                <div class="flex items-center gap-2">
                    <input type="radio" name="correct_${id}" value="1" ${q && q.correct_answer == 1 ? 'checked' : ''} class="q-correct">
                    <input type="text" placeholder="الخيار الثاني" class="q-opt w-full px-4 py-2 luxury-card border-none rounded-[1.5rem] text-xs font-bold shadow-sm" value="${q ? q.options[1] : ''}">
                </div>
                <div class="flex items-center gap-2">
                    <input type="radio" name="correct_${id}" value="2" ${q && q.correct_answer == 2 ? 'checked' : ''} class="q-correct">
                    <input type="text" placeholder="الخيار الثالث" class="q-opt w-full px-4 py-2 luxury-card border-none rounded-[1.5rem] text-xs font-bold shadow-sm" value="${q ? q.options[2] : ''}">
                </div>
                <div class="flex items-center gap-2">
                    <input type="radio" name="correct_${id}" value="3" ${q && q.correct_answer == 3 ? 'checked' : ''} class="q-correct">
                    <input type="text" placeholder="الخيار الرابع" class="q-opt w-full px-4 py-2 luxury-card border-none rounded-[1.5rem] text-xs font-bold shadow-sm" value="${q ? q.options[3] : ''}">
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
}

document.getElementById('quizForm').onsubmit = async function(e) {
    e.preventDefault();
    const questions = [];
    document.querySelectorAll('#questionsContainer > div').forEach(div => {
        const question = div.querySelector('.q-text').value;
        const options = Array.from(div.querySelectorAll('.q-opt')).map(i => i.value);
        const correct = div.querySelector('.q-correct:checked').value;
        if(question && options[0] && options[1]) {
            questions.push({ question, options, correct_answer: correct });
        }
    });
    
    if(questions.length === 0) {
        showToast('يرجى إضافة سؤال واحد على الأقل', 'error');
        return;
    }
    
    const eid = document.getElementById('quiz_ep_id').value;
    const res = await apiCall('add_quiz', {
        episode_id: eid,
        title: 'اختبار الحلقة',
        questions: JSON.stringify(questions)
    });
    
    if(res.success) {
        showToast('تم حفظ الاختبار بنجاح');
        closeQuizModal();
    }
};

document.addEventListener('DOMContentLoaded', () => {
    initPage();
});
</script>
