/* ════════ NAVBAR SECTION ════════════════ */

(function () {
    'use strict';

    const section = document.getElementById('navbar-section');
    if (!section) return;


    /* ═══════════ UTILITIES - أدوات النافبار ════════════════ */

    function throttle(func, limit) {
        var lastFunc;
        var lastRan;

        return function () {
            var context = this;
            var args = arguments;

            if (!lastRan) {
                func.apply(context, args);
                lastRan = Date.now();
            } else {
                clearTimeout(lastFunc);
                lastFunc = setTimeout(function () {
                    if (Date.now() - lastRan >= limit) {
                        func.apply(context, args);
                        lastRan = Date.now();
                    }
                }, limit - (Date.now() - lastRan));
            }
        };
    }


    /* ══════════════ NAVBAR OBJECT ════════════════ */

    const Navbar = {

        // --- عناصر DOM ---
        dom: {
            navbar:            null,
            subscribeBtn:      null,
            subscribeDropdown: null,
            mobileMenuBtn:     null,
            mobileMenu:        null,
            mobileOverlay:     null,
            closeMobileBtn:    null,
            mobileCloseAreas:  null,
            navLinks:          null,
            mobileLinks:       null,
            dropdownArrow:     null,
        },

        // --- الحالة ---
        state: {
            isScrolled:       false,
            isDropdownOpen:   false,
            isMobileMenuOpen: false,
            scrollThreshold:  50,
        },

        // --- التهيئة ---
        init() {
            this.dom.navbar            = section.querySelector('#navbar');
            this.dom.subscribeBtn      = section.querySelector('#subscribeBtn');
            this.dom.subscribeDropdown = section.querySelector('#subscribeDropdown');
            this.dom.mobileMenuBtn     = section.querySelector('#mobileMenuBtn');
            this.dom.mobileMenu        = section.querySelector('#mobileMenu');
            this.dom.mobileOverlay     = section.querySelector('#mobileMenuOverlay');
            this.dom.closeMobileBtn    = section.querySelector('#closeMobileBtn');
            this.dom.mobileCloseAreas  = section.querySelectorAll('[data-mobile-close]');
            this.dom.navLinks          = section.querySelectorAll('.nav-link');
            this.dom.mobileLinks       = section.querySelectorAll('.mobile-nav-link');

            if (!this.dom.navbar) {
                console.warn('Mishkat Navbar: لم يتم العثور على عنصر #navbar');
                return;
            }

            if (this.dom.subscribeBtn) {
                this.dom.dropdownArrow = this.dom.subscribeBtn.querySelector('.navbar__dropdown-arrow');
            }

            this.bindEvents();
            this.handleScroll();
        },

        // --- ربط الأحداث ---
        bindEvents() {
            // التمرير
            window.addEventListener('scroll', throttle(this.handleScroll.bind(this), 16), { passive: true });

            // Dropdown
            if (this.dom.subscribeBtn) {
                this.dom.subscribeBtn.addEventListener('click', this.toggleDropdown.bind(this));
            }

            // قائمة الموبايل
            if (this.dom.mobileMenuBtn) {
                this.dom.mobileMenuBtn.addEventListener('click', this.toggleMobileMenu.bind(this));
            }

            if (this.dom.closeMobileBtn) {
                this.dom.closeMobileBtn.addEventListener('click', this.closeMobileMenu.bind(this));
            }

            if (this.dom.mobileOverlay) {
                this.dom.mobileOverlay.addEventListener('click', this.closeMobileMenu.bind(this));
            }

            // إغلاق الموبايل بالنقر على الخلفية
            this.dom.mobileCloseAreas.forEach((area) => {
                area.addEventListener('click', this.closeMobileMenu.bind(this));
            });

            // إغلاق الموبايل بالنقر على رابط
            this.dom.mobileLinks.forEach((link) => {
                link.addEventListener('click', () => {
                    setTimeout(() => this.closeMobileMenu(), 300);
                });
            });

            // الروابط النشطة
            this.dom.navLinks.forEach((link) => {
                link.addEventListener('click', () => this.setActiveLink(link));
            });

            // إغلاق عند النقر خارج العنصر
            document.addEventListener('click', this.handleOutsideClick.bind(this));

            // لوحة المفاتيح (Escape)
            document.addEventListener('keydown', this.handleKeydown.bind(this));

            // تغيير حجم الشاشة
            window.addEventListener('resize', throttle(this.handleResize.bind(this), 200));
        },

        // --- التمرير ---
        handleScroll() {
            const scrollY = window.scrollY || window.pageYOffset;
            const shouldBeScrolled = scrollY > this.state.scrollThreshold;

            if (shouldBeScrolled !== this.state.isScrolled) {
                this.state.isScrolled = shouldBeScrolled;
                this.dom.navbar.classList.toggle('navbar--scrolled', this.state.isScrolled);
            }
        },

        // --- Dropdown ---
        openDropdown() {
            if (this.state.isDropdownOpen) return;
            this.state.isDropdownOpen = true;
            this.dom.subscribeDropdown.classList.add('navbar__dropdown-menu--active');
            this.dom.subscribeBtn.setAttribute('aria-expanded', 'true');
            if (this.dom.dropdownArrow) {
                this.dom.dropdownArrow.classList.add('navbar__dropdown-arrow--rotated');
            }
        },

        closeDropdown() {
            if (!this.state.isDropdownOpen) return;
            this.state.isDropdownOpen = false;
            this.dom.subscribeDropdown.classList.remove('navbar__dropdown-menu--active');
            this.dom.subscribeBtn.setAttribute('aria-expanded', 'false');
            if (this.dom.dropdownArrow) {
                this.dom.dropdownArrow.classList.remove('navbar__dropdown-arrow--rotated');
            }
        },

        toggleDropdown(event) {
            event.stopPropagation();
            this.state.isDropdownOpen ? this.closeDropdown() : this.openDropdown();
        },

        // --- قائمة الموبايل ---
        openMobileMenu() {
            this.state.isMobileMenuOpen = true;
            if (this.dom.mobileMenu) this.dom.mobileMenu.classList.add('navbar__mobile-menu--active');
            if (this.dom.mobileOverlay) this.dom.mobileOverlay.classList.add('mobile-overlay--active');
            if (this.dom.mobileMenu) this.dom.mobileMenu.setAttribute('aria-hidden', 'false');
            if (this.dom.mobileMenuBtn) {
                this.dom.mobileMenuBtn.classList.add('navbar__hamburger--active');
                this.dom.mobileMenuBtn.setAttribute('aria-expanded', 'true');
                this.dom.mobileMenuBtn.setAttribute('aria-label', 'إغلاق القائمة');
            }
            document.body.style.overflow = 'hidden';
            
            if (this.dom.mobileMenuBtn) {
                const lines = this.dom.mobileMenuBtn.querySelectorAll('.hamburger-line');
                if (lines.length === 3) {
                    lines[0].style.transform = 'translateY(9px) rotate(45deg)';
                    lines[1].style.opacity = '0';
                    lines[2].style.transform = 'translateY(-9px) rotate(-45deg)';
                    lines[2].classList.remove('w-3/4');
                    lines[2].classList.add('w-full');
                }
            }
        },

        closeMobileMenu() {
            this.state.isMobileMenuOpen = false;
            if (this.dom.mobileMenu) this.dom.mobileMenu.classList.remove('navbar__mobile-menu--active');
            if (this.dom.mobileOverlay) this.dom.mobileOverlay.classList.remove('mobile-overlay--active');
            if (this.dom.mobileMenu) this.dom.mobileMenu.setAttribute('aria-hidden', 'true');
            if (this.dom.mobileMenuBtn) {
                this.dom.mobileMenuBtn.classList.remove('navbar__hamburger--active');
                this.dom.mobileMenuBtn.setAttribute('aria-expanded', 'false');
                this.dom.mobileMenuBtn.setAttribute('aria-label', 'فتح القائمة');
            }
            document.body.style.overflow = '';
            
            if (this.dom.mobileMenuBtn) {
                const lines = this.dom.mobileMenuBtn.querySelectorAll('.hamburger-line');
                if (lines.length === 3) {
                    lines[0].style.transform = '';
                    lines[1].style.opacity = '1';
                    lines[2].style.transform = '';
                    lines[2].classList.remove('w-full');
                    lines[2].classList.add('w-3/4');
                }
            }
        },

        toggleMobileMenu() {
            this.state.isMobileMenuOpen ? this.closeMobileMenu() : this.openMobileMenu();
        },

        // --- الروابط النشطة ---
        setActiveLink(activeLink) {
            this.dom.navLinks.forEach((link) => link.removeAttribute('data-active'));
            if (activeLink) activeLink.setAttribute('data-active', 'true');
        },

        // --- إغلاق عند النقر خارج ---
        handleOutsideClick(event) {
            if (this.state.isDropdownOpen) {
                const container = this.dom.subscribeBtn
                    ? this.dom.subscribeBtn.closest('[data-dropdown]')
                    : null;
                if (container && !container.contains(event.target)) {
                    this.closeDropdown();
                }
            }
        },

        // --- لوحة المفاتيح ---
        handleKeydown(event) {
            if (event.key === 'Escape') {
                if (this.state.isDropdownOpen) {
                    this.closeDropdown();
                    this.dom.subscribeBtn.focus();
                }
                if (this.state.isMobileMenuOpen) {
                    this.closeMobileMenu();
                    this.dom.mobileMenuBtn.focus();
                }
            }
        },

        // --- تغيير حجم الشاشة ---
        handleResize() {
            if (window.innerWidth >= 1024 && this.state.isMobileMenuOpen) {
                this.closeMobileMenu();
            }
        },
    };


    /* ═══════════ تشغيل النافبار ═════════════ */

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => Navbar.init());
    } else {
        Navbar.init();
    }

})();



/* ══════════ HEADER SECTION ═════════════════════╗
 */

(function () {
    'use strict';

    const section = document.getElementById('header-section');
    if (!section) return;


    /* ═══════════ UTILITIES - أدوات الهيدر ════════════════ */

    function debounce(fn, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function getCSSVar(name, fallback) {
        const value = getComputedStyle(document.documentElement).getPropertyValue(name);
        return value.trim() || fallback;
    }


    /* ══════════════ HERO - Parallax Effect ════════════════ */

    const Parallax = {
        bg: null,
        heroSection: null,
        currentTranslateY: 0,
        targetTranslateY: 0,

        init() {
            this.bg = section.querySelector('#heroBg');
            this.heroSection = section.querySelector('#hero');
            if (!this.bg || !this.heroSection) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.isVisible = entry.isIntersecting;
                    if (this.isVisible) {
                        this.animate();
                    }
                });
            }, { threshold: 0.1 });

            observer.observe(this.heroSection);
            window.addEventListener('scroll', this.onScroll.bind(this), { passive: true });
        },

        onScroll() {
            const rect = this.heroSection.getBoundingClientRect();
            if (rect.bottom < 0 || rect.top > window.innerHeight) return;
            this.targetTranslateY = -rect.top * 0.35;
        },

        animate() {
            if (!this.isVisible) return;
            this.currentTranslateY += (this.targetTranslateY - this.currentTranslateY) * 0.08;
            if (Math.abs(this.targetTranslateY - this.currentTranslateY) > 0.1) {
                this.bg.style.transform = `translate3d(0, ${this.currentTranslateY}px, 0)`;
            }
            requestAnimationFrame(this.animate.bind(this));
        },
    };


    /* ══════════════ HERO - Particles System ════════════════ */

    const Particles = {
        canvas: null,
        ctx: null,
        particles: [],
        count: 50,
        animationId: null,
        width: 0,
        height: 0,

        init() {
            this.canvas = section.querySelector('#particlesCanvas');
            if (!this.canvas) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            this.ctx = this.canvas.getContext('2d');
            this.resize();
            this.createParticles();
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.isActive = entry.isIntersecting;
                    if (this.isActive) {
                        this.animate();
                    }
                });
            }, { threshold: 0.1 });

            observer.observe(this.canvas);
            window.addEventListener('resize', debounce(this.resize.bind(this), 250));
        },

        resize() {
            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            const rect = this.canvas.parentElement.getBoundingClientRect();

            this.width = rect.width;
            this.height = rect.height;

            this.canvas.width = rect.width * dpr;
            this.canvas.height = rect.height * dpr;
            this.canvas.style.width = rect.width + 'px';
            this.canvas.style.height = rect.height + 'px';
            this.ctx.setTransform(1, 0, 0, 1, 0, 0);
            this.ctx.scale(dpr, dpr);

            this.count = window.innerWidth < 768 ? 25 : 50;
            this.particles = [];
            this.createParticles();
        },

        createParticles() {
            for (let i = 0; i < this.count; i++) {
                this.particles.push(this.createSingleParticle());
            }
        },

        createSingleParticle() {
            const isGold = Math.random() > 0.3;
            return {
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                radius: Math.random() * 2 + 0.5,
                speedX: (Math.random() - 0.5) * 0.3,
                speedY: -(Math.random() * 0.4 + 0.1),
                opacity: Math.random() * 0.5 + 0.1,
                maxOpacity: Math.random() * 0.5 + 0.1,
                fadeSpeed: Math.random() * 0.005 + 0.002,
                fadingIn: Math.random() > 0.5,
                color: isGold
                    ? { r: 201, g: 168, b: 76 }
                    : { r: 255, g: 255, b: 255 },
                waveAmplitude: Math.random() * 0.5 + 0.2,
                waveSpeed: Math.random() * 0.02 + 0.01,
                waveOffset: Math.random() * Math.PI * 2,
                life: 0,
            };
        },

        animate() {
            if (!this.isActive) return;
            this.ctx.clearRect(0, 0, this.width, this.height);

            for (let i = 0; i < this.particles.length; i++) {
                const p = this.particles[i];
                p.life += 1;

                // Fade in/out
                if (p.fadingIn) {
                    p.opacity += p.fadeSpeed;
                    if (p.opacity >= p.maxOpacity) p.fadingIn = false;
                } else {
                    p.opacity -= p.fadeSpeed;
                    if (p.opacity <= 0) {
                        this.particles[i] = this.createSingleParticle();
                        this.particles[i].y = this.height + 10;
                        this.particles[i].fadingIn = true;
                        this.particles[i].opacity = 0;
                        continue;
                    }
                }

                // حركة موجية
                const waveX = Math.sin(p.life * p.waveSpeed + p.waveOffset) * p.waveAmplitude;
                p.x += p.speedX + waveX * 0.1;
                p.y += p.speedY;

                // إعادة التموضع
                if (p.y < -10) { p.y = this.height + 10; p.x = Math.random() * this.width; }
                if (p.x < -10) p.x = this.width + 10;
                if (p.x > this.width + 10) p.x = -10;

                // رسم الجسيم
                this.ctx.beginPath();
                this.ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                this.ctx.fillStyle = `rgba(${p.color.r}, ${p.color.g}, ${p.color.b}, ${p.opacity})`;
                this.ctx.fill();

                // تأثير التوهج
                if (p.radius > 1.5) {
                    this.ctx.beginPath();
                    this.ctx.arc(p.x, p.y, p.radius * 3, 0, Math.PI * 2);
                    this.ctx.fillStyle = `rgba(${p.color.r}, ${p.color.g}, ${p.color.b}, ${p.opacity * 0.15})`;
                    this.ctx.fill();
                }
            }

            this.animationId = requestAnimationFrame(this.animate.bind(this));
        },

        destroy() {
            if (this.animationId) cancelAnimationFrame(this.animationId);
        },
    };




    const heroStartBtn = document.getElementById('heroStartBtn');
const subscribeBtn = document.getElementById('subscribeBtn');

if (heroStartBtn && subscribeBtn) {
    heroStartBtn.addEventListener('click', function (e) {
        e.preventDefault();
        // سكرول لفوق
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // بعد ما يوصل للأعلى افتح الـ dropdown
        setTimeout(() => {
            subscribeBtn.click();
        }, 600);
    });
}



    /* ══════════════ HERO - Scroll Indicator Fade ════════════════ */

    const ScrollFade = {
        indicator: null,

        init() {
            this.indicator = section.querySelector('#scrollIndicator');
            if (!this.indicator) return;
            window.addEventListener('scroll', this.onScroll.bind(this), { passive: true });
        },

        onScroll() {
            const scrollY = window.scrollY || window.pageYOffset;
            const fadeStart = 50;
            const fadeEnd = 200;

            if (scrollY <= fadeStart) {
                this.indicator.style.opacity = '1';
                this.indicator.style.transform = 'translateY(0)';
                this.indicator.style.pointerEvents = 'auto';
            } else if (scrollY >= fadeEnd) {
                this.indicator.style.opacity = '0';
                this.indicator.style.transform = 'translateY(20px)';
                this.indicator.style.pointerEvents = 'none';
            } else {
                const progress = (scrollY - fadeStart) / (fadeEnd - fadeStart);
                this.indicator.style.opacity = String(1 - progress);
                this.indicator.style.transform = `translateY(${progress * 20}px)`;
                this.indicator.style.pointerEvents = 'auto';
            }
        },
    };


    /* ══════════════ HERO - Heading Shimmer Effect ════════════════ */

    const HeadingGlow = {
        titleWord: null,

        init() {
            this.titleWord = section.querySelector('.title-word');
            if (!this.titleWord) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            setTimeout(() => {
                this.titleWord.classList.add('shimmer-active');
            }, 2500);
        },
    };


    /* ══════════════ HERO - Image Loader ════════════════ */

    const ImageLoader = {
        init() {
            const heroImg = section.querySelector('.hero-bg-image');
            if (!heroImg) return;

            const onReady = () => section.classList.add('hero-loaded');

            if (heroImg.complete && heroImg.naturalWidth > 0) {
                onReady();
            } else {
                heroImg.addEventListener('load', onReady);
                heroImg.addEventListener('error', () => {
                    onReady();
                    console.warn('Hero background image failed to load.');
                });
            }

            setTimeout(onReady, 4000);
        },
    };


    /* ══════════════ HERO - Button Ripple Effect ════════════════ */

    const ButtonRipple = {
        init() {
            const buttons = section.querySelectorAll('.btn-primary, .btn-secondary');
            buttons.forEach((btn) => {
                btn.addEventListener('mouseenter', this.createRipple.bind(this));
            });
        },

        createRipple(e) {
            const btn = e.currentTarget;
            const rect = btn.getBoundingClientRect();

            const existingRipple = btn.querySelector('.ripple-effect');
            if (existingRipple) existingRipple.remove();

            const ripple = document.createElement('span');
            ripple.classList.add('ripple-effect');

            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
                border-radius: 50%;
                transform: scale(0);
                animation: header-rippleExpand 0.6s ease-out forwards;
                pointer-events: none;
                z-index: 0;
            `;

            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 700);
        },
    };


    /* ══════════════ HERO - Dynamic Styles Injection ════════════════ */

    const DynamicStyles = {
        init() {
            const style = document.createElement('style');
            style.textContent = `
                /* Ripple Animation */
                @keyframes header-rippleExpand {
                    0%   { transform: scale(0); opacity: 1; }
                    100% { transform: scale(2.5); opacity: 0; }
                }

                /* Heading Shimmer */
                #header-section .shimmer-active {
                    position: relative;
                    background: linear-gradient(
                        90deg,
                        #FFFFFF 0%, #FFFFFF 40%,
                        ${getCSSVar('--gold-300', '#FFDB4D')} 50%,
                        #FFFFFF 60%, #FFFFFF 100%
                    );
                    background-size: 200% 100%;
                    -webkit-background-clip: text;
                    background-clip: text;
                    -webkit-text-fill-color: transparent;
                    animation: header-headingShimmer 6s ease-in-out infinite;
                }

                @keyframes header-headingShimmer {
                    0%, 100% { background-position: 200% center; }
                    50%      { background-position: -200% center; }
                }

                /* Hero Load Transition */
                #header-section:not(.hero-loaded) .hero-content { opacity: 0; }
                #header-section.hero-loaded .hero-content {
                    opacity: 1;
                    transition: opacity 0.5s ease;
                }

                #header-section:not(.hero-loaded) .hero-bg-image { opacity: 0; }
                #header-section.hero-loaded .hero-bg-image {
                    opacity: 1;
                    transition: opacity 1s ease;
                }

                               /* Accessibility Focus */
                #header-section .btn-primary:focus-visible,
                #header-section .btn-secondary:focus-visible {
                    outline: 2px solid #C9A84C;
                    outline-offset: 4px;
                }

                /* Scroll Indicator */
                #header-section .scroll-indicator {
                    transition: opacity 0.3s ease, transform 0.3s ease;
                }
            `;
            document.head.appendChild(style);
        },
    };


    /* ═══════════ INITIALIZATION - تشغيل قسم الهيدر ═════════════ */

    function init() {
        // --- أنماط ديناميكية (أولاً) ---
        DynamicStyles.init();

        // --- Hero Section ---
        ImageLoader.init();
        Parallax.init();
        // Particles.init(); 
        ScrollFade.init();
        HeadingGlow.init();
        ButtonRipple.init();

        // --- رسالة نجاح ---
        console.log(
            '%c مشكاة | Mishkat %c Header initialized successfully ✓',
            'background: #2a7351; color: white; padding: 4px 8px; border-radius: 4px 0 0 4px; font-weight: bold;',
            'background: #f0f7f4; color: #2a7351; padding: 4px 8px; border-radius: 0 4px 4px 0;'
        );
    }

    // --- تشغيل عند جاهزية الصفحة ---
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // --- تنظيف عند مغادرة الصفحة ---
    window.addEventListener('beforeunload', () => {
        Particles.destroy();
    });

})();


(function () {
    'use strict';


    /* ══════════════ SHARED - Smooth Scroll ════════════════ */

    const SmoothScroll = {
        init() {
            document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
                anchor.addEventListener('click', this.handleClick.bind(this));
            });
        },

        handleClick(e) {
            const href = e.currentTarget.getAttribute('href');
            if (!href || href === '#') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
    };


    /* ═══════════ تشغيل المشترك ═════════════ */

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => SmoothScroll.init());
    } else {
        SmoothScroll.init();
    }

})();
