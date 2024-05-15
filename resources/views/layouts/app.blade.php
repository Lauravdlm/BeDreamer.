<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('partials.head')

<body>
    @include('partials.header')
    <!-- Contenido principal de la página -->
    <main id="app">
        {{-- Toasts --}}
        @include('partials.toasts')
        @yield('content')
        @include('partials.footer')
    </main>
    @yield('scripts') <!-- Aquí se incluirá la sección de scripts -->
</body>

</html>
<script>
    $(document).ready(function() {

        var timeoutId;
        // Función para obtener valores deseados en el buscador dinámico de Destinos, Actividades, Restaurantes y Hoteles
        $('#searchInput').on('input', function() {
            var query = $(this).val(); // Obtener el valor del input

            if (query.length >= 3) { // Al ser mayor de tres caracteres
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    $.ajax({ // Llamada Ajax al servidor
                        url: '/search',
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            // console.log(response);
                            var optionsHTML = '';
                            $.each(response, function(index, search) {
                                optionsHTML +=
                                    '<div class="option-item" data-value="' +
                                    search.id + '">' +
                                    '<span class="p-name">' + search.name +
                                    '</span>' +
                                    '</div>';
                            });
                            $('#searchOptionsContainer').html(optionsHTML).show();

                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }, 300);
            } else {
                // Ocultar el contenedor si se borran caracteres y/o quedan menos de tres
                $('#searchOptionsContainer').empty().hide();
                $('#searchSelect').show(); // Mostrar el select
            }
        });

        // Función que se ejecuta al seleccionar una opción de las opciones obtenidas en el buscador
        $('#searchOptionsContainer').on('click', '.option-item', function() {
            var selectedOption = $(this).data('value'); // Obtenemos el valor de la selección
            if (selectedOption) {
                var searchType = selectedOption.split('-')[0]; // Obtener el tipo de búsqueda
                var id = selectedOption.split('-')[1]; // Obtener su ID
                // Dependiendo del tipo de búsqueda redirigiremos a su página principal
                var url = searchType === 'place' ? "{{ route('place.show', ':id') }}" :
                    searchType === 'activity' ? "{{ route('activity.show', ':id') }}" :
                    searchType === 'hotel' ? "{{ route('hotel.show', ':id') }}" :
                    searchType === 'restaurant' ? "{{ route('restaurant.show', ':id') }}" :
                    "{{ route('home') }}";
                url = url.replace(':id', id);
                window.location.href = url;
            }
        });
    });
</script>
