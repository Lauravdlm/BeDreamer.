@extends('layouts.app')

@section('title', 'Destinos')

@section('content')

    <div class="a-index-container container">
        <div class="section-title-container">
            <h1 class="section-title fadeInLeft">Explora todos nuestros Destinos</h1>
        </div>

        <!--Incluimos el formulario de filtrado para blogs -->
        @include('partials.place-filter-form')

        <section class="a-section-container-wrapper">
            <div class="a-section-container" id="place-container">
                @if (!empty($places))
                    @foreach ($places as $place)
                        <div class="a-custom-card card">
                            <div class="card-body a-custom-card-body">
                                <div class="card-title title">
                                    <h1>{{ $place->name }}</h1>
                                </div>
                                <div class="card-a-frontpage">
                                    <figure class="frontpage-img">
                                        <img src="{{ asset($place->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}"
                                            class="card-img-top" alt="Imagen de portada del Destino">
                                    </figure>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('place.show', $place->id) }}"
                                        class="btn btn-sm button-55">Ver
                                        detalles</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- Paginación -->
            <div class="pagination-outer">
                @include('partials.pagination', ['paginator' => $places])
            </div>
        </section>
    </div>
@endsection
