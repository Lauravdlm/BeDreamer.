@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <section class="trendings-destinations-container-wrapper">
        <div class="container-fluid top-destinations-container">
            <div class="trendings-destinations-inner">
                <div class="trendings-destinations-content">
                    <h1 class="slider-title">Últimas tendencias
                        <img width="30"
                            height="30"src="https://img.icons8.com/external-rabit-jes-flat-rabit-jes/62/external-world-navigation-and-maps-rabit-jes-flat-rabit-jes.png"
                            alt="external-world-navigation-and-maps-rabit-jes-flat-rabit-jes" />
                    </h1>
                    <p class="slider-description">Descubre los últimos destinos más demandados por los usuarios.</p>
                    <div id="destination-carousel">
                        <!-- Pasar la lista de destinos al componente DestinationCarousel -->
                        <destination-carousel :places="{{ $places }}"></destination-carousel>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blogs-container-wrapper">
        <div class="container-fluid tblogs-container">
            <div class="blogs-inner">
                <div class="blogs-content">
                    <h1 class="slider-title">El rincón del viajero
                        <img width="30" height="30" src="https://img.icons8.com/fluency/48/expedition-backpack.png"
                            alt="expedition-backpack" />
                    </h1>
                    <p class="slider-description">Últimos post recién salidos del horno.</p>
                    <div id="blog-carousel">
                        <!-- Pasar la lista de blogs al componente BlogCarousel -->
                        <blog-carousel :blogs="{{ $blogs }}"></blog-carousel>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
