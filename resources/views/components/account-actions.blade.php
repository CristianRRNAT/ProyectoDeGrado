@auth
    @if(auth()->user()->is_admin)<a class="account-name" href="{{ route('admin.dashboard') }}">Administración</a>@endif
    <a class="account-name" href="{{ route('test.complete') }}">Mi test completo</a>
    <form method="post" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="account-logout">Cerrar sesión</button>
    </form>
@else
    <a href="{{ route('login') }}">Iniciar sesión</a>
    <a href="{{ route('register') }}" class="button button-light">Crear cuenta</a>
@endauth
