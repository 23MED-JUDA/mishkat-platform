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
<link rel="icon" type="image/jpeg" href="assets/images/6046279299901361992.jpg">
<link rel="apple-touch-icon" href="assets/images/6046279299901361992.jpg">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ══════════════════════════════════════
       THEME VARIABLES (Premium Minimalist Palette)
    ══════════════════════════════════════ */
    :root {
        /* LIGHT MODE: 3 calm colors — White, Soft Gray, Calm Green. NO GOLD. */
        --bg-app: #f5f5f5;            /* Warm off-white background */
        --bg-surface: #ffffff;        /* Pure white cards */
        --color-primary: #4a8c6e;     /* Calm sage green — the only accent */
        --color-primary-light: #6aad8e;
        --color-accent: #4a8c6e;      /* Same green (no gold in light mode) */
        --color-text-main: #2c2c2c;   /* Soft dark gray, not harsh black */
        --color-text-muted: #888888;  /* Medium gray for secondary text */
        --border-color: #e8e8e8;      /* Very soft gray border */

        /* Sidebar — white with green accents */
        --sidebar-bg: #ffffff;
        --sidebar-text: #888888;
        --sidebar-text-hover: #4a8c6e;
        --sidebar-active-bg: #eef6f1; /* Faint green tint */
        --sidebar-active-text: #4a8c6e;
        --sidebar-icon-bg: #f0f0f0;
        --sidebar-icon-bg-active: #d4ece1;
    }

    html.dark {
        /* DARK MODE: Black + White + Electric Neon Cyan/Blue */
        --bg-app: #000000;            /* Pure Black background */
        --bg-surface: #0a0a0a;        /* Near-black for cards */
        --color-primary: #00d2ff;     /* Vibrant Electric Cyan/Blue */
        --color-primary-light: #7be7ff;
        --color-accent: #00d2ff;      /* Electric accent */
        --color-text-main: #ffffff;   /* Pure White text */
        --color-text-muted: #888888;  /* Muted silver text */
        --border-color: rgba(0, 210, 255, 0.12); /* Subtle glowing electric border */

        /* Sidebar — pure black with glowing electric highlights */
        --sidebar-bg: #050505;
        --sidebar-text: #888888;
        --sidebar-text-hover: #ffffff;
        --sidebar-active-bg: rgba(0, 210, 255, 0.12); /* Subtle glow for active item */
        --sidebar-active-text: #00d2ff; /* Electric active text */
        --sidebar-icon-bg: #111111;
        --sidebar-icon-bg-active: rgba(0, 210, 255, 0.2);
    }

    /* ══════════════════════════════════════
       GLOBAL OVERRIDES
    ══════════════════════════════════════ */
    body {
        font-family: 'Tajawal', sans-serif;
        background-color: var(--bg-app) !important;
        color: var(--color-text-main) !important;
        transition: background-color 0.4s ease, color 0.4s ease;
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
        border-radius: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.25s ease;
    }
    html.dark .luxury-card {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(212,168,67,0.06);
    }

    /* — Typography Colors — */
    .text-gray-900, .text-gray-800, .text-gray-700 {
        color: var(--color-text-main) !important;
    }
    .text-gray-600, .text-gray-500, .text-gray-400 {
        color: var(--color-text-muted) !important;
    }
    .text-mishkat-green-900, .text-mishkat-green-800, .text-mishkat-green-700, .text-mishkat-green-600 {
        color: var(--color-primary) !important;
    }
    html.dark .text-mishkat-green-900, html.dark .text-mishkat-green-800, html.dark .text-mishkat-green-700, html.dark .text-mishkat-green-600 {
        color: var(--color-text-main) !important;
    }
    
    /* Accents */
    .text-amber-500, .text-amber-600, .text-mishkat-gold-500, .text-mishkat-gold-600, .text-mishkat-gold-400 {
        color: var(--color-accent) !important;
    }
    html.dark .text-amber-500, html.dark .text-amber-600, html.dark .text-mishkat-gold-500, html.dark .text-mishkat-gold-600, html.dark .text-mishkat-gold-400 {
        color: var(--color-primary) !important;
    }

    /* — Background Accents (Badges, light backgrounds) — */
    .bg-mishkat-green-50, .bg-amber-50 {
        background-color: var(--sidebar-active-bg) !important;
    }
    html.dark .bg-blue-50, html.dark .bg-purple-50, html.dark .bg-red-50 {
        background-color: rgba(212, 168, 67, 0.08) !important;
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
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--border-color) !important;
    }
    html.dark .glass-nav {
        background: rgba(0, 0, 0, 0.9) !important;
        border-bottom: 1px solid rgba(212, 168, 67, 0.15) !important;
    }

    /* — Sidebar — */
    .luxury-sidebar {
        background: var(--sidebar-bg) !important;
        border-left: 1px solid var(--border-color) !important;
        box-shadow: 2px 0 20px rgba(0,0,0,0.06) !important;
    }
    html.dark .luxury-sidebar {
        box-shadow: 0 0 40px rgba(0,0,0,0.8) !important;
    }

    /* Sidebar nav items */
    .luxury-sidebar-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.65rem 1rem;
        border-radius: 1.25rem;
        margin: 0.2rem 0.75rem;
        color: var(--sidebar-text) !important;
        text-decoration: none;
        transition: all 0.25s ease;
    }
    .luxury-sidebar-item:hover:not(.active) {
        background: var(--sidebar-active-bg) !important;
        color: var(--sidebar-text-hover) !important;
    }
    .luxury-sidebar-item.active {
        background: var(--sidebar-active-bg) !important;
        color: var(--sidebar-active-text) !important;
        font-weight: 700;
    }
    .luxury-sidebar-item .icon-box {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--sidebar-icon-bg);
        flex-shrink: 0;
        transition: all 0.25s ease;
    }
    .luxury-sidebar-item.active .icon-box {
        background: var(--sidebar-icon-bg-active);
    }
    .luxury-sidebar-item .material-icons-outlined {
        font-size: 1.2rem;
        color: var(--sidebar-text) !important;
        transition: color 0.25s ease;
    }
    .luxury-sidebar-item:hover .material-icons-outlined {
        color: var(--sidebar-text-hover) !important;
    }
    .luxury-sidebar-item.active .material-icons-outlined {
        color: var(--sidebar-active-text) !important;
    }
    html.dark .luxury-sidebar-item.active .icon-box {
        box-shadow: 0 4px 12px rgba(212, 168, 67, 0.3);
    }

    /* Sidebar Logo & User Box */
    .logo-box {
        background: var(--sidebar-bg) !important;
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem 1.25rem;
    }
    .user-box {
        background: var(--bg-app) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 1.25rem;
    }
    .user-info p { color: var(--color-text-main) !important; }
    .user-info span { color: var(--color-text-muted) !important; }

    /* — Buttons — */
    .btn-luxury {
        background: var(--color-primary) !important;
        color: #ffffff !important;
        border-radius: 1.5rem;
        padding: 0.75rem 2rem;
        font-weight: bold;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: none !important;
    }
    html.dark .btn-luxury {
        color: #000000 !important;
        box-shadow: 0 4px 16px rgba(212,168,67,0.25);
    }
    .btn-luxury:hover { 
        transform: translateY(-2px); 
        filter: brightness(1.1);
    }

    /* — Inputs — */
    input, select, textarea {
        background-color: var(--bg-app) !important;
        color: var(--color-text-main) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 1rem;
    }
    input:focus, select:focus, textarea:focus {
        border-color: var(--color-primary) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px var(--sidebar-active-bg) !important;
    }

    /* — Modal — */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
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
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    html.dark ::-webkit-scrollbar-thumb { background: #475569; }

    /* — Toast — */
    .toast-container {
        position: fixed;
        bottom: 2rem;
        left: 2rem;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Animations */
    @keyframes fadeIn  { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
    .animate-fadeIn  { animation: fadeIn  0.4s ease forwards; }
    .animate-slideIn { animation: slideIn 0.3s ease forwards; }

    /* --- Mobile & Responsive Optimizations --- */
    @media (max-width: 768px) {
        body { font-size: 14px; }
        .luxury-card { border-radius: 1.25rem !important; padding: 1.25rem !important; }
        .btn-luxury { width: 100%; text-align: center; }
        .grid { gap: 1rem !important; }
        .table-container { 
            width: 100%; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
            border-radius: 1rem;
        }
        h1 { font-size: 1.5rem !important; }
        h2 { font-size: 1.25rem !important; }
        h3 { font-size: 1.1rem !important; }
        .glass-nav { padding: 0.75rem 1rem !important; }
    }

    /* --- Buttons & Images Global Animations --- */
    button, .btn-luxury, a.btn-luxury {
        transition: all 0.2s ease;
    }
    button:active:not(:disabled), .btn-luxury:active {
        transform: translateY(0) scale(0.98);
    }

    img {
        transition: all 0.3s ease;
    }
    .luxury-card img:hover {
        transform: scale(1.02);
    }

    html, body {
        max-width: 100vw;
        overflow-x: hidden;
        position: relative;
    }
</style>

<script src="assets/js/mishkat-ui.js" defer></script>
