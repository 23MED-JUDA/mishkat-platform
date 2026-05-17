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
       THEME VARIABLES (Premium Minimalist Palette)
    ══════════════════════════════════════ */
    :root {
        /* LIGHT MODE: Clean White & Gray, Vibrant Green, Subtle Gold */
        --bg-app: #f8fafc;            /* Soft cool gray background */
        --bg-surface: #ffffff;        /* Pure white cards & sidebar */
        --color-primary: #059669;     /* Vibrant Emerald Green */
        --color-primary-light: #10b981; 
        --color-accent: #f59e0b;      /* Warm Amber/Gold */
        --color-text-main: #0f172a;   /* Deep slate for high contrast */
        --color-text-muted: #64748b;  /* Muted slate text */
        --border-color: #e2e8f0;      /* Light border */
        
        --sidebar-bg: #ffffff;
        --sidebar-text: #475569;
        --sidebar-text-hover: #059669;
        --sidebar-active-bg: #ecfdf5; /* Light emerald tint */
        --sidebar-active-text: #059669;
    }

    html.dark {
        /* DARK MODE: Deep Slate, Luminous Gold, Crisp White */
        --bg-app: #0f172a;            /* Deep navy/slate background */
        --bg-surface: #1e293b;        /* Lighter slate for cards/sidebar */
        --color-primary: #fbbf24;     /* Luminous Gold for main elements */
        --color-primary-light: #fcd34d;
        --color-accent: #34d399;      /* Mint Green for subtle accents */
        --color-text-main: #f8fafc;   /* White text */
        --color-text-muted: #94a3b8;  /* Slate text */
        --border-color: #334155;      /* Dark border */
        
        --sidebar-bg: #1e293b;
        --sidebar-text: #94a3b8;
        --sidebar-text-hover: #f8fafc;
        --sidebar-active-bg: rgba(251, 191, 36, 0.1);
        --sidebar-active-text: #fbbf24;
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
        border-radius: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }
    html.dark .luxury-card {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
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
    .bg-mishkat-green-50, .bg-amber-50, .bg-blue-50, .bg-purple-50, .bg-red-50 {
        background-color: var(--sidebar-active-bg) !important;
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
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--border-color) !important;
    }
    html.dark .glass-nav {
        background: rgba(30, 41, 59, 0.85) !important;
    }

    /* — Sidebar — */
    .luxury-sidebar {
        background: var(--sidebar-bg) !important;
        border-left: 1px solid var(--border-color) !important;
        box-shadow: none !important;
    }

    .luxury-sidebar-item {
        color: var(--sidebar-text) !important;
    }
    .luxury-sidebar-item:hover:not(.active) {
        background: var(--bg-app) !important;
        color: var(--sidebar-text-hover) !important;
    }
    .luxury-sidebar-item.active {
        background: var(--sidebar-active-bg) !important;
        color: var(--sidebar-active-text) !important;
        font-weight: bold;
    }
    .luxury-sidebar-item.active .material-icons-outlined,
    .luxury-sidebar-item.active span {
        color: var(--sidebar-active-text) !important;
    }

    /* Sidebar Logo & User Box overriding transparent */
    .logo-box {
        background: var(--sidebar-bg) !important;
        border-bottom: 1px solid var(--border-color);
    }
    .user-box {
        background: var(--bg-app) !important;
        border: 1px solid var(--border-color) !important;
    }
    .user-info p {
        color: var(--color-text-main) !important;
    }
    .user-info span {
        color: var(--color-text-muted) !important;
    }

    /* — Buttons — */
    .btn-luxury {
        background: var(--color-primary) !important;
        color: #ffffff !important;
        border-radius: 1.5rem;
        padding: 0.75rem 2rem;
        font-weight: bold;
        transition: all 0.2s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: none !important;
    }
    html.dark .btn-luxury {
        color: #0f172a !important;
    }
    .btn-luxury:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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
