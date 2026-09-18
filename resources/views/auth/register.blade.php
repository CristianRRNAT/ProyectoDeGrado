<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear cuenta | OrientaBo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}"><link rel="stylesheet" href="{{ asset('css/auth.css') }}"><link rel="stylesheet" href="{{ asset('css/google-auth.css') }}">
</head>
<body class="auth-page">
<main class="auth-layout">
    <a class="google-access floating-google" href="{{ route('google.redirect') }}"><b>G</b> Registrarme con Google</a>
    <section class="auth-brand"><a href="{{ route('home') }}" class="logo"><span class="logo-icon">⌁</span><span>Orienta<b>Bolivia</b></span></a><div><span class="auth-kicker">EMPIEZA TU RECORRIDO</span><h1>Una cuenta para construir tu futuro.</h1><p>Realiza el test completo, guarda tus avances y recibe recomendaciones vinculadas con la oferta educativa del país.</p></div><small>Tus datos se utilizarán únicamente dentro de la plataforma</small></section>
    <section class="auth-form-panel"><a class="auth-back" href="{{ route('home') }}">← Volver al inicio</a><form method="post" action="{{ route('register.store') }}" class="auth-card">@csrf<h2>Crear una cuenta</h2><p>Completa tus datos para acceder a todas las herramientas.</p><label>Nombre completo<input type="text" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus placeholder="Tu nombre y apellido">@error('name')<small>{{ $message }}</small>@enderror</label><label>Correo electrónico<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required placeholder="nombre@correo.com">@error('email')<small>{{ $message }}</small>@enderror</label><label>Contraseña<input type="password" name="password" autocomplete="new-password" required placeholder="Mínimo 8 caracteres">@error('password')<small>{{ $message }}</small>@enderror</label><label>Confirmar contraseña<input type="password" name="password_confirmation" autocomplete="new-password" required placeholder="Repite tu contraseña"></label><button type="submit">Crear mi cuenta <span>→</span></button><footer>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></footer></form>
    </section>
</main>
</body>
</html>
