@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Gestión de Favoritos')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE FAVORITOS</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.favorites-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.favorites-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Favoritos</h4>
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
                                            <th>Destino</th>
                                            <th>Actividad</th>
                                            <th>Restaurante</th>
                                            <th>Hotel</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($favorites as $favorite)
                                            <tr>
                                                <td contenteditable="false" data-column="id" data-id="{{ $favorite->id }}">
                                                    {{ $favorite->id }}</td>

                                                <td contenteditable="true" class="editable" data-column="type"
                                                    data-id="{{ $favorite->id }}"
                                                    data-endpoint="/admin-panel/favorites-management/update/{{ $favorite->id }}">
                                                    {{ optional($favorite)->type }}
                                                </td>

                                                <td contenteditable="false" data-column="user_id"
                                                    data-id="{{ $favorite->id }}">
                                                    <span
                                                        class="user-value value">{{ optional(optional($favorite)->user)->name }}</span>
                                                </td>

                                                <td contenteditable="false" data-column="place_id"
                                                    data-id="{{ $favorite->id }}">
                                                    <span
                                                        class="place-value value">{{ optional(optional($favorite)->place)->name }}</span>
                                                </td>

                                                <td contenteditable="false" data-column="activity_id"
                                                    data-id="{{ $favorite->id }}">
                                                    @if ($favorite->activity)
                                                        <span
                                                            class="activity-value value">{{ optional(optional($favorite)->activity)->name }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td contenteditable="false" data-column="restaurant_id"
                                                    data-id="{{ $favorite->id }}">
                                                    @if ($favorite->restaurant)
                                                        <span
                                                            class="restaurant-value value">{{ optional(optional($favorite)->restaurant)->name }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td contenteditable="false" data-column="hotel_id"
                                                    data-id="{{ $favorite->id }}">
                                                    @if ($favorite->hotel)
                                                        <span
                                                            class="hotel-value value">{{ optional(optional($favorite)->hotel)->name }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="action-cell">
                                                    <div class="d-flex">
                                                        <form method="POST"
                                                            action="{{ route('admin.favorites-management.delete', $favorite->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar el favorito con ID {{ $favorite->id }}?')">
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
                            @include('partials.pagination', ['paginator' => $favorites])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
