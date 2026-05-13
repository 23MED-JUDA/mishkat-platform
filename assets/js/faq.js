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
