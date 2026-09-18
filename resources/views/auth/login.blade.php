<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | OrientaBo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}"><link rel="stylesheet" href="{{ asset('css/auth.css') }}"><link rel="stylesheet" href="{{ asset('css/google-auth.css') }}">
</head>
<body class="auth-page">
<main class="auth-layout">
    <a class="google-access floating-google" href="{{ route('google.redirect') }}"><b>G</b> Continuar con Google</a>
    <section class="auth-brand"><a href="{{ route('home') }}" class="logo"><span class="logo-icon">⌁</span><span>Orienta<b>Bolivia</b></span></a><div><span class="auth-kicker">TU CAMINO CONTINÚA</span><h1>Vuelve a descubrir nuevas posibilidades.</h1><p>Accede al test vocacional completo, conserva tus resultados y continúa explorando carreras e instituciones.</p></div><small>Orientación educativa para estudiantes de Bolivia</small></section>
    <section class="auth-form-panel"><a class="auth-back" href="{{ route('home') }}">← Volver al inicio</a><form method="post" action="{{ route('login.store') }}" class="auth-card">@csrf<h2>Iniciar sesión</h2><p>Ingresa los datos con los que creaste tu cuenta.</p>@if(session('status'))<div class="auth-success">{{ session('status') }}</div>@endif<label>Correo electrónico<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="nombre@correo.com">@error('email')<small>{{ $message }}</small>@enderror</label><label>Contraseña<input type="password" name="password" autocomplete="current-password" required placeholder="Tu contraseña">@error('password')<small>{{ $message }}</small>@enderror</label><label class="remember"><input type="checkbox" name="remember" value="1"><span>Recordar mi sesión</span></label><button type="submit">Ingresar <span>→</span></button><footer>¿Aún no tienes una cuenta? <a href="{{ route('register') }}">Créala aquí</a></footer></form>
    </section>
</main>
</body>
</html>
