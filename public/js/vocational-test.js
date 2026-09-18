document.addEventListener('DOMContentLoaded', () => {
    const app = document.querySelector('[data-test-app]');
    if (!app) return;

    const screens = [...app.querySelectorAll('[data-screen]')];
    const cards = [...app.querySelectorAll('[data-question]')];
    const dots = [...app.querySelectorAll('[data-dot]')];
    const profiles = JSON.parse(app.dataset.profiles);
    const nextButton = app.querySelector('[data-next]');
    const backButton = app.querySelector('[data-back]');
    let current = 0;

    const showScreen = name => screens.forEach(screen => {
        const active = screen.dataset.screen === name;
        screen.hidden = !active;
        screen.classList.toggle('is-active', active);
    });

    const refreshQuestion = () => {
        cards.forEach((card, index) => {
            card.hidden = index !== current;
            card.classList.toggle('current', index === current);
        });
        dots.forEach((dot, index) => {
            dot.classList.toggle('current', index === current);
            dot.classList.toggle('completed', index < current || Boolean(cards[index].querySelector('input:checked')));
        });
        app.querySelector('[data-current]').textContent = current + 1;
        app.querySelector('[data-percent]').textContent = `${Math.round(((current + 1) / cards.length) * 100)}%`;
        backButton.disabled = current === 0;
        nextButton.disabled = !cards[current].querySelector('input:checked');
        nextButton.innerHTML = current === cards.length - 1 ? 'Ver mi resultado <span>→</span>' : 'Siguiente <span>→</span>';
    };

    const showResult = () => {
        const scores = { R: 0, I: 0, A: 0, S: 0, E: 0, C: 0 };
        cards.forEach(card => scores[card.dataset.type] += Number(card.querySelector('input:checked').value));
        const ranking = Object.entries(scores).sort((a, b) => b[1] - a[1]);
        const [primaryKey, primaryScore] = ranking[0];
        const [secondaryKey] = ranking[1];
        const primary = profiles[primaryKey];
        const secondary = profiles[secondaryKey];

        app.querySelector('[data-primary-name]').textContent = primary.name;
        app.querySelector('[data-secondary-name]').textContent = secondary.name;
        app.querySelector('[data-primary-letter]').textContent = primaryKey;
        app.querySelector('[data-primary-title]').textContent = primary.name;
        app.querySelector('[data-primary-phrase]').textContent = primary.phrase;
        app.querySelector('[data-primary-description]').textContent = primary.description;
        app.querySelector('[data-strengths]').innerHTML = primary.strengths.map(item => `<span>✓ ${item}</span>`).join('');
        app.querySelector('[data-careers]').innerHTML = [...primary.careers, ...secondary.careers.slice(0, 2)].map(item => `<span>${item}</span>`).join('');

        const maxScore = 9;
        app.querySelector('[data-score-bars]').innerHTML = ranking.map(([key, score]) => `<div class="score-row"><div><b>${profiles[key].name}</b><span>${score}/${maxScore}</span></div><i><span style="width:${(score / maxScore) * 100}%"></span></i></div>`).join('');
        showScreen('result');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    app.querySelector('[data-start]').addEventListener('click', () => { showScreen('questions'); refreshQuestion(); });
    cards.forEach(card => card.addEventListener('change', () => { nextButton.disabled = false; }));
    nextButton.addEventListener('click', () => {
        if (!cards[current].querySelector('input:checked')) return;
        if (current === cards.length - 1) return showResult();
        current++; refreshQuestion();
    });
    backButton.addEventListener('click', () => { if (current > 0) { current--; refreshQuestion(); } });
    app.querySelector('[data-restart]').addEventListener('click', () => {
        app.querySelector('form').reset(); current = 0; showScreen('welcome'); window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
