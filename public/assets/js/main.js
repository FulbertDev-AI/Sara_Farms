document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu toggle
    const menuBtn = document.querySelector('.mobile-menu');
    const navLinks = document.querySelector('.nav-links');
    if(menuBtn) menuBtn.addEventListener('click', () => navLinks.classList.toggle('active'));

    // Scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if(entry.isIntersecting) entry.target.classList.add('animate'); });
    }, { threshold: 0.1 });
    document.querySelectorAll('.card, .hero-content').forEach(el => observer.observe(el));
});