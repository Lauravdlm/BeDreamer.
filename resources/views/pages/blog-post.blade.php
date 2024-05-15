@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <div class="container blog-container">
        <article class="blog-content-wrapper container">
            <div class="blog-info">
                <div>
                    <div class="blog-title">
                        <h3>{{ $blog->title }}</h3>
                        <p>
                            <i class="bi bi-geo-fill"></i>{{ $blog->place->name }} | {{ $blog->place->city->name }},
                            {{ $blog->place->city->country->name }}
                        </p>
                    </div>
                    <div class="blog-autor-date">
                        <p class="d-flex flex-column">
                            <span class="txt">ACTUALIZADO EL</span>
                            <span>
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('d \d\e F \d\e Y') }}
                            </span>
                        </p>
                        <p class="d-flex flex-column">
                            <span class="txt">POR</span>
                            <span>
                                <i class="bi bi-person-fill"></i> {{ $blog->user->name }} {{ $blog->user->surname }}
                            </span>
                        </p>
                        <div>
                            <figure>
                                <img src="{{ asset($blog->user->getPhotoUrlAttribute()) }}" class="author-picture">
                            </figure>
                        </div>
                        <p>
                            <i class="bi bi-at"></i><small>{{ $blog->user->username }}</small>
                        </p>
                    </div>
                </div>
                {{-- <div class="blog-frontpage-wrapper">
                    <figure class="blog-frontpage-img">
                        <img src="{{ asset($blog->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}"
                            class="card-img-top" alt="Imagen de portada del Blog">
                    </figure>
                </div> --}}
            </div>
            <div class="blog-post-wrapper">
                <section class="blog-post">
                    <div class="blog-content">
                        <!-- Al contenido del blog no le daremos estilo directamente ya que se edita/crea con CKEditor -->
                        <p>{!! $blog->content !!}</p>
                    </div>
                </section>
            </div>
        </article>
        <!-- Incluimos sección de ver y crear comentarios-->
        @include('partials.comments')
    </div>
@endsection
