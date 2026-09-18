<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Carreras, instituciones y orientación vocacional para estudiantes de Bolivia.">
    <title>OrientaBo | Encuentra tu camino profesional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}"><link rel="stylesheet" href="{{ asset('css/home-showcases.css') }}"><link rel="stylesheet" href="{{ asset('css/home-hero-centered.css') }}?v=1"><link rel="stylesheet" href="{{ asset('css/home-pathway-feature.css') }}?v=2">
    <meta name=csrf-token content={{ csrf_token() }}>
    <link rel=stylesheet href={{ asset('css/chatbot.css') }}?v=2>
</head>
<body>
<header class="topbar"><div class="container nav-wrap">
    <a href="#inicio" class="logo" aria-label="OrientaBo"><span class="logo-icon">⌁</span><span>Orienta<b>Bo</b></span></a>
    <button class="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" data-menu-toggle><i></i><i></i><i></i></button>
    <nav class="main-nav" data-menu><a class="active" href="#inicio">Inicio</a><a href="{{ route(auth()->check() ? 'test.complete' : 'test.basic') }}">Test vocacional</a><a href="{{ route('careers.index') }}">Carreras</a><a href="{{ route('institutions.index') }}">Instituciones</a><a href="{{ auth()->check() ? route('opportunities.index') : route('login') }}">Oportunidades</a></nav>
    <div class="nav-actions"><x-account-actions /></div>
</div></header>
<main id="inicio">
<section class="hero"><div class="hero-glow"></div><div class="container hero-grid">
    <div class="hero-copy">
        <div class="eyebrow">TU FUTURO COMIENZA CON UNA BUENA DECISIÓN</div>
        <div class="hero-main"><h1>Encuentra el camino que<br><em>sí conecta contigo.</em></h1><p>Explora carreras, compara instituciones y descubre oportunidades de formación en Bolivia. Toda la información que necesitas para decidir con confianza, en un solo lugar.</p><div class="hero-actions"><a class="button button-accent" href="{{ route(auth()->check() ? 'test.complete' : 'test.basic') }}">Realizar test vocacional</a><a class="button button-outline" href="{{ route('careers.index') }}">Explorar carreras</a></div></div>
        <div class="hero-proof"><p><b>Orientación clara y accesible</b><br>para estudiantes de toda Bolivia</p></div>
    </div>
</div></section>
<section class="intro"><div class="container intro-grid"><div><span class="kicker">UNA GUÍA PARA TU DECISIÓN</span><h2>Elegir qué estudiar puede ser más sencillo.</h2></div><div><p>Sabemos que decidir una carrera puede generar preguntas, dudas e incluso confusión cuando no se cuenta con información clara. OrientaBo reúne información educativa confiable y herramientas prácticas para que comprendas tus opciones, reconozcas lo que conecta contigo y avances con mayor seguridad.</p><a href="#modulos">Conoce cómo te ayudamos <span>→</span></a></div></div></section>

<section class="discovery" id="modulos"><div class="container">
    <article class="pathway-feature">
        <div class="pathway-copy">
            <h2>Opciones reales para construir tu camino.</h2>
            <p>Conoce la oferta académica desde diferentes perspectivas y encuentra una alternativa alineada con tus intereses.</p>
            <nav class="pathway-links" aria-label="Módulos principales de OrientaBo">
                <a href="#test"><span class="pathway-icon violet"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3 9.8 8.8 4 11l5.8 2.2L12 19l2.2-5.8L20 11l-5.8-2.2L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg></span><b>Descubre tu vocación</b></a>
                <a href="{{ route('careers.index') }}"><span class="pathway-icon mint"><svg viewBox="0 0 24 24" fill="none"><path d="m3 9 9-5 9 5-9 5-9-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M6 11.2V16c3.6 2.7 8.4 2.7 12 0v-4.8M21 9v6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span><b>Encuentra una carrera</b></a>
                <a href="{{ route('institutions.index') }}"><span class="pathway-icon amber"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20h16M6 20V9m4 11V9m4 11V9m4 11V9M3 9h18L12 4 3 9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg></span><b>Compara instituciones</b></a>
                <a href="{{ auth()->check() ? route('opportunities.index') : route('login') }}"><span class="pathway-icon blue"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3v5m0 8v5M3 12h5m8 0h5M5.6 5.6l3.5 3.5m5.8 5.8 3.5 3.5m0-12.8-3.5 3.5m-5.8 5.8-3.5 3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg></span><b>Aprovecha nuevas oportunidades</b></a>
            </nav>
            <a class="pathway-button" href="#test">OrientaBo</a>
            <span class="pathway-kicker">EXPLORA ANTES DE DECIDIR</span>
        </div>
        <div class="pathway-mosaic"><img src="{{ asset('images/Principal.png') }}" alt="Áreas profesionales, graduación y formación académica en Bolivia"></div>
    </article>

    <article class="compact-banner test-banner" id="test">
        <div class="compact-copy"><span>ORIENTACIÓN PERSONALIZADA</span><h3>Descubre tu vocación</h3><p>Reconoce tus intereses, habilidades y las áreas profesionales relacionadas contigo.</p><a class="button button-accent" href="{{ route(auth()->check() ? 'test.complete' : 'test.basic') }}">Comenzar test <b>→</b></a></div>
        <div class="compact-media" aria-label="Espacio preparado para imagen o video del test"><div class="media-orbit"><i></i><i></i><i></i></div><small>ESPACIO PARA IMAGEN O VIDEO</small></div>
    </article>

    @php
        $showcases = [
            'careers' => ['label'=>'CARRERAS EN BOLIVIA','title'=>'Encuentra una carrera','description'=>'Explora carreras tradicionales y rutas no comunes con formación formal disponible en Bolivia. Descubre opciones que pueden interesarte y conoce los caminos educativos que tienes a tu alcance.','link'=>route('careers.index'),'linkText'=>'Explorar todas las carreras','mainStart'=>1,'thumbStart'=>1,'items'=>['Medicina','Gastronomía','Ingeniería de Sistemas','Diseño de Moda']],
            'institutions' => ['label'=>'DÓNDE PUEDES FORMARTE','title'=>'Compara instituciones','description'=>'Conoce universidades reconocidas, institutos técnicos, escuelas y academias, junto con sus programas y ubicaciones. Compara alternativas y encuentra una formación adecuada para ti.','link'=>route('institutions.index'),'linkText'=>'Conocer instituciones','mainStart'=>6,'thumbStart'=>5,'items'=>['Universidades','Institutos tecnológicos','Formación docente','Formación técnica']],
        ];
    @endphp
    @foreach($showcases as $key => $showcase)
    <article class="showcase gallery-showcase" data-showcase="{{ $key }}" aria-label="{{ $showcase['label'] }}">
        <div class="showcase-gallery">
            <div class="showcase-visual carousel-slice carousel-slice-{{ $showcase['mainStart'] }}" data-showcase-image role="img" aria-label="Imagen destacada de {{ $showcase['title'] }}"></div>
            <div class="gallery-info">
                <span class="showcase-label">{{ $showcase['label'] }}</span><h3>{{ $showcase['title'] }}</h3>
                <div class="showcase-thumbs" aria-label="Galería de referencia">@foreach($showcase['items'] as $index => $item)<span class="image-slice image-slice-{{ $showcase['thumbStart'] + $index }}" role="img" aria-label="{{ $item }}"></span>@endforeach</div>
                <p>{{ $showcase['description'] }}</p><a class="showcase-link" href="{{ $showcase['link'] }}">{{ $showcase['linkText'] }} <span>→</span></a>
            </div>
        </div>
        <div class="showcase-dots" data-showcase-dots aria-label="Progreso del carrusel"></div>
    </article>
    @endforeach

    <article class="compact-banner opportunity-banner" id="oportunidades">
        <div class="compact-copy"><span>APRENDE Y AVANZA</span><h3>Aprovecha nuevas oportunidades</h3><p>No dejes pasar la oportunidad de formarte con becas, cursos y capacitaciones verificadas.</p><a class="button button-light" href="{{ auth()->check() ? route('opportunities.index') : route('register') }}">{{ auth()->check() ? 'Ver oportunidades' : 'Registrarme para acceder' }} <b>→</b></a></div>
        <div class="compact-media" aria-label="Espacio preparado para imagen o video de oportunidades"><div class="media-cards"><i></i><i></i><i></i></div><small>ESPACIO PARA IMAGEN O VIDEO</small></div>
    </article>
</div></section>

<section class="community-stories"><div class="container">
    <div class="stories-heading"><div><span class="kicker">VOCES DE LA COMUNIDAD</span><h2>Experiencias que también pueden orientarte.</h2></div><p>Historias breves de personas que utilizaron OrientaBo para comprender mejor sus opciones. Cada comentario es revisado antes de publicarse.</p></div>
    @if(session('status'))<div class="story-status">{{ session('status') }}</div>@endif
    <div class="stories-layout">
        <div class="stories-carousel" data-stories-carousel>
            <div class="stories-track" data-stories-track>
            @forelse($communityComments as $comment)
                @php($initials = collect(explode(' ', trim($comment->user->name)))->take(2)->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))->join(''))
                <article class="story-slide"><div class="story-profile">@if($comment->user->avatar_url)<img src="{{ $comment->user->avatar_url }}" alt="Fotografía de {{ $comment->user->name }}" referrerpolicy="no-referrer">@else<b>{{ $initials }}</b>@endif<div><strong>{{ $comment->user->name }}</strong><small>Experiencia verificada</small></div></div><blockquote>{{ $comment->content }}</blockquote><footer>Compartido con la comunidad de OrientaBo</footer></article>
            @empty
                <article class="story-slide"><div class="story-profile"><b>OB</b><div><strong>Comunidad OrientaBo</strong><small>Este espacio comienza contigo</small></div></div><blockquote>Sé la primera persona en compartir cómo OrientaBo te ayudó a encontrar nuevas posibilidades.</blockquote><footer>Tu experiencia puede ayudar a alguien más</footer></article>
            @endforelse
            </div>
            @if($communityComments->count() > 1)<div class="stories-controls"><button type="button" data-story-previous aria-label="Comentario anterior">←</button><div data-story-dots></div><button type="button" data-story-next aria-label="Comentario siguiente">→</button></div>@endif
        </div>
        <aside class="share-story"><span class="kicker">COMPARTE TU RECORRIDO</span><h3>Tu experiencia puede iluminar el camino de alguien más.</h3><p>Cuéntanos qué descubriste y cómo OrientaBo te ayudó. El administrador revisará tu mensaje antes de mostrarlo públicamente.</p>
            @auth
                <form method="POST" action="{{ route('comments.store') }}">@csrf<label for="community-comment">Tu comentario</label><textarea id="community-comment" name="content" minlength="20" maxlength="700" required placeholder="Cuéntanos cómo te ayudó OrientaBo...">{{ old('content') }}</textarea>@error('content')<small class="story-error">{{ $message }}</small>@enderror<div><small>Entre 20 y 700 caracteres</small><button type="submit">Enviar comentario <span>→</span></button></div></form>
            @else
                <div class="story-login-message"><strong>Inicia sesión para dejar tu experiencia</strong><p>Los comentarios son visibles para todos, pero necesitas una cuenta para compartir el tuyo.</p><a class="button button-dark" href="{{ route('login') }}">Iniciar sesión <span>→</span></a></div>
            @endauth
        </aside>
    </div>
</div></section>
</main>
<footer class="site-footer"><div class="container"><a href="#inicio" class="logo"><span class="logo-icon">⌁</span><span>Orienta<b>Bo</b></span></a><p>Información para elegir tu futuro académico con confianza.</p><small>© {{ date('Y') }} OrientaBo</small></div></footer>
<button class="chat-button" type="button" aria-label="Abrir asistente" data-chat-toggle><i></i><span>◌</span></button><aside class="chat-preview" data-chat hidden><button data-chat-close>×</button><small>ASISTENTE VIRTUAL</small><h3>Hola, ¿en qué puedo orientarte?</h3><p>Pregúntame sobre carreras, instituciones o cómo utilizar la plataforma.</p><div>El asistente estará disponible próximamente.</div></aside>
<script src="{{ asset('js/home.js') }}" defer></script><script src="{{ asset('js/home-showcases.js') }}" defer></script>
<script src={{ asset('js/chatbot.js') }}?v=2 defer></script>
</body></html>
