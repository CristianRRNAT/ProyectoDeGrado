document.addEventListener('DOMContentLoaded', () => {
    const app = document.querySelector('[data-complete-test]');
    if (!app) return;
    const screens = [...app.querySelectorAll('[data-screen]')];
    const cards = [...app.querySelectorAll('[data-question]')];
    const dots = [...app.querySelectorAll('[data-dot]')];
    const form = app.querySelector('[data-question-form]');
    const next = app.querySelector('[data-next]');
    const back = app.querySelector('[data-back]');
    let current = 0;
    const showScreen = name => screens.forEach(screen => { const active = screen.dataset.screen === name; screen.hidden = !active; screen.classList.toggle('is-active', active); });
    const refresh = () => {
        cards.forEach((card, index) => { card.hidden = index !== current; card.classList.toggle('current', index === current); });
        dots.forEach((dot, index) => { dot.classList.toggle('current', index === current); dot.classList.toggle('completed', index < current || !!cards[index].querySelector('input:checked')); });
        app.querySelector('[data-current]').textContent = current + 1;
        app.querySelector('[data-percent]').textContent = `${Math.round(((current + 1) / cards.length) * 100)}%`;
        back.disabled = current === 0;
        next.disabled = !cards[current].querySelector('input:checked');
        const isLastQuestion = current === cards.length - 1;
        next.classList.toggle('is-result-button', isLastQuestion);
        next.innerHTML = isLastQuestion ? 'Obtener mi resultado <span>→</span>' : 'Siguiente <span>→</span>';
    };
    app.querySelector('[data-start]').addEventListener('click', () => { showScreen('questions'); refresh(); window.scrollTo({top: 0, behavior: 'smooth'}); });
    cards.forEach(card => card.addEventListener('change', () => { next.disabled = false; }));
    next.addEventListener('click', () => { if (!cards[current].querySelector('input:checked')) return; if (current === cards.length - 1) { next.disabled = true; next.textContent = 'Analizando tus respuestas…'; form.submit(); return; } current++; refresh(); });
    back.addEventListener('click', () => { if (current > 0) { current--; refresh(); } });
});
