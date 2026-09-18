document.addEventListener('DOMContentLoaded', () => {
    const galleries = {
        careers: [
            { image: 1, alt: 'Formación en ciencias de la salud' },
            { image: 2, alt: 'Formación en ingeniería y tecnología' },
            { image: 3, alt: 'Formación profesional en gastronomía' },
            { image: 4, alt: 'Formación en diseño creativo' },
            { image: 5, alt: 'Formación profesional docente' }
        ],
        institutions: [
            { image: 6, alt: 'Campus universitario' },
            { image: 7, alt: 'Instituto tecnológico' },
            { image: 8, alt: 'Aula universitaria' },
            { image: 9, alt: 'Taller de formación técnica' },
            { image: 10, alt: 'Centro moderno de formación profesional' }
        ]
    };

    document.querySelectorAll('[data-showcase]').forEach((showcase) => {
        const slides = galleries[showcase.dataset.showcase];
        const mainImage = showcase.querySelector('[data-showcase-image]');
        const thumbs = [...showcase.querySelectorAll('[data-showcase-thumb]')];
        const dots = showcase.querySelector('[data-showcase-dots]');
        let current = 0;
        let timer;

        slides.forEach((slide, index) => {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.setAttribute('aria-label', `Ver imagen ${index + 1}`);
            dot.addEventListener('click', () => show(index, true));
            dots.appendChild(dot);
        });

        const show = (index, restart = false) => {
            current = index;
            const slide = slides[current];
            showcase.classList.add('is-changing');
            window.setTimeout(() => {
                mainImage.className = `showcase-visual carousel-slice carousel-slice-${slide.image}`;
                mainImage.setAttribute('aria-label', slide.alt);
                thumbs.forEach((thumb, position) => thumb.classList.toggle('active', position === current));
                [...dots.children].forEach((dot, position) => dot.classList.toggle('active', position === current));
                showcase.classList.remove('is-changing');
            }, 130);
            if (restart) start();
        };

        const start = () => {
            window.clearInterval(timer);
            timer = window.setInterval(() => show((current + 1) % slides.length), 6000);
        };

        thumbs.forEach((thumb, index) => thumb.addEventListener('click', () => show(index, true)));
        showcase.addEventListener('mouseenter', () => window.clearInterval(timer));
        showcase.addEventListener('mouseleave', start);
        show(0);
        start();
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.querySelector('[data-stories-carousel]');
    if (!carousel) return;
    const track = carousel.querySelector('[data-stories-track]');
    const slides = [...track.children];
    const previous = carousel.querySelector('[data-story-previous]');
    const next = carousel.querySelector('[data-story-next]');
    const dots = carousel.querySelector('[data-story-dots]');
    if (slides.length < 2 || !previous || !next || !dots) return;
    let current = 0;
    let timer;

    slides.forEach((_, index) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', `Ver comentario ${index + 1}`);
        dot.addEventListener('click', () => show(index, true));
        dots.appendChild(dot);
    });

    const show = (index, restart = false) => {
        current = (index + slides.length) % slides.length;
        track.style.transform = `translateX(-${current * 100}%)`;
        [...dots.children].forEach((dot, position) => dot.classList.toggle('active', position === current));
        if (restart) start();
    };
    const start = () => {
        window.clearInterval(timer);
        timer = window.setInterval(() => show(current + 1), 7000);
    };
    previous.addEventListener('click', () => show(current - 1, true));
    next.addEventListener('click', () => show(current + 1, true));
    carousel.addEventListener('mouseenter', () => window.clearInterval(timer));
    carousel.addEventListener('mouseleave', start);
    show(0);
    start();
});
