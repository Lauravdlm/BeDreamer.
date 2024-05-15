@extends('layouts.app')

@section('title', 'Panel de usuario - Mis favoritos')

@section('content')
    @if ($favoritesByPlace->isEmpty())
        <div class="container favpage-wrapper">
            <p> No hay favoritos que mostrar.</p>
        </div>
    @else
        <div class="container favpage-wrapper">
            <h1 class="favpage-title">Lista de favoritos</h1>
            <div class="favorites-container container">
                @foreach ($favoritesByPlace as $placeId => $favorites)
                    <div class="d-flex favs">
                        <h2 class="fav-place-title">
                            <a
                                href="{{ route('place.show', ['id' => $placeId]) }}">{{ $favorites->first()->place->name }}</a>
                        </h2>
                        <ul>
                            @foreach ($favorites as $favorite)
                                <li>
                                    @if ($favorite->type === 'Actividad')
                                        <span>
                                            <i class="fi fi-rr-palette"></i>
                                            <a href="{{ route('activity.show', ['id' => $favorite->activity->id]) }}">{{ $favorite->activity->name }}
                                            </a>
                                        </span>
                                    @elseif($favorite->type === 'Restaurante')
                                        <span>
                                            <i class="fi fi-rr-restaurant"></i>
                                            <a href="{{ route('restaurant.show', ['id' => $favorite->restaurant->id]) }}">{{ $favorite->restaurant->name }}
                                            </a>
                                        </span>
                                    @elseif($favorite->type === 'Hotel')
                                        <span>
                                            <i class="fi fi-sr-bed"></i>
                                            <a href="{{ route('hotel.show', ['id' => $favorite->hotel->id]) }}">{{ $favorite->hotel->name }}
                                            </a>
                                        </span>
                                    @endif
                                    <form method="POST" action="{{ route('user.favorites.delete', $favorite->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn delete-btn" title="Eliminar">
                                            <i class="bi bi-trash3-fill"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar el favorito?')">
                                            </i>
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
    @endif
    <div class="create-favorite-form container">
        <div class="container form-container">
            <h2>Agregar Favorito</h2>
            <form method="POST" action="{{ route('user.favorites.store') }}">
                @csrf
                <div class="form-group">
                    <label for="place" class="form-label">Destino</label>
                    <input type="text" class="form-control" id="place" name="place" placeholder="Elige un Destino"
                        minlength="3">
                </div>
                <div class="form-group">
                    <label for="type" class="form-label">Tipo</label>
                    <select class="form-select" id="type" name="type">
                        <option>Seleccione un tipo</option>
                        <option value="Restaurante">Restaurante</option>
                        <option value="Hotel">Hotel</option>
                        <option value="Actividad">Actividad</option>
                    </select>
                </div>

                <div id="related-options" style="display: none;">
                    <div class="form-group" id="restaurant-container">
                        {{-- <label for="restaurant_id">Restaurante</label> --}}
                        <select id="restaurant" class="form-select" name="restaurant_id"></select>
                    </div>
                    <div class="form-group" id="hotel-container">
                        {{-- <label for="hotel_id">Hotel</label> --}}
                        <select id="hotel" class="form-select" name="hotel_id"></select>
                    </div>
                    <div class="form-group" id="activity-container">
                        {{-- <label for="activity_id">Actividad</label> --}}
                        <select id="activity" class="form-select" name="activity_id"></select>
                    </div>
                </div>
                <div class="d-flex button-container">
                    <button type="submit" class="btn yellow-button">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#place').keyup(function() {
                var query = $(this).val();
                if (query.length >= 3) {
                    $.ajax({
                        url: "{{ route('places.search') }}",
                        method: "POST",
                        data: {
                            query: query,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#related-options').hide();
                            $('#restaurant, #hotel, #activity').empty().hide();
                            if ($('#placeOptions').length === 0) {
                                $('#place').after(
                                    '<select id="placeOptions" class="form-control" name="place_id"></select>'
                                );
                            }
                            $('#placeOptions').html(data);
                        }
                    });
                } else {
                    $('#placeOptions').remove();
                    $('#related-options').hide();
                    $('#restaurant, #hotel, #activity').empty().hide();
                }
            });

            $(document).on('change', '#placeOptions', function() {
                $('#related-options').show();
                var selectedPlaceId = $(this).val();
                $('#place_id').val(selectedPlaceId);
                $('#place').val($(this).find('option:selected')
                    .text()
                ); // Actualiza el valor del input de destino con el nombre del destino seleccionado
            });

            $(document).on('change', '#type', function() {
                var type = $(this).val();
                var placeId = $('#placeOptions').val();

                if (type === 'Restaurante') {
                    $('#restaurant-container').show();
                    $('#hotel-container, #activity-container').hide();
                    if (placeId) {
                        $.ajax({
                            url: "{{ route('restaurants.search') }}",
                            method: "POST",
                            data: {
                                place_id: placeId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                $('#restaurant').html(data).show();
                            }
                        });
                    }
                } else if (type === 'Hotel') {
                    $('#hotel-container').show();
                    $('#restaurant-container, #activity-container').hide();
                    if (placeId) {
                        $.ajax({
                            url: "{{ route('hotels.search') }}",
                            method: "POST",
                            data: {
                                place_id: placeId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                $('#hotel').html(data).show();
                            }
                        });
                    }
                } else if (type === 'Actividad') {
                    $('#activity-container').show();
                    $('#restaurant-container, #hotel-container').hide();
                    if (placeId) {
                        $.ajax({
                            url: "{{ route('activities.search') }}",
                            method: "POST",
                            data: {
                                place_id: placeId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                $('#activity').html(data).show();
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection
