@extends('layouts.app')

@section('title', 'Blogs')

@section('content')
    <div class="a-index-container container">
        <div class="section-title-container">
            <h1 class="section-title fadeInLeft">Explora todos nuestros Blogs</h1>
        </div>
        <!--Incluimos el formulario de filtrado para blogs -->
        @include('partials.blog-filter-form')

        <section class="a-section-container-wrapper">
            <div class="a-section-container" id="blog-container">
                @if (!empty($blogs))
                    @foreach ($blogs as $blog)
                        <div class="a-custom-card card">
                            <div class="card-body a-custom-card-body">
                                <div class="card-a-frontpage">
                                    <figure class="frontpage-img">
                                        <img src="{{ asset($blog->getPhotoUrlAttribute() ?? 'img/no-available-image.jpg') }}"
                                            class="card-img-top" alt="Imagen de portada del Blog">
                                    </figure>
                                </div>
                                <div class="card-title title">
                                    <h1>{{ $blog->title }}</h1>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('blog.show', $blog->id) }}"
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
                @include('partials.pagination', ['paginator' => $blogs])
            </div>
        </section>
    </div>
@endsection
