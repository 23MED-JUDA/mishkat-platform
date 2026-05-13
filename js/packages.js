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
                    // Gold / warm
                    this.r = 196; this.g = 146; this.b = 37;
                } else if (pick < 0.65) {
                    // Sage green
                    this.r = 131; this.g = 171; this.b = 119;
                } else {
                    // Warm cream
                    this.r = 212; this.g = 190; this.b = 142;
                }
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                // Twinkle
                this.opacity += this.opacitySpeed;
                if (this.opacity >= this.maxOpacity || this.opacity <= this.minOpacity) {
                    this.opacitySpeed *= -1;
                }

                // Wrap edges
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

        // Recreate particles on resize
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

        // Ambient light tracking - محصور جوه الـ section
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

        // Inject ripple keyframes مرة وحدة بس
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

            // تأكد إن الـ button جوه الـ section
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

        // Inject focus styles مرة وحدة بس
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

        // تأكد إن الـ element جوه الـ section
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
