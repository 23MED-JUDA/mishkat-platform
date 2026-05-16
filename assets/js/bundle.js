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

        state: {
            isScrolled:       false,
            isDropdownOpen:   false,
            isMobileMenuOpen: false,
            scrollThreshold:  50,
        },

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

        bindEvents() {
            window.addEventListener('scroll', throttle(this.handleScroll.bind(this), 16), { passive: true });

            if (this.dom.subscribeBtn) {
                this.dom.subscribeBtn.addEventListener('click', this.toggleDropdown.bind(this));
            }

            if (this.dom.mobileMenuBtn) {
                this.dom.mobileMenuBtn.addEventListener('click', this.toggleMobileMenu.bind(this));
            }

            if (this.dom.closeMobileBtn) {
                this.dom.closeMobileBtn.addEventListener('click', this.closeMobileMenu.bind(this));
            }

            if (this.dom.mobileOverlay) {
                this.dom.mobileOverlay.addEventListener('click', this.closeMobileMenu.bind(this));
            }

            this.dom.mobileCloseAreas.forEach((area) => {
                area.addEventListener('click', this.closeMobileMenu.bind(this));
            });

            this.dom.mobileLinks.forEach((link) => {
                link.addEventListener('click', () => {
                    setTimeout(() => this.closeMobileMenu(), 300);
                });
            });

            this.dom.navLinks.forEach((link) => {
                link.addEventListener('click', () => this.setActiveLink(link));
            });

            document.addEventListener('click', this.handleOutsideClick.bind(this));

            document.addEventListener('keydown', this.handleKeydown.bind(this));

            window.addEventListener('resize', throttle(this.handleResize.bind(this), 200));
        },

        handleScroll() {
            const scrollY = window.scrollY || window.pageYOffset;
            const shouldBeScrolled = scrollY > this.state.scrollThreshold;

            if (shouldBeScrolled !== this.state.isScrolled) {
                this.state.isScrolled = shouldBeScrolled;
                this.dom.navbar.classList.toggle('navbar--scrolled', this.state.isScrolled);
            }
        },

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

        setActiveLink(activeLink) {
            this.dom.navLinks.forEach((link) => link.removeAttribute('data-active'));
            if (activeLink) activeLink.setAttribute('data-active', 'true');
        },

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

                const waveX = Math.sin(p.life * p.waveSpeed + p.waveOffset) * p.waveAmplitude;
                p.x += p.speedX + waveX * 0.1;
                p.y += p.speedY;

                if (p.y < -10) { p.y = this.height + 10; p.x = Math.random() * this.width; }
                if (p.x < -10) p.x = this.width + 10;
                if (p.x > this.width + 10) p.x = -10;

                this.ctx.beginPath();
                this.ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                this.ctx.fillStyle = `rgba(${p.color.r}, ${p.color.g}, ${p.color.b}, ${p.opacity})`;
                this.ctx.fill();

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
        window.scrollTo({ top: 0, behavior: 'smooth' });
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
        DynamicStyles.init();

        ImageLoader.init();
        Parallax.init();
        ScrollFade.init();
        HeadingGlow.init();
        ButtonRipple.init();

        console.log(
            '%c مشكاة | Mishkat %c Header initialized successfully ✓',
            'background: #2a7351; color: white; padding: 4px 8px; border-radius: 4px 0 0 4px; font-weight: bold;',
            'background: #f0f7f4; color: #2a7351; padding: 4px 8px; border-radius: 0 4px 4px 0;'
        );
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

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
(function () {
    "use strict";

    /* ────────── بيانات البرامج التعليمية ──────────── */
    const programsData = [
        {
            id: 1,
            title: "تحفيظ القرآن الكريم",
            description: "برنامج شامل لحفظ كتاب الله تعالى كاملاً بإتقان عن طريق التلقين المباشر والمراجعة المنتظمة مع معلم متخصص ومُجاز.",
            fullDescription: "برنامج تحفيظ القرآن الكريم هو البرنامج الرئيسي في أكاديمية مشكاة، يهدف إلى تمكين الطالب من حفظ كتاب الله تعالى حفظًا متقنًا مع الفهم والتدبر. يعتمد البرنامج على منهجية التلقين المباشر مع المعلم، والمراجعة اليومية المنتظمة، مع اختبارات دورية لضمان ثبات الحفظ. يناسب البرنامج جميع الأعمار والمستويات.",
            image: "assets/images/download (5).jfif",
            category: "quran",
            categoryLabel: "القرآن الكريم",
            teacher: "الشيخ أحمد محمد العلي",
            teacherRole: "حافظ ومُجاز بالقراءات",
            teacherImage: "assets/images/الشيخ عثمان الخميس ❤️❤️.jfif",
            duration: "12 شهر",
            lessons: 96,
            level: "جميع المستويات",
            schedule: "4 حصص أسبوعيًا",
            features: [
                "حفظ مع التلقين المباشر من معلم مُجاز",
                "مراجعة يومية لتثبيت الحفظ",
                "اختبارات شهرية للتقييم",
                "تقارير أداء مفصّلة للطالب",
                "شهادة إتمام الحفظ معتمدة",
                "مرونة في اختيار المواعيد"
            ],
            curriculum: [
                "التهيئة وأساسيات الحفظ",
                "حفظ جزء عمّ مع المراجعة",
                "حفظ جزء تبارك والأجزاء القصيرة",
                "الانتقال للأجزاء الطويلة",
                "المراجعة الشاملة والتثبيت",
                "اختبار الإجازة النهائي"
            ]
        },
        {
            id: 2,
            title: "أحكام التجويد التطبيقي",
            description: "تعلّم أحكام التجويد من الصفر حتى الإتقان مع التطبيق العملي على آيات القرآن الكريم بإشراف متخصصين.",
            fullDescription: "يقدّم هذا البرنامج تعليمًا شاملاً لأحكام التجويد بأسلوب تطبيقي عملي. يبدأ من أحكام النون الساكنة والتنوين، مرورًا بأحكام الميم الساكنة واللام، وصولاً إلى المدود والوقف والابتداء. كل حكم يتم تطبيقه مباشرة على آيات من القرآن الكريم لضمان الفهم والإتقان.",
            image: "assets/images/download (6).jfif",
            category: "tajweed",
            categoryLabel: "التجويد",
            teacher: "الدكتورة هالة سمير",
            teacherRole: "متخصصة في التجويد وعلوم القرآن",
            teacherImage: "assets/images/download (7).jfif",
            duration: "6 أشهر",
            lessons: 48,
            level: "مبتدئ - متوسط",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "شرح نظري مبسّط لكل حكم",
                "تطبيق عملي على آيات القرآن",
                "تمارين تفاعلية وواجبات",
                "اختبارات بعد كل وحدة",
                "شهادة إتمام مستوى التجويد",
                "مادة علمية مسجّلة للمراجعة"
            ],
            curriculum: [
                "مقدمة في علم التجويد وأهميته",
                "أحكام النون الساكنة والتنوين",
                "أحكام الميم الساكنة",
                "أحكام اللام (لام ال، لام الفعل)",
                "المدود بأنواعها",
                "الوقف والابتداء وعلامات المصحف"
            ]
        },
        {
            id: 3,
            title: "القاعدة النورانية",
            description: "الأساس المتين لتعليم القراءة الصحيحة للقرآن الكريم من نطق الحروف من مخارجها الصحيحة للأطفال والكبار.",
            fullDescription: "القاعدة النورانية هي المنهج الأساسي لتعليم القراءة الصحيحة للقرآن الكريم. تبدأ من تعليم الحروف المفردة ونطقها من مخارجها الصحيحة، ثم الانتقال للحروف المركّبة والكلمات، وصولاً لقراءة الآيات بطلاقة.",
            image: "assets/images/القاعدة النورانية.jfif",
            category: "kids",
            categoryLabel: "الأطفال",
            teacher: "الدكتورة هيفاء يونس",
            teacherRole: "معلمة قاعدة نورانية معتمدة",
            teacherImage: "assets/images/د_ هيفاء يونس _ Facebook.jfif",
            duration: "3 أشهر",
            lessons: 36,
            level: "مبتدئ",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "منهج القاعدة النورانية المعتمد",
                "تعليم مخارج الحروف وصفاتها",
                "تدرّج من الحروف للكلمات للآيات",
                "أنشطة تفاعلية ممتعة للأطفال",
                "متابعة فردية لكل طالب",
                "شهادة إتمام القاعدة النورانية"
            ],
            curriculum: [
                "الحروف المفردة ونطقها",
                "الحروف المركّبة",
                "الحروف المقطّعة",
                "الحركات (فتحة، ضمة، كسرة)",
                "التنوين والسكون والشدّة",
                "التطبيق على سور قصيرة"
            ]
        },
        {
            id: 4,
            title: "القراءات العشر المتواترة",
            description: "دراسة القراءات القرآنية العشر مع التعمّق في أصول وفرش كل قراءة للمتقدمين والحفّاظ.",
            fullDescription: "برنامج متقدّم لدراسة القراءات القرآنية العشر المتواترة. يتناول أصول كل قراءة وفرشها مع التطبيق العملي. يشترط في المتقدّم أن يكون حافظًا للقرآن الكريم كاملاً ومُلمًّا بأحكام التجويد.",
            image: "assets/images/Client Challenge.jfif",
            category: "quran",
            categoryLabel: "القرآن الكريم",
            teacher: "الشيخ عبدالله بن سعيد",
            teacherRole: "مُجاز بالقراءات العشر الكبرى",
            teacherImage: "assets/images/e8c512755aea1abefe52b26050ccdd7f.jpg",
            duration: "18 شهر",
            lessons: 144,
            level: "متقدم",
            schedule: "4 حصص أسبوعيًا",
            features: [
                "دراسة أصول القراءات العشر",
                "فرش الحروف لكل قراءة",
                "التطبيق على القرآن كاملاً",
                "إجازة بالسند المتصل",
                "حلقات مذاكرة جماعية",
                "مراجع ومصادر علمية موثّقة"
            ],
            curriculum: [
                "مقدمة في علم القراءات",
                "قراءة نافع (ورش وقالون)",
                "قراءة ابن كثير وأبي عمرو",
                "قراءة ابن عامر وعاصم",
                "قراءة حمزة والكسائي",
                "قراءة أبي جعفر ويعقوب وخلف"
            ]
        },

        {
            id: 5,
            title: "التفسير الميسّر",
            description: "فهم معاني آيات القرآن الكريم بأسلوب ميسّر مع ربط الآيات بالواقع المعاصر واستخراج الدروس والعبر.",
            fullDescription: "يهدف هذا البرنامج إلى تقديم تفسير ميسّر لآيات القرآن الكريم بلغة سهلة وواضحة. يتناول البرنامج تفسير السور بالترتيب مع استخراج الفوائد والأحكام والدروس المستفادة.",
            image: "assets/images/ae508528c5376aeed30f7afdc8da6c86.jpg",
            category: "islamic",
            categoryLabel: "العلوم الشرعية",
            teacher: "الدكتور محمد عبدالرحمن",
            teacherRole: "دكتوراه في التفسير وعلوم القرآن",
            teacherImage: "assets/images/00ee61039099595e831297f0661cdbe2.jpg",
            duration: "8 أشهر",
            lessons: 64,
            level: "متوسط",
            schedule: "حصتان أسبوعيًا",
            features: [
                "تفسير بأسلوب سهل وميسّر",
                "ربط الآيات بالواقع المعاصر",
                "استخراج الفوائد والأحكام",
                "أسباب النزول وسياق الآيات",
                "نقاشات تفاعلية مع المعلم",
                "ملخّصات مكتوبة لكل درس"
            ],
            curriculum: [
                "مقدمة في علم التفسير ومناهجه",
                "تفسير سورة الفاتحة وقصار السور",
                "تفسير سورة البقرة (مختارات)",
                "تفسير سورة آل عمران (مختارات)",
                "تفسير آيات الأحكام",
                "تفسير آيات القصص القرآني"
            ]
        },
        {
            id: 6,
            title: "الإجازة بالسند المتصل",
            description: "الحصول على إجازة في قراءة القرآن بسند متصل إلى رسول الله ﷺ من شيوخ مُجازين ومعتمدين.",
            fullDescription: "برنامج الإجازة بالسند المتصل هو أعلى مراتب التعلّم في الأكاديمية. يقوم الطالب بقراءة القرآن الكريم كاملاً على الشيخ المُجاز، ويحصل بعد إتمام القراءة على سند متصل إلى رسول الله ﷺ.",
            image: "assets/images/854635775f1554aef0e8022c5086de2e.jpg",
            category: "quran",
            categoryLabel: "القرآن الكريم",
            teacher: "الشيخ إبراهيم عبدالباري",
            teacherRole: "مُجاز بالقراءات ومُسنِد",
            teacherImage: "assets/images/dcb44e6ac84f748dc10744fc9ae48bae.jpg",
            duration: "6 أشهر",
            lessons: 60,
            level: "متقدم",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "قراءة القرآن كاملاً على الشيخ",
                "سند متصل إلى النبي ﷺ",
                "تصحيح دقيق للأداء والنطق",
                "اهتمام بالوقف والابتداء",
                "شهادة إجازة معتمدة ومسندة",
                "تأهيل لتعليم الغير وإقراء القرآن"
            ],
            curriculum: [
                "اختبار القبول وتقييم المستوى",
                "قراءة الأجزاء الأولى مع التصحيح",
                "استكمال قراءة النصف الأول",
                "قراءة النصف الثاني",
                "المراجعة الشاملة",
                "الاختبار النهائي ومنح الإجازة"
            ]
        },
        {
            id: 7,
            title: "برنامج النشء والأطفال",
            description: "برنامج تعليمي ترفيهي مخصص للأطفال من سن 5 سنوات لتعليم الحروف والقراءة وحفظ قصار السور بأسلوب ممتع.",
            fullDescription: "برنامج مصمّم خصيصًا للأطفال بأسلوب تعليمي ترفيهي يجمع بين التعلّم والمرح. يستخدم وسائل تعليمية متنوعة مثل الأناشيد والقصص والألعاب التفاعلية لتحبيب الأطفال في القرآن الكريم.",
            image: "assets/images/534b673d4919c186290ed8bf3fdb79b4.jpg",
            category: "kids",
            categoryLabel: "الأطفال",
            teacher: "الدكتورة نورا السيد",
            teacherRole: "متخصصة في تعليم الأطفال",
            teacherImage: "assets/images/bc6c884a1f3ce9da2814faa5f478b11c.jpg",
            duration: "9 أشهر",
            lessons: 72,
            level: "مبتدئ",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "أسلوب تعليمي ترفيهي وممتع",
                "أناشيد وألعاب تعليمية تفاعلية",
                "حصص قصيرة مناسبة للأطفال (30 دقيقة)",
                "تقارير متابعة دورية لولي الأمر",
                "حفظ جزء عمّ كاملاً",
                "شهادات تشجيعية ومكافآت"
            ],
            curriculum: [
                "تعليم الحروف بالأناشيد",
                "تركيب الكلمات البسيطة",
                "حفظ سورة الفاتحة والإخلاص والفلق والناس",
                "حفظ قصار السور (المسد - الفيل)",
                "حفظ سور متوسطة (النبأ - عبس)",
                "مراجعة جزء عمّ كاملاً"
            ]
        },
        {
            id: 8,
            title: "السيرة النبوية والأخلاق",
            description: "دراسة سيرة النبي ﷺ وأخلاقه وصفاته مع استخراج الدروس التربوية والعملية من أحداث السيرة العطرة.",
            fullDescription: "برنامج شامل لدراسة سيرة خير البشر محمد ﷺ من ميلاده حتى وفاته. يتناول الأحداث الرئيسية مع التركيز على الدروس التربوية والأخلاقية المستفادة. يهدف لتعزيز محبة النبي ﷺ والاقتداء به.",
            image: "assets/images/48cbf397fff3e2905819f84db23dcee5.jpg",
            category: "islamic",
            categoryLabel: "العلوم الشرعية",
            teacher: "الشيخ يوسف الحسني",
            teacherRole: "متخصص في السيرة والتاريخ الإسلامي",
            teacherImage: "assets/images/1f1a317d0f410f72cf7bafa71117971a.jpg",
            duration: "4 أشهر",
            lessons: 32,
            level: "جميع المستويات",
            schedule: "حصتان أسبوعيًا",
            features: [
                "سرد ممتع وشيّق للسيرة",
                "ربط الأحداث بدروس عملية",
                "عرض مرئي وخرائط ذهنية",
                "أنشطة وتمارين تفاعلية",
                "مناسب لجميع الأعمار",
                "شهادة إتمام البرنامج"
            ],
            curriculum: [
                "حياة النبي ﷺ قبل البعثة",
                "البعثة والدعوة السرية",
                "الهجرة وبناء الدولة",
                "الغزوات والمعارك الكبرى",
                "فتح مكة وحجة الوداع",
                "أخلاق النبي ﷺ وصفاته"
            ]
        },
        {
            id: 9,
            title: "أحكام التلاوة للنساء",
            description: "برنامج مخصص للأخوات لتعلّم التلاوة الصحيحة وأحكام التجويد في بيئة تعليمية مريحة ومناسبة.",
            fullDescription: "برنامج تعليمي مصمّم خصيصًا للنساء، يوفّر بيئة تعليمية مريحة مع معلمات مؤهلات ومُجازات. يغطي البرنامج أحكام التجويد كاملة مع التطبيق العملي، بالإضافة لتصحيح التلاوة والقراءة الفردية.",
            image: "assets/images/OIP.webp",
            category: "tajweed",
            categoryLabel: "التجويد",
            teacher: "الكتورة ابتسام أيمن",
            teacherRole: "مُجازة بالقراءات ومعلمة تجويد",
            teacherImage: "assets/images/afb713bf886bb3e99f70ceec0bc7fb33.jpg",
            duration: "5 أشهر",
            lessons: 40,
            level: "مبتدئ - متوسط",
            schedule: "3 حصص أسبوعيًا",
            features: [
                "بيئة تعليمية نسائية بالكامل",
                "معلمات مؤهلات ومُجازات",
                "مرونة في المواعيد",
                "حلقات قراءة جماعية",
                "تصحيح فردي للتلاوة",
                "شهادة إتمام معتمدة"
            ],
            curriculum: [
                "أساسيات النطق الصحيح",
                "أحكام النون الساكنة والتنوين",
                "أحكام الميم الساكنة واللام",
                "المدود وأنواعها",
                "أحكام الراء والتفخيم والترقيق",
                "التطبيق الشامل على سور مختارة"
            ]
        }
    ];

    window.programsData = programsData;

        /* ────────  SVG Icons المستخدمة────────── */
    const icons = {
        clock: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        book: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
        level: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        calendar: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
        arrow: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 17l-4-4m0 0l4-4m-4 4h18"/></svg>',
        play: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        check: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>',
        user: '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
        star: '<svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>'
    };

    /* ────── إنشاء كارت برنامج واحد (Reusable) ───────── */
    function createProgramCard(program, index) {
        const card = document.createElement("a");
        card.className = "program-card";
        card.href = "course_details.php?id=" + program.id;
        card.setAttribute("data-index", index);
        card.setAttribute("data-category", program.category);
        card.setAttribute("role", "article");
        card.setAttribute("aria-label", program.title);

        card.innerHTML = `
            <!-- صورة الكارت -->
            <div class="program-card__image-wrapper">
                <img
                    class="program-card__image"
                    src="${program.image}"
                    alt="${program.title}"
                    loading="lazy"
                />
                <div class="program-card__image-overlay"></div>

                <!-- تصنيف البرنامج -->
                <span class="program-card__category program-card__category--${program.category}">
                    ${program.categoryLabel}
                </span>

                <!-- عدد الدروس -->
                <span class="program-card__lessons-badge">
                    ${icons.play}
                    <span>${program.lessons} درس</span>
                </span>
            </div>

            <!-- محتوى الكارت -->
            <div class="program-card__body">
                <h3 class="program-card__title">${program.title}</h3>
                <p class="program-card__desc">${program.description}</p>

                <!-- المعلومات السريعة -->
                <div class="program-card__meta">
                    <span class="program-card__meta-item">
                        ${icons.clock}
                        <span>${program.duration}</span>
                    </span>
                    <span class="program-card__meta-item">
                        ${icons.level}
                        <span>${program.level}</span>
                    </span>
                    <span class="program-card__meta-item">
                        ${icons.calendar}
                        <span>${program.schedule}</span>
                    </span>
                </div>
            </div>
        `;

        return card;
    }

    /* ────── renderPrograms ───────── */
    function renderPrograms(section) {
        const grid = section.querySelector("#programsGrid");
        if (!grid) return;

        const fragment = document.createDocumentFragment();

        programsData.forEach(function (program, index) {
            const card = createProgramCard(program, index);
            fragment.appendChild(card);
        });

        grid.appendChild(fragment);

        initScrollAnimation(section);
        initFilter(section);
    }

    /* ────── (Fade + Stagger) ──────── */
    function initScrollAnimation(section) {
        const animatedElements = section.querySelectorAll("[data-animate]");
        const cards = section.querySelectorAll(".program-card");

        const observerOptions = {
            root: null,
            rootMargin: "0px 0px -50px 0px",
            threshold: 0.1,
        };

        const generalObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-animated");
                    generalObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        animatedElements.forEach(function (el) {
            generalObserver.observe(el);
        });

        const cardObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const index = parseInt(card.getAttribute("data-index"), 10);
                    const delay = index * 100;

                    setTimeout(function () {
                        card.style.transition =
                            "opacity 0.7s cubic-bezier(0.25,0.46,0.45,0.94), " +
                            "transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94)";
                        card.classList.add("is-visible");
                    }, delay);

                    cardObserver.unobserve(card);
                }
            });
        }, observerOptions);

        cards.forEach(function (card) {
            cardObserver.observe(card);
        });
    }

        /* ──────── فلتر التصنيفات ────────── */
    function initFilter(section) {
        const filterBtns = section.querySelectorAll(".filter-bar__btn");
        const cards = section.querySelectorAll(".program-card");

        if (!filterBtns.length) return;

        filterBtns.forEach(function (btn) {
            btn.addEventListener("click", function () {
                const filter = this.getAttribute("data-filter");

                filterBtns.forEach(function (b) {
                    b.classList.remove("filter-bar__btn--active");
                });
                this.classList.add("filter-bar__btn--active");

                let visibleIndex = 0;

                cards.forEach(function (card) {
                    const category = card.getAttribute("data-category");
                    const shouldShow = filter === "all" || category === filter;

                    if (shouldShow) {
                        const delay = visibleIndex * 80;
                        visibleIndex++;

                        card.style.transition = "none";
                        card.classList.remove("is-visible");
                        card.classList.remove("program-card--hidden");
                        card.style.display = "";

                        setTimeout(function () {
                            card.style.transition =
                                "opacity 0.5s ease, transform 0.5s ease";
                            card.classList.add("is-visible");
                        }, delay + 50);
                    } else {
                        card.style.transition = "opacity 0.3s ease, transform 0.3s ease";
                        card.classList.remove("is-visible");

                        setTimeout(function () {
                            card.style.display = "none";
                        }, 300);
                    }
                });
            });
        });
    }

    /* ─────── صفحة تفاصيل الدورة (course.html) ──────────── */
    window.renderCourseDetail = function (courseId) {
        const container = document.getElementById("courseDetail");
        if (!container) return;

        const course = programsData.find(function (p) {
            return p.id === courseId;
        });

        if (!course) {
            container.innerHTML = `
                <div class="course-detail__loading">
                    <p style="color:#9b2c2c;font-weight:700;">عذرًا، لم يتم العثور على هذا البرنامج</p>
                    <a href="index.html" class="back-btn" style="margin-top:1rem;">
                        ${icons.arrow}
                        <span>العودة للبرامج</span>
                    </a>
                </div>
            `;
            return;
        }

        container.innerHTML = `
            <!-- ========== Hero Section ========== -->
            <div class="course-hero">
                <img
                    class="course-hero__image"
                    src="${course.image}"
                    alt="${course.title}"
                />
                <div class="course-hero__overlay">
                    <span class="course-hero__category course-hero__category--${course.category}">
                        ${course.categoryLabel}
                    </span>
                    <h1 class="course-hero__title">${course.title}</h1>
                    <p class="course-hero__subtitle">${course.description}</p>
                </div>
            </div>

            <!-- ========== Content Grid ========== -->
            <div class="course-content">

                <!-- العمود الرئيسي -->
                <div class="course-main">

                    <!-- وصف البرنامج -->
                    <div class="course-info-card">
                        <h2 class="course-info-card__title">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            عن البرنامج
                        </h2>
                        <p class="course-info-card__text">${course.fullDescription}</p>

                        <h3 class="course-info-card__title" style="margin-top:1.5rem;">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            مميزات البرنامج
                        </h3>
                        <ul class="course-features">
                            ${course.features
                                .map(
                                    (f) => `
                                <li class="course-features__item">
                                    <span class="course-features__icon">
                                        ${icons.check}
                                    </span>
                                    <span>${f}</span>
                                </li>
                            `
                                )
                                .join("")}
                        </ul>
                    </div>

                                <!-- المنهج الدراسي -->
                    <div class="course-info-card" style="margin-top:1.5rem;">
                        <h2 class="course-info-card__title">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            المنهج الدراسي
                        </h2>
                        <ul class="curriculum-list">
                            ${course.curriculum
                                .map(
                                    (item, i) => `
                                <li class="curriculum-list__item">
                                    <span class="curriculum-list__num">${i + 1}</span>
                                    <span>${item}</span>
                                </li>
                            `
                                )
                                .join("")}
                        </ul>
                    </div>
                </div>

                <!-- الشريط الجانبي -->
                <div class="course-sidebar">

                    <!-- تفاصيل سريعة -->
                    <div class="course-sidebar__card">
                        <h3 class="course-sidebar__title">تفاصيل البرنامج</h3>
                        <ul class="course-details-list">
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.clock}
                                    <span>المدة</span>
                                </span>
                                <span class="course-details-list__value">${course.duration}</span>
                            </li>
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.book}
                                    <span>عدد الدروس</span>
                                </span>
                                <span class="course-details-list__value">${course.lessons} درس</span>
                            </li>
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.level}
                                    <span>المستوى</span>
                                </span>
                                <span class="course-details-list__value">${course.level}</span>
                            </li>
                            <li class="course-details-list__item">
                                <span class="course-details-list__label">
                                    ${icons.calendar}
                                    <span>الجدول</span>
                                </span>
                                <span class="course-details-list__value">${course.schedule}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- المعلم -->
                    <div class="course-sidebar__card">
                        <h3 class="course-sidebar__title">المعلم</h3>
                        <div class="teacher-card">
                            <img
                                class="teacher-card__avatar"
                                src="${course.teacherImage}"
                                alt="${course.teacher}"
                                loading="lazy"
                            />
                            <div>
                                <p class="teacher-card__name">${course.teacher}</p>
                                <p class="teacher-card__role">${course.teacherRole}</p>
                            </div>
                        </div>
                    </div>

                    <!-- مشاركة -->
                    <div class="course-sidebar__card">
                        <h3 class="course-sidebar__title">شارك البرنامج</h3>
                        <div class="share-buttons">
                            <button class="share-btn share-btn--whatsapp" onclick="shareCourse('whatsapp', '${course.title}')" aria-label="مشاركة عبر واتساب">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </button>
                            <button class="share-btn share-btn--twitter" onclick="shareCourse('twitter', '${course.title}')" aria-label="مشاركة عبر تويتر">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </button>
                            <button class="share-btn share-btn--copy" onclick="shareCourse('copy', '${course.title}')" aria-label="نسخ الرابط">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        `;
    };

    /* ───────── مشاركة الدورة ───────── */
    window.shareCourse = function (platform, title) {
        const url = window.location.href;
        const text = "أنصحكم ببرنامج: " + title + " من أكاديمية مشكاة 🌟";

        switch (platform) {
            case "whatsapp":
                window.open(
                    "https://wa.me/?text=" + encodeURIComponent(text + "\n" + url),
                    "_blank"
                );
                break;
            case "twitter":
                window.open(
                    "https://twitter.com/intent/tweet?text=" +
                        encodeURIComponent(text) +
                        "&url=" +
                        encodeURIComponent(url),
                    "_blank"
                );
                break;
            case "copy":
                navigator.clipboard.writeText(url).then(function () {
                    var btn = document.querySelector(".share-btn--copy");
                    var originalHTML = btn.innerHTML;
                    btn.innerHTML =
                        '<svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
                    btn.style.background = "#dcfce7";
                    btn.style.color = "#155e3a";
                    setTimeout(function () {
                        btn.innerHTML = originalHTML;
                        btn.style.background = "";
                        btn.style.color = "";
                    }, 2000);
                });
                break;
        }
    };


    function init() {
        
        const section = document.getElementById("programs-section");

        if (section && section.querySelector("#programsGrid")) {
            renderPrograms(section);
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }

})();
/* ====== بيانات المعلمين  ====== */
const teachersData = [
    {
        id: 1,
        name: "الشيخ محمود خليل الحصري",
        specialty: "إقراء وتجويد",
        title: "شيخ المقرئين بمصر",
        image: "assets/images/88fac63309bd27b514c4d38152b29f90.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg", 
        experience: "25+",
        students: "1500",
        ijazat: 12,
        rating: 4.9,
        bio: "فضيلة الشيخ من كبار علماء القراءات بالأزهر الشريف، حاصل على إجازات عالية في القراءات العشر بأسانيد متصلة إلى رسول الله ﷺ. تخرّج على يديه آلاف الطلاب من مختلف أنحاء العالم الإسلامي، وله مساهمات جليلة في خدمة كتاب الله تعالى.",
        qualifications: [
            "ليسانس كلية القرآن الكريم - جامعة الأزهر",
            "ماجستير في القراءات والتجويد",
            "دكتوراه في علوم القرآن بمرتبة الشرف الأولى",
            "عضو لجنة مراجعة المصاحف بالأزهر الشريف"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم بسند متصل",
            "إجازة بالقراءات السبع من طريق الشاطبية",
            "إجازة بالقراءات العشر الكبرى من طريق الطيبة",
            "إجازة في علم التجويد ومتن الجزرية"
        ],
        courses: ["تحفيظ القرآن", "أحكام التجويد", "القراءات العشر", "متن الجزرية", "متن الشاطبية"],
        schedule: [
            { day: "السبت", time: "بعد العصر" },
            { day: "الإثنين", time: "بعد المغرب" },
            { day: "الأربعاء", time: "بعد العشاء" }
        ]
    },
    {
        id: 2,
        name: "الشيخ أحمد محمد عامر",
        specialty: "تحفيظ وتلاوة",
        title: "إمام وخطيب ومحفّظ للقرآن الكريم",
        image: "assets/images/b545daa447427cdd8eafe132f188b959.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "18+",
        students: "950",
        ijazat: 8,
        rating: 4.8,
        bio: "شيخ فاضل متخصص في تحفيظ القرآن الكريم للأطفال والكبار، يتميز بأسلوبه التربوي الراقي وصبره على الطلاب. حاصل على إجازات قرآنية متعددة، ويُشرف على حلقات تحفيظ منذ أكثر من ثمانية عشر عامًا.",
        qualifications: [
            "ليسانس أصول الدين - جامعة الأزهر",
            "دبلوم تخصصي في طرق تحفيظ القرآن",
            "دورات متقدمة في علم النفس التربوي",
            "إمام وخطيب بوزارة الأوقاف المصرية"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم",
            "إجازة برواية ورش عن نافع",
            "إجازة في رواية قالون عن نافع",
            "إجازة في متن تحفة الأطفال"
        ],
        courses: ["تحفيظ للأطفال", "تحفيظ للكبار", "تصحيح التلاوة", "تحفة الأطفال"],
        schedule: [
            { day: "الأحد", time: "بعد الفجر" },
            { day: "الثلاثاء", time: "بعد العصر" },
            { day: "الخميس", time: "بعد المغرب" }
        ]
    },
    {
        id: 3,
        name: "الشيخ عبد الباسط عبد الصمد",
        specialty: "علم القراءات",
        title: "مقرئ ومجاز بالقراءات العشر",
        image: "assets/images/3d1b323a0312ba22cfd12487f7f20f31.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "22+",
        students: "1200",
        ijazat: 10,
        rating: 5.0,
        bio: "من أعلام القراءات في مصر، يتمتع بصوت ندي وأداء متقن. متخصص في تدريس القراءات العشر الصغرى والكبرى، وله طلاب أجازهم في القراءات من شتى بقاع الأرض. يجمع بين الإتقان العلمي والأداء الجمالي للقرآن.",
        qualifications: [
            "دكتوراه في القراءات - جامعة الأزهر",
            "أستاذ مساعد بكلية القرآن الكريم",
            "عضو رابطة القراء العالمية",
            "محكّم في المسابقات الدولية للقرآن"
        ],
        ijazatList: [
            "إجازة بالقراءات العشر الكبرى من طريق الطيبة",
            "إجازة بالقراءات العشر الصغرى من طريق الشاطبية والدرة",
            "إجازة في الأداء بالقراءات الأربع الزائدة",
            "إجازة في علم رسم المصحف وضبطه"
        ],
        courses: ["القراءات العشر", "الشاطبية", "طيبة النشر", "رسم المصحف", "ضبط المصحف"],
        schedule: [
            { day: "السبت", time: "بعد المغرب" },
            { day: "الإثنين", time: "بعد العشاء" },
            { day: "الخميس", time: "بعد العصر" }
        ]
    },
    {
        id: 4,
        name: "الشيخ مصطفى إسماعيل",
        specialty: "تجويد وأحكام",
        title: "معلم تجويد ومجوّد محترف",
        image: "assets/images/c894b961bca74dbc88409f718c57d994.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "15+",
        students: "780",
        ijazat: 6,
        rating: 4.9,
        bio: "متخصص في تعليم أحكام التجويد بأسلوب مبسط وميسر، يتميز بمنهجية تعليمية فريدة تجمع بين الجانب النظري والتطبيق العملي. يُشرف على دورات تجويد متعددة المستويات، وله طريقة مميزة في إيصال المعلومة.",
        qualifications: [
            "ليسانس قراءات - جامعة الأزهر",
            "ماجستير في علوم التجويد",
            "دبلوم في طرق تدريس التجويد",
            "محاضر معتمد من نقابة القراء"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم",
            "إجازة في متن تحفة الأطفال للجمزوري",
            "إجازة في متن المقدمة الجزرية",
            "إجازة في متن السلسبيل الشافي"
        ],
        courses: ["تجويد المبتدئين", "تجويد المتقدمين", "تحفة الأطفال", "المقدمة الجزرية", "أحكام النون والميم"],
        schedule: [
            { day: "الأحد", time: "بعد المغرب" },
            { day: "الثلاثاء", time: "بعد العشاء" },
            { day: "الجمعة", time: "بعد العصر" }
        ]
    },
    {
        id: 5,
        name: "الشيخ محمد صديق المنشاوي",
        specialty: "تلاوة ومقامات",
        title: "قارئ ومرتل للقرآن الكريم",
        image: "assets/images/e1a96888bae866d3ddb61f00eddc0704.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "20+",
        students: "1050",
        ijazat: 9,
        rating: 5.0,
        bio: "صاحب صوت عذب وأداء متميز، يجمع بين إتقان أحكام التجويد وجمال الترتيل. متخصص في تعليم المقامات الصوتية القرآنية بطريقة شرعية لا تخرج عن أحكام التجويد. له تسجيلات قرآنية معتمدة من الإذاعة المصرية.",
        qualifications: [
            "ليسانس كلية القرآن الكريم بطنطا",
            "دبلوم في المقامات الصوتية",
            "قارئ معتمد بالإذاعة المصرية",
            "حاصل على المركز الأول في عدة مسابقات دولية"
        ],
        ijazatList: [
            "إجازة برواية حفص عن عاصم بسند عالٍ",
            "إجازة برواية الدوري عن أبي عمرو",
            "إجازة في علم المقامات الصوتية",
            "إجازة في الأداء الصوتي للقرآن"
        ],
        courses: ["تلاوة وترتيل", "المقامات الصوتية", "تحسين الصوت", "أداء القراءة"],
        schedule: [
            { day: "السبت", time: "بعد العشاء" },
            { day: "الأربعاء", time: "بعد المغرب" },
            { day: "الجمعة", time: "بعد العصر" }
        ]
    },
    {
        id: 6,
        name: "الشيخ راغب مصطفى غلوش",
        specialty: "علوم القرآن",
        title: "أستاذ علوم القرآن والتفسير",
        image: "assets/images/aed18e1f589afcbef8df2401bf3d71c2.jpg",
        coverImage: "assets/images/599f4c24a3dae933f283cdba12e79442.jpg",
        experience: "30+",
        students: "1800",
        ijazat: 14,
        rating: 4.9,
        bio: "من كبار العلماء المتخصصين في علوم القرآن والتفسير، له مؤلفات عديدة في هذا المجال. يجمع بين العلم الشرعي والمنهج الأكاديمي، ويتميز بأسلوبه العلمي الرصين الذي يربط بين النص القرآني والواقع المعاصر.",
        qualifications: [
            "دكتوراه في التفسير وعلوم القرآن",
            "أستاذ بكلية أصول الدين - الأزهر",
            "عضو هيئة كبار العلماء",
            "مؤلف لأكثر من 15 كتابًا في علوم القرآن"
        ],
        ijazatList: [
            "إجازة بالقراءات العشر الكبرى",
            "إجازة في علم التفسير",
            "إجازة في علوم القرآن",
            "إجازة في علم أصول الفقه"
        ],
        courses: ["علوم القرآن", "أصول التفسير", "إعجاز القرآن", "أسباب النزول", "الناسخ والمنسوخ"],
        schedule: [
            { day: "الإثنين", time: "بعد المغرب" },
            { day: "الأربعاء", time: "بعد العشاء" },
            { day: "السبت", time: "بعد العصر" }
        ]
    }
];


document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    }

    const teachersGrid = document.getElementById('teachersGrid');
    const profileHero = document.getElementById('profileHero');

    if (teachersGrid) {
        renderTeachers();
    }

    if (profileHero) {
        loadTeacherProfile();
    }
});

/* ======== عرض كروت المعلمين=========== */
function renderTeachers() {
    const grid = document.getElementById('teachersGrid');
    if (!grid) return;
    grid.innerHTML = teachersData.map((teacher, index) => createTeacherCard(teacher, index)).join('');
}

function createTeacherCard(teacher, index) {
    return `
        <div class="teacher-card" data-aos="fade-up" data-aos-delay="${index * 100}">
            <div class="card-pattern"></div>

            <div class="teacher-image-wrapper">
                <img src="${teacher.image}" alt="${teacher.name}" class="teacher-image" loading="lazy">
            </div>

            <div class="teacher-info">
                <h3 class="teacher-name">${teacher.name}</h3>
                <p class="teacher-specialty">
                    <i class="fas fa-book-quran"></i>
                    ${teacher.specialty}
                </p>

                <div class="teacher-extra">
                    <div class="teacher-stats">
                        <div class="stat">
                            <i class="fas fa-graduation-cap"></i>
                            <span class="num">${teacher.experience}</span>
                            <span class="lbl">سنة خبرة</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-users"></i>
                            <span class="num">${teacher.students}</span>
                            <span class="lbl">طالب</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-star"></i>
                            <span class="num">${teacher.rating}</span>
                            <span class="lbl">تقييم</span>
                        </div>
                    </div>
                </div>

                <button class="view-more-btn" onclick="goToProfile(${teacher.id})">
                    <span>عرض الملف الشخصي</span>
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
        </div>
    `;
}

/* =========  الانتقال لصفحة المعلم========== */
function goToProfile(teacherId) {
    localStorage.setItem('selectedTeacherId', teacherId);
    window.location.href = `teacher_profile.php?id=${teacherId}`;
}

/* =========== تحميل بيانات المعلم في صفحة البروفايل =========== */
function loadTeacherProfile() {
    const urlParams = new URLSearchParams(window.location.search);
    let teacherId = parseInt(urlParams.get('id')) || parseInt(localStorage.getItem('selectedTeacherId')) || 1;

    const teacher = teachersData.find(t => t.id === teacherId);

    if (!teacher) {
        console.error('المعلم غير موجود');
        return;
    }

    fillHeroSection(teacher);
    fillProfileContent(teacher);
    document.title = `${teacher.name} - مشكاة`;
}

/* ====== ملء قسم الهيرو ====== */
function fillHeroSection(teacher) {
    const setText = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    };

    const setImage = (id, src) => {
        const el = document.getElementById(id);
        if (el) el.src = src;
    };

    if (teacher.coverImage) {
        setImage('heroBgImage', teacher.coverImage);
    }

    setImage('heroImage', teacher.image);
    setText('heroSpecialty', teacher.specialty);
    setText('heroName', teacher.name);
    setText('heroTitle', teacher.title);
    setText('heroExperience', teacher.experience);
    setText('heroStudents', teacher.students + '+');
    setText('heroIjazat', teacher.ijazat);
}

/* ====== ملء محتوى البروفايل ====== */
function fillProfileContent(teacher) {
    const bioEl = document.getElementById('profileBio');
    if (bioEl) bioEl.textContent = teacher.bio;

    const qualEl = document.getElementById('profileQualifications');
    if (qualEl) {
        qualEl.innerHTML = teacher.qualifications.map(q => `<li>${q}</li>`).join('');
    }

    const ijazatEl = document.getElementById('profileIjazat');
    if (ijazatEl) {
        ijazatEl.innerHTML = teacher.ijazatList.map(i => `<li>${i}</li>`).join('');
    }

    const coursesEl = document.getElementById('profileCourses');
    if (coursesEl) {
        coursesEl.innerHTML = teacher.courses.map(c => `
            <div class="course-tag">
                <i class="fas fa-book-open"></i>
                ${c}
            </div>
        `).join('');
    }

    const scheduleEl = document.getElementById('profileSchedule');
    if (scheduleEl) {
        scheduleEl.innerHTML = teacher.schedule.map(s => `
            <div class="schedule-item">
                <div class="day">
                    <i class="far fa-calendar-alt"></i>
                    ${s.day}
                </div>
                <div class="time">
                    <i class="far fa-clock"></i>
                    ${s.time}
                </div>
            </div>
        `).join('');
    }
}

/* ========= تأثير parallax بسيط على صورة الهيرو ============== */
window.addEventListener('scroll', function() {
    const heroBg = document.getElementById('heroBgImage');
    if (!heroBg) return;

    const scrolled = window.pageYOffset;
    if (scrolled < 800) {
        heroBg.style.transform = `translateY(${scrolled * 0.3}px) scale(1.05)`;
    }
});
(function () {
    'use strict';

    const section = document.getElementById('packages-section');
    if (!section) return;

    /* ===== Helpers ===== */
    function prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    function debounce(fn, delay) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = setTimeout(() => fn.apply(this, args), delay);
        };
    }

    /* ===== Init ===== */
    document.addEventListener('DOMContentLoaded', () => {
        initParticles();
        initScrollAnimations();
        initCardGlowTracking();
        initRippleEffect();
        initAccessibility();
    });

    /* ============= Particles System (Light & Elegant) =============== */
    function initParticles() {
        const canvas = section.querySelector('#particlesCanvas');
        if (!canvas || prefersReducedMotion()) {
            if (canvas) canvas.style.display = 'none';
            return;
        }

        const ctx = canvas.getContext('2d');
        let particles = [];
        let animationId;
        let isVisible = true;

        function resize() {
            canvas.width = section.offsetWidth;
            canvas.height = section.offsetHeight;
        }

        resize();
        window.addEventListener('resize', debounce(resize, 200));

        document.addEventListener('visibilitychange', () => {
            isVisible = !document.hidden;
            if (isVisible) animate();
            else cancelAnimationFrame(animationId);
        });

        class Particle {
            constructor() {
                this.reset();
            }

            reset() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 2 + 0.5;
                this.speedX = (Math.random() - 0.5) * 0.2;
                this.speedY = -Math.random() * 0.15 - 0.05;
                this.opacity = Math.random() * 0.25 + 0.05;
                this.opacitySpeed = (Math.random() - 0.5) * 0.003;
                this.maxOpacity = Math.min(this.opacity + 0.15, 0.35);
                this.minOpacity = Math.max(0.03, this.opacity - 0.1);

                const pick = Math.random();
                if (pick < 0.35) {
                    this.r = 196; this.g = 146; this.b = 37;
                } else if (pick < 0.65) {
                    this.r = 131; this.g = 171; this.b = 119;
                } else {
                    this.r = 212; this.g = 190; this.b = 142;
                }
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                this.opacity += this.opacitySpeed;
                if (this.opacity >= this.maxOpacity || this.opacity <= this.minOpacity) {
                    this.opacitySpeed *= -1;
                }

                if (this.x < -10) this.x = canvas.width + 10;
                if (this.x > canvas.width + 10) this.x = -10;
                if (this.y < -10) this.y = canvas.height + 10;
                if (this.y > canvas.height + 10) this.y = -10;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(${this.r}, ${this.g}, ${this.b}, ${this.opacity})`;
                ctx.fill();

                if (this.size > 1.2) {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size * 3.5, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(${this.r}, ${this.g}, ${this.b}, ${this.opacity * 0.08})`;
                    ctx.fill();
                }
            }
        }

        function getParticleCount() {
            const area = canvas.width * canvas.height;
            return Math.min(Math.floor(area / 18000), 60);
        }

        function createParticles() {
            particles = [];
            const count = getParticleCount();
            for (let i = 0; i < count; i++) {
                particles.push(new Particle());
            }
        }

        createParticles();

        function animate() {
            if (!isVisible) return;

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
                particles[i].draw();
            }

            animationId = requestAnimationFrame(animate);
        }

        animate();

        window.addEventListener('resize', debounce(() => {
            cancelAnimationFrame(animationId);
            createParticles();
            if (isVisible) animate();
        }, 300));
    }

    /* =========== Scroll Reveal Animations =========== */
    function initScrollAnimations() {
        const cards = section.querySelectorAll('.pricing-card');
        if (!cards.length) return;

        if (!('IntersectionObserver' in window) || prefersReducedMotion()) {
            cards.forEach(card => {
                card.classList.add('is-visible');
                card.style.opacity = '1';
                card.style.transform = 'none';
            });
            return;
        }

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -60px 0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const delay = parseInt(card.dataset.delay, 10) || 0;

                    setTimeout(() => {
                        card.classList.add('is-visible');
                    }, delay);

                    observer.unobserve(card);
                }
            });
        }, observerOptions);

        cards.forEach(card => observer.observe(card));
    }

    /* ========= Card Glow Mouse Tracking ============= */
    function initCardGlowTracking() {
        const cards = section.querySelectorAll('.pricing-card');
        if (!cards.length || prefersReducedMotion()) return;

        cards.forEach(card => {
            const inner = card.querySelector('.card-inner');
            if (!inner) return;

            card.addEventListener('mousemove', (e) => {
                const rect = inner.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                inner.style.setProperty('--mouse-x', `${x}px`);
                inner.style.setProperty('--mouse-y', `${y}px`);
            }, { passive: true });

            card.addEventListener('mouseleave', () => {
                inner.style.setProperty('--mouse-x', '50%');
                inner.style.setProperty('--mouse-y', '50%');
            }, { passive: true });
        });

        let lastX = 0;
        let lastY = 0;
        let ticking = false;

        section.addEventListener('mousemove', (e) => {
            lastX = e.clientX;
            lastY = e.clientY;

            if (!ticking) {
                requestAnimationFrame(() => {
                    updateAmbientLight(lastX, lastY);
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

})();


    /* ============== Ambient Light Effect ================= */
    function updateAmbientLight(x, y) {
        const lightBeam = section.querySelector('#lightBeam');
        if (!lightBeam) return;

        const rect = section.getBoundingClientRect();
        const pX = ((x - rect.left) / section.offsetWidth) * 100;
        const pY = ((y - rect.top) / section.offsetHeight) * 100;

        lightBeam.style.background = `
            radial-gradient(
                ellipse 50% 60% at 50% 0%,
                rgba(163, 193, 153, 0.06) 0%,
                transparent 60%
            ),
            radial-gradient(
                ellipse 20% 30% at ${pX}% ${pY}%,
                rgba(196, 146, 37, 0.025) 0%,
                transparent 50%
            ),
            radial-gradient(
                ellipse 35% 50% at 30% 80%,
                rgba(163, 193, 153, 0.03) 0%,
                transparent 50%
            )
        `;
    }

    /* =========== Ripple Effect on Buttons =============== */
    function initRippleEffect() {

        if (!document.getElementById('packages-ripple-style')) {
            const style = document.createElement('style');
            style.id = 'packages-ripple-style';
            style.textContent = `
                @keyframes packages-ripple-anim {
                    0%   { transform: scale(0); opacity: 1; }
                    100% { transform: scale(2.5); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }

        section.addEventListener('click', (e) => {
            const button = e.target.closest('button');
            if (!button) return;

            if (!section.contains(button)) return;

            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            const isFeatured = button.classList.contains('btn-featured');
            const rippleColor = isFeatured
                ? 'rgba(255, 255, 255, 0.2)'
                : 'rgba(131, 171, 119, 0.15)';

            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                border-radius: 50%;
                background: ${rippleColor};
                transform: scale(0);
                animation: packages-ripple-anim 0.6s ease-out;
                pointer-events: none;
                z-index: 20;
            `;

            button.style.position = 'relative';
            button.style.overflow = 'hidden';
            button.appendChild(ripple);

            ripple.addEventListener('animationend', () => {
                ripple.remove();
            });
        });
    }

    /* ======== Accessibility Enhancements ============= */
    function initAccessibility() {

        if (!document.getElementById('packages-focus-style')) {
            const focusStyle = document.createElement('style');
            focusStyle.id = 'packages-focus-style';
            focusStyle.textContent = `
                #packages-section:not(.keyboard-nav) button:focus {
                    outline: none;
                }
                #packages-section.keyboard-nav button:focus {
                    outline: 2px solid rgba(196, 146, 37, 0.6);
                    outline-offset: 3px;
                    border-radius: 1rem;
                }
            `;
            document.head.appendChild(focusStyle);
        }

        section.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                section.classList.add('keyboard-nav');
            }
        });

        section.addEventListener('mousedown', () => {
            section.classList.remove('keyboard-nav');
        });

        if (prefersReducedMotion()) {
            const cards = section.querySelectorAll('.pricing-card');
            cards.forEach(card => {
                card.style.opacity = '1';
                card.style.transform = 'none';
                card.classList.add('is-visible');
            });
        }
    }

    const subscribeBtn = document.getElementById('subscribeBtn');
const packageBtns = ['packageBtn1', 'packageBtn2', 'packageBtn3'];

packageBtns.forEach((btnId) => {
    const btn = document.getElementById(btnId);
    if (btn && subscribeBtn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            setTimeout(() => {
                subscribeBtn.click();
            }, 600);
        });
    }
});


    /* ========== Counter Animation (Utility) ============== */
    function animateCounter(element, start, end, duration) {
        if (!element) return;

        if (!section.contains(element)) return;

        const startTime = performance.now();
        const range = end - start;

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = easeOutCubic(progress);
            element.textContent = Math.round(start + range * eased);

            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }

        requestAnimationFrame(update);
    }

    function easeOutCubic(t) {
        return 1 - Math.pow(1 - t, 3);
    }
(function () {
    'use strict';

    /* ---------- Section Root ---------- */
    const section = document.getElementById('study-section');
    if (!section) return;

    /* ---------- DOM References ---------- */
    const stepsContainer     = section.querySelector('#steps-container');
    const timelineProgress   = section.querySelector('#timeline-progress');
    const timelineOrb        = section.querySelector('#timeline-orb');
    const particlesContainer = section.querySelector('#particles-container');
    const stepItems          = section.querySelectorAll('.step-item');
    const animatedEls        = section.querySelectorAll('[data-animate]');

    /* ---------- Configuration ---------- */
    const CONFIG = {
        particleCount: 25,
        observerThreshold: 0.25,
        staggerDelay: 150,
        orbSmoothness: 0.08,
    };

    /* ========== PARTICLES SYSTEM ========== */
    function initParticles() {
        if (!particlesContainer) return;

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) return;

        const fragment = document.createDocumentFragment();

        for (let i = 0; i < CONFIG.particleCount; i++) {
            const particle = document.createElement('div');
            const isGold   = Math.random() > 0.5;
            const size     = Math.random() * 6 + 3;

            particle.classList.add('particle', isGold ? 'particle--gold' : 'particle--green');

            Object.assign(particle.style, {
                width:   `${size}px`,
                height:  `${size}px`,
                left:    `${Math.random() * 100}%`,
                top:     `${Math.random() * 100}%`,
                opacity: '0',
            });

            fragment.appendChild(particle);
            animateParticle(particle);
        }

        particlesContainer.appendChild(fragment);
    }

    function animateParticle(el) {
        const duration = Math.random() * 8000 + 6000;
        const delay    = Math.random() * 5000;

        const driftX = (Math.random() - 0.5) * 20;
        const driftY = (Math.random() - 0.5) * 30;

        const keyframes = [
            { opacity: 0,   transform: `translate(0, 0)` },
            { opacity: 0.7, transform: `translate(${driftX * 0.3}px, ${driftY * 0.3}px)`, offset: 0.3 },
            { opacity: 0.5, transform: `translate(${driftX * 0.7}px, ${driftY * 0.7}px)`, offset: 0.7 },
            { opacity: 0,   transform: `translate(${driftX}px, ${driftY}px)` },
        ];

        const animation = el.animate(keyframes, {
            duration:   duration,
            delay:      delay,
            easing:     'ease-in-out',
            iterations: Infinity,
        });

        return animation;
    }

    /* ========== INTERSECTION OBSERVER - REVEAL ========== */
    function initRevealObserver() {
        const headerObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const delay = parseInt(entry.target.dataset.delay || '0', 10);
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, delay);
                        headerObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.2, rootMargin: '0px 0px -50px 0px' }
        );

        animatedEls.forEach((el) => headerObserver.observe(el));

        let revealedCount = 0;
        const stepObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const stepIndex = Array.from(stepItems).indexOf(entry.target);
                        const delay = Math.max(0, stepIndex - revealedCount) * CONFIG.staggerDelay;

                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                            revealedCount++;
                        }, delay);

                        stepObserver.unobserve(entry.target);
                    }
                });
            },
            {
                threshold:  CONFIG.observerThreshold,
                rootMargin: '0px 0px -80px 0px',
            }
        );

        stepItems.forEach((el) => stepObserver.observe(el));
    }

    /* ========== TIMELINE PROGRESS + ORB ========== */
    function initTimelineProgress() {
        if (!stepsContainer || !timelineProgress || !timelineOrb) return;

        let ticking         = false;
        let currentProgress = 0;
        let targetProgress  = 0;

        function updateTimeline() {
            const containerRect = stepsContainer.getBoundingClientRect();
            const containerTop  = containerRect.top;
            const containerH    = containerRect.height;
            const viewH         = window.innerHeight;

            const viewCenter  = viewH * 0.6;
            const progressRaw = (viewCenter - containerTop) / containerH;
            targetProgress    = Math.max(0, Math.min(1, progressRaw));
        }

        function smoothUpdate() {
            currentProgress += (targetProgress - currentProgress) * CONFIG.orbSmoothness;

            const pct = (currentProgress * 100).toFixed(2);
            timelineProgress.style.height = `${pct}%`;
            timelineOrb.style.top         = `${pct}%`;

            timelineOrb.style.opacity = currentProgress > 0.01 ? '1' : '0';

            stepItems.forEach((item) => {
                const itemRect   = item.getBoundingClientRect();
                const itemCenter = itemRect.top + itemRect.height / 2;
                const viewCenter = window.innerHeight * 0.6;

                if (itemCenter < viewCenter) {
                    item.classList.add('is-passed');
                    item.classList.remove('is-active');
                } else if (itemCenter < viewCenter + 200) {
                    item.classList.add('is-active');
                    item.classList.remove('is-passed');
                } else {
                    item.classList.remove('is-active', 'is-passed');
                }
            });

            requestAnimationFrame(smoothUpdate);
        }

        function onScroll() {
            if (!ticking) {
                ticking = true;
                requestAnimationFrame(() => {
                    updateTimeline();
                    ticking = false;
                });
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll, { passive: true });

        updateTimeline();
        smoothUpdate();
    }

    const studyStartBtn = document.getElementById('studyStartBtn');
const subscribeBtn = document.getElementById('subscribeBtn');

if (studyStartBtn && subscribeBtn) {
    studyStartBtn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        setTimeout(() => {
            subscribeBtn.click();
        }, 600);
    });
}


    /* ========== HOVER PARALLAX ON CARDS (Desktop) ========== */
    function initCardParallax() {
        const isMobile = window.matchMedia('(max-width: 768px)').matches;
        if (isMobile) return;

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) return;

        const cards = section.querySelectorAll('.step-card');

        cards.forEach((card) => {
            card.addEventListener('mousemove', (e) => {
                const rect    = card.getBoundingClientRect();
                const x       = e.clientX - rect.left;
                const y       = e.clientY - rect.top;
                const centerX = rect.width  / 2;
                const centerY = rect.height / 2;

                const rotateX = ((y - centerY) / centerY) * -3;
                const rotateY = ((x - centerX) / centerX) *  3;

                card.style.transform =
                    `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform =
                    'perspective(800px) rotateX(0deg) rotateY(0deg) scale(1)';
            });
        });
    }

        /* ========== LIGHT SWEEP EFFECT ON CARDS ========== */
    function initLightSweep() {
        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) return;

        const cards = section.querySelectorAll('.step-card');

        cards.forEach((card, index) => {
            const sweep = document.createElement('div');
            sweep.setAttribute('aria-hidden', 'true');
            Object.assign(sweep.style, {
                position:     'absolute',
                top:          '0',
                left:         '-100%',
                width:        '60%',
                height:       '100%',
                background:   'linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent)',
                zIndex:       '5',
                pointerEvents: 'none',
                borderRadius: 'inherit',
            });
            card.style.position = 'relative';
            card.appendChild(sweep);

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                sweep.animate(
                                    [
                                        { left: '-100%' },
                                        { left: '200%'  },
                                    ],
                                    {
                                        duration: 1200,
                                        easing:   'ease-in-out',
                                        fill:     'forwards',
                                    }
                                );
                            }, index * CONFIG.staggerDelay + 600);
                            observer.unobserve(entry.target);
                        }
                    });
                },
                { threshold: 0.3 }
            );

            observer.observe(card);
        });
    }

    /* ========== COUNTER ANIMATION FOR STEP NUMBERS ========== */
    function initStepCounters() {
        const arabicNumerals = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        stepItems.forEach((item) => {
            const numberEl = item.querySelector('.step-number');
            if (!numberEl) return;

            const finalNum  = parseInt(item.dataset.step, 10);
            const finalChar = arabicNumerals[finalNum] || finalNum.toString();
            let animated    = false;

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting && !animated) {
                            animated = true;

                            let count = 0;
                            const interval = setInterval(() => {
                                count++;
                                numberEl.textContent = arabicNumerals[count] || count.toString();
                                if (count >= finalNum) {
                                    clearInterval(interval);
                                    numberEl.textContent = finalChar;
                                }
                            }, 80);

                            observer.unobserve(entry.target);
                        }
                    });
                },
                { threshold: 0.5 }
            );

            observer.observe(item);
        });
    }

    /* ========== INITIALIZATION ========== */
    function init() {
        initParticles();
        initRevealObserver();
        initTimelineProgress();
        initCardParallax();
        initLightSweep();
        initStepCounters();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
(function () {
    'use strict';

    /* -------- القسم المستهدف --------- */
    const section = document.getElementById('faq-section');
    if (!section) return;

    /* -------- DOM Elements --------- */
    const accordionContainer = section.querySelector('#accordionContainer');
    const accordionItems     = section.querySelectorAll('.accordion-item');
    const categoryTabs       = section.querySelector('#categoryTabs');
    const tabButtons         = section.querySelectorAll('.tab-btn');
    const canvas             = section.querySelector('#particlesCanvas');
    const ctx                = canvas ? canvas.getContext('2d') : null;

    /* -------- State ------- */
    let activeItem      = null;
    let currentCategory = 'all';
    let particles       = [];
    let animationFrameId = null;
    let isReducedMotion  = false;

    /* ======= Initialize ======== */
    function init() {
        checkReducedMotion();
        setupAccordion();
        setupCategoryTabs();
        setupScrollReveal();
        if (!isReducedMotion && canvas && ctx) {
            setupParticles();
        }
    }

    /* ========== Check Reduced Motion Preference ========= */
    function checkReducedMotion() {
        const query = window.matchMedia('(prefers-reduced-motion: reduce)');
        isReducedMotion = query.matches;

        query.addEventListener('change', function (e) {
            isReducedMotion = e.matches;
            if (isReducedMotion && animationFrameId) {
                cancelAnimationFrame(animationFrameId);
                animationFrameId = null;
                if (ctx && canvas) {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            } else if (!isReducedMotion && canvas && ctx) {
                setupParticles();
            }
        });
    }

    /* ======= Accordion Logic ======== */
    function setupAccordion() {
        accordionItems.forEach(function (item) {
            const trigger = item.querySelector('.accordion-trigger');
            if (!trigger) return;

            trigger.addEventListener('click', function () {
                handleAccordionClick(item);
            });

            /* Keyboard accessibility */
            trigger.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    handleAccordionClick(item);
                }
            });
        });
    }

    function handleAccordionClick(item) {
        const isCurrentlyActive = item.classList.contains('active');

        /* Close currently active item */
        if (activeItem && activeItem !== item) {
            closeAccordionItem(activeItem);
        }

        if (isCurrentlyActive) {
            closeAccordionItem(item);
            activeItem = null;
        } else {
            openAccordionItem(item);
            activeItem = item;
        }
    }

    function openAccordionItem(item) {
        const content = item.querySelector('.accordion-content');
        const trigger = item.querySelector('.accordion-trigger');
        if (!content || !trigger) return;

        item.classList.add('active');
        trigger.setAttribute('aria-expanded', 'true');

        const innerContent = content.querySelector('.content-inner');
        if (innerContent) {
            content.style.maxHeight = 'none';
            const fullHeight = content.scrollHeight;
            content.style.maxHeight = '0px';

            /* Force reflow */
            void content.offsetHeight;

            content.style.maxHeight = fullHeight + 'px';

            const onTransitionEnd = function () {
                if (item.classList.contains('active')) {
                    content.style.maxHeight = 'none';
                }
                content.removeEventListener('transitionend', onTransitionEnd);
            };
            content.addEventListener('transitionend', onTransitionEnd);
        }

        setTimeout(function () {
            scrollToItemIfNeeded(item);
        }, 300);
    }

    function closeAccordionItem(item) {
        const content = item.querySelector('.accordion-content');
        const trigger = item.querySelector('.accordion-trigger');
        if (!content || !trigger) return;

        const currentHeight = content.scrollHeight;
        content.style.maxHeight = currentHeight + 'px';

        /* Force reflow */
        void content.offsetHeight;

        content.style.maxHeight = '0px';

        item.classList.remove('active');
        trigger.setAttribute('aria-expanded', 'false');
    }

    function scrollToItemIfNeeded(item) {
        const rect           = item.getBoundingClientRect();
        const viewportHeight = window.innerHeight;

        if (rect.top < 80 || rect.bottom > viewportHeight - 40) {
            const scrollTarget = window.scrollY + rect.top - 120;
            window.scrollTo({ top: scrollTarget, behavior: 'smooth' });
        }
    }

    /* ======== Category Tabs / Filter ========== */
    function setupCategoryTabs() {
        tabButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const category = btn.getAttribute('data-category');
                if (category === currentCategory) return;

                /* Update active tab */
                tabButtons.forEach(function (b) {
                    b.classList.remove('active');
                });
                btn.classList.add('active');
                currentCategory = category;

                /* Close active accordion item */
                if (activeItem) {
                    closeAccordionItem(activeItem);
                    activeItem = null;
                }

                filterItems(category);
            });
        });
    }

    function filterItems(category) {
        let visibleIndex = 0;

        accordionItems.forEach(function (item) {
            const itemCategory = item.getAttribute('data-category');
            const shouldShow   = category === 'all' || itemCategory === category;

            if (shouldShow) {
                item.classList.remove('filtered-out');
                item.style.position  = '';
                item.style.height    = '';
                item.style.margin    = '';
                item.style.padding   = '';
                item.style.border    = '';

                const delay = visibleIndex * 80;
                item.style.transitionDelay = delay + 'ms';
                item.style.opacity         = '0';
                item.style.transform       = 'translateY(20px)';

                /* Force reflow */
                void item.offsetHeight;

                setTimeout(function (el) {
                    el.style.opacity   = '1';
                    el.style.transform = 'translateY(0)';
                }.bind(null, item), 20 + delay);

                visibleIndex++;
            } else {
                item.style.transitionDelay = '0ms';
                item.classList.add('filtered-out');
            }
        });

        /* Clean up transition delays after animations */
        setTimeout(function () {
            accordionItems.forEach(function (item) {
                item.style.transitionDelay = '';
            });
        }, visibleIndex * 80 + 500);
    }

    /* ======= Scroll Reveal Animation ========= */
    function setupScrollReveal() {
        if (!('IntersectionObserver' in window)) {
            /* Fallback: show all immediately */
            accordionItems.forEach(function (item) {
                item.classList.add('visible');
            });
            return;
        }

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -60px 0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    const item  = entry.target;
                    const index = parseInt(item.getAttribute('data-index'), 10) || 0;
                    const delay = index * 100;

                    setTimeout(function () {
                        item.classList.add('visible');
                    }, delay);

                    observer.unobserve(item);
                }
            });
        }, observerOptions);

        accordionItems.forEach(function (item) {
            observer.observe(item);
        });
    }


       /* ======== Particles System =========== */
    function setupParticles() {
        resizeCanvas();
        createParticles();
        animateParticles();

        window.addEventListener('resize', debounce(function () {
            resizeCanvas();
            createParticles();
        }, 250));

        /* Pause when tab is hidden */
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                if (animationFrameId) {
                    cancelAnimationFrame(animationFrameId);
                    animationFrameId = null;
                }
            } else {
                if (!animationFrameId && !isReducedMotion) {
                    animateParticles();
                }
            }
        });
    }

    function resizeCanvas() {
        if (!canvas) return;
        canvas.width  = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    function createParticles() {
        particles = [];
        if (!canvas) return;

        /* Fewer particles for performance */
        const count = Math.min(
            Math.floor((canvas.width * canvas.height) / 35000),
            40
        );

        for (let i = 0; i < count; i++) {
            particles.push(createSingleParticle());
        }
    }

    function createSingleParticle() {
        const types    = ['dot', 'ring', 'star'];
        const type     = types[Math.floor(Math.random() * types.length)];
        const baseSize = type === 'star'
            ? randomRange(1.5, 3)
            : randomRange(1, 2.5);

        return {
            x:                Math.random() * (canvas ? canvas.width  : 1000),
            y:                Math.random() * (canvas ? canvas.height : 800),
            size:             baseSize,
            type:             type,
            speedX:           randomRange(-0.15, 0.15),
            speedY:           randomRange(-0.3, -0.05),
            opacity:          randomRange(0.1, 0.35),
            opacitySpeed:     randomRange(0.002, 0.008),
            opacityDirection: 1,
            rotation:         Math.random() * Math.PI * 2,
            rotationSpeed:    randomRange(-0.01, 0.01),
            color:            getParticleColor(),
            life:             0,
            maxLife:          randomRange(300, 800)
        };
    }

    function getParticleColor() {
        const colors = [
            { r: 26,  g: 107, b: 74  },  /* Green      */
            { r: 45,  g: 143, b: 101 },  /* Light green */
            { r: 212, g: 168, b: 83  },  /* Gold        */
            { r: 184, g: 134, b: 11  },  /* Dark gold   */
            { r: 100, g: 160, b: 120 }   /* Sage        */
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    function animateParticles() {
        if (!ctx || !canvas || isReducedMotion) return;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];

            /* Update position */
            p.x        += p.speedX;
            p.y        += p.speedY;
            p.rotation += p.rotationSpeed;
            p.life++;

            /* Update opacity (pulsing effect) */
            p.opacity += p.opacitySpeed * p.opacityDirection;
            if (p.opacity >= 0.35) {
                p.opacityDirection = -1;
            } else if (p.opacity <= 0.05) {
                p.opacityDirection = 1;
            }

            /* Reset particle if off screen or life exceeded */
            if (
                p.y < -20 ||
                p.x < -20 ||
                p.x > canvas.width + 20 ||
                p.life > p.maxLife
            ) {
                particles[i]   = createSingleParticle();
                particles[i].y = canvas.height + 10;
                particles[i].x = Math.random() * canvas.width;
                continue;
            }

            drawParticle(p);
        }

        animationFrameId = requestAnimationFrame(animateParticles);
    }

    function drawParticle(p) {
        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate(p.rotation);
        ctx.globalAlpha = Math.max(0, Math.min(1, p.opacity));

        const colorStr = 'rgb(' + p.color.r + ',' + p.color.g + ',' + p.color.b + ')';

        switch (p.type) {
            case 'dot':
                ctx.beginPath();
                ctx.arc(0, 0, p.size, 0, Math.PI * 2);
                ctx.fillStyle = colorStr;
                ctx.fill();
                break;

            case 'ring':
                ctx.beginPath();
                ctx.arc(0, 0, p.size, 0, Math.PI * 2);
                ctx.strokeStyle = colorStr;
                ctx.lineWidth   = 0.5;
                ctx.stroke();
                break;

            case 'star':
                drawStar(0, 0, p.size, colorStr);
                break;
        }

        ctx.restore();
    }

    function drawStar(cx, cy, size, color) {
        const spikes      = 4;
        const outerRadius = size;
        const innerRadius = size * 0.4;

        ctx.beginPath();
        for (let i = 0; i < spikes * 2; i++) {
            const radius = i % 2 === 0 ? outerRadius : innerRadius;
            const angle  = (Math.PI * i) / spikes - Math.PI / 2;
            const x      = cx + Math.cos(angle) * radius;
            const y      = cy + Math.sin(angle) * radius;
            if (i === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        }
        ctx.closePath();
        ctx.fillStyle = color;
        ctx.fill();
    }

    /* ========= Utility Functions ========= */
    function randomRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    function debounce(func, wait) {
        let timeout;
        return function () {
            const context = this;
            const args    = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                func.apply(context, args);
            }, wait);
        };
    }

   


        /* ====== Keyboard Navigation for Accordion ========== */
    function setupKeyboardNav() {
        if (!accordionContainer) return;

        accordionContainer.addEventListener('keydown', function (e) {
            const triggers = Array.from(
                accordionContainer.querySelectorAll(
                    '.accordion-item:not(.filtered-out) .accordion-trigger'
                )
            );

            const currentIndex = triggers.indexOf(document.activeElement);
            if (currentIndex === -1) return;

            let newIndex = -1;

            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    newIndex = (currentIndex + 1) % triggers.length;
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    newIndex = (currentIndex - 1 + triggers.length) % triggers.length;
                    break;
                case 'Home':
                    e.preventDefault();
                    newIndex = 0;
                    break;
                case 'End':
                    e.preventDefault();
                    newIndex = triggers.length - 1;
                    break;
                default:
                    return;
            }

            if (newIndex >= 0 && newIndex < triggers.length) {
                triggers[newIndex].focus();
            }
        });
    }

    /* =========== Light Trail Effect on Hover (subtle) ========== */
    function setupLightTrail() {
        if (isReducedMotion) return;

        accordionItems.forEach(function (item) {
            item.addEventListener('mousemove', function (e) {
                const rect = item.getBoundingClientRect();
                const x    = e.clientX - rect.left;
                const y    = e.clientY - rect.top;

                item.style.setProperty(
                    'background',
                    'radial-gradient(circle 200px at ' + x + 'px ' + y + 'px, rgba(26,107,74,0.02), transparent)'
                );
            });

            item.addEventListener('mouseleave', function () {
                item.style.removeProperty('background');
            });
        });
    }

    /* ========= Start Everything ============ */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            init();
            setupKeyboardNav();
            setupLightTrail();
        });
    } else {
        init();
        setupKeyboardNav();
        setupLightTrail();
    }

})();
(function () {
    'use strict';

    const section = document.getElementById('footer-section');
    if (!section) return;

    document.addEventListener('DOMContentLoaded', () => {
        initParticles();
        initScrollAnimations();
        initCountUp();
        initScrollTopButton();
        setCurrentYear();
        initSocialTilt();
    });

    /* ---- PARTICLES SYSTEM ---- */
    function initParticles() {
        const canvas = section.querySelector('#footerParticles');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let particles = [];
        let animationId;
        let width, height;

        function resize() {
            const rect = canvas.parentElement.getBoundingClientRect();
            width = canvas.width = rect.width;
            height = canvas.height = rect.height;
        }

        class Particle {
            constructor() {
                this.reset();
            }

            reset() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.size = Math.random() * 1.8 + 0.3;
                this.speedX = (Math.random() - 0.5) * 0.15;
                this.speedY = (Math.random() - 0.5) * 0.15;
                this.opacity = Math.random() * 0.4 + 0.05;
                this.maxOpacity = this.opacity;
                this.fadeSpeed = Math.random() * 0.008 + 0.002;
                this.fadingIn = Math.random() > 0.5;
                this.life = Math.random() * 500 + 200;
                this.age = 0;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                this.age++;

                if (this.fadingIn) {
                    this.opacity += this.fadeSpeed;
                    if (this.opacity >= this.maxOpacity) this.fadingIn = false;
                } else {
                    this.opacity -= this.fadeSpeed;
                    if (this.opacity <= 0.02) this.fadingIn = true;
                }

                if (this.x < -10 || this.x > width + 10 ||
                    this.y < -10 || this.y > height + 10 ||
                    this.age > this.life) {
                    this.reset();
                }
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(212, 175, 55, ${this.opacity})`;
                ctx.fill();

                if (this.size > 1) {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size * 3, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(212, 175, 55, ${this.opacity * 0.08})`;
                    ctx.fill();
                }
            }
        }

        function createParticles() {
            const count = Math.min(Math.floor((width * height) / 18000), 70);
            particles = [];
            for (let i = 0; i < count; i++) {
                particles.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, width, height);

            particles.forEach(p => {
                p.update();
                p.draw();
            });

            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 100) {
                        const lineOpacity = (1 - dist / 100) * 0.04;
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(212, 175, 55, ${lineOpacity})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                }
            }

            animationId = requestAnimationFrame(animate);
        }

        resize();
        createParticles();

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (!animationId) animate();
                } else {
                    cancelAnimationFrame(animationId);
                    animationId = null;
                }
            });
        }, { threshold: 0.05 });

        observer.observe(canvas);

        window.addEventListener('resize', () => {
            resize();
            createParticles();
        });
    }


    /* ---- SCROLL ANIMATIONS ---- */
    function initScrollAnimations() {
        const elements = section.querySelectorAll('[data-animate]');
        elements.forEach(el => {
            const delay = parseInt(el.dataset.delay) || 0;
            setTimeout(() => {
                el.classList.add('is-visible');
            }, delay + 100);
        });

        const cols = section.querySelectorAll('.footer-col');
        cols.forEach(col => {
            const delay = parseInt(col.dataset.delay) || 0;
            setTimeout(() => {
                col.classList.add('is-visible');
            }, delay + 100);
        });
    }


    /* ---- COUNT UP ANIMATION ---- */
    function initCountUp() {
        const statNumbers = section.querySelectorAll('.stat-number');
        if (!statNumbers.length) return;

        setTimeout(() => {
            statNumbers.forEach((el, index) => {
                setTimeout(() => {
                    animateCount(el);
                }, index * 200);
            });
        }, 600);
    }

    function animateCount(element) {
        const target = parseInt(element.dataset.count);
        const duration = 2500;
        const startTime = performance.now();

        element.classList.add('counting');

        function easeOutExpo(t) {
            return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
        }

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeOutExpo(progress);
            const current = Math.floor(easedProgress * target);

            element.textContent = current.toLocaleString('ar-SA') + '+';

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                element.textContent = target.toLocaleString('ar-SA') + '+';
                element.classList.remove('counting');
            }
        }

        requestAnimationFrame(update);
    }


    /* ---- NEWSLETTER SUBSCRIBE ---- */
    function handleSubscribe(event) {
        event.preventDefault();

        const email = section.querySelector('#newsletterEmail');
        const btnText = section.querySelector('#btnText');
        const btnIcon = section.querySelector('#btnIcon');
        const btnSuccess = section.querySelector('#btnSuccess');
        const btn = section.querySelector('#newsletterBtn');

        if (!email.value) return;

        btnText.textContent = 'جاري...';
        btnIcon.classList.add('hidden');
        btn.disabled = true;
        btn.classList.add('opacity-70');

        setTimeout(() => {
            btnText.classList.add('hidden');
            btnSuccess.classList.remove('hidden');
            btnSuccess.classList.add('flex');
            btn.classList.remove('opacity-70');
            btn.classList.add('bg-green-500');

            email.value = '';

            setTimeout(() => {
                btnText.textContent = 'اشتراك';
                btnText.classList.remove('hidden');
                btnIcon.classList.remove('hidden');
                btnSuccess.classList.add('hidden');
                btnSuccess.classList.remove('flex');
                btn.classList.remove('bg-green-500');
                btn.disabled = false;
            }, 3000);
        }, 1500);
    }

    window.footerHandleSubscribe = handleSubscribe;


    /* ---- SCROLL TO TOP ---- */
    function initScrollTopButton() {
        const btn = section.querySelector('#scrollTopBtn');
        if (!btn) return;

        window.addEventListener('scroll', () => {
            if (window.scrollY > 200) {
                btn.classList.add('is-active');
            } else {
                btn.classList.remove('is-active');
            }
        }, { passive: true });
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    window.footerScrollToTop = scrollToTop;


    /* ---- CURRENT YEAR ---- */
    function setCurrentYear() {
        const yearEl = section.querySelector('#currentYear');
        if (yearEl) {
            yearEl.textContent = new Date().getFullYear();
        }
    }


    /* ---- SOCIAL ICONS TILT ---- */
    function initSocialTilt() {
        section.querySelectorAll('.social-icon-btn').forEach(btn => {
            btn.addEventListener('mousemove', function (e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                const rotateX = (y / rect.height) * -10;
                const rotateY = (x / rect.width) * 10;
                this.style.transform = `perspective(200px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.1) translateY(-4px)`;
            });

            btn.addEventListener('mouseleave', function () {
                this.style.transform = '';
            });
        });
    }

})();
