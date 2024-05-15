@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Gestión de Restaurantes')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE RESTAURANTES</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.restaurants-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.restaurants-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Restaurantes</h4>
                    <div class="add-button add-button ms-2">
                        <button id="create-user-btn" class="create-user-btn btn btn-block btn-warning"
                            data-bs-toggle="modal" data-bs-target="#create-form">
                            <i class="fi fi-sr-square-plus"></i> Añadir Restaurante
                        </button>
                    </div>
                </div>
                <div class="data-table-wrapper">
                    <div class="data-table-content-wrapper table-responsive">
                        <div class="card">
                            <div class="card-body table-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Tipo</th>
                                            <th>Portada</th>
                                            <th>Dirección</th>
                                            <th>Latitud</th>
                                            <th>Longitud</th>
                                            <th>Destino</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($restaurants as $restaurant)
                                            <tr>
                                                <td data-column="id" data-id="{{ $restaurant->id }}">{{ $restaurant->id }}
                                                </td>
                                                <td contenteditable="true" class="editable" data-column="name"
                                                    data-id="{{ $restaurant->id }}"
                                                    data-endpoint="/admin-panel/restaurants-management/update/{{ $restaurant->id }}">
                                                    {{ optional($restaurant)->name }}
                                                </td>
                                                <td contenteditable="true" class="editable" data-column="description"
                                                    data-id="{{ $restaurant->id }}"
                                                    data-endpoint="/admin-panel/restaurants-management/update/{{ $restaurant->id }}"
                                                    title="{{ $restaurant->description }}">
                                                    {{ Str::limit(optional($restaurant)->description, 50) }}
                                                </td>
                                                <td contenteditable="true" class="editable" data-column="type"
                                                    data-id="{{ $restaurant->id }}"
                                                    data-endpoint="/admin-panel/restaurants-management/update/{{ $restaurant->id }}">
                                                    {{ optional($restaurant)->type }}
                                                </td>
                                                <td class="photo-td">
                                                    <img src="{{ $restaurant->getPhotoUrlAttribute() }}"
                                                        alt="Foto de portada del restaurante" width="50" height="50">
                                                    <form
                                                        action="{{ route('admin.restaurants-management.update-photo', $restaurant->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="file" name="photo" class="form-input-photo"
                                                            id="file_{{ $restaurant->id }}" required>
                                                        <label for="file_{{ $restaurant->id }}"
                                                            class="btn form-label-photo">Selecciona foto</label>
                                                        <button type="submit" class=" btn update-photo">Actualizar
                                                            Foto</button>
                                                    </form>
                                                </td>
                                                <td contenteditable="true" class="editable" data-column="address"
                                                    data-id="{{ $restaurant->id }}"
                                                    data-endpoint="/admin-panel/restaurants-management/update/{{ $restaurant->id }}">
                                                    {{ optional($restaurant)->address }}
                                                </td>
                                                <td contenteditable="true" class="editable" data-column="latitude"
                                                    data-id="{{ $restaurant->id }}"
                                                    data-endpoint="/admin-panel/restaurants-management/update/{{ $restaurant->id }}">
                                                    {{ optional($restaurant)->latitude }}
                                                </td>
                                                <td contenteditable="true" class="editable" data-column="longitude"
                                                    data-id="{{ $restaurant->id }}"
                                                    data-endpoint="/admin-panel/restaurants-management/update/{{ $restaurant->id }}">
                                                    {{ optional($restaurant)->longitude }}
                                                </td>

                                                <td class="editable" data-column="place_id" data-id="{{ $restaurant->id }}"
                                                    data-endpoint="/admin-panel/restaurants-management/update/{{ $restaurant->id }}">
                                                    <span
                                                        class="place-value value">{{ optional(optional($restaurant)->place)->name }}</span>
                                                    <select class="form-select place-select select" style="display: none;">
                                                        <option value="">Selecciona un destino</option>
                                                        @foreach ($places as $place)
                                                            <option value="{{ $place->id }}">{{ $place->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="action-cell">
                                                    <div class="d-flex">
                                                        <form method="POST"
                                                            action="{{ route('admin.restaurants-management.delete', $restaurant->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar el restaurante con ID {{ $restaurant->id }}?')">
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
                            @include('partials.pagination', ['paginator' => $restaurants])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL AÑADIR RESTAURANTE -->
        <div class="modal fade" id="create-form" tabindex="-1" aria-hidden="true" aria-labelledby="create-restaurant">
            <div class="modal-dialog modal-dialog-centered create-modal-dialog">
                <div class="modal-content create-modal-content">
                    <div class="modal-header create-form-header">
                        <h5 class="modal-title">Añadir Restaurante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body create-form-body">
                        <form method="POST" action="{{ route('admin.restaurants-management.create') }}"
                            enctype="multipart/form-data"class="create-form">
                            @csrf

                            <div class="form-group create-form-group">
                                <label for="name" class="col-form-label">Nombre</label>
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="description" class="col-form-label">Descripción</label>
                                <input id="description" type="text" class="form-control" name="description">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="type" class="col-form-label">Tipo</label>
                                <input id="type" type="text" class="form-control" name="type" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="photo" class="col-form-label">Foto de portada</label>
                                <input id="photo" type="file" class="form-control-file" name="photo">
                            </div>

                            <div class="form-group create-form-group">
                                <label for="address" class="col-form-label">Dirección</label>
                                <input id="address" type="text" class="form-control" name="address" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="latitude" class="col-form-label">Latitud</label>
                                <input id="latitude" type="text" class="form-control" name="latitude">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="longitude" class="col-form-label">Longitud</label>
                                <input id="longitude" type="text" class="form-control" name="longitude">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="place_id" class="col-form-label">Destino</label>
                                <select id="place_id" class="form-control form-select" name="place_id" required>
                                    <option value="" disabled selected>Elige destino</option>
                                    @foreach ($places as $place)
                                        <option value="{{ $place->id }}">{{ $place->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-warning">Añadir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
