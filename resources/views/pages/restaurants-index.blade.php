@extends('layouts.app')

@section('title', $restaurants->isNotEmpty() ? 'Restaurantes en ' . $restaurants->first()->place->name : 'Restaurante')
@section('content')
    @if ($restaurants->isEmpty())
        <div class="empty-options container">
            <div>
                <p>No hay restaurantes disponibles en este destino.</p>
                <a href="{{ route('place.show', ['id' => $place->id]) }}" class="btn yellow-button">Volver atrás</a>
            </div>
        </div>
    @else
        <h1 class="ahr-title">Dónde comer en {{ $restaurants->first()->place->name }}</h1>
        <div class="options-index-container">
            <div class="filter-container container">
                <!-- Formulario de filtro -->
                <form action="{{ route('place.restaurants', ['place_id' => $place->id]) }}" method="GET"
                    class="restaurants-filter filters-form">
                    @csrf
                    <div class="form-group">
                        <label for="type" class="form-label">Tipo</label>

                        @foreach ($types as $type)
                            <button type="submit" class="type-btn button-13" name="type"
                                value="{{ $type }}">{{ $type }}</button>
                        @endforeach

                    </div>
                    <div class="form-group score-group">
                        <label for="score" class="form-label">Puntuación de los usuarios</label>
                        <div class="form-group-score">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="submit" class="score-btn score-btn-{{ $i }} button-13"
                                    name="score" value="{{ $i }}">
                                    @for ($j = 0; $j < $i; $j++)
                                        <i class="fi fi-rr-smile"></i>
                                    @endfor
                                </button>
                            @endfor
                        </div>
                    </div>
                    <div class="send-button">
                        <a href="{{ route('place.restaurants', ['place_id' => $place->id]) }}"
                            class="btn yellow-button">Limpiar filtros</a>
                    </div>
                </form>
                <a href="{{ route('place.show', ['id' => $place->id]) }}" class="btn button-13">Volver a
                    {{ $place->name }}</a>
            </div>
            <div class="items-container container">
                @foreach ($restaurants as $restaurant)
                    <div class="card rounded shadow-sm border-0 item-card">
                        <img src="{{ asset($restaurant->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}"
                            class="card-img-top img-fluid d-block mx-auto mb-2" alt="Foto de la actividad">
                        <!-- Sólo añadiremos a favoritos cuándo haya un usuario autenticado -->
                        @auth
                            <form action="{{ route('favorite.restaurant.add', ['restaurant' => $restaurant->id]) }}"
                                method="POST">
                                @csrf
                                <button class="favorite-btn" type="submit" aria-label="Guardar en favoritos"
                                    title="Añadir a favoritos">
                                    <!-- Cambiar aspecto del corazón dependiendo de si está o no añadido ya como favorito del usuario -->
                                    @if ($restaurant->isFavorite(auth()->user()))
                                        <i class="bi bi-heart-fill"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif
                                </button>
                            </form>
                        @endauth
                        <div class="card-body ahr-index-card-body">
                            <h5 class="card-title">{{ $restaurant->name }}</h5>
                            <p class="card-text small">{{ $restaurant->description }}</p>
                            <div class="d-flex flex-column-reverse">
                                <div class="btn-group">
                                    <a href="{{ route('restaurant.show', ['id' => $restaurant->id]) }}"
                                        class="btn button-55">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Paginación -->
                <div class="pagination-outer">
                    @include('partials.pagination', ['paginator' => $restaurants])
                </div>
            </div>
        </div>
    @endif
@endsection
