<?php
/**
 * Quran Reader - Mishkat Platform
 */
?>

<style>
    /* ══ Quran Page ══ */
    .quran-hero {
        background: var(--sidebar-active-bg);
        border: 1px solid var(--border-color);
        border-radius: 2rem;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    html.dark .quran-hero {
        background: linear-gradient(135deg, rgba(212,168,67,0.06) 0%, rgba(0,0,0,0) 100%);
        border-color: rgba(212,168,67,0.12);
    }

    /* Surah Grid */
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
        text-decoration: none;
    }
    .surah-card:hover {
        border-color: var(--color-primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }
    html.dark .surah-card:hover {
        box-shadow: 0 8px 24px rgba(212,168,67,0.1);
    }
    .surah-num {
        width: 2.75rem;
        height: 2.75rem;
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.85rem;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        flex-shrink: 0;
        transition: all 0.2s ease;
        font-family: 'Tajawal', sans-serif;
    }
    .surah-card:hover .surah-num {
        background: var(--color-primary);
        color: white;
    }
    html.dark .surah-card:hover .surah-num { color: #000; }

    /* ══ Surah Reader ══ */
    .surah-banner {
        background: var(--color-primary);
        border-radius: 1.75rem;
        padding: 2rem 2.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .surah-banner h3 {
        font-family: 'Amiri', serif;
        font-size: 2.5rem;
        font-weight: 900;
        color: white;
        position: relative;
        z-index: 1;
    }
    html.dark .surah-banner h3 { color: #000; }
    .surah-banner p {
        font-size: 0.8rem;
        letter-spacing: 0.1em;
        font-weight: 600;
        color: rgba(255,255,255,0.75);
        margin-top: 0.3rem;
        position: relative;
        z-index: 1;
    }
    html.dark .surah-banner p { color: rgba(0,0,0,0.6); }
    .surah-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(255,255,255,0.1) 0%, transparent 60%);
    }

    /* Bismillah */
    .bismillah-row {
        text-align: center;
        font-family: 'Amiri', serif;
        font-size: 1.9rem;
        color: var(--color-primary);
        padding: 1.5rem 1rem;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 0.5rem;
        line-height: 1.8;
    }

    /* ══ Each Ayah as its own row ══ */
    .ayah-row {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        direction: rtl;
        transition: background 0.2s ease;
    }
    .ayah-row:last-child { border-bottom: none; }
    .ayah-row:hover {
        background: var(--sidebar-active-bg);
        border-radius: 1rem;
    }

    /* Ayah number badge */
    .ayah-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        border: 2px solid var(--color-primary);
        color: var(--color-primary);
        font-family: 'Tajawal', sans-serif;
        font-size: 0.8rem;
        font-weight: 900;
        flex-shrink: 0;
        background: var(--sidebar-active-bg);
        margin-top: 0.25rem;
    }

    /* Ayah text */
    .ayah-body {
        font-family: 'Amiri', serif;
        font-size: clamp(1.3rem, 2.5vw, 1.75rem);
        line-height: 2.2;
        color: var(--color-text-main);
        flex: 1;
        text-align: right;
    }

    /* Reader container */
    .reader-box {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 2rem;
        overflow: hidden;
    }

    /* Toolbar inside reader */
    .reader-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-app);
    }
    .ayah-count-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.3rem 0.9rem;
        border-radius: 2rem;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Tajawal', sans-serif;
    }

    /* Back button */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 1.1rem;
        border-radius: 2rem;
        background: var(--sidebar-active-bg);
        color: var(--color-primary);
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
        font-family: 'Tajawal', sans-serif;
        margin-bottom: 1.25rem;
    }
    .back-btn:hover {
        background: var(--color-primary);
        color: white;
        border-color: transparent;
    }
    html.dark .back-btn:hover { color: #000; }

    /* Search */
    .quran-search-wrap {
        position: relative;
        max-width: 360px;
        margin-bottom: 1.5rem;
    }
    .quran-search-wrap .s-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-text-muted);
        font-size: 1.2rem;
    }
    .quran-search-wrap input {
        width: 100%;
        padding: 0.7rem 3rem 0.7rem 1rem !important;
        border-radius: 1.25rem !important;
        font-family: 'Tajawal', sans-serif;
    }

    /* Spinner */
    .q-spinner {
        width: 3rem; height: 3rem;
        border: 3px solid var(--border-color);
        border-top-color: var(--color-primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Pagination */
    .page-nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.5rem 1.2rem;
        border-radius: 2rem;
        border: 1px solid var(--border-color);
        background: var(--bg-surface);
        color: var(--color-text-muted);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Tajawal', sans-serif;
    }
    .page-nav-btn:hover:not(:disabled) {
        background: var(--color-primary);
        color: white;
        border-color: transparent;
    }
    html.dark .page-nav-btn:hover:not(:disabled) { color: #000; }
    .page-nav-btn:disabled { opacity: 0.35; cursor: not-allowed; }
</style>

<div class="animate-fadeIn" style="max-width: 1100px; margin: 0 auto;">

    <!-- Hero -->
    <div class="quran-hero mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-3"
             style="background: var(--color-primary);">
            <span class="material-icons-outlined text-2xl" style="color:white;">auto_stories</span>
        </div>
        <h2 class="text-2xl font-black font-amiri mb-1" style="color: var(--color-text-main);">القرآن الكريم</h2>
        <p class="text-sm" style="color: var(--color-text-muted);">تلاوة وتدبر آيات الله البينات</p>
    </div>

    <!-- Loading -->
    <div id="quranLoading" class="flex flex-col items-center justify-center py-24">
        <div class="q-spinner"></div>
        <p class="mt-4 text-sm font-semibold" style="color: var(--color-text-muted);">جاري تحميل القرآن الكريم...</p>
    </div>

    <!-- Grid View -->
    <div id="surahGridView" class="hidden">

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-3 mb-6">
            <div class="luxury-card p-4 text-center">
                <p class="text-xl font-black" style="color: var(--color-primary);">١١٤</p>
                <p class="text-xs mt-1 font-medium" style="color: var(--color-text-muted);">سورة</p>
            </div>
            <div class="luxury-card p-4 text-center">
                <p class="text-xl font-black" style="color: var(--color-primary);">٦٢٣٦</p>
                <p class="text-xs mt-1 font-medium" style="color: var(--color-text-muted);">آية</p>
            </div>
            <div class="luxury-card p-4 text-center">
                <p class="text-xl font-black" style="color: var(--color-primary);">٣٠</p>
                <p class="text-xs mt-1 font-medium" style="color: var(--color-text-muted);">جزءاً</p>
            </div>
        </div>

        <!-- Search -->
        <div class="quran-search-wrap">
            <span class="material-icons-outlined s-icon">search</span>
            <input type="text" id="surahSearch" placeholder="ابحث عن سورة...">
        </div>

        <!-- Grid -->
        <div id="surahGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3"></div>
    </div>

    <!-- Surah Reader -->
    <div id="surahReader" class="hidden">

        <!-- Back -->
        <button class="back-btn" onclick="showSurahGrid()">
            <span class="material-icons-outlined" style="font-size:1rem;">arrow_forward</span>
            العودة لقائمة السور
        </button>

        <!-- Banner -->
        <div class="surah-banner">
            <h3 id="readerSurahName"></h3>
            <p id="readerSurahMeta"></p>
        </div>

        <!-- Reader box -->
        <div class="reader-box">

            <!-- Toolbar -->
            <div class="reader-toolbar">
                <div class="ayah-count-badge">
                    <span class="material-icons-outlined" style="font-size:0.95rem;">format_list_numbered</span>
                    <span id="ayahCountLabel"></span>
                </div>
                <div style="color: var(--color-text-muted); font-size:0.8rem; font-family:'Tajawal',sans-serif;">
                    الصفحة <span id="pageLabel">١</span>
                </div>
            </div>

            <!-- Ayahs -->
            <div id="ayahsContainer" style="padding: 0.5rem 0;"></div>

            <!-- Pagination -->
            <div id="paginationBar" class="hidden flex items-center justify-between gap-3 px-5 py-4"
                 style="border-top: 1px solid var(--border-color);">
                <button class="page-nav-btn" onclick="QuranApp.prevPage()">
                    <span class="material-icons-outlined" style="font-size:1rem;">chevron_right</span>
                    السابق
                </button>
                <span id="pageInfo" style="color: var(--color-text-muted); font-size:0.85rem; font-family:'Tajawal',sans-serif;"></span>
                <button class="page-nav-btn" onclick="QuranApp.nextPage()">
                    التالي
                    <span class="material-icons-outlined" style="font-size:1rem;">chevron_left</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const QuranApp = {
    surahs: [],
    currentSurah: null,
    currentPage: 1,
    ayahsPerPage: 20,

    async init() {
        try {
            const res  = await fetch('assets/data/quran-data/quran.json');
            const json = await res.json();
            this.surahs = json.data.surahs;

            this.renderGrid();
            document.getElementById('quranLoading').classList.add('hidden');
            document.getElementById('surahGridView').classList.remove('hidden');

            document.getElementById('surahSearch').addEventListener('input', e =>
                this.filterSurahs(e.target.value)
            );
        } catch {
            document.getElementById('quranLoading').innerHTML =
                `<p style="color:#ef4444;font-weight:bold;">⚠️ حدث خطأ أثناء تحميل البيانات</p>`;
        }
    },

    renderGrid(list = this.surahs) {
        document.getElementById('surahGrid').innerHTML = list.map(s => `
            <div class="surah-card" onclick="QuranApp.showSurah(${s.number})">
                <div class="surah-num">${s.number}</div>
                <div style="flex:1; min-width:0;">
                    <h4 style="font-weight:900; color: var(--color-text-main); font-size:0.95rem;">${s.name}</h4>
                    <p style="font-size:0.75rem; color: var(--color-text-muted); margin-top:2px;">
                        ${s.revelationType === 'Meccan' ? 'مكية' : 'مدنية'} &bull; ${s.ayahs.length} آيات
                    </p>
                </div>
                <span class="material-icons-outlined" style="color:var(--color-text-muted);font-size:1.1rem;">chevron_left</span>
            </div>
        `).join('');
    },

    filterSurahs(q) {
        const r = this.surahs.filter(s => s.name.includes(q) || s.number.toString() === q);
        this.renderGrid(r);
    },

    showSurah(num) {
        const surah = this.surahs.find(s => s.number === num);
        if (!surah) return;

        this.currentSurah = surah;
        this.currentPage  = 1;

        window.scrollTo({ top: 0, behavior: 'smooth' });
        document.getElementById('surahGridView').classList.add('hidden');
        document.getElementById('surahReader').classList.remove('hidden');

        document.getElementById('readerSurahName').innerText = surah.name;
        document.getElementById('readerSurahMeta').innerText =
            `${surah.revelationType === 'Meccan' ? 'سورة مكية' : 'سورة مدنية'} • ${surah.ayahs.length} آية`;

        document.getElementById('ayahCountLabel').innerText = `${surah.ayahs.length} آية`;

        this.renderPage();
    },

    renderPage() {
        const surah  = this.currentSurah;
        const ayahs  = surah.ayahs;
        const total  = Math.ceil(ayahs.length / this.ayahsPerPage);
        const start  = (this.currentPage - 1) * this.ayahsPerPage;
        const slice  = ayahs.slice(start, start + this.ayahsPerPage);

        let html = '';

        // Bismillah before first ayah (only on page 1)
        if (this.currentPage === 1 && surah.number !== 1 && surah.number !== 9) {
            html += `<div class="bismillah-row">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>`;
        }

        slice.forEach(a => {
            let text = a.text;
            // Remove embedded bismillah from ayah 1 (except Al-Fatiha)
            if (a.numberInSurah === 1 && surah.number !== 1 && surah.number !== 9) {
                text = text.replace('بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', '').trim();
            }
            html += `
                <div class="ayah-row">
                    <div class="ayah-badge">${this.toArabic(a.numberInSurah)}</div>
                    <div class="ayah-body">${text}</div>
                </div>
            `;
        });

        document.getElementById('ayahsContainer').innerHTML = html;

        // Update page label
        document.getElementById('pageLabel').innerText = this.toArabic(this.currentPage);
        document.getElementById('pageInfo').innerText =
            `${this.toArabic(this.currentPage)} من ${this.toArabic(total)}`;

        // Show pagination if needed
        const bar = document.getElementById('paginationBar');
        if (total > 1) {
            bar.classList.remove('hidden');
            bar.classList.add('flex');
            bar.querySelectorAll('button')[0].disabled = (this.currentPage === 1);
            bar.querySelectorAll('button')[1].disabled = (this.currentPage === total);
        } else {
            bar.classList.add('hidden');
        }
    },

    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.renderPage();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    nextPage() {
        const total = Math.ceil(this.currentSurah.ayahs.length / this.ayahsPerPage);
        if (this.currentPage < total) {
            this.currentPage++;
            this.renderPage();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
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
