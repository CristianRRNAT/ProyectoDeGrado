<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test vocacional completo | OrientaBo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}"><link rel="stylesheet" href="{{ asset('css/vocational-test.css') }}"><link rel="stylesheet" href="{{ asset('css/complete-test.css') }}"><link rel="stylesheet" href="{{ asset('css/vocational-test-cover.css') }}?v=2">
</head>
<body class="test-page">
<header class="test-header"><div class="test-container"><a href="{{ route('home') }}" class="logo"><span class="logo-icon">⌁</span><span>Orienta<b>Bolivia</b></span></a><a class="exit-test" href="{{ route('home') }}">Guardar para después <span>×</span></a></div></header>
<main class="test-shell" data-complete-test>
    <section class="welcome-screen is-active" data-screen="welcome">
        <div class="welcome-art" aria-hidden="true"><img src="{{ asset('images/Test Vocacional.jpg') }}" alt=""></div>
        <div class="welcome-copy"><span class="test-kicker">TEST VOCACIONAL COMPLETO</span><h1>Hola, {{ Str::words($user->name, 1, '') }}. Vamos a descubrir los caminos que conectan contigo.</h1><p>Responde con sinceridad pensando en lo que disfrutas, no en lo que otras personas esperan de ti. No existen respuestas buenas o malas.</p>
            <div class="test-details"><div><span>30</span><p><b>Preguntas</b><small>Una a la vez</small></p></div><div><span>10</span><p><b>Minutos aprox.</b><small>A tu ritmo</small></p></div><div><span>5</span><p><b>Recomendaciones</b><small>Informe personal</small></p></div></div>
            <div class="complete-instructions"><b>Antes de comenzar</b><ul><li>Piensa en tus preferencias actuales.</li><li>Evita responder según el prestigio o salario de una carrera.</li><li>El resultado es una guía para investigar, no una decisión definitiva.</li></ul></div>
            <button class="start-button" type="button" data-start>Comenzar mi recorrido <span>→</span></button>
        </div>
    </section>
    <section class="questions-screen" data-screen="questions" hidden>
        <div class="progress-header"><div><span>MI RECORRIDO PERSONAL</span><b>Pregunta <i data-current>1</i> de {{ count($questions) }}</b></div><strong data-percent>3%</strong></div>
        <div class="progress-track" aria-label="Progreso del test">@foreach($questions as $question)<button type="button" class="progress-dot {{ $loop->first ? 'current' : '' }}" tabindex="-1" aria-label="Pregunta {{ $loop->iteration }}" data-dot="{{ $loop->index }}"><span>{{ $loop->iteration }}</span></button>@endforeach</div>
        <form method="post" action="{{ route('test.complete.store') }}" data-question-form>@csrf
            @foreach($questions as $question)<section class="question-card complete-question-card {{ $loop->first ? 'current' : '' }}" data-question="{{ $loop->index }}" @if(!$loop->first) hidden @endif><div class="question-frame-top"><span>PREFERENCIAS E INTERESES</span></div><div class="question-prompt"><small>INDICA CUÁNTO TE REPRESENTA</small><div class="question-white-panel"><span>{{ $question['text'] }}</span><div class="answer-grid"><label><input type="radio" name="answers[{{ $loop->index }}]" value="0"><span><i>○</i><b>Nada</b><small>No me representa</small></span></label><label><input type="radio" name="answers[{{ $loop->index }}]" value="1"><span><i>◔</i><b>Un poco</b><small>Rara vez</small></span></label><label><input type="radio" name="answers[{{ $loop->index }}]" value="2"><span><i>◕</i><b>Bastante</b><small>Muchas veces</small></span></label><label><input type="radio" name="answers[{{ $loop->index }}]" value="3"><span><i>●</i><b>Mucho</b><small>Me representa</small></span></label></div></div></div></section>@endforeach
            <div class="question-controls"><button type="button" class="back-button" data-back disabled>← Anterior</button><p>Tu primera reacción suele ser la respuesta más sincera.</p><button type="button" class="next-button" data-next disabled>Siguiente <span>→</span></button></div>
        </form>
    </section>
</main>
<script src="{{ asset('js/complete-test.js') }}" defer></script>
</body>
</html>
