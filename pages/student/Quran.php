<?php
/**
 * Quran Reader - Mishkat Platform
 */
?>

<style>
    /* ── Quran Page Styles ── */
    .quran-hero {
        background: var(--sidebar-active-bg);
        border: 1px solid var(--border-color);
        border-radius: 2rem;
        padding: 2.5rem;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    html.dark .quran-hero {
        background: linear-gradient(135deg, rgba(212,168,67,0.08) 0%, rgba(0,0,0,0) 100%);
        border-color: rgba(212,168,67,0.15);
    }
    .quran-hero::before {
        content: 'قرآن';
        position: absolute;
        font-family: 'Amiri', serif;
        font-size: 10rem;
        color: var(--color-primary);
        opacity: 0.04;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        pointer-events: none;
        white-space: nowrap;
    }

    .surah-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 1.25rem;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .surah-card:hover {
        border-color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }
    html.dark .surah-card:hover {
        box-shadow: 0 8px 20px rgba(212,168,67,0.1);
    }
    .surah-num {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.9rem;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .surah-card:hover .surah-num {
        background: var(--color-primary);
        color: white;
    }
    html.dark .surah-card:hover .surah-num {
        color: #000;
    }

    /* Ayah Reader */
    .ayah-reader-container {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 2rem;
        padding: 2.5rem;
    }
    .ayah-text {
        font-family: 'Amiri', serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        line-height: 2.6;
        color: var(--color-text-main);
        text-align: justify;
        direction: rtl;
    }
    .ayah-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        border: 1.5px solid var(--color-primary);
        color: var(--color-primary);
        font-size: 0.75rem;
        font-family: 'Tajawal', sans-serif;
        margin: 0 0.35rem;
        vertical-align: middle;
        opacity: 0.7;
    }
    .bismillah-text {
        display: block;
        text-align: center;
        font-family: 'Amiri', serif;
        font-size: 1.75rem;
        color: var(--color-primary);
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    /* Search */
    .quran-search-wrapper {
        position: relative;
    }
    .quran-search-wrapper .search-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-text-muted);
    }
    .quran-search-wrapper input {
        padding-right: 3rem !important;
        padding-left: 1rem !important;
        padding-top: 0.75rem !important;
        padding-bottom: 0.75rem !important;
        border-radius: 1.25rem !important;
        font-family: 'Tajawal', sans-serif;
        width: 100%;
    }

    /* Back button */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem 0.5rem 0.75rem;
        border-radius: 2rem;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
        margin-bottom: 1.5rem;
    }
    .back-btn:hover {
        background: var(--color-primary);
        color: white;
        border-color: transparent;
    }
    html.dark .back-btn:hover { color: #000; }

    /* Surah Header Banner */
    .surah-header-banner {
        background: var(--color-primary);
        border-radius: 1.5rem;
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    html.dark .surah-header-banner { color: #000; }
    .surah-header-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .surah-header-banner h3 {
        font-family: 'Amiri', serif;
        font-size: 2.5rem;
        font-weight: 900;
        position: relative;
        z-index: 1;
    }
    .surah-header-banner p {
        font-size: 0.85rem;
        opacity: 0.8;
        font-weight: 600;
        letter-spacing: 0.1em;
        position: relative;
        z-index: 1;
        margin-top: 0.25rem;
    }

    /* Loading spinner */
    .quran-spinner {
        width: 3rem;
        height: 3rem;
        border: 3px solid var(--border-color);
        border-top-color: var(--color-primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Juz badge */
    .juz-badge {
        display: inline-block;
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        font-size: 0.7rem;
        font-weight: 700;
    }
</style>

<div class="animate-fadeIn" style="max-width: 1200px; margin: 0 auto;">

    <!-- Hero Header -->
    <div class="quran-hero">
        <div class="relative z-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4" style="background: var(--color-primary);">
                <span class="material-icons-outlined text-3xl" style="color: white;">auto_stories</span>
            </div>
            <h2 class="text-3xl font-black font-amiri mb-1" style="color: var(--color-text-main);">القرآن الكريم</h2>
            <p class="text-sm font-medium" style="color: var(--color-text-muted);">تلاوة وتدبر آيات الله البينات</p>
        </div>
    </div>

    <!-- Surah List Section -->
    <div id="quranContainer">

        <!-- Loading -->
        <div id="quranLoading" class="flex flex-col items-center justify-center py-24">
            <div class="quran-spinner"></div>
            <p class="mt-5 font-bold text-sm" style="color: var(--color-text-muted);">جاري تحميل القرآن الكريم...</p>
        </div>

        <!-- Grid View -->
        <div id="surahGridView" class="hidden">
            <!-- Search bar -->
            <div class="quran-search-wrapper mb-6" style="max-width: 400px;">
                <span class="material-icons-outlined search-icon">search</span>
                <input type="text" id="surahSearch" placeholder="ابحث عن سورة...">
            </div>

            <!-- Stats row -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="luxury-card p-4 text-center">
                    <p class="text-2xl font-black" style="color: var(--color-primary);">١١٤</p>
                    <p class="text-xs font-semibold mt-1" style="color: var(--color-text-muted);">سورة</p>
                </div>
                <div class="luxury-card p-4 text-center">
                    <p class="text-2xl font-black" style="color: var(--color-primary);">٦٢٣٦</p>
                    <p class="text-xs font-semibold mt-1" style="color: var(--color-text-muted);">آية</p>
                </div>
                <div class="luxury-card p-4 text-center">
                    <p class="text-2xl font-black" style="color: var(--color-primary);">٣٠</p>
                    <p class="text-xs font-semibold mt-1" style="color: var(--color-text-muted);">جزءاً</p>
                </div>
            </div>

            <!-- Surahs Grid -->
            <div id="surahGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <!-- injected by JS -->
            </div>
        </div>

        <!-- Surah Reader -->
        <div id="surahReader" class="hidden">
            <button class="back-btn" onclick="showSurahGrid()">
                <span class="material-icons-outlined" style="font-size:1.1rem;">arrow_forward</span>
                العودة لقائمة السور
            </button>

            <div class="surah-header-banner">
                <h3 id="readerSurahName"></h3>
                <p id="readerSurahMeta"></p>
            </div>

            <div class="ayah-reader-container">
                <div id="ayahsContainer" class="ayah-text"></div>
            </div>
        </div>

    </div>
</div>

<script>
    const QuranApp = {
        surahs: [],

        async init() {
            try {
                const res = await fetch('assets/data/quran-data/quran.json');
                const json = await res.json();
                this.surahs = json.data.surahs;

                this.renderGrid();

                document.getElementById('quranLoading').classList.add('hidden');
                document.getElementById('surahGridView').classList.remove('hidden');

                document.getElementById('surahSearch').addEventListener('input', (e) =>
                    this.filterSurahs(e.target.value)
                );
            } catch (err) {
                document.getElementById('quranLoading').innerHTML =
                    `<p style="color: #ef4444; font-weight: bold;">⚠️ حدث خطأ أثناء تحميل البيانات</p>`;
            }
        },

        renderGrid(list = this.surahs) {
            document.getElementById('surahGrid').innerHTML = list.map(s => `
                <div class="surah-card" onclick="QuranApp.showSurah(${s.number})">
                    <div class="surah-num">${s.number}</div>
                    <div style="flex:1; min-width:0;">
                        <h4 class="font-black text-sm" style="color: var(--color-text-main);">${s.name}</h4>
                        <p class="text-xs mt-0.5" style="color: var(--color-text-muted);">
                            ${s.revelationType === 'Meccan' ? 'مكية' : 'مدنية'} &bull; ${s.ayahs.length} آيات
                        </p>
                    </div>
                    <span class="material-icons-outlined" style="color: var(--color-text-muted); font-size:1.1rem;">chevron_left</span>
                </div>
            `).join('');
        },

        filterSurahs(q) {
            const filtered = this.surahs.filter(s =>
                s.name.includes(q) || s.number.toString() === q
            );
            this.renderGrid(filtered);
        },

        showSurah(num) {
            const surah = this.surahs.find(s => s.number === num);
            if (!surah) return;

            window.scrollTo({ top: 0, behavior: 'smooth' });

            document.getElementById('surahGridView').classList.add('hidden');
            document.getElementById('surahReader').classList.remove('hidden');

            document.getElementById('readerSurahName').innerText = surah.name;
            document.getElementById('readerSurahMeta').innerText =
                `${surah.revelationType === 'Meccan' ? 'سورة مكية' : 'سورة مدنية'} • ${surah.ayahs.length} آية`;

            let html = '';
            if (surah.number !== 1 && surah.number !== 9) {
                html += `<span class="bismillah-text">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</span>`;
            }

            surah.ayahs.forEach(a => {
                let text = a.text;
                if (a.numberInSurah === 1 && surah.number !== 1 && surah.number !== 9) {
                    text = text.replace('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', '').trim();
                }
                html += `<span>${text}</span><span class="ayah-number">${this.toArabic(a.numberInSurah)}</span> `;
            });

            document.getElementById('ayahsContainer').innerHTML = html;
        },

        toArabic(num) {
            return num.toString().replace(/[0-9]/g, d => '٠١٢٣٤٥٦٧٨٩'[d]);
        }
    };

    function showSurahGrid() {
        document.getElementById('surahReader').classList.add('hidden');
        document.getElementById('surahGridView').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    QuranApp.init();
</script>
