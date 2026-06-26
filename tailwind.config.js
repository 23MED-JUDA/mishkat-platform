
module.exports = {
  darkMode: 'class',
  content: [
    '.*.php',
    './assets*.js',
    './pages*.php',
    './includes*.php',
  ],
  theme: {
    extend: {
      colors: {
        
        'mishkat-green': {
          50:  '#f0f7f4', 100: '#dceee5', 200: '#bbdece',
          300: '#8ec7ad', 400: '#5daa83', 500: '#3b8f66',
          600: '#2a7351', 700: '#225c42', 800: '#1d4a36',
          900: '#193d2e', 950: '#0c221a',
        },
        'mishkat-beige': {
          50:  '#fefdfb', 100: '#fdf9f0', 200: '#faf2de',
          300: '#f5e6c4', 400: '#eed5a0', 500: '#e5c07a',
          600: '#d4a54e', 700: '#b8893d', 800: '#956e35',
          900: '#795b2e', 950: '#412f17',
        },
        'mishkat-gold': {
          50:  '#FFF9E6', 100: '#FFF0B3', 200: '#FFE680',
          300: '#FFDB4D', 400: '#FFD11A', 500: '#C9A84C',
          600: '#B8943F', 700: '#9A7B33', 800: '#7C6228',
          900: '#5E4A1E',
        },
        'mishkat-night': {
          50:  '#E8EAF0', 100: '#C5CAD6', 200: '#9FA8BC',
          300: '#7986A2', 400: '#5C6D8F', 500: '#3F547C',
          600: '#374A6E', 700: '#2D3D5B', 800: '#1A2744',
          900: '#0D1728', 950: '#070E1A',
        },

        
        'programs-primary': {
          50: '#f0fdf4', 100: '#dcfce7', 200: '#b6f2cd',
          300: '#7ae1a8', 400: '#3cc87c', 500: '#1a7a4a',
          600: '#155e3a', 700: '#124a2f', 800: '#0f3b26',
          900: '#0a2919',
        },
        'programs-beige': {
          50: '#fefcf8', 100: '#fdf8ed', 200: '#faf0d6',
          300: '#f5e3b8', 400: '#edd499', 500: '#e0bf72',
        },
        'programs-cream': {
          50: '#fefdfb', 100: '#fdfaf4', 200: '#fbf5e9',
          300: '#f7edda',
        },

        
        'teachers-primary':       '#1B4332',
        'teachers-primary-light': '#2D6A4F',
        'teachers-secondary':     '#F5EBE0',
        'teachers-accent':        '#D4A373',
        'teachers-cream':         '#FAF7F2',
        'teachers-text':          '#2C3E2D',

        
        'packages-gold': {
          50: '#fffef7', 100: '#fef9e7', 200: '#fdf0c4',
          300: '#fce4a0', 400: '#d4a537', 500: '#c49225',
          600: '#a67a1e', 700: '#876118', 800: '#6b4c14',
          900: '#4f380f',
        },
        'packages-cream': {
          50: '#fefdfb', 100: '#fdf9f3', 200: '#faf3e6',
          300: '#f5ead6', 400: '#eedfc3', 500: '#e4d2ac',
          600: '#d4be8e', 700: '#bfa46e', 800: '#a08752',
          900: '#7d6840',
        },
        'packages-sage': {
          50: '#f6f8f5', 100: '#eef2ec', 200: '#dce6d8',
          300: '#c4d6be', 400: '#a3c199', 500: '#83ab77',
          600: '#6b9360', 700: '#567a4e', 800: '#456340',
          900: '#3a5236',
        },
        'packages-warm': {
          50: '#faf9f7', 100: '#f5f3ef', 200: '#ebe7df',
          300: '#ddd7cb', 400: '#c9bfae', 500: '#b3a693',
          600: '#9a8d79', 700: '#7d7264', 800: '#645b52',
          900: '#514a43',
        },

        
        'study-primary': {
          50: '#f0f7f4', 100: '#d9ece2', 200: '#b5d9c7',
          300: '#85bfa5', 400: '#5a9f80', 500: '#3a8366',
          600: '#2b6951', 700: '#245543', 800: '#1f4436',
          900: '#1b382e', 950: '#0e201a',
        },
        'study-gold': {
          50: '#fdf9ef', 100: '#f9f0d4', 200: '#f2dea5',
          300: '#eac86d', 400: '#e4b340', 500: '#da9a28',
          600: '#c17a1e', 700: '#a05b1b', 800: '#83491d',
          900: '#6c3d1b',
        },
        'study-cream': {
          50: '#fefdf8', 100: '#fdf9ed', 200: '#faf2d4',
          300: '#f5e6b0',
        },

        
        'footer-gold': {
          50: '#fdf8e8', 100: '#f5e6b8', 200: '#e8d08a',
          300: '#d4af37', 400: '#c9a020', 500: '#b8910a',
          600: '#9a7a08', 700: '#7c6206', 800: '#5e4a05',
          900: '#403203',
        },
        'footer-dark': {
          50: '#1e1e2e', 100: '#1a1a28', 200: '#151522',
          300: '#12121e', 400: '#0f0f1a', 500: '#0d0d17',
          600: '#0a0a12', 700: '#08080e', 800: '#05050a',
          900: '#030306',
        },
      },
      fontFamily: {
        'arabic':  ['Tajawal', 'Arial', 'sans-serif'],
        'amiri':   ['Amiri', 'serif'],
        'tajawal': ['Tajawal', 'sans-serif'],
        'cairo':   ['Cairo', 'sans-serif'],
        'kufi':    ['Noto Kufi Arabic', 'sans-serif'],
      },
      animation: {
        'float-slow':   'floatSlow 12s ease-in-out infinite',
        'float-medium': 'floatMedium 15s ease-in-out infinite',
        'float-fast':   'floatFast 10s ease-in-out infinite',
        'glow':         'glow 2s ease-in-out infinite alternate',
      },
      keyframes: {
        floatSlow: {
          '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
          '50%':      { transform: 'translate(30px, -20px) scale(1.1)' },
        },
        floatMedium: {
          '0%, 100%': { transform: 'translate(0, 0) scale(1)' },
          '50%':      { transform: 'translate(-20px, 15px) scale(1.05)' },
        },
        floatFast: {
          '0%, 100%': { transform: 'translate(-50%, -50%) scale(1)', opacity: '0.3' },
          '50%':      { transform: 'translate(-50%, -50%) scale(1.2)', opacity: '0.6' },
        },
        glow: {
          '0%':   { textShadow: '0 0 5px rgba(212,175,55,0.3)' },
          '100%': { textShadow: '0 0 20px rgba(212,175,55,0.6), 0 0 40px rgba(212,175,55,0.2)' },
        }
      }
    },
  },
  plugins: [],
};
