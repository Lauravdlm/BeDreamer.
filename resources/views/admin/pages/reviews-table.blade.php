@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Gestión de Reseñas')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE RESEÑAS</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.reviews-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.reviews-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Reseñas</h4>
                </div>
                <div class="data-table-wrapper">
                    <div class="data-table-content-wrapper table-responsive">
                        <div class="card">
                            <div class="card-body table-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo</th>
                                            <th>Usuario</th>
                                            <th>Contenido</th>
                                            <th>Puntuación</th>
                                            <th>Actividad</th>
                                            <th>Restaurante</th>
                                            <th>Hotel</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $review)
                                            <tr>
                                                <td contenteditable="false" data-column="id" data-id="{{ $review->id }}">
                                                    {{ $review->id }}</td>
                                                <td contenteditable="true" class="editable" data-column="type"
                                                    data-id="{{ $review->id }}"
                                                    data-endpoint="/admin-panel/reviews-management/update/{{ $review->id }}">
                                                    {{ optional($review)->type }}
                                                </td>
                                                <td contenteditable="false" data-column="user_id"
                                                    data-id="{{ $review->id }}">
                                                    <span
                                                        class="user-value value">{{ optional(optional($review)->user)->name }}</span>
                                                </td>
                                                <td contenteditable="false" data-column="content"
                                                    data-id="{{ $review->id }}">
                                                    {{ Str::limit(optional($review)->content, 50) }}
                                                </td>
                                                <td contenteditable="false" data-column="score"
                                                    data-id="{{ $review->id }}">
                                                    {{ optional($review)->score }}
                                                </td>
                                                <td contenteditable="false" data-column="activity_id"
                                                    data-id="{{ $review->id }}">
                                                    @if ($review->activity)
                                                        <span
                                                            class="activity-value value">{{ optional(optional($review)->activity)->name }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td contenteditable="false" data-column="restaurant_id"
                                                    data-id="{{ $review->id }}">
                                                    @if ($review->restaurant)
                                                        <span
                                                            class="restaurant-value value">{{ optional(optional($review)->restaurant)->name }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td contenteditable="false" data-column="hotel_id"
                                                    data-id="{{ $review->id }}">
                                                    @if ($review->hotel)
                                                        <span
                                                            class="hotel-value value">{{ optional(optional($review)->hotel)->name }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="action-cell">
                                                    <div class="d-flex">
                                                        <form method="POST"
                                                            action="{{ route('admin.reviews-management.delete', $review->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar la reseña con ID {{ $review->id }}?')">
                                                            <i class="bi bi-trash3"></i>
                                                        </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Paginación -->
                        <div class="pagination-outer">
                            @include('partials.pagination', ['paginator' => $reviews])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
