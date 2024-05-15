@extends('layouts.app')

@section('title', $activities->isNotEmpty() ? 'Atracciones de ' . $activities->first()->place->name : 'Atracciones')
@section('content')
    @if ($activities->isEmpty())
        <div class="empty-options container">
            <div>
                <p>No hay actividades disponibles en este destino.</p>
                <a href="{{ route('place.show', ['id' => $place->id]) }}" class="btn yellow-button">Volver atrás</a>
            </div>
        </div>
    @else
        <h1 class="ahr-title">Vive experiencias en {{ $activities->first()->place->name }}</h1>
        <div class="options-index-container">
            <div class="filter-container container">
                <form id="activities-filter" class="activities-filter filters-form" method="get"
                    action="{{ route('place.activities', ['place_id' => $place->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="price" class="form-label">Precio</label>
                        <button type="submit" class="noprice-btn button-13" name="price" value="free">Gratis</button>
                        <button type="submit" class="price-btn button-13" name="price" value="paid">De pago</button>
                    </div>
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
                        <a href="{{ route('place.activities', ['place_id' => $place->id]) }}"
                            class="btn yellow-button">Limpiar filtros</a>
                    </div>
                </form>
                <a href="{{ route('place.show', ['id' => $place->id]) }}" class="btn button-13">Volver a
                    {{ $place->name }}</a>
            </div>
            <div class="items-container container">
                @foreach ($activities as $activity)
                    <div class="card rounded shadow-sm border-0 item-card">
                        <img src="{{ asset($activity->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}"
                            class="card-img-top img-fluid d-block mx-auto mb-2" alt="Foto de la actividad">
                        <!-- Sólo añadiremos a favoritos cuándo haya un usuario autenticado -->
                        @auth
                            <form action="{{ route('favorite.activity.add', ['activity' => $activity->id]) }}" method="POST">
                                @csrf
                                <button class="favorite-btn" type="submit" aria-label="Guardar en favoritos">
                                    <!-- Cambiar aspecto del corazón dependiendo de si está o no añadido ya como favorito del usuario -->
                                    @if ($activity->isFavorite(auth()->user()))
                                        <i class="bi bi-heart-fill"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif
                                </button>
                            </form>
                        @endauth
                        <div class="card-body ahr-index-card-body">
                            <h5 class="card-title text-dark">{{ $activity->name }}</h5>
                            {{-- <p class="card-text small">{{ $activity->description }}</p> --}}
                            <div class="d-flex flex-column-reverse">
                                <div class="btn-group">
                                    <a href="{{ route('activity.show', ['id' => $activity->id]) }}"
                                        class="btn button-55">Ver detalles
                                    </a>
                                </div>
                                <small class="text-muted">Precio: {{ $activity->price }}€</small>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Paginación -->
                <div class="pagination-outer">
                    @include('partials.pagination', ['paginator' => $activities])
                </div>
            </div>
        </div>
    @endif
@endsection
