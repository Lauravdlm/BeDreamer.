<div class="filter-container blog-filter-container">
    <form id="blog-filter" class="blog-filter filter" method="get" action="{{ route('blogs.index') }}">
        @csrf
        <fieldset>
            <leyend>
                <i class="bi bi-funnel-fill"></i>
                Seleccione filtros para refinar su búsqueda (ingrese al menos tres
                carácteres)
            </leyend>
            <div class="form-group-container">
                <div class="form-group-inputs">
                    <div class="form-group">
                        <input type="text" class="form-control" id="place_name" name="place_name"
                            placeholder="Destino" minlength="3">
                        <select class="form-control" id="place_select" name="place_id" style="display: none;"></select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="city_name" name="city_name" placeholder="Ciudad"
                            minlength="3">
                        <select class="form-control" id="city_select" style="display: none;" name="city_id"></select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="country_name" name="country_name"
                            placeholder="Pais" minlength="3">
                        <select class="form-control" id="country_select" style="display: none;"
                            name="country_id"></select>
                    </div>
                </div>
                <a href="{{ route('blogs.index') }}" class="btn btn-danger"><i
                    class="fi fi-sr-undo"></i>
                </a>
                <button type="submit" class="submit btn yellow-button">Filtrar</button>
            </div>
        </fieldset>
    </form>
</div>
@section('scripts')
    <script>
        $(document).ready(function() {
            // Función genérica para el filtrado dinámico
            function dynamicFilter(inputId, selectId, searchRoute) {
                $(inputId).on('input', function() {
                    var query = $(this).val();
                    if (query.length >= 3) { // Escribir al menos tres carácteres
                        $.ajax({
                            url: searchRoute,
                            type: "POST",
                            data: {
                                query: query,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $(selectId).html(response).show();
                            }
                        });
                    } else {
                        $(selectId).html('').hide();
                    }
                });

                $(selectId).change(function() {
                    var selectedOption = $(this).find('option:selected').text();
                    $(inputId).val(selectedOption);
                    $(this).hide();
                });
            }

            // Filtrado para lugares
            dynamicFilter('#place_name', '#place_select', "{{ route('places.search') }}");

            // Filtrado para ciudades
            dynamicFilter('#city_name', '#city_select', "{{ route('cities.search') }}");

            // Filtrado para países
            dynamicFilter('#country_name', '#country_select', "{{ route('countries.search') }}");


        });
    </script>
@endsection
