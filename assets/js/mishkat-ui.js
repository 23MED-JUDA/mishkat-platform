/**
 * Mishkat UI & API Utilities
 * Shared functions for toasts, dialogs, and API calls.
 */

const MishkatUI = {
    // ── TOAST MESSAGES ──
    showToast(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) {
            const newContainer = document.createElement('div');
            newContainer.id = 'toastContainer';
            newContainer.className = 'toast-container';
            document.body.appendChild(newContainer);
            return this.showToast(message, type);
        }

        const toast = document.createElement('div');
        toast.className = `toast toast-${type} luxury-card !py-3 !px-6 !rounded-2xl !shadow-2xl animate-slideIn flex items-center gap-3`;
        
        const icon = type === 'success' ? 'check_circle' : (type === 'error' ? 'error' : 'info');
        const iconColor = type === 'success' ? 'text-emerald-500' : (type === 'error' ? 'text-red-500' : 'text-blue-500');
        
        toast.innerHTML = `
            <span class="material-icons-outlined ${iconColor}">${icon}</span>
            <span class="font-bold text-sm text-gray-800">${message}</span>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(20px)';
            toast.style.transition = 'all 0.5s ease';
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    },

    // ── CUSTOM CONFIRM DIALOG ──
    confirm(message) {
        return new Promise((resolve) => {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-mishkat-green-900/40 backdrop-blur-sm animate-fadeIn';
            modal.innerHTML = `
                <div class="luxury-card max-w-sm w-full text-center p-8 scale-95 transition-all duration-300">
                    <div class="w-16 h-16 bg-mishkat-beige-100 text-mishkat-gold-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="material-icons-outlined text-3xl">help_outline</span>
                    </div>
                    <h3 class="text-xl font-black text-mishkat-green-900 mb-4 font-tajawal">${message}</h3>
                    <div class="flex gap-3">
                        <button id="confirmCancel" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition-all">إلغاء</button>
                        <button id="confirmOk" class="flex-1 py-3 btn-luxury shadow-none">تأكيد</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);

            // Animation
            setTimeout(() => modal.querySelector('.luxury-card').classList.replace('scale-95', 'scale-100'), 10);

            const cleanup = (val) => {
                const card = modal.querySelector('.luxury-card');
                if(card) card.classList.replace('scale-100', 'scale-95');
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.remove();
                    resolve(val);
                }, 300);
            };

            modal.querySelector('#confirmOk').onclick = () => cleanup(true);
            modal.querySelector('#confirmCancel').onclick = () => cleanup(false);
            modal.onclick = (e) => { if(e.target === modal) cleanup(false); };
        });
    },

    // ── API CALL WRAPPER ──
    async apiCall(action, data = {}) {
        const formData = new FormData();
        formData.append('action', action);
        for (const key in data) {
            formData.append(key, data[key]);
        }

        try {
            const response = await fetch('api/api.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            return result;
        } catch (error) {
            console.error('API Error:', error);
            return { success: false, message: 'حدث خطأ أثناء الاتصال بالخادم' };
        }
    },

    // ── API GET WRAPPER ──
    async apiGet(action, params = '') {
        try {
            const response = await fetch(`api/api.php?action=${action}${params}`);
            const result = await response.json();
            return result;
        } catch (error) {
            console.error('API GET Error:', error);
            return { success: false, message: 'حدث خطأ أثناء الاتصال بالخادم' };
        }
    }
};

// Global shortcuts
const showToast = MishkatUI.showToast.bind(MishkatUI);
const apiCall = MishkatUI.apiCall.bind(MishkatUI);
const apiGet = MishkatUI.apiGet.bind(MishkatUI);
const confirmDialog = MishkatUI.confirm.bind(MishkatUI);
