// scripts.js

document.addEventListener('DOMContentLoaded', function () {

    // Fade-in au scroll
    const fadeElements = document.querySelectorAll('.fade-in');

    const checkVisibility = () => {
        fadeElements.forEach(el => {
            const pos = el.getBoundingClientRect().top;
            if (pos < window.innerHeight / 1.1) {
                el.classList.add('visible');
            }
        });
    };

    checkVisibility();
    window.addEventListener('scroll', checkVisibility);

    // Animation des chiffres dans les stat-cards
    const animateNumbers = () => {
        document.querySelectorAll('.stat-value').forEach(stat => {
            if (stat.hasAttribute('data-animated')) return;
            const original = stat.innerText;
            const num = parseFloat(original.replace(/[^\d,.]/g, '').replace(',', '.'));
            if (isNaN(num) || num === 0) return;
            stat.setAttribute('data-animated', 'true');
            let current = 0;
            const steps = 50;
            const increment = num / steps;
            const update = () => {
                current += increment;
                if (current < num) {
                    stat.innerText = original.replace(/[\d\s]+([,.][\d]+)?/, Math.floor(current).toLocaleString('fr-FR'));
                    requestAnimationFrame(update);
                } else {
                    stat.innerText = original;
                }
            };
            update();
        });
    };

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateNumbers();
                observer.unobserve(entry.target);
            }
        });
    });

    document.querySelectorAll('.stat-card').forEach(card => observer.observe(card));

    // Hover sur les cartes
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-3px)');
        card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0)');
    });

    // Disparition automatique des alertes
    const alert = document.querySelector('.alert');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.3s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    }

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
});

function formatNumber(num) {
    return new Intl.NumberFormat('fr-FR').format(num);
}

function formatPrice(price) {
    return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(price);
}
