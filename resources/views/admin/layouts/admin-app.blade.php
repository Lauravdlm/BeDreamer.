<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('partials.head')

<body class="wrapper">
    @include('admin.partials.header')

    <!-- Contenido principal de la página -->
    <main id="admin-backoffice">
        @include('admin.partials.aside')
        {{-- Toasts --}}
        @include('partials.toasts')

        @yield('admin-content')
    </main>
    @yield('scripts') <!-- Aquí se incluirá la sección de scripts genéricos -->
</body>

</html>
<script>
    // Mostrar/Ocultar sidebar
    $('#sidebar-toggle-top').click(function() {
        $('#sidenav-main').toggleClass('hide');
    });
</script>
