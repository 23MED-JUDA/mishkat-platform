<?php
/**
 * Digital Tasbih - Premium Pro Version
 */
?>

<div class="max-w-4xl mx-auto px-4 py-8 md:py-12 animate-fadeIn">
    <!-- Header Section -->
    <div class="text-center mb-12">
        <div class="inline-block px-4 py-1.5 bg-mishkat-gold-500/10 border border-mishkat-gold-500/20 rounded-full mb-4">
            <span class="text-[10px] font-black text-mishkat-gold-600 uppercase tracking-widest">الذكر الحكيم</span>
        </div>
        <h2 class="text-4xl md:text-5xl font-black text-mishkat-green-900 dark:text-white font-tajawal mb-4">السبحة الرقمية</h2>
        <p class="text-gray-500 dark:text-white/40 font-medium font-amiri text-xl italic">"فَاذْكُرُونِي أَذْكُرْكُمْ وَاشْكُرُوا لِي وَلَا تَكْفُرُونِ"</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left: Settings & Presets -->
        <div class="lg:col-span-4 space-y-6 order-2 lg:order-1">
            <div class="luxury-card p-6 bg-white dark:bg-white/5 border border-gray-100 dark:border-white/5 rounded-[2.5rem]">
                <h3 class="text-sm font-black text-mishkat-green-900 dark:text-mishkat-gold-400 mb-6 flex items-center gap-2">
                    <span class="material-icons-outlined text-lg">tune</span>
                    إعدادات السبحة
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">الهدف الحالي</label>
                        <div class="grid grid-cols-3 gap-2">
                            <button onclick="setTarget(33)" id="btn33" class="target-btn active">33</button>
                            <button onclick="setTarget(100)" id="btn100" class="target-btn">100</button>
                            <button onclick="setTarget(Infinity)" id="btnInf" class="target-btn">∞</button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 block">اختر الذكر</label>
                        <div class="space-y-2">
                            <?php 
                            $azkar = ["سبحان الله", "الحمد لله", "الله أكبر", "لا إله إلا الله", "أستغفر الله"];
                            foreach($azkar as $index => $zkr): ?>
                                <button onclick="setDhikr('<?php echo $zkr; ?>')" 
                                        class="w-full text-right px-5 py-3.5 bg-gray-50 dark:bg-white/5 hover:bg-mishkat-gold-500 hover:text-black rounded-2xl font-bold text-sm transition-all flex items-center justify-between group">
                                    <span><?php echo $zkr; ?></span>
                                    <span class="material-icons-outlined text-sm opacity-0 group-hover:opacity-100 transition-opacity">chevron_left</span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center: The Main Counter -->
        <div class="lg:col-span-8 flex flex-col items-center order-1 lg:order-2">
            <div class="relative">
                <!-- Outer Progress Ring -->
                <svg class="w-72 h-72 md:w-96 md:h-96 -rotate-90">
                    <circle cx="50%" cy="50%" r="48%" 
                            class="stroke-gray-200 dark:stroke-white/5 fill-none" 
                            stroke-width="8"></circle>
                    <circle id="progressCircle" cx="50%" cy="50%" r="48%" 
                            class="stroke-mishkat-gold-500 fill-none transition-all duration-300" 
                            stroke-width="8" stroke-dasharray="1000" stroke-dashoffset="1000"
                            stroke-linecap="round"></circle>
                </svg>

                <!-- Inner Counter Button -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <button id="tasbihBtn" onclick="incrementTasbih()" 
                            class="w-56 h-56 md:w-80 md:h-80 rounded-full bg-white dark:bg-[#0c1210] shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-gray-100 dark:border-white/5 flex flex-col items-center justify-center active:scale-95 transition-all duration-150 relative overflow-hidden group">
                        
                        <div class="absolute inset-0 bg-mishkat-gold-500 opacity-0 group-active:opacity-20 transition-opacity"></div>
                        
                        <!-- Pulse Ring -->
                        <div id="pulseRing" class="absolute inset-0 rounded-full border-2 border-mishkat-gold-500 opacity-0"></div>

                        <div class="text-center z-10">
                            <span id="tasbihCount" class="text-7xl md:text-9xl font-black text-mishkat-green-900 dark:text-mishkat-gold-400 font-tajawal tabular-nums leading-none">0</span>
                            <div class="mt-2 flex flex-col items-center">
                                <span class="text-mishkat-gold-600 font-black uppercase tracking-[0.3em] text-[10px]">تسبيحة</span>
                                <div class="mt-4 flex items-center gap-2 px-3 py-1 bg-mishkat-green-50 dark:bg-white/5 rounded-full">
                                    <span class="material-icons-outlined text-xs text-mishkat-green-600">loop</span>
                                    <span id="roundCount" class="text-[10px] font-black text-mishkat-green-700 dark:text-white/60">الدورة: 0</span>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Current Dhikr Display -->
            <div class="mt-12 w-full max-w-lg text-center px-6 py-8 bg-mishkat-green-900 dark:bg-mishkat-gold-500 rounded-[3rem] shadow-2xl relative overflow-hidden group">
                <div class="absolute inset-0 opacity-10 pointer-events-none">
                    <span class="material-icons-outlined text-[200px] absolute -right-10 -top-10 rotate-12">auto_awesome</span>
                </div>
                <h4 class="text-[10px] font-black uppercase tracking-[0.3em] mb-3 text-mishkat-gold-500 dark:text-mishkat-green-900 opacity-60">الذكر المختار</h4>
                <p id="currentDhikr" class="text-2xl md:text-3xl font-black text-white dark:text-mishkat-green-900 font-amiri leading-relaxed">سبحان الله</p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex items-center gap-4">
                <button onclick="resetTasbih()" class="w-12 h-12 rounded-2xl bg-white dark:bg-white/5 border border-gray-100 dark:border-white/5 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm">
                    <span class="material-icons-outlined">refresh</span>
                </button>
                <button onclick="toggleSound()" id="soundBtn" class="w-12 h-12 rounded-2xl bg-white dark:bg-white/5 border border-gray-100 dark:border-white/5 text-mishkat-green-600 flex items-center justify-center hover:bg-mishkat-green-600 hover:text-white transition-all shadow-sm">
                    <span class="material-icons-outlined" id="soundIcon">volume_up</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .target-btn {
        @apply py-2 px-3 bg-gray-50 dark:bg-white/5 border border-transparent rounded-xl font-black text-xs text-gray-500 transition-all;
    }
    .target-btn.active {
        @apply bg-mishkat-gold-500 text-black shadow-lg shadow-mishkat-gold-500/20 border-mishkat-gold-600/20;
    }
    .pulse-effect {
        animation: ringPulse 0.4s ease-out;
    }
    @keyframes ringPulse {
        0% { transform: scale(1); opacity: 0.8; }
        100% { transform: scale(1.2); opacity: 0; }
    }
</style>

<script>
    let count = parseInt(localStorage.getItem('tasbih_count') || '0');
    let rounds = parseInt(localStorage.getItem('tasbih_rounds') || '0');
    let target = parseInt(localStorage.getItem('tasbih_target') || '33');
    let soundEnabled = localStorage.getItem('tasbih_sound') === 'true';

    const countEl = document.getElementById('tasbihCount');
    const roundEl = document.getElementById('roundCount');
    const dhikrEl = document.getElementById('currentDhikr');
    const progressCircle = document.getElementById('progressCircle');
    const pulseRing = document.getElementById('pulseRing');
    
    // Circle math
    const radius = 48; // 48%
    const circumference = 2 * Math.PI * (window.innerWidth >= 768 ? 192 * 0.48 : 144 * 0.48); // Approximate based on width
    
    // Initialize UI
    function init() {
        countEl.innerText = count;
        roundEl.innerText = `الدورة: ${rounds}`;
        updateProgress();
        updateTargetButtons();
        updateSoundUI();
    }

    function incrementTasbih() {
        count++;
        
        if (target !== Infinity && count >= target) {
            count = 0;
            rounds++;
            if (soundEnabled) playSuccessSound();
            showCelebration();
        } else if (soundEnabled) {
            playClickSound();
        }

        updateUI();
        triggerPulse();
        saveData();
    }

    function updateUI() {
        countEl.innerText = count;
        roundEl.innerText = `الدورة: ${rounds}`;
        updateProgress();
    }

    function updateProgress() {
        if (target === Infinity) {
            progressCircle.style.strokeDashoffset = 0;
            return;
        }
        const offset = 1000 - (count / target) * 1000;
        progressCircle.style.strokeDashoffset = offset;
    }

    function triggerPulse() {
        pulseRing.classList.remove('pulse-effect');
        void pulseRing.offsetWidth;
        pulseRing.classList.add('pulse-effect');
    }

    function setTarget(t) {
        target = t;
        count = 0;
        updateUI();
        updateTargetButtons();
        saveData();
    }

    function setDhikr(text) {
        dhikrEl.innerText = text;
        count = 0;
        updateUI();
        saveData();
    }

    function resetTasbih() {
        count = 0;
        rounds = 0;
        updateUI();
        saveData();
        showToast('تم تصفير جميع العدادات بنجاح', 'success');
    }

    function updateTargetButtons() {
        document.querySelectorAll('.target-btn').forEach(btn => btn.classList.remove('active'));
        if (target === 33) document.getElementById('btn33').classList.add('active');
        else if (target === 100) document.getElementById('btn100').classList.add('active');
        else if (target === Infinity) document.getElementById('btnInf').classList.add('active');
    }

    function toggleSound() {
        soundEnabled = !soundEnabled;
        updateSoundUI();
        saveData();
    }

    function updateSoundUI() {
        const icon = document.getElementById('soundIcon');
        icon.innerText = soundEnabled ? 'volume_up' : 'volume_off';
    }

    function playClickSound() {
        const audio = new Audio('https://www.soundjay.com/buttons/sounds/button-16.mp3');
        audio.volume = 0.2;
        audio.play();
    }

    function playSuccessSound() {
        const audio = new Audio('https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3');
        audio.volume = 0.3;
        audio.play();
    }

    function saveData() {
        localStorage.setItem('tasbih_count', count);
        localStorage.setItem('tasbih_rounds', rounds);
        localStorage.setItem('tasbih_target', target);
        localStorage.setItem('tasbih_sound', soundEnabled);
    }

    function showCelebration() {
        // Simple scale effect on count
        countEl.classList.add('scale-110', 'text-mishkat-gold-500');
        setTimeout(() => countEl.classList.remove('scale-110', 'text-mishkat-gold-500'), 500);
        showToast(`ما شاء الله! أتممت الدورة رقم ${rounds}`, 'success');
    }

    init();
</script>
