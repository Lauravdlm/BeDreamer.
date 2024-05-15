<header class="header-wrapper" id="main-header">
    <div class="header-top-side d-flex">
        <div class="navbar d-flex">
            <div class="logo-column">
                <div class="component-logo" data-component-id="logo">
                    <div class="site-branding">
                        {{-- <a href="/home" class="custom-logo-link" rel="home" aria-current="page">
                            <img src="{{ asset('img/logo.png') }}" class="custom-logo" alt="BeDreamer">
                        </a> --}}
                        <h1 class="site-title tada">
                            <a href="{{ route('home') }}" rel="home">BeDreamer</a>
                        </h1>
                    </div>
                </div>
            </div>

            <div class="navbar-right-side d-flex">
                <div class="users-login-container" id="users-options-wrapper">
                    <div id="options-list" class="options-list">
                        <!--  Componente Vue LoginModal - Opciones de usuario - Iniciar sesión -->
                        <user-option></user-option>
                        <!-- Componente Vue RegisterModal - Crear usuario -->
                        <register-component></register-component>
                    </div>
                </div>
                @if (Auth::check() && Auth::user()->role_id === 1)
                    <div class="options-list">
                        <a href="{{ route('admin.index') }}" class="btn">
                            <span title="Ir al panel de administración">
                                <i class="fi fi-ss-admin-alt admin-i-btn"></i>
                            </span>
                        </a>
                    </div>
                @endif
                <div id="burgermenu">
                    <nav class="navbar navbar-expand-lg">
                        <!-- Componente Vue BurgerMenu -->
                        <burger-menu></burger-menu>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="header-botton-side">
        <!-- Incluye el componente de búsqueda -->
        @include('partials.searchbox')
    </div>
</header>
