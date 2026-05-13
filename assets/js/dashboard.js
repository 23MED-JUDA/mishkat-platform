/**
 * ملف منطق لوحة التحكم (Dashboard Logic)
 * =====================================
 * هذا الملف مسؤول عن كافة التفاعلات الديناميكية في لوحة تحكم المستخدم.
 * يتضمن ذلك: التحكم في القائمة الجانبية، الإشعارات، الرسائل المنبثقة، والاتصال مع الـ API.
 */

// ── وظائف مساعدة (Utility Functions) ──

/**
 * وظيفة (showToast): لإظهار رسائل تنبيهية منبثقة للمستخدم (نجاح، خطأ، تنبيه).
 */
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = message;
    container.appendChild(toast);
    
    // إخفاء الرسالة تلقائياً بعد 3 ثوانٍ
    setTimeout(() => { 
        toast.style.opacity = '0'; 
        toast.style.transform = 'translateY(-10px)'; 
        setTimeout(() => toast.remove(), 300); 
    }, 3000);
}

/**
 * وظيفة (apiCall): وسيط لإرسال البيانات إلى ملف الـ PHP API باستخدام تقنية Fetch.
 * تستخدم في عمليات (الإرسال والتعديل والحذف).
 */
function apiCall(action, data = {}, method = 'POST') {
    const fd = new FormData();
    fd.append('action', action);
    for (const k in data) fd.append(k, data[k]);
    return fetch('api/api.php', { method, body: fd }).then(r => r.json());
}

/**
 * وظيفة (apiGet): لطلب البيانات من الـ API (عمليات الجلب فقط).
 */
function apiGet(action, params = '') {
    return fetch(`api/api.php?action=${action}${params}`).then(r => r.json());
}

/**
 * وظيفة (confirmDialog): نافذة تأكيد مخصصة قبل تنفيذ إجراءات حساسة مثل الحذف.
 */
function confirmDialog(message) {
    return new Promise(resolve => {
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop active';
        backdrop.innerHTML = `
            <div class="modal-box text-center">
                <span class="material-icons-outlined text-5xl text-amber-500 mb-4">warning</span>
                <h3 class="text-lg font-bold text-gray-900 mb-2">${message}</h3>
                <p class="text-sm text-gray-500 mb-6">لا يمكن التراجع عن هذا الإجراء</p>
                <div class="flex gap-3 justify-center">
                    <button class="px-6 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-all" id="cancelBtn">إلغاء</button>
                    <button class="px-6 py-2.5 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all" id="confirmBtn">تأكيد</button>
                </div>
            </div>`;
        document.body.appendChild(backdrop);
        
        backdrop.querySelector('#confirmBtn').onclick = () => { backdrop.remove(); resolve(true); };
        backdrop.querySelector('#cancelBtn').onclick = () => { backdrop.remove(); resolve(false); };
        backdrop.onclick = (e) => { if(e.target === backdrop) { backdrop.remove(); resolve(false); } };
    });
}

// ── التحكم في العناصر بعد تحميل الصفحة ──

document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const brandText = document.getElementById('brandText');
    const sidebarTexts = document.querySelectorAll('.sidebar-text');
    let isOpen = true;

    // طي وتوسيع القائمة الجانبية (Sidebar Collapse)
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            isOpen = !isOpen;
            if (isOpen) {
                sidebar.classList.remove('sidebar-closed');
                sidebar.classList.add('sidebar-open');
                toggleIcon.style.transform = 'rotate(0deg)';
                setTimeout(() => {
                    if(brandText) brandText.style.opacity = '1';
                    sidebarTexts.forEach(el => el.style.display = 'inline');
                }, 200);
            } else {
                sidebar.classList.remove('sidebar-open');
                sidebar.classList.add('sidebar-closed');
                toggleIcon.style.transform = 'rotate(180deg)';
                if(brandText) brandText.style.opacity = '0';
                sidebarTexts.forEach(el => el.style.display = 'none');
            }
        });
    }

    // ── نظام البحث السريع ──
    let searchTimeout;
    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const q = e.target.value.trim();
                if (q.length < 2) return;
                // إرسال طلب بحث للـ API
                apiGet('search', `&q=${encodeURIComponent(q)}`).then(res => {
                    if (res.success && res.data.length > 0) {
                        showToast(`تم العثور على ${res.data.length} نتيجة`, 'info');
                    }
                });
            }, 500);
        });
    }
});

// ── إغلاق القوائم عند النقر خارجها ──
document.addEventListener('click', (e) => {
    const notifPanel = document.getElementById('notifPanel');
    if (notifPanel && !e.target.closest('#notifPanel') && !e.target.closest('[onclick*="toggleNotifPanel"]')) {
        notifPanel.classList.add('hidden');
    }
});

// ── نظام الإشعارات (Notifications System) ──

/**
 * فتح وإغلاق لوحة الإشعارات
 */
function toggleNotifPanel() {
    const panel = document.getElementById('notifPanel');
    if(panel) {
        panel.classList.toggle('hidden');
        if (!panel.classList.contains('hidden')) loadNotifications();
    }
}

/**
 * جلب الإشعارات من قاعدة البيانات وعرضها في القائمة
 */
function loadNotifications() {
    apiGet('get_notifications').then(res => {
        if (!res.success) return;
        const list = document.getElementById('notifList');
        if (!list) return;
        
        if (res.data.length === 0) {
            list.innerHTML = '<div class="p-6 text-center text-gray-400 text-sm">لا توجد إشعارات حالية</div>';
            return;
        }
        
        list.innerHTML = res.data.slice(0, 8).map(n => `
            <div class="p-3 border-b border-gray-50 hover:bg-gray-50 transition-all cursor-pointer ${n.is_read == 0 ? 'bg-emerald-50/30' : ''}" onclick="readNotif(${n.id})">
                <div class="flex items-start gap-3">
                    <span class="material-icons-outlined text-lg mt-0.5 ${n.type==='success'?'text-emerald-500':n.type==='alert'?'text-red-500':'text-blue-500'}">
                        ${n.type==='success'?'check_circle':n.type==='alert'?'error':'info'}
                    </span>
                    <div>
                        <p class="text-sm font-bold text-gray-800">${n.title}</p>
                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">${n.message}</p>
                    </div>
                </div>
            </div>
        `).join('');
    });
}

/**
 * وضع علامة "مقروء" على إشعار معين
 */
function readNotif(id) {
    apiCall('read_notification', { notif_id: id }).then(() => {
        const badge = document.getElementById('notifBadge');
        if (badge) { 
            let c = parseInt(badge.innerText) - 1; 
            if (c <= 0) badge.remove(); 
            else badge.innerText = c; 
        }
    });
}

function markAllRead() {
    apiCall('read_all_notifications').then(res => {
        if (res.success) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.remove();
            loadNotifications();
            showToast('تم قراءة جميع الإشعارات');
        }
    });
}

function toggleProfileMenu() {
    // يمكن إضافة قائمة منسدلة هنا لاحقاً
}
