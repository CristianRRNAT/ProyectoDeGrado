<section class="institution-profile-layout" aria-label="Información institucional complementaria">
    <article class="institution-admission-card">
        <span class="institution-profile-label">ADMISIÓN</span>
        <div class="admission-mark" aria-hidden="true">A</div>
        <h3>Modalidad de admisión</h3>
        <p>{{ $institutionProfile['admission'] }}</p>
    </article>

    <div class="institution-profile-list">
        <article class="institution-profile-row institution-verification-row">
            <div class="profile-row-media ministry-media">
                <img src="{{ asset('images/Instituciones/ministerio-educacion-bolivia.png') }}" alt="Ministerio de Educación del Estado Plurinacional de Bolivia">
            </div>
            <div>
                <span class="institution-profile-label">RECONOCIMIENTO</span>
                <h3>{{ $institutionProfile['verification_label'] }}</h3>
                <p>{{ $institution->is_verified ? 'Institución contrastada con registros y fuentes oficiales de educación superior.' : $institutionProfile['verification'] }}</p>
            </div>
        </article>

        <article class="institution-profile-row">
            <div class="profile-row-media graduation-media" aria-hidden="true">
                <img src="{{ asset('images/Instituciones/graduation-cap-color.svg') }}" alt="">
            </div>
            <div>
                <span class="institution-profile-label">TITULACIÓN</span>
                <h3>Niveles y modalidades</h3>
                <p>{{ Str::limit($institutionProfile['graduation'], 210) }}</p>
            </div>
        </article>
    </div>

    <div class="institution-mini-cards">
    <article class="institution-mini-card schedule-card">
        <svg viewBox="0 0 64 64" aria-hidden="true"><circle cx="32" cy="32" r="23"/><path d="M32 18v15l11 7"/></svg>
        <div><span class="institution-profile-label">HORARIOS</span><h3>{{ $institutionProfile['schedule'] }}</h3><p>El turno puede variar según carrera y sede.</p></div>
    </article>

    <article class="institution-mini-card cost-card">
        <svg viewBox="0 0 64 64" aria-hidden="true"><ellipse cx="32" cy="18" rx="19" ry="8"/><path d="M13 18v12c0 4 9 8 19 8s19-4 19-8V18M13 30v12c0 4 9 8 19 8s19-4 19-8V30"/><path d="M32 13v10M27 17h9"/></svg>
        <div><span class="institution-profile-label">COSTO</span><h3>{{ $institution->payment_type ?? 'Consultar' }}</h3><p>{{ Str::limit($institution->cost_notes ?: 'Consulta aranceles, matrícula y otros gastos directamente con la institución.', 105) }}</p></div>
    </article>
    </div>
</section>
<style>
@media (min-width: 901px) {
    .institution-content > .container.content-grid {
        width: min(1320px, calc(100% - 48px));
        max-width: none;
        grid-template-columns: minmax(0, 2.05fr) minmax(300px, .85fr);
        gap: 24px;
    }
    .institution-profile-layout {
        grid-template-columns: minmax(300px, .95fr) minmax(0, 1.55fr);
        gap: 13px;
    }
    .institution-admission-card { min-height: 210px; padding: 22px; }
    .institution-profile-list { gap: 8px; }
    .institution-profile-row {
        min-height: 101px;
        padding: 9px 11px;
        grid-template-columns: 118px minmax(0, 1fr);
        gap: 13px;
    }
    .profile-row-media { height: 82px; }
    .ministry-media { padding: 6px; }
    .graduation-media svg { width: 48px; height: 48px; }
    .graduation-media img { width: 64px; height: 64px; object-fit: contain; }
    .institution-profile-row h3 { margin: 4px 0; font-size: 14px; }
    .institution-profile-row p { font-size: 9px; line-height: 1.4; }
    .institution-mini-card { min-height: 108px; padding: 15px 20px; }
    .institution-mini-card > svg { width: 50px; height: 50px; }
    .institution-mini-card h3 { margin: 4px 0; font-size: 14px; }
}
@media (min-width: 901px) and (max-width: 1120px) {
    .institution-content > .container.content-grid {
        width: calc(100% - 40px);
        grid-template-columns: minmax(0, 1fr) 300px;
    }
    .institution-profile-row { grid-template-columns: 100px minmax(0, 1fr); }
}
@media (min-width: 761px) {
    .institution-mini-cards {
        grid-column: 1 / -1;
        display: flex;
        align-items: stretch;
        gap: 14px;
    }
    .institution-mini-cards .institution-mini-card { flex: 0 0 225px; }
}
@media (max-width: 760px) {
    .institution-mini-cards { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
}
@media (max-width: 520px) {
    .institution-mini-cards { grid-template-columns: 1fr; }
}
#oferta {
    background: #121212;
    border-color: #2d302f;
    color: #fff;
}
#oferta .section-kicker { color: #58d9ae; }
#oferta h2,
#oferta h3,
#oferta strong { color: #fff; }
#oferta .accordion-help,
#oferta .unit-body > p,
#oferta .career-offering > summary small,
#oferta .offering-details > p,
#oferta .empty-offer { color: #aeb5b2; }
#oferta .count-badge,
#oferta .academic-unit > summary > b {
    background: #273c36;
    color: #69dfb9;
}
#oferta .academic-unit {
    border-color: #303332;
    background: #181818;
}
#oferta .academic-unit > summary {
    background: #181818;
}
#oferta .academic-unit > summary:hover,
#oferta .career-offering > summary:hover { background: #242725; }
#oferta .academic-unit > summary small,
#oferta .expand-label,
#oferta .offering-details > a { color: #58d9ae; }
#oferta .unit-body { background: #161616; }
#oferta .career-offering { border-color: #303332; }
#oferta .offering-details {
    background: #202220;
    color: #fff;
    grid-template-columns: repeat(5, minmax(0, 1fr));
}
#oferta .offering-details small { color: #8f9995; }
#oferta .offering-details .demand {
    background: #f2c94c;
    color: #171817;
    border: 1px solid #ffdc70;
    font-weight: 800;
}
#oferta .single-program {
    background: #191b1a;
    border-color: #303332;
}
#oferta .single-program h3 { color: #fff; }
#oferta .single-program p { color: #aeb5b2; }
.general-offering-summary {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    margin-top: 14px;
    overflow: hidden;
    border: 1px solid #303332;
    border-radius: 9px;
    background: #202220;
}
.general-offering-fact { min-width: 0; padding: 15px 13px; border-right: 1px solid #343735; }
.general-offering-fact:last-child { border-right: 0; }
.general-offering-fact small { display: block; margin-bottom: 6px; color: #58d9ae; font-size: 7px; font-weight: 800; letter-spacing: 1px; }
.general-offering-fact strong { display: block; color: #fff; font: 800 10px/1.35 Manrope, sans-serif; overflow-wrap: anywhere; }
#oferta .specialty-grid span,
#oferta .specialty-grid a {
    background: #242625;
    border-color: #343735;
    color: #65dcb6;
}
.institution-hero .back-link {
    align-self: flex-start;
    width: auto;
    max-width: max-content;
    padding: 8px 14px;
    white-space: nowrap;
}
.map-section .map-heading h2 {
    max-width: 760px;
    margin: 8px 0 7px;
    color: #102e28;
    font-family: Inter, Arial, sans-serif;
    font-size: clamp(28px, 3vw, 38px);
    font-weight: 800;
    line-height: 1.08;
    letter-spacing: -1.35px;
    text-wrap: balance;
}
.map-place-card {
    width: min(315px, calc(100% - 24px));
    padding: 16px 18px;
    gap: 0;
    border: 1px solid rgba(20, 35, 30, .1);
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
}
.map-place-icon { display: none !important; }
.map-place-card strong { font: 800 14px/1.3 Manrope; }
.map-place-card span { margin-top: 6px; font-size: 10px; }
.map-place-card a { margin-top: 10px; color: #087b5d; }
.contact-address > i {
    width: 31px !important;
    height: 31px;
    flex: 0 0 31px;
    display: grid;
    place-items: center;
    border-radius: 9px;
    background: #e0f5ed;
}
.contact-address > i svg {
    width: 17px;
    height: 17px;
    fill: none;
    stroke: #087b5d;
    stroke-width: 1.8;
}
.contact-phone > i {
    width: 31px !important;
    height: 31px;
    flex: 0 0 31px;
    display: grid;
    place-items: center;
    border-radius: 9px;
    background: #e8f0ff;
}
.contact-phone > i svg {
    width: 17px;
    height: 17px;
    fill: none;
    stroke: #2563a8;
    stroke-width: 1.65;
    stroke-linecap: round;
    stroke-linejoin: round;
}
.institution-socials {
    margin-top: 22px;
    padding: 18px;
    border: 1px solid #e0e6e3;
    border-radius: 10px;
    background: #f6f8f7;
}
.institution-socials > small {
    display: block;
    margin-bottom: 12px;
    color: #74837e;
    font-size: 8px;
    font-weight: 800;
    letter-spacing: 1.3px;
}
.social-links { display: flex; flex-wrap: wrap; gap: 9px; }
.social-links a {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 10px;
    border-radius: 8px;
    color: #fff;
    font-size: 9px;
    font-weight: 800;
}
.social-links a svg { width: 16px; height: 16px; fill: currentColor; }
.social-whatsapp { background: #168f4e; }
.social-facebook { background: #1877f2; }
.social-tiktok { background: #151515; }
.social-links a:hover { transform: translateY(-1px); filter: brightness(1.05); }
.social-links p { margin: 0; color: #78837f; font-size: 10px; }
.source-unavailable {
    margin-left: auto;
    padding: 10px 13px;
    border: 1px solid #d9dfdc;
    border-radius: 7px;
    color: #78837f;
    font-size: 9px;
    font-weight: 800;
}
.institution-campus-list .specialty-grid a { cursor: pointer; transition: background .2s,color .2s,border-color .2s,transform .2s; }
.institution-campus-list .specialty-grid a:hover,
.institution-campus-list .specialty-grid a.is-selected { background:#171817; border-color:#171817; color:#fff; transform:translateY(-1px); }
.institution-campus-list .specialty-grid a:hover small,
.institution-campus-list .specialty-grid a.is-selected small { color:#b8c2be; }
.campus-show-all {
    margin-top: 14px;
    padding: 11px 16px;
    border: 1px solid #202220;
    border-radius: 8px;
    background: #202220;
    color: #fff;
    font: 800 10px/1 Manrope, sans-serif;
    cursor: pointer;
}
.campus-show-all:hover { background: #087b5d; border-color: #087b5d; }
.campus-modal[hidden] { display: none; }
.campus-modal {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: grid;
    place-items: center;
    padding: 24px;
    background: rgba(5, 9, 8, .72);
    backdrop-filter: blur(7px);
}
.campus-modal-dialog {
    width: min(820px, 100%);
    max-height: min(720px, 88vh);
    overflow: auto;
    padding: 26px;
    border: 1px solid #303432;
    border-radius: 16px;
    background: #171817;
    box-shadow: 0 28px 80px rgba(0,0,0,.42);
}
.campus-modal-header { display: flex; justify-content: space-between; gap: 20px; align-items: flex-start; margin-bottom: 20px; }
.campus-modal-header small { color: #58d9ae; font-size: 8px; font-weight: 800; letter-spacing: 1.5px; }
.campus-modal-header h3 { margin: 6px 0 0; color: #fff; font: 800 25px/1.15 Manrope, sans-serif; }
.campus-modal-close { width: 38px; height: 38px; border: 1px solid #3a3e3c; border-radius: 50%; background: #242625; color: #fff; font-size: 25px; cursor: pointer; }
.campus-modal-grid { display: grid; grid-template-columns: repeat(2,minmax(0,1fr)); gap: 10px; }
.campus-modal-item { display: grid; gap: 5px; padding: 15px 16px; text-align: left; border: 1px solid #303432; border-radius: 9px; background: #202220; color: #fff; cursor: pointer; }
.campus-modal-item b { font: 800 11px/1.3 Manrope, sans-serif; }
.campus-modal-item small { color: #aeb7b3; font-size: 9px; }
.campus-modal-item:hover { border-color: #58d9ae; background: #28302d; transform: translateY(-1px); }
body.campus-modal-open { overflow: hidden; }
[data-institution-address] span { display:inline; }
[data-address-line] { color:#142d27; }
[data-address-location] { color:#66736f; font-weight:600; }
@media (max-width: 600px) {
    .source-unavailable { margin-left: 0; }
    .campus-modal { padding: 12px; }
    .campus-modal-dialog { padding: 19px; }
    .campus-modal-grid { grid-template-columns: 1fr; }
}
@media (max-width: 780px) {
    #oferta .offering-details { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .general-offering-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .general-offering-fact { border-bottom: 1px solid #343735; }
}
@media (max-width: 440px) {
    #oferta .offering-details { grid-template-columns: 1fr; }
    .general-offering-summary { grid-template-columns: 1fr; }
    .general-offering-fact { border-right: 0; }
}
</style>
