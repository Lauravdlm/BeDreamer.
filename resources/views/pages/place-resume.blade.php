@extends('layouts.app')

@section('title', $place->name)
@section('content')
    <div class="container resume-container">
        <section class="resume-section">
            <div class="resume-section-wrapper">
                <div class="resume-title">
                    <h1>{{ $place->name }}</h1>
                </div>
                <div class="resume-data">
                    <i class="bi bi-geo-alt-fill"></i>
                    <small>{{ $city_name . ' | ' . $country_name }}</small>
                </div>
                <div class="resume-wrapper">
                    <div class="resume-photo-wrapper">
                        <figure class="resume-photo">
                            <img src="{{ asset($place->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}" class="card-img-top"
                                alt="Portada de {{ $city_name }}">
                        </figure>
                    </div>
                    <div class="resume-info">
                        <p>{!! $place->description !!}</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="row second-side">
            @if (!is_null($place->latitude) && !empty($place->latitude) && !is_null($place->longitude) && !empty($place->longitude))
                <section class="resume-map-section">
                    <h4>Dónde estoy
                        <i class="fi fi-rs-map-marker"></i>
                    </h4>
                    <div class="resume-map-wrapper">
                        <div id="map"></div>
                    </div>
                </section>
            @endif
            <section class="place-things-to-do-section">
                <div class="place-things-to-do-wrapper">
                    <h2>Descubre {{ $place->name }}</h2>
                    <div class="cards-things-to-do d-flex">
                        <div class="card place-resume-card">
                            <img class="card-img-top" src="{{ asset('img/activity.jpg') }}" alt="Actividades Imagen">
                            <div class="card-body place-resume-card-body">
                                <h4 class="card-title">Qué hacer</h4>
                                <a href="{{ route('place.activities', ['place_id' => $place->id]) }}"
                                    class="btn button-55">Ver
                                    más</a>
                            </div>
                        </div>
                        <div class="card place-resume-card">
                            <img class="card-img-top" src="{{ asset('img/restaurant.jpg') }}" alt="Restaurante Imagen">
                            <div class="card-body place-resume-card-body">
                                <h4 class="card-title">Dónde comer</h4>
                                <a href="{{ route('place.restaurants', ['place_id' => $place->id]) }}"
                                    class="btn button-55">Ver
                                    más</a>
                            </div>
                        </div>
                        <div class="card place-resume-card">
                            <img class="card-img-top" src="{{ asset('img/hotel.jpg') }}" alt="Hoteles Imagen">
                            <div class="card-body place-resume-card-body">
                                <h4 class="card-title">Dónde dormir</h4>
                                <a href="{{ route('place.hotels', ['place_id' => $place->id]) }}" class="btn button-55">Ver
                                    más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var latitude = {{ $place->latitude ?? '0' }};
            var longitude = {{ $place->longitude ?? '0' }};

            if (latitude !== 0 && longitude !== 0) {
                var map = L.map('map').setView([latitude, longitude], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                var marker = L.marker([latitude, longitude]).addTo(map);

                // Evento al pulsar en el marcador del mapa
                marker.on('click', function(e) {
                    var latlng = marker.getLatLng();
                    var lat = latlng.lat;
                    var lng = latlng.lng;

                    // Realizar la geocodificación inversa para obtener la dirección
                    var url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat +
                        '&lon=' + lng;

                    $.ajax({
                        url: url,
                        dataType: 'json',
                        success: function(data) {
                            var address = data.display_name;
                            marker.bindPopup("<b>Dirección:</b> " + address).openPopup();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error obteniendo la dirección:', error);
                        }
                    });
                });
            } else {
                console.error('Las coordenadas de latitud y longitud no son válidas y/o no se han establecido.');
            }
        });
    </script>
@endsection
