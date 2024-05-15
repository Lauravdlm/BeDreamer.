@extends('layouts.app')

@section('title', $activity->name)
@section('content')
    <div class="container resume-container">
        <section class="resume-section">
            <div class="resume-section-wrapper">
                <div class="resume-title">
                    <h1>{{ $activity->name }}</h1>
                </div>
                <div class="resume-data">
                    <i class="bi bi-geo-alt-fill"></i>
                    <small>{{ $activity->address . ' ' . $activity->place->name . ' | ' . $activity->place->city->name . ' ' . $activity->place->city->country->name }}</small>
                </div>
                <div class="resume-data">
                    <i class="bi bi-cash-coin"></i>
                    <small>{{ $activity->price }}€</small>
                </div>
                <div class="resume-wrapper">
                    <div class="resume-photo-wrapper">
                        <figure class="resume-photo">
                            <img src="{{ asset($activity->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}" class="card-img-top"
                                alt="Foto de la actividad">
                        </figure>
                    </div>
                    <div class="resume-info">
                        <p>{!! $activity->description !!}</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="row second-side">
            @if (
                !is_null($activity->latitude) &&
                    !empty($activity->latitude) &&
                    !is_null($activity->longitude) &&
                    !empty($activity->longitude))
                <section class="resume-map-section">
                    <h4>Dónde estoy
                        <i class="fi fi-rs-map-marker"></i>
                    </h4>
                    <div class="resume-map-wrapper">
                        <div id="map"></div>
                    </div>
                </section>
            @endif
        </div>
    </div>
    <!-- Incluimos sección de ver y crear comentarios-->
    @include('partials.reviews', [
        'type' => 'activity',
        'entity' => 'activity',
        'entity_id' => $activity->id,
    ])
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            var latitude = {{ $activity->latitude ?? '0' }};
            var longitude = {{ $activity->longitude ?? '0' }};

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

            // Función para enviar la puntuación a través de la selección de un numero determinado de estrellas
            $('.star-rating i').click(function() {
                var rating = $(this).data('rating');
                $('#score').val(rating);

                // Marcar las estrellas seleccionadas y cambiar el tipo de icono
                $(this).addClass('selected').removeClass('bi-star').addClass('bi-star-fill');
                $(this).prevAll().addClass('selected').removeClass('bi-star').addClass('bi-star-fill');
                $(this).nextAll().removeClass('selected').removeClass('bi-star-fill').addClass('bi-star');
            });

        });
    </script>
@endsection
