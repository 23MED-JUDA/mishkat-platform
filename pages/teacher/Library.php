<?php
// pages/teacher/Library.php
?>
<div class="animate-fadeIn" dir="rtl">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 mb-2">المكتبة القرآنية</h1>
            <p class="text-gray-500 font-medium">أضف محتوى إثرائي للطلاب (أحاديث، دروس تجويد، فيديوهات)</p>
        </div>
        <button onclick="openLibraryModal()" class="flex items-center gap-2 px-6 py-3 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined">add</span>
            إضافة محتوى جديد
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="luxury-card p-6 rounded-[2rem] shadow-sm border border-gray-50 flex items-center gap-4">
            <div class="w-12 h-12 rounded-[2rem] bg-mishkat-green-50 text-mishkat-green-700 flex items-center justify-center">
                <span class="material-icons-outlined">article</span>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase">إجمالي المواد</p>
                <p class="text-xl font-black text-gray-900" id="totalItems">0</p>
            </div>
        </div>
    </div>

    <!-- Filter & Content -->
    <div class="luxury-card rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex flex-wrap justify-between items-center gap-4">
            <div class="flex gap-2">
                <button onclick="filterLibrary('')" class="lib-filter active px-6 py-2 rounded-[1.5rem] text-xs font-black transition-all bg-mishkat-green-700 text-white">الكل</button>
                <button onclick="filterLibrary('أحاديث')" class="lib-filter px-6 py-2 rounded-[1.5rem] text-xs font-black transition-all bg-gray-50 text-gray-500 hover:bg-gray-100">أحاديث</button>
                <button onclick="filterLibrary('تجويد')" class="lib-filter px-6 py-2 rounded-[1.5rem] text-xs font-black transition-all bg-gray-50 text-gray-500 hover:bg-gray-100">تجويد</button>
                <button onclick="filterLibrary('أذكار')" class="lib-filter px-6 py-2 rounded-[1.5rem] text-xs font-black transition-all bg-gray-50 text-gray-500 hover:bg-gray-100">أذكار</button>
            </div>
        </div>
        
        <div class="p-8">
            <div id="libraryGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Items here -->
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Item Modal -->
<div id="libraryModal" class="modal-backdrop">
    <div class="modal-box max-w-lg">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-black text-gray-900" id="libModalTitle">إضافة محتوى للمكتبة</h3>
            <button onclick="closeLibraryModal()" class="text-gray-400 hover:text-gray-600">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        
        <form id="libraryForm" class="space-y-4">
            <input type="hidden" name="item_id" id="lib_item_id">
            <div class="space-y-1">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">عنوان المحتوى</label>
                <input type="text" name="title" id="lib_title" required class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none transition-all">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">التصنيف</label>
                    <select name="category" id="lib_category" class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none transition-all">
                        <option value="أحاديث">أحاديث</option>
                        <option value="تجويد">تجويد</option>
                        <option value="أذكار">أذكار</option>
                        <option value="تفسير">تفسير</option>
                        <option value="عام">عام</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">نوع الملف</label>
                    <select name="type" id="lib_type" class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none transition-all">
                        <option value="pdf">ملف PDF</option>
                        <option value="video">فيديو (يوتيوب)</option>
                        <option value="audio">ملف صوتي</option>
                        <option value="article">مقال نصي</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">رابط المحتوى (YouTube / File Link)</label>
                <input type="text" name="file_url" id="lib_file_url" placeholder="https://..." class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none transition-all">
            </div>

            <div class="space-y-1">
                <label class="text-xs font-black text-gray-400 uppercase tracking-widest px-1">وصف أو محتوى نصي</label>
                <textarea name="description" id="lib_description" rows="3" class="w-full px-4 py-3 bg-gray-50 border-none rounded-[2rem] text-sm font-bold text-gray-700 focus:ring-2 focus:ring-mishkat-green-100 outline-none transition-all"></textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeLibraryModal()" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[2rem] font-black hover:bg-gray-200 transition-all">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[2rem] font-black hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">حفظ ونشر</button>
            </div>
        </form>
    </div>
</div>

<script>
let libraryItems = [];

function loadLibrary(cat = '') {
    apiGet('get_library', cat ? `&category=${encodeURIComponent(cat)}` : '').then(res => {
        if(res.success) {
            libraryItems = res.data;
            document.getElementById('totalItems').innerText = libraryItems.length;
            renderLibrary();
        }
    });
}

function renderLibrary() {
    const grid = document.getElementById('libraryGrid');
    if(libraryItems.length === 0) {
        grid.innerHTML = '<div class="col-span-full py-10 text-center text-gray-400 font-bold">لا يوجد محتوى في هذا التصنيف</div>';
        return;
    }

    grid.innerHTML = libraryItems.map(item => `
        <div class="luxury-card p-6 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-xl transition-all group relative overflow-hidden">
            <div class="flex justify-between items-start mb-6">
                <div class="w-12 h-12 rounded-[2rem] bg-mishkat-green-50 text-mishkat-green-700 flex items-center justify-center shadow-sm">
                    <span class="material-icons-outlined">${getLibIcon(item.type)}</span>
                </div>
                <div class="flex gap-1">
                    <button onclick='openEditModal(${JSON.stringify(item).replace(/'/g, "&apos;")})' class="w-8 h-8 flex items-center justify-center text-gray-400 hover:bg-mishkat-green-50 hover:text-mishkat-green-700 rounded-full transition-all">
                        <span class="material-icons-outlined text-sm">edit</span>
                    </button>
                    <button onclick="deleteLibItem(${item.id})" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 rounded-full transition-all">
                        <span class="material-icons-outlined text-sm">delete</span>
                    </button>
                </div>
            </div>
            
            <h4 class="text-lg font-black text-gray-900 mb-1">${item.title}</h4>
            <div class="flex items-center gap-2 mb-4">
                <span class="px-2 py-0.5 bg-mishkat-green-100 text-mishkat-green-700 text-[9px] font-black rounded uppercase">${item.category}</span>
                <span class="text-[9px] font-bold text-gray-300">أضيف في ${new Date(item.created_at).toLocaleDateString('ar-SA')}</span>
            </div>
            
            <p class="text-xs text-gray-500 mb-6 line-clamp-2 leading-relaxed">${item.description || 'بدون وصف'}</p>
            
            <div class="flex gap-2">
                ${item.file_url ? `
                    <a href="${item.file_url}" target="_blank" class="flex-1 py-3 bg-gray-50 text-mishkat-green-700 rounded-[1.5rem] text-[10px] font-black hover:bg-mishkat-green-700 hover:text-white text-center transition-all">
                        عرض الرابط
                    </a>
                ` : ''}
            </div>
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

function filterLibrary(cat) {
    document.querySelectorAll('.lib-filter').forEach(btn => {
        btn.classList.remove('active', 'bg-mishkat-green-700', 'text-white');
        btn.classList.add('bg-gray-50', 'text-gray-500');
        if(btn.innerText === (cat || 'الكل')) {
            btn.classList.add('active', 'bg-mishkat-green-700', 'text-white');
            btn.classList.remove('bg-gray-50', 'text-gray-500');
        }
    });
    loadLibrary(cat);
}

function openLibraryModal() {
    document.getElementById('libModalTitle').innerText = 'إضافة محتوى للمكتبة';
    document.getElementById('libraryForm').reset();
    document.getElementById('lib_item_id').value = '';
    document.getElementById('libraryModal').classList.add('active');
}

function openEditModal(item) {
    document.getElementById('libModalTitle').innerText = 'تعديل المحتوى';
    document.getElementById('lib_item_id').value = item.id;
    document.getElementById('lib_title').value = item.title;
    document.getElementById('lib_category').value = item.category;
    document.getElementById('lib_type').value = item.type;
    document.getElementById('lib_file_url').value = item.file_url || '';
    document.getElementById('lib_description').value = item.description || '';
    document.getElementById('libraryModal').classList.add('active');
}

function closeLibraryModal() {
    document.getElementById('libraryModal').classList.remove('active');
}

document.getElementById('libraryForm').onsubmit = function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const data = Object.fromEntries(fd);
    const action = data.item_id ? 'update_library_item' : 'add_library_item';
    
    apiCall(action, data).then(res => {
        if(res.success) {
            showToast(data.item_id ? 'تم تحديث البيانات' : 'تم إضافة المادة بنجاح');
            closeLibraryModal();
            loadLibrary();
        } else {
            showToast(res.message || 'خطأ في العملية', 'error');
        }
    });
};

function deleteLibItem(id) {
    confirmDialog('هل أنت متأكد من حذف هذه المادة؟').then(ok => {
        if(ok) {
            apiCall('delete_library_item', { item_id: id }).then(res => {
                if(res.success) {
                    showToast('تم الحذف');
                    loadLibrary();
                }
            });
        }
    });
}

// Init
loadLibrary();
</script>
