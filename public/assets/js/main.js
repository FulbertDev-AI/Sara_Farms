document.addEventListener('DOMContentLoaded', () => {
    // Menu mobile
    const toggle = document.querySelector('.mobile-toggle');
    const nav = document.querySelector('.nav-links');
    if (toggle) toggle.addEventListener('click', () => nav.classList.toggle('active'));

    // Animations au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Validation formulaire contact
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Message envoyé avec succès. Notre équipe vous contactera sous 24h.');
            contactForm.reset();
        });
    }
});