import './bootstrap';

function initTheme() {
    const stored = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = stored ?? (prefersDark ? 'dark' : 'light');

    document.documentElement.classList.toggle('dark', theme === 'dark');
    updateThemeIcons(theme);
}

function updateThemeIcons(theme) {
    document.querySelectorAll('[data-theme-icon="sun"]').forEach((el) => {
        el.classList.toggle('hidden', theme === 'dark');
    });
    document.querySelectorAll('[data-theme-icon="moon"]').forEach((el) => {
        el.classList.toggle('hidden', theme === 'light');
    });
}

function toggleTheme() {
    const isDark = document.documentElement.classList.toggle('dark');
    const theme = isDark ? 'dark' : 'light';
    localStorage.setItem('theme', theme);
    updateThemeIcons(theme);
}

function setMobileMenuOpen(open) {
    const menu = document.getElementById('mobile-menu');
    const backdrop = document.getElementById('mobile-menu-backdrop');
    const openBtn = document.querySelector('[data-mobile-menu-open]');
    const closeBtn = document.querySelector('[data-mobile-menu-close]');

    if (!menu || !backdrop) return;

    menu.classList.toggle('translate-x-full', !open);
    backdrop.classList.toggle('opacity-0', !open);
    backdrop.classList.toggle('pointer-events-none', !open);
    document.body.classList.toggle('overflow-hidden', open);

    if (openBtn) openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (closeBtn) closeBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
}

function initMobileMenu() {
    document.querySelectorAll('[data-mobile-menu-open]').forEach((btn) => {
        btn.addEventListener('click', () => setMobileMenuOpen(true));
    });

    document.querySelectorAll('[data-mobile-menu-close]').forEach((btn) => {
        btn.addEventListener('click', () => setMobileMenuOpen(false));
    });

    document.querySelectorAll('[data-mobile-menu-link]').forEach((link) => {
        link.addEventListener('click', () => setMobileMenuOpen(false));
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            setMobileMenuOpen(false);
        }
    });
}

function initHeroSlider() {
    const slider = document.querySelector('[data-hero-slider]');
    if (!slider) return;

    const slides = [...slider.querySelectorAll('[data-hero-slide]')];
    const dots = [...slider.querySelectorAll('[data-hero-dot]')];
    const prevBtn = slider.querySelector('[data-hero-prev]');
    const nextBtn = slider.querySelector('[data-hero-next]');
    const currentEl = slider.querySelector('[data-hero-current]');
    const autoplayMs = parseInt(slider.dataset.autoplay, 10) || 6000;

    if (slides.length <= 1) return;

    let current = 0;
    let timer = null;
    let touchStartX = 0;

    function goTo(index) {
        current = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.classList.toggle('is-active', i === current);
        });

        dots.forEach((dot, i) => {
            dot.classList.toggle('is-active', i === current);
        });

        if (currentEl) {
            currentEl.textContent = String(current + 1);
        }
    }

    function next() {
        goTo(current + 1);
    }

    function prev() {
        goTo(current - 1);
    }

    function startAutoplay() {
        stopAutoplay();
        timer = setInterval(next, autoplayMs);
    }

    function stopAutoplay() {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    prevBtn?.addEventListener('click', () => {
        prev();
        startAutoplay();
    });

    nextBtn?.addEventListener('click', () => {
        next();
        startAutoplay();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            goTo(parseInt(dot.dataset.heroDot, 10));
            startAutoplay();
        });
    });

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);

    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        stopAutoplay();
    }, { passive: true });

    slider.addEventListener('touchend', (e) => {
        const diff = e.changedTouches[0].screenX - touchStartX;
        if (Math.abs(diff) > 50) {
            diff > 0 ? prev() : next();
        }
        startAutoplay();
    }, { passive: true });

    startAutoplay();
}

document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initMobileMenu();
    initHeroSlider();

    document.querySelectorAll('[data-theme-toggle]').forEach((btn) => {
        btn.addEventListener('click', toggleTheme);
    });
});

function updateCountdowns() {
    document.querySelectorAll('[data-countdown]').forEach((el) => {
        const end = new Date(el.dataset.countdown);
        const now = new Date();
        const diff = end - now;

        if (diff <= 0) {
            el.textContent = 'Ended';
            el.classList.remove('text-red-500', 'dark:text-red-400');
            el.classList.add('text-slate-500');
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        if (days > 0) {
            el.textContent = `${days}d ${hours}h ${minutes}m`;
        } else if (hours > 0) {
            el.textContent = `${hours}h ${minutes}m ${seconds}s`;
        } else {
            el.textContent = `${minutes}m ${seconds}s`;
            el.classList.add('text-red-500', 'dark:text-red-400');
        }
    });
}

updateCountdowns();
setInterval(updateCountdowns, 1000);
