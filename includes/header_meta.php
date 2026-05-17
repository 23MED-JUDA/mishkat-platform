<!-- Preconnect to external resources -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdnjs.cloudflare.com">
<link rel="dns-prefetch" href="https://fonts.googleapis.com">
<link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        colors: {
          'mishkat-green': {
            50:  '#f0f7f4', 100: '#dceee5', 200: '#bbdece',
            300: '#8ec7ad', 400: '#5da888', 500: '#3e8c6b',
            600: '#2d7155', 700: '#225c42', 800: '#1d4a36',
            900: '#193d2e', 950: '#0e231b',
          },
          'mishkat-gold': {
            50:  '#fdf9ed', 100: '#f9efd1', 200: '#f2dea3',
            300: '#e9c66d', 400: '#dfa73f', 500: '#d48d28',
            600: '#b86f20', 700: '#99541d', 800: '#7c431b',
            900: '#663819', 950: '#3a1d0b',
          },
          'mishkat-beige': {
            50:  '#fcfaf6', 100: '#f7f2e9', 200: '#ede2ce',
            300: '#decaa8', 400: '#ccab7e', 500: '#bd915f',
          }
        },
        fontFamily: {
          'tajawal': ['Tajawal', 'sans-serif'],
          'amiri': ['Amiri', 'serif'],
        },
      }
    }
  }
</script>

<!-- Favicon -->
<link rel="icon" type="image/png" href="assets/images/logo-app.png">
<link rel="apple-touch-icon" href="assets/images/logo-app.png">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ══════════════════════════════════════
       THEME VARIABLES (3 Harmonious Colors)
    ══════════════════════════════════════ */
    :root {
        /* LIGHT MODE: Mint (Background), Green (Primary), Gold (Accent) */
        --bg-app: #f0f4f2;            /* Soft mint background */
        --bg-surface: #ffffff;        /* Pure white cards */
        --color-primary: #193d2e;     /* Deep Emerald Green */
        --color-primary-light: #2d7155; 
        --color-accent: #d48d28;      /* Warm Gold */
        --color-text-main: #112b20;   /* Dark Green Text */
        --color-text-muted: #5da888;  /* Muted Green Text */
        --border-color: rgba(25, 61, 46, 0.08);
        --sidebar-bg: linear-gradient(180deg, #193d2e 0%, #112b20 100%);
        --sidebar-text: rgba(255, 255, 255, 0.7);
        --sidebar-text-hover: #ffffff;
        --sidebar-active-bg: rgba(212, 141, 40, 0.15);
        --sidebar-active-text: #e9c66d;
    }

    html.dark {
        /* DARK MODE: Dark Forest (Surface), Gold (Accent), Mint-White (Text) */
        --bg-app: #090e0c;            /* Deep Forest Black */
        --bg-surface: #121c18;        /* Dark Emerald Gray Cards */
        --color-primary: #d48d28;     /* Gold becomes primary in dark mode */
        --color-primary-light: #e9c66d;
        --color-accent: #c97f22;      /* Darker Gold */
        --color-text-main: #e6f0ec;   /* Light Mint Text */
        --color-text-muted: #8ba699;  /* Muted Mint Text */
        --border-color: rgba(212, 141, 40, 0.15);
        --sidebar-bg: linear-gradient(180deg, #050807 0%, #090e0c 100%);
        --sidebar-text: #8ba699;
        --sidebar-text-hover: #e6f0ec;
        --sidebar-active-bg: linear-gradient(135deg, #d48d28, #c97f22);
        --sidebar-active-text: #050807;
    }

    /* ══════════════════════════════════════
       GLOBAL OVERRIDES
    ══════════════════════════════════════ */
    body {
        font-family: 'Tajawal', sans-serif;
        background-color: var(--bg-app) !important;
        color: var(--color-text-main) !important;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    /* — Surfaces & Cards — */
    .bg-white, .luxury-card, .modal-box {
        background-color: var(--bg-surface) !important;
        border-color: var(--border-color) !important;
    }
    .bg-gray-50, .bg-gray-100 {
        background-color: var(--bg-app) !important;
    }
    .luxury-card {
        border-radius: 2.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    html.dark .luxury-card {
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
    }

    /* — Typography Colors — */
    .text-gray-900, .text-gray-800, .text-gray-700, .text-mishkat-green-900 {
        color: var(--color-text-main) !important;
    }
    .text-gray-600, .text-gray-500, .text-gray-400 {
        color: var(--color-text-muted) !important;
    }
    html:not(.dark) .text-mishkat-green-800, html:not(.dark) .text-mishkat-green-700, html:not(.dark) .text-mishkat-green-600 {
        color: var(--color-primary) !important;
    }
    html.dark .text-mishkat-green-800, html.dark .text-mishkat-green-700, html.dark .text-mishkat-green-600 {
        color: var(--color-primary) !important;
    }
    
    /* Accents */
    .text-amber-500, .text-amber-600, .text-mishkat-gold-500, .text-mishkat-gold-600, .text-mishkat-gold-400 {
        color: var(--color-primary) !important;
    }

    /* — Background Accents (Badges, light backgrounds) — */
    .bg-mishkat-green-50, .bg-amber-50, .bg-blue-50, .bg-purple-50, .bg-red-50 {
        background-color: rgba(212, 141, 40, 0.1) !important;
    }
    html:not(.dark) .bg-mishkat-green-50 {
        background-color: rgba(25, 61, 46, 0.05) !important;
    }
    
    /* Progress Bars & Badges filled */
    .bg-mishkat-green-500, .bg-mishkat-green-600, .bg-mishkat-green-700 {
        background-color: var(--color-primary) !important;
    }

    /* — Borders — */
    .border-gray-100, .border-gray-200, .border-white\/10 {
        border-color: var(--border-color) !important;
    }

    /* — Top Nav — */
    .glass-nav {
        background: rgba(255, 255, 255, 0.85) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border-color) !important;
    }
    html.dark .glass-nav {
        background: rgba(18, 28, 24, 0.85) !important;
    }

    /* — Sidebar — */
    .luxury-sidebar {
        background: var(--sidebar-bg) !important;
        border-left: 1px solid var(--border-color) !important;
        box-shadow: 4px 0 30px rgba(0, 0, 0, 0.15) !important;
    }
    html.dark .luxury-sidebar {
        box-shadow: 4px 0 30px rgba(0, 0, 0, 0.6) !important;
    }

    .luxury-sidebar-item {
        color: var(--sidebar-text) !important;
    }
    .luxury-sidebar-item:hover:not(.active) {
        background: rgba(255, 255, 255, 0.05) !important;
        color: var(--sidebar-text-hover) !important;
    }
    .luxury-sidebar-item.active {
        background: var(--sidebar-active-bg) !important;
        color: var(--sidebar-active-text) !important;
    }
    html.dark .luxury-sidebar-item.active .material-icons-outlined,
    html.dark .luxury-sidebar-item.active span {
        color: var(--sidebar-active-text) !important;
    }

    /* Sidebar Logo overriding hardcoded from-[#0c1210] gradient */
    .logo-box {
        background: transparent !important;
    }

    /* — Buttons — */
    .btn-luxury {
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light)) !important;
        color: #ffffff !important;
        border-radius: 2rem;
        padding: 0.75rem 2rem;
        font-weight: 800;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px -5px rgba(0,0,0,0.3);
        border: none !important;
    }
    html.dark .btn-luxury {
        color: #050807 !important;
    }
    .btn-luxury:hover { transform: translateY(-2px); }

    /* — Inputs — */
    input, select, textarea {
        background-color: var(--bg-app) !important;
        color: var(--color-text-main) !important;
        border: 1px solid var(--border-color) !important;
    }
    input:focus, select:focus, textarea:focus {
        border-color: var(--color-primary) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(212, 141, 40, 0.2) !important;
    }
    html:not(.dark) input:focus, html:not(.dark) select:focus, html:not(.dark) textarea:focus {
        box-shadow: 0 0 0 3px rgba(25, 61, 46, 0.2) !important;
    }

    /* — Modal — */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(10px);
        z-index: 100;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .modal-backdrop.active { display: flex; }
    .modal-box {
        width: 100%;
        max-width: 500px;
    }

    /* — Scrollbar — */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--color-primary-light); border-radius: 10px; }

    /* — Toast — */
    .toast-container {
        position: fixed;
        top: 2rem;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Animations */
    @keyframes fadeIn  { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
    .animate-fadeIn  { animation: fadeIn  0.5s ease forwards; }
    .animate-slideIn { animation: slideIn 0.4s ease forwards; }

    /* --- Mobile & Responsive Optimizations --- */
    @media (max-width: 768px) {
        body { font-size: 14px; }
        .luxury-card { border-radius: 1.5rem !important; padding: 1.25rem !important; }
        .btn-luxury { width: 100%; text-align: center; }
        .grid { gap: 1rem !important; }
        .table-container { 
            width: 100%; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
            border-radius: 1rem;
        }
        h1 { font-size: 1.75rem !important; }
        h2 { font-size: 1.35rem !important; }
        h3 { font-size: 1.15rem !important; }
        .glass-nav { padding: 0.75rem 1rem !important; }
    }

    /* --- Buttons & Images Global Animations --- */
    button, .btn-luxury, a.btn-luxury {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    button:hover:not(:disabled), .btn-luxury:hover {
        transform: translateY(-3px) scale(1.02);
        filter: brightness(1.1);
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.3);
    }
    button:active:not(:disabled), .btn-luxury:active {
        transform: translateY(-1px) scale(0.97);
    }

    img {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .luxury-card img:hover {
        transform: scale(1.05) rotate(1deg);
        filter: saturate(1.1);
    }

    /* Special Glow for Primary Buttons */
    .btn-luxury::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        transform: scale(0);
        transition: transform 0.6s ease-out;
        pointer-events: none;
    }
    .btn-luxury:hover::after {
        transform: scale(1);
    }

    html, body {
        max-width: 100vw;
        overflow-x: hidden;
        position: relative;
    }
</style>

<script src="assets/js/mishkat-ui.js" defer></script>
