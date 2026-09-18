<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Test vocacional básico para descubrir intereses y áreas profesionales.">
    <title>Test vocacional básico | OrientaBo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}"><link rel="stylesheet" href="{{ asset('css/vocational-test.css') }}"><link rel="stylesheet" href="{{ asset('css/test-account-invitation.css') }}"><link rel="stylesheet" href="{{ asset('css/vocational-test-cover.css') }}">
</head>
<body class="test-page">
<header class="test-header"><div class="test-container"><a href="{{ route('home') }}" class="logo"><span class="logo-icon">⌁</span><span>Orienta<b>Bolivia</b></span></a><a class="exit-test" href="{{ route('home') }}">Salir del test <span>×</span></a></div></header>

<main class="test-shell" data-test-app data-profiles='@json($profiles)'>
    <section class="welcome-screen is-active" data-screen="welcome">
        <div class="welcome-art" aria-hidden="true"><img src="{{ asset('images/Test Vocacional.jpg') }}" alt=""></div>
        <div class="welcome-copy"><span class="test-kicker">TEST VOCACIONAL BÁSICO</span><h1>Te ayudaremos a encontrar un camino que conecte contigo.</h1><p>No necesitas tener todas las respuestas. Solo elige cuánto se parece cada frase a ti y descubre las áreas que mejor representan tus intereses.</p>
            <div class="test-details"><div><span>18</span><p><b>Preguntas breves</b><small>Una a la vez</small></p></div><div><span>5</span><p><b>Minutos aprox.</b><small>Sin registro</small></p></div><div><span>✓</span><p><b>Resultado inmediato</b><small>Orientación inicial</small></p></div></div>
            <div class="account-invitation"><span>✦</span><div><b>¿Quieres una orientación más completa?</b><p>Inicia sesión para acceder al test extendido, guardar tus resultados y descargar tu informe en PDF.</p></div><a href="{{ auth()->check() ? route('test.complete') : route('login') }}">{{ auth()->check() ? 'Ir al test completo' : 'Iniciar sesión' }} →</a></div>
            <button class="start-button" type="button" data-start>Continuar con el test básico <span>→</span></button><small class="privacy-note">Tus respuestas no serán almacenadas en esta versión básica.</small>
        </div>
    </section>

    <section class="questions-screen" data-screen="questions" hidden>
        <div class="progress-header"><div><span>MI RECORRIDO</span><b>Pregunta <i data-current>1</i> de {{ count($questions) }}</b></div><strong data-percent>6%</strong></div>
        <div class="progress-track" aria-label="Progreso del test">@foreach($questions as $question)<button type="button" class="progress-dot {{ $loop->first ? 'current' : '' }}" tabindex="-1" aria-label="Pregunta {{ $loop->iteration }}" data-dot="{{ $loop->index }}"><span>{{ $loop->iteration }}</span></button>@endforeach</div>
        <form data-question-form>
            @foreach($questions as $question)
                <fieldset class="question-card {{ $loop->first ? 'current' : '' }}" data-question="{{ $loop->index }}" data-type="{{ $question['type'] }}" @if(!$loop->first) hidden @endif>
                    <legend><small>¿CUÁNTO SE PARECE A TI?</small><span>{{ $question['text'] }}</span></legend>
                    <div class="answer-grid">
                        <label><input type="radio" name="question_{{ $loop->index }}" value="0"><span><i>○</i><b>Nada</b><small>No me representa</small></span></label>
                        <label><input type="radio" name="question_{{ $loop->index }}" value="1"><span><i>◔</i><b>Un poco</b><small>Rara vez</small></span></label>
                        <label><input type="radio" name="question_{{ $loop->index }}" value="2"><span><i>◕</i><b>Bastante</b><small>Muchas veces</small></span></label>
                        <label><input type="radio" name="question_{{ $loop->index }}" value="3"><span><i>●</i><b>Mucho</b><small>Me representa</small></span></label>
                    </div>
                </fieldset>
            @endforeach
            <div class="question-controls"><button type="button" class="back-button" data-back disabled>← Anterior</button><p>Elige la respuesta más sincera, no la que parece “correcta”.</p><button type="button" class="next-button" data-next disabled>Siguiente <span>→</span></button></div>
        </form>
    </section>

    <section class="result-screen" data-screen="result" hidden>
        <div class="result-heading"><span class="test-kicker">TU ORIENTACIÓN INICIAL</span><h1>Tu perfil combina <em data-primary-name></em> y <em data-secondary-name></em>.</h1><p>Estas áreas reflejan los intereses que destacaron en tus respuestas.</p></div>
        <div class="result-grid"><article class="profile-card primary-profile"><span>ÁREA PRINCIPAL</span><div class="profile-symbol" data-primary-letter></div><h2 data-primary-title></h2><strong data-primary-phrase></strong><p data-primary-description></p></article><article class="scores-card"><span>TU MAPA DE INTERESES</span><div data-score-bars></div></article></div>
        <div class="recommendations"><article><span>FORTALEZAS QUE DESTACAN</span><div class="strength-list" data-strengths></div></article><article><span>CARRERAS PARA EXPLORAR</span><div class="career-chips" data-careers></div></article></div>
        <div class="result-note"><span>i</span><p><b>Este resultado es una guía inicial.</b> No determina una única carrera ni reemplaza el acompañamiento de un profesional en orientación vocacional.</p></div>
        <div class="result-upgrade"><div><span>✦</span><div><b>Profundiza en tu resultado</b><p>Con una cuenta podrás realizar el test completo, conservar tu historial y descargar un informe detallado en PDF.</p></div></div><a href="{{ auth()->check() ? route('test.complete') : route('login') }}" class="start-button">{{ auth()->check() ? 'Realizar test completo' : 'Iniciar sesión' }} <span>→</span></a></div>
        <div class="result-actions"><button type="button" class="back-button" data-restart>↻ Repetir el test</button><a class="next-button" href="{{ route('home') }}#carreras">Explorar carreras <span>→</span></a></div>
    </section>
</main>
<script src="{{ asset('js/vocational-test.js') }}" defer></script>
</body></html>
