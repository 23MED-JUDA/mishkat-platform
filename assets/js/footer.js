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

            // Faint connections
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
        animate();

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

    // تعريض handleSubscribe للـ HTML
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

    // تعريض scrollToTop للـ HTML
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
