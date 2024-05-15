<nav class="navbar-main main-header navbar navbar-expand navbar-dark" id="admin-header">
    <div class="navbar-main-wrapper d-flex">
        <div class="user-navbar-info">
            <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <span>{{ Auth::user()->name . ' ' . Auth::user()->surname ?? 'Invitado' }}</span>
                <img id="user-picture" src="{{ asset(Auth::user()->getPhotoUrlAttribute() ?? 'img/profile/no-avatar.png') }}"
                    alt="Imagen perfil del usuario" class="user-photo rounded-circle" width="30" height="30">
            </button>
            <ul class="dropdown-menu">
                <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('user.panel') }}"><i
                            class="bi bi-person-vcard-fill"></i>
                        Perfil
                    </a>
                </li>
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="bi bi-box-arrow-right"></i>
                            Cerrar sesión
                        </button>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('home') }}">
                        <span>
                            <i class="fi fi-rr-address-card"></i>
                            Volver a Inicio
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="toggle-sidebar-container">
            <button id="sidebar-toggle-top" class="btn">
                <i class="fi fi-br-menu-burger"></i>
            </button>
        </div>
    </div>
</nav>
@section('scripts')
    @parent
    <script>
        $(document).ready(function() {

            // Mostrar/Ocultar sidebar
            // $('#sidebar-toggle-top').click(function() {
            //     $('#sidenav-main').toggleClass('hide');
            // });

            // FUNCIONES GENÉRICAS PARA ACTUALIZAR DATOS TABLAS (desde el panel de Admin)
            function updateValue(endpoint, id, column, value) {
                $.ajax({
                    url: endpoint,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        column: column,
                        value: value
                    },
                    success: function(response) {
                        console.log(response);
                        // Recargamos para visualizar los cambios.
                        location.reload();
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // Al hacer clic sobre la celda
            $('.editable').on('click', function() {
                var select = $(this).find('.select'); // Obtenemos el select de esa celda
                var value = $(this).find('.value'); // Obtenemos el valor de esa celda
                select.show(); // Mostramos el select
                value.hide(); // Ocultamos la celda
            });

            // Al hacer foco sobre la celda
            $('.editable').on('blur', function() {
                var id = $(this).data('id'); // Obtener id del lugar
                var column = $(this).data('column'); // Obtener la columna a actualizar/editar
                var value = $(this).text(); // Obtener el valor de la celda
                var endpoint = $(this).data('endpoint'); // Obtener el endpoint para la llamada AJAX

                // Llamar a la función genérica para actualizar el valor
                updateValue(endpoint, id, column, value);
            });

            // Al cambiar el valor del select
            $('.select').on('change', function() {
                var id = $(this).closest('td').data('id'); // Obtener id del lugar
                var column = $(this).closest('td').data('column'); // Obtener la columna a actualizar/editar
                var value = $(this).val(); // Obtener el nuevo valor seleccionado
                var endpoint = $(this).closest('td').data(
                    'endpoint'); // Obtener el endpoint para la llamada AJAX

                // Llamar a la función genérica para actualizar el valor
                updateValue(endpoint, id, column, value);
            });

        });
    </script>
@endsection
