<?php
/**
 * Quran Reader - Native Platform Version
 */
?>

<div class="space-y-8 animate-fadeIn">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-black text-mishkat-green-900 dark:text-white font-tajawal">القرآن الكريم</h2>
            <p class="text-gray-500 dark:text-gray-400 font-medium">تلاوة وتدبر آيات الله البينات</p>
        </div>
        <div class="flex gap-2">
            <div class="relative flex-1 md:w-64">
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" id="surahSearch" placeholder="بحث عن سورة..." 
                       class="w-full pr-12 pl-4 py-3 bg-white dark:bg-mishkat-green-900/20 border border-gray-100 dark:border-mishkat-gold-500/10 rounded-2xl focus:ring-2 focus:ring-mishkat-gold-500 outline-none transition-all dark:text-white">
            </div>
        </div>
    </div>

    <!-- Surah List / Surah Content -->
    <div id="quranContainer" class="min-h-[400px]">
        <!-- Loading State -->
        <div id="quranLoading" class="flex flex-col items-center justify-center py-20">
            <div class="w-12 h-12 border-4 border-mishkat-gold-500 border-t-transparent rounded-full animate-spin"></div>
            <p class="mt-4 text-gray-500 font-bold">جاري تحميل البيانات...</p>
        </div>

        <!-- Surah Grid -->
        <div id="surahGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 hidden">
            <!-- Surahs will be injected here -->
        </div>

        <!-- Surah Reader (Hidden by default) -->
        <div id="surahReader" class="hidden space-y-6">
            <button onclick="showSurahGrid()" class="flex items-center gap-2 text-mishkat-green-700 dark:text-mishkat-gold-400 font-black hover:gap-3 transition-all mb-4">
                <span class="material-icons-outlined">arrow_forward</span>
                العودة لقائمة السور
            </button>
            
            <div id="surahHeader" class="luxury-card p-10 text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h3 id="readerSurahName" class="text-4xl font-amiri font-black text-mishkat-green-900 dark:text-mishkat-gold-200 mb-2"></h3>
                    <p id="readerSurahMeta" class="text-mishkat-gold-600 font-black tracking-widest uppercase text-xs"></p>
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-5 pointer-events-none">
                    <span class="material-icons-outlined text-[150px]">auto_stories</span>
                </div>
            </div>

            <div id="ayahsContainer" class="luxury-card p-6 md:p-12 space-y-10 leading-[2.5] text-right font-amiri text-2xl md:text-3xl dark:text-gray-100">
                <!-- Ayahs will be injected here -->
            </div>
        </div>
    </div>
</div>

<style>
    .surah-card {
        @apply luxury-card p-5 flex items-center gap-4 cursor-pointer hover:border-mishkat-gold-500/50 hover:-translate-y-1 transition-all;
    }
    .ayah-num {
        @apply inline-flex items-center justify-center w-8 h-8 rounded-full border border-mishkat-gold-500/30 text-xs font-tajawal text-mishkat-gold-600 mx-2 align-middle;
    }
    .bismillah {
        @apply text-center text-4xl mb-12 text-mishkat-green-800 dark:text-mishkat-gold-400 font-amiri block;
    }
</style>

<script>
    const QuranApp = {
        data: null,
        surahs: [],

        async init() {
            try {
                const response = await fetch('assets/data/quran-data/quran.json');
                const result = await response.json();
                this.data = result.data;
                this.surahs = result.data.surahs;
                
                this.renderGrid();
                document.getElementById('quranLoading').classList.add('hidden');
                document.getElementById('surahGrid').classList.remove('hidden');
                
                document.getElementById('surahSearch').addEventListener('input', (e) => this.filterSurahs(e.target.value));
            } catch (error) {
                console.error('Failed to load Quran data:', error);
                document.getElementById('quranLoading').innerHTML = `<p class="text-red-500">حدث خطأ أثناء تحميل البيانات. يرجى التأكد من مسار الملف.</p>`;
            }
        },

        renderGrid(list = this.surahs) {
            const grid = document.getElementById('surahGrid');
            grid.innerHTML = list.map(s => `
                <div class="luxury-card p-5 flex items-center gap-4 cursor-pointer hover:border-mishkat-gold-500/50 hover:-translate-y-1 transition-all group" onclick="QuranApp.showSurah(${s.number})">
                    <div class="w-12 h-12 rounded-xl bg-mishkat-green-50 dark:bg-mishkat-green-900/30 text-mishkat-green-700 dark:text-mishkat-gold-500 flex items-center justify-center font-black group-hover:bg-mishkat-gold-500 group-hover:text-black transition-colors">
                        ${s.number}
                    </div>
                    <div class="flex-1">
                        <h4 class="font-black text-gray-900 dark:text-white">${s.name}</h4>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">${s.revelationType === 'Meccan' ? 'مكية' : 'مدنية'} • ${s.ayahs.length} آيات</p>
                    </div>
                    <span class="material-icons-outlined text-gray-300 group-hover:text-mishkat-gold-500">chevron_left</span>
                </div>
            `).join('');
        },

        filterSurahs(query) {
            const filtered = this.surahs.filter(s => s.name.includes(query) || s.number.toString() === query);
            this.renderGrid(filtered);
        },

        showSurah(num) {
            const surah = this.surahs.find(s => s.number === num);
            if (!surah) return;

            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            document.getElementById('surahGrid').classList.add('hidden');
            document.getElementById('surahReader').classList.remove('hidden');
            
            document.getElementById('readerSurahName').innerText = surah.name;
            document.getElementById('readerSurahMeta').innerText = `${surah.revelationType === 'Meccan' ? 'سورة مكية' : 'سورة مدنية'} • عدد آياتها ${surah.ayahs.length}`;
            
            let html = '';
            if (surah.number !== 1 && surah.number !== 9) {
                html += `<span class="bismillah">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</span>`;
            }
            
            surah.ayahs.forEach(a => {
                let text = a.text;
                if (a.numberInSurah === 1 && surah.number !== 1 && surah.number !== 9) {
                    text = text.replace('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', '').trim();
                }
                html += `<span>${text}</span> <span class="ayah-num">${QuranApp.toArabicDigits(a.numberInSurah)}</span> `;
            });
            
            document.getElementById('ayahsContainer').innerHTML = html;
        },

        toArabicDigits(num) {
            const id = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            return num.toString().replace(/[0-9]/g, (w) => id[+w]);
        }
    };

    function showSurahGrid() {
        document.getElementById('surahReader').classList.add('hidden');
        document.getElementById('surahGrid').classList.remove('hidden');
    }

    QuranApp.init();
</script>
