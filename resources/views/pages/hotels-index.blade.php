@extends('layouts.app')

@section('title', $hotels->isNotEmpty() ? 'Hoteles en ' . $hotels->first()->place->name : 'Hoteles')
@section('content')
    @if ($hotels->isEmpty())
        <div class="empty-options container">
            <div>
                <p>No hay hoteles disponibles en este destino.</p>
                <a href="{{ route('place.show', ['id' => $place->id]) }}" class="btn yellow-button">Volver atrás</a>
            </div>
        </div>
    @else
        <h1 class="ahr-title">Dónde descansar en {{ $hotels->first()->place->name }}</h1>
        <div class="options-index-container">
            <div class="filter-container container">
                <form id="hotels-filter" class="hotels-filter filters-form" method="get"
                    action="{{ route('place.hotels', ['place_id' => $place->id]) }}">
                    @csrf
                    <div class="form-group score-group">
                        <label for="classification" class="form-label">Clasificación del alojamiento</label>
                        <div class="form-group-score">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="submit" class="classif-btn score-btn score-btn-{{ $i }} button-13"
                                    name="classification" value="{{ $i }}">
                                    <span>
                                        {{-- {{ $i }} --}}
                                        @for ($j = 0; $j < $i; $j++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                    </span>
                                </button>
                            @endfor
                        </div>
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
                        <a href="{{ route('place.hotels', ['place_id' => $place->id]) }}" class="btn yellow-button">Limpiar
                            filtros</a>
                    </div>
                </form>
                <a href="{{ route('place.show', ['id' => $place->id]) }}" class="btn button-13">Volver a
                    {{ $place->name }}</a>
            </div>
            <div class="items-container container">
                @foreach ($hotels as $hotel)
                    <div class="card rounded shadow-sm border-0 item-card">
                        <img src="{{ asset($hotel->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}"
                            class="card-img-top img-fluid d-block mx-auto mb-2" alt="Portada del hotel">
                        <!-- Sólo añadiremos a favoritos cuándo haya un usuario autenticado -->
                        @auth
                            <form action="{{ route('favorite.hotel.add', ['hotel' => $hotel->id]) }}" method="POST">
                                @csrf
                                <button class="favorite-btn" type="submit" aria-label="Guardar en favoritos">
                                    <!-- Cambiar aspecto del corazón dependiendo de si está o no añadido ya como favorito del usuario -->
                                    @if ($hotel->isFavorite(auth()->user()))
                                        <i class="bi bi-heart-fill"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif
                                </button>
                            </form>
                        @endauth
                        <div class="card-body ahr-index-card-body">
                            <h5 class="card-title text-dark">{{ $hotel->name }}</h5>
                            <p class="card-text small">{{ $hotel->description }}</p>
                            <div class="d-flex flex-column-reverse">
                                <div class="btn-group">
                                    <a href="{{ route('hotel.show', ['id' => $hotel->id]) }}" class="btn button-55">Ver
                                        detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Paginación -->
                <div class="pagination-outer">
                    @include('partials.pagination', ['paginator' => $hotels])
                </div>
            </div>
        </div>
    @endif
@endsection
