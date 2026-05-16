<?php
/**
 * Digital Tasbih - Native Platform Version
 */
?>

<div class="flex flex-col items-center justify-center min-h-[600px] space-y-10 animate-fadeIn">
    <!-- Header -->
    <div class="text-center">
        <h2 class="text-3xl font-black text-mishkat-green-900 dark:text-white font-tajawal">السبحة الرقمية</h2>
        <p class="text-gray-500 dark:text-gray-400 font-medium">أَلا بِذِكْرِ اللَّهِ تَطْمَئِنُّ الْقُلُوبُ</p>
    </div>

    <!-- Tasbih Counter -->
    <div class="relative group">
        <!-- Main Button -->
        <button id="tasbihBtn" onclick="incrementTasbih()" 
                class="w-64 h-64 md:w-80 md:h-80 rounded-full bg-white dark:bg-mishkat-green-900/20 border-[12px] border-mishkat-green-50 dark:border-mishkat-gold-500/10 shadow-2xl flex flex-col items-center justify-center group active:scale-95 transition-all duration-150 relative overflow-hidden">
            
            <div class="absolute inset-0 bg-mishkat-gold-500 opacity-0 group-active:opacity-10 transition-opacity"></div>
            
            <span id="tasbihCount" class="text-7xl md:text-9xl font-black text-mishkat-green-900 dark:text-mishkat-gold-400 font-tajawal select-none">0</span>
            <span class="text-mishkat-gold-600 font-black uppercase tracking-widest text-xs mt-2 select-none">تسبيحة</span>
            
            <!-- Pulse Effect -->
            <div id="pulseEffect" class="absolute inset-0 rounded-full border-4 border-mishkat-gold-500 opacity-0"></div>
        </button>

        <!-- Small Reset Button -->
        <button onclick="resetTasbih()" 
                class="absolute -bottom-4 left-1/2 -translate-x-1/2 px-6 py-2 bg-red-500 text-white rounded-full font-black text-xs shadow-lg hover:bg-red-600 transition-all active:scale-90 flex items-center gap-2">
            <span class="material-icons-outlined text-sm">refresh</span>
            تصفير
        </button>
    </div>

    <!-- Dhikr Selector -->
    <div class="w-full max-w-md">
        <div class="grid grid-cols-2 gap-3">
            <button onclick="setDhikr('سبحان الله')" class="dhikr-preset">سبحان الله</button>
            <button onclick="setDhikr('الحمد لله')" class="dhikr-preset">الحمد لله</button>
            <button onclick="setDhikr('الله أكبر')" class="dhikr-preset">الله أكبر</button>
            <button onclick="setDhikr('لا إله إلا الله')" class="dhikr-preset">لا إله إلا الله</button>
        </div>
        <div class="mt-6 p-6 luxury-card text-center bg-mishkat-green-900 text-white">
            <p id="currentDhikr" class="text-xl font-bold font-amiri">اضغط على الدائرة للبدء في التسبيح</p>
        </div>
    </div>
</div>

<style>
    .dhikr-preset {
        @apply py-3 px-4 bg-white dark:bg-mishkat-green-900/10 border border-gray-100 dark:border-mishkat-gold-500/10 rounded-xl font-bold text-sm text-gray-700 dark:text-gray-300 hover:bg-mishkat-gold-500 hover:text-black transition-all;
    }
    .pulse-anim {
        animation: pulse 0.5s ease-out;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.5; }
        100% { transform: scale(1.3); opacity: 0; }
    }
</style>

<script>
    let count = parseInt(localStorage.getItem('mishkat_tasbih_count') || '0');
    const countEl = document.getElementById('tasbihCount');
    const dhikrEl = document.getElementById('currentDhikr');
    const pulseEl = document.getElementById('pulseEffect');
    
    countEl.innerText = count;

    function incrementTasbih() {
        count++;
        countEl.innerText = count;
        localStorage.setItem('mishkat_tasbih_count', count);
        
        // Haptic feedback if available
        if (window.navigator && window.navigator.vibrate) {
            window.navigator.vibrate(20);
        }

        // Animation
        pulseEl.classList.remove('pulse-anim');
        void pulseEl.offsetWidth; // trigger reflow
        pulseEl.classList.add('pulse-anim');
    }

    function resetTasbih() {
        if(confirm('هل تريد تصفير العداد؟')) {
            count = 0;
            countEl.innerText = count;
            localStorage.setItem('mishkat_tasbih_count', 0);
        }
    }

    function setDhikr(text) {
        dhikrEl.innerText = text;
        count = 0;
        countEl.innerText = count;
        localStorage.setItem('mishkat_tasbih_count', 0);
    }
</script>
