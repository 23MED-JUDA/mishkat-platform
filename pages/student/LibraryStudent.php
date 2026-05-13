<?php
// pages/student/LibraryStudent.php
?>
<div class="animate-fadeIn space-y-12" dir="rtl">
    <!-- Header -->
    <div class="bg-gradient-to-l from-mishkat-green-900 to-mishkat-green-800 rounded-[3rem] p-10 md:p-16 text-white shadow-2xl relative overflow-hidden">
        <div class="relative z-10">
            <span class="px-4 py-1.5 bg-mishkat-green-700/50 rounded-full text-[10px] font-black mb-6 inline-block uppercase tracking-widest">المكتبة الرقمية</span>
            <h1 class="text-4xl md:text-6xl font-black mb-6 leading-tight">كنز المعرفة الإسلامية</h1>
            <p class="text-mishkat-green-100 font-medium max-w-2xl mb-10 text-lg leading-relaxed">استكشف مجموعة واسعة من المصادر الإسلامية، من القرآن الكريم والسيرة النبوية إلى الأبحاث والمقالات التعليمية.</p>
            
            <div class="flex flex-wrap gap-4">
                <button onclick="filterLib('')" class="stu-lib-filter active px-8 py-3 luxury-card text-mishkat-green-900 rounded-[2rem] font-black shadow-xl hover:scale-105 transition-all">محتوى الأكاديمية</button>
                <button onclick="filterLib('أحاديث')" class="stu-lib-filter px-8 py-3 bg-mishkat-green-700/50 text-white border border-mishkat-green-600/30 rounded-[2rem] font-black hover:bg-mishkat-green-700 transition-all">أحاديث</button>
                <button onclick="filterLib('تجويد')" class="stu-lib-filter px-8 py-3 bg-mishkat-green-700/50 text-white border border-mishkat-green-600/30 rounded-[2rem] font-black hover:bg-mishkat-green-700 transition-all">تجويد</button>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-mishkat-green-700 rounded-full -translate-x-20 -translate-y-20 blur-[150px] opacity-30"></div>
        <span class="material-icons-outlined absolute bottom-10 left-10 text-[200px] text-white/5 pointer-events-none">auto_stories</span>
    </div>

    <!-- External Quick Access Section -->
    <div class="space-y-6">
        <div class="flex items-center gap-4 px-4">
            <div class="w-2 h-8 bg-mishkat-gold-500 rounded-full"></div>
            <h3 class="text-2xl font-black text-gray-900 font-tajawal">منصة مشكاة المفتوحة</h3>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6">
            <?php
            $externalLinks = [
                ['name' => 'القرآن الكريم', 'icon' => 'menu_book', 'color' => 'emerald', 'desc' => 'قراءة واستماع'],
                ['name' => 'الأحاديث', 'icon' => 'history_edu', 'color' => 'blue', 'desc' => 'الصحاح والسنن'],
                ['name' => 'السيرة النبوية', 'icon' => 'mosque', 'color' => 'amber', 'desc' => 'حياة المصطفى'],
                ['name' => 'أسئلة دينية', 'icon' => 'quiz', 'color' => 'purple', 'desc' => 'فتاوى ومعلومات'],
                ['name' => 'السبحة', 'icon' => 'track_changes', 'color' => 'rose', 'desc' => 'أذكار وتسبيح'],
            ];
            foreach($externalLinks as $link):
            ?>
            <a href="https://mishkah-al8f4yypg-23med-judas-projects.vercel.app/" target="_blank" 
               class="luxury-card p-6 rounded-[2.5rem] text-center group hover:shadow-xl hover:-translate-y-2 transition-all border border-gray-50 flex flex-col items-center">
                <div class="w-16 h-16 bg-<?php echo $link['color']; ?>-50 text-<?php echo $link['color']; ?>-600 rounded-[2rem] flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-6 transition-all shadow-sm">
                    <span class="material-icons-outlined text-3xl"><?php echo $link['icon']; ?></span>
                </div>
                <h4 class="font-black text-gray-900 text-sm mb-1"><?php echo $link['name']; ?></h4>
                <p class="text-[10px] text-gray-400 font-bold"><?php echo $link['desc']; ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Main Library Grid -->
    <div class="space-y-6">
        <div class="flex items-center gap-4 px-4">
            <div class="w-2 h-8 bg-mishkat-green-600 rounded-full"></div>
            <h3 class="text-2xl font-black text-gray-900 font-tajawal">مرفقات المعلمين</h3>
        </div>
        <div id="studentLibraryGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <!-- Loading State -->
            <?php for($i=0;$i<4;$i++): ?>
            <div class="luxury-card p-6 rounded-[2.5rem] shadow-sm animate-pulse border border-gray-50">
                <div class="w-12 h-12 bg-gray-100 rounded-[2rem] mb-6"></div>
                <div class="h-4 bg-gray-100 rounded w-3/4 mb-4"></div>
                <div class="h-3 bg-gray-50 rounded w-full mb-2"></div>
                <div class="h-3 bg-gray-50 rounded w-2/3"></div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="libPreviewModal" class="modal-backdrop">
    <div class="modal-box max-w-3xl overflow-hidden p-0">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center luxury-card sticky top-0 z-10">
            <h3 id="previewTitle" class="text-xl font-black text-gray-900">عرض المحتوى</h3>
            <button onclick="closePreviewModal()" class="w-10 h-10 flex items-center justify-center text-gray-400 hover:bg-gray-50 rounded-full transition-all">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        <div id="previewContent" class="p-8 max-h-[70vh] overflow-y-auto custom-scrollbar"></div>
    </div>
</div>

<script>
let stuLibItems = [];

function loadStuLibrary(cat = '') {
    apiGet('get_library', cat ? `&category=${encodeURIComponent(cat)}` : '').then(res => {
        if(res.success) {
            stuLibItems = res.data;
            renderStuLibrary();
        }
    });
}

function renderStuLibrary() {
    const grid = document.getElementById('studentLibraryGrid');
    if(stuLibItems.length === 0) {
        grid.innerHTML = `
            <div class="col-span-full py-20 text-center luxury-card rounded-[3rem] border border-dashed border-gray-100">
                <span class="material-icons-outlined text-6xl text-gray-200 mb-4">folder_off</span>
                <p class="text-gray-400 font-bold">لا يوجد محتوى متاح حالياً</p>
            </div>
        `;
        return;
    }

    grid.innerHTML = stuLibItems.map(item => `
        <div class="group luxury-card p-8 rounded-[2.5rem] shadow-sm border border-gray-50 hover:shadow-2xl hover:-translate-y-2 transition-all">
            <div class="flex items-center justify-between mb-6">
                <div class="w-14 h-14 bg-mishkat-green-50 text-mishkat-green-700 rounded-[2rem] flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                    <span class="material-icons-outlined text-2xl">${getLibIcon(item.type)}</span>
                </div>
                <span class="px-3 py-1 bg-mishkat-green-50 text-mishkat-green-700 text-[10px] font-black rounded-lg uppercase tracking-widest">${item.category}</span>
            </div>
            
            <h4 class="text-lg font-black text-gray-900 mb-2 leading-tight">${item.title}</h4>
            <div class="flex items-center gap-2 mb-6">
                <div class="w-5 h-5 bg-gray-100 rounded-full flex items-center justify-center">
                    <span class="material-icons-outlined text-[10px] text-gray-400">person</span>
                </div>
                <span class="text-[10px] font-bold text-gray-400">بواسطة ${item.author || 'المعلم'}</span>
            </div>
            
            <p class="text-sm text-gray-500 font-medium mb-8 line-clamp-3 leading-relaxed">${item.description || ''}</p>
            
            <button onclick='openPreview(${JSON.stringify(item).replace(/'/g, "&apos;")})' class="w-full py-4 bg-gray-50 text-mishkat-green-700 rounded-[2rem] font-black text-xs hover:bg-mishkat-green-700 hover:text-white transition-all shadow-sm">
                مشاهدة التفاصيل
            </button>
        </div>
    `).join('');
}

function getLibIcon(type) {
    switch(type) {
        case 'video': return 'play_circle';
        case 'audio': return 'headset';
        case 'article': return 'newspaper';
        default: return 'picture_as_pdf';
    }
}

function filterLib(cat) {
    document.querySelectorAll('.stu-lib-filter').forEach(btn => {
        btn.className = 'stu-lib-filter px-8 py-3 bg-mishkat-green-700/50 text-white border border-mishkat-green-600/30 rounded-[2rem] font-black hover:bg-mishkat-green-700 transition-all';
        if(btn.innerText === (cat || 'الكل')) {
            btn.className = 'stu-lib-filter active px-8 py-3 luxury-card text-mishkat-green-900 rounded-[2rem] font-black shadow-xl hover:scale-105 transition-all';
        }
    });
    loadStuLibrary(cat);
}

function openPreview(item) {
    document.getElementById('previewTitle').innerText = item.title;
    const content = document.getElementById('previewContent');
    
    let html = `
        <div class="mb-8">
            <span class="px-3 py-1 bg-mishkat-green-50 text-mishkat-green-700 text-[10px] font-black rounded-lg uppercase tracking-widest">${item.category}</span>
            <p class="mt-4 text-gray-700 font-medium leading-relaxed whitespace-pre-wrap">${item.description || 'لا يوجد وصف متاح لهذا المحتوى.'}</p>
        </div>
    `;
    
    if(item.type === 'video' && item.file_url) {
        const vidId = extractYoutubeId(item.file_url);
        if(vidId) html += `<iframe class="w-full aspect-video rounded-[2rem] shadow-lg" src="https://www.youtube.com/embed/${vidId}" frameborder="0" allowfullscreen></iframe>`;
        else html += `<a href="${item.file_url}" target="_blank" class="block p-4 bg-mishkat-green-50 text-mishkat-green-700 rounded-[1.5rem] text-center font-bold">مشاهدة الفيديو الخارجي</a>`;
    } else if(item.file_url) {
        html += `
            <div class="p-6 bg-gray-50 rounded-[2rem] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-icons-outlined text-mishkat-green-700">attach_file</span>
                    <span class="text-sm font-black text-gray-700">رابط الملف المرفق</span>
                </div>
                <a href="${item.file_url}" target="_blank" class="px-6 py-2 bg-mishkat-green-700 text-white rounded-[1.5rem] text-xs font-black shadow-lg shadow-mishkat-green-100">تحميل / عرض</a>
            </div>
        `;
    }
    
    content.innerHTML = html;
    document.getElementById('libPreviewModal').classList.add('active');
}

function closePreviewModal() {
    document.getElementById('libPreviewModal').classList.remove('active');
    document.getElementById('previewContent').innerHTML = '';
}

function extractYoutubeId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length == 11) ? match[2] : false;
}

// Init
loadStuLibrary();
</script>
