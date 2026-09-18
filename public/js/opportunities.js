(() => {
    const styles = document.createElement('link');
    styles.rel = 'stylesheet'; styles.href = '/css/opportunities-enhancements.css';
    document.head.appendChild(styles);
    const modal = document.getElementById('submission-modal');
    if (!modal) return;
    const toggle = open => {
        modal.classList.toggle('is-open', open);
        modal.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.body.classList.toggle('modal-open', open);
        if (open) setTimeout(() => modal.querySelector('input')?.focus(), 80);
    };
    document.querySelector('[data-open-submission]')?.addEventListener('click', () => toggle(true));
    modal.querySelectorAll('[data-close-submission]').forEach(el => el.addEventListener('click', () => toggle(false)));
    document.addEventListener('keydown', e => e.key === 'Escape' && toggle(false));
    if (modal.classList.contains('is-open')) document.body.classList.add('modal-open');
})();
