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

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ══════════════════════════════════════
       LIGHT MODE
    ══════════════════════════════════════ */
    body {
        font-family: 'Tajawal', sans-serif;
        background-color: #f0f4f2;
        transition: background-color 0.5s ease, color 0.5s ease;
    }

    .luxury-card {
        background: white;
        border-radius: 2.5rem;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 10px 30px -5px rgba(25, 61, 46, 0.06);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .glass-nav {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255,255,255,0.5);
    }

    .luxury-sidebar {
        background: linear-gradient(180deg, #193d2e 0%, #112b20 60%, #0a1f16 100%);
        border-left: 1px solid rgba(255,255,255,0.05);
    }

    .luxury-sidebar-item {
        margin: 0.2rem 0.8rem;
        border-radius: 1.2rem;
        transition: all 0.25s ease;
        color: rgba(255,255,255,0.6);
    }

    .luxury-sidebar-item:hover:not(.active) {
        background: rgba(255,255,255,0.06);
        color: rgba(255,255,255,0.9);
    }

    .luxury-sidebar-item.active {
        background: rgba(212, 141, 40, 0.18);
        color: #e9c66d;
    }

    .btn-luxury {
        background: linear-gradient(135deg, #193d2e, #2d7155);
        color: white;
        border-radius: 2rem;
        padding: 0.75rem 2rem;
        font-weight: 800;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px -5px rgba(25,61,46,0.25);
    }

    .btn-luxury:hover { transform: translateY(-2px); }

    /* ══════════════════════════════════════
       DARK MODE — BLACK × GOLD × WHITE
    ══════════════════════════════════════ */

    /* — Background & Body — */
    .dark body {
        background-color: #080808 !important;
        color: #f0f0f0 !important;
    }

    /* — Cards — */
    .dark .luxury-card {
        background: #111111 !important;
        border: 1px solid rgba(212, 141, 40, 0.15) !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7) !important;
    }

    /* — Top Nav — */
    .dark .glass-nav {
        background: rgba(8, 8, 8, 0.92) !important;
        border-bottom: 1px solid rgba(212, 141, 40, 0.2) !important;
    }

    /* ─── SIDEBAR — Special Black × Gold Design ─── */
    .dark .luxury-sidebar {
        background: #000000 !important;
        border-left: 1px solid rgba(212, 141, 40, 0.25) !important;
        box-shadow: 4px 0 30px rgba(0, 0, 0, 0.8) !important;
    }

    /* Sidebar items - normal state */
    .dark .luxury-sidebar-item {
        color: rgba(255, 255, 255, 0.45) !important;
    }

    .dark .luxury-sidebar-item:hover:not(.active) {
        background: rgba(212, 141, 40, 0.08) !important;
        color: rgba(255, 255, 255, 0.85) !important;
    }

    /* Sidebar active item - solid gold pill */
    .dark .luxury-sidebar-item.active {
        background: linear-gradient(135deg, #d48d28, #c97f22) !important;
        color: #000000 !important;
        box-shadow: 0 6px 20px rgba(212, 141, 40, 0.35) !important;
    }

    /* Override material icon color inside active item */
    .dark .luxury-sidebar-item.active .material-icons-outlined,
    .dark .luxury-sidebar-item.active span { color: #000000 !important; }

    /* Sidebar section labels */
    .dark .sidebar-label {
        color: rgba(212, 141, 40, 0.5) !important;
    }

    /* — Color overrides across the whole page — */
    .dark .text-gray-900  { color: #ffffff !important; }
    .dark .text-gray-700  { color: #e0e0e0 !important; }
    .dark .text-gray-600  { color: #c0c0c0 !important; }
    .dark .text-gray-500  { color: rgba(255,255,255,0.5) !important; }
    .dark .text-gray-400  { color: rgba(255,255,255,0.35) !important; }

    .dark .bg-white           { background-color: #111111 !important; }
    .dark .bg-gray-50         { background-color: #0d0d0d !important; }
    .dark .bg-gray-100        { background-color: #1a1a1a !important; }

    .dark .border-gray-100    { border-color: rgba(212,141,40,0.12) !important; }
    .dark .border-gray-200    { border-color: rgba(212,141,40,0.18) !important; }

    /* Green → Gold in dark mode */
    .dark .text-mishkat-green-900 { color: #ffffff !important; }
    .dark .text-mishkat-green-700 { color: #d48d28 !important; }
    .dark .text-mishkat-green-600 { color: #d48d28 !important; }
    .dark .text-mishkat-gold-600  { color: #d48d28 !important; }

    .dark .bg-mishkat-green-50  { background-color: rgba(212,141,40,0.08) !important; }
    .dark .bg-mishkat-green-600,
    .dark .bg-mishkat-green-700,
    .dark .bg-mishkat-green-900 { background-color: #111111 !important; border: 1px solid rgba(212,141,40,0.2) !important; }

    /* Amber, Blue, Purple tinted icon backgrounds → unified dark look */
    .dark [class*="bg-amber-50"] { background-color: rgba(212,141,40,0.1) !important; }
    .dark [class*="bg-blue-50"]  { background-color: rgba(255,255,255,0.05) !important; }
    .dark [class*="bg-purple-50"]{ background-color: rgba(255,255,255,0.05) !important; }
    .dark [class*="bg-red-50"]   { background-color: rgba(212,141,40,0.07) !important; }

    .dark [class*="text-amber-600"],
    .dark [class*="text-amber-500"] { color: #d48d28 !important; }
    .dark [class*="text-blue-600"]  { color: #e9c66d !important; }
    .dark [class*="text-purple-600"]{ color: #e9c66d !important; }

    /* Buttons */
    .dark .btn-luxury {
        background: linear-gradient(135deg, #d48d28 0%, #c07a20 100%) !important;
        color: #000000 !important;
        box-shadow: 0 8px 20px rgba(212, 141, 40, 0.25) !important;
    }

    /* Inputs */
    .dark input, .dark select, .dark textarea {
        background-color: #1a1a1a !important;
        color: #f0f0f0 !important;
        border: 1px solid rgba(212, 141, 40, 0.2) !important;
    }

    /* Modal */
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
        background: white;
        border-radius: 2.5rem;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.3);
    }
    .dark .modal-box {
        background: #0e0e0e !important;
        border: 1px solid rgba(212, 141, 40, 0.25) !important;
        color: white !important;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #bbdece; border-radius: 10px; }
    .dark ::-webkit-scrollbar-thumb { background: #d48d28; }

    /* Progress bars */
    .dark .bg-mishkat-green-500 { background-color: #d48d28 !important; }
    .dark .bg-mishkat-green-600 { background-color: #d48d28 !important; }

    /* Toast */
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
        
        /* Grid adjustments */
        .grid { gap: 1rem !important; }
        
        /* Table responsiveness */
        .table-container { 
            width: 100%; 
            overflow-x: auto; 
            -webkit-overflow-scrolling: touch;
            border-radius: 1rem;
        }
        
        /* Typography */
        h1 { font-size: 1.75rem !important; }
        h2 { font-size: 1.35rem !important; }
        h3 { font-size: 1.15rem !important; }

        /* Navigation mobile height */
        .glass-nav { padding: 0.75rem 1rem !important; }
    }

    /* Prevent accidental horizontal scrolling */
    html, body {
        max-width: 100vw;
        overflow-x: hidden;
        position: relative;
    }
</style>

<script src="assets/js/mishkat-ui.js"></script>
