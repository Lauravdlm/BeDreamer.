@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Administrador | Gestión de Destinos')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE DESTINOS</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.places-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.places-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Destinos</h4>
                    <div class="add-button add-button ms-2">
                        <button id="create-user-btn" class="create-user-btn btn btn-block btn-warning"
                            data-bs-toggle="modal" data-bs-target="#create-form">
                            <i class="fi fi-sr-square-plus"></i> Añadir Destino
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
                                            <th>Portada</th>
                                            <th>Latitud</th>
                                            <th>Longitud</th>
                                            <th>Ciudad</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($places as $place)
                                            <tr>
                                                <td>{{ $place->id }}</td>
                                                <td contenteditable="true" class="editable" data-column="name"
                                                    data-id="{{ $place->id }}"
                                                    data-endpoint="/admin-panel/places-management/update/{{ $place->id }}">
                                                    {{ optional($place)->name }}
                                                </td>

                                                <td contenteditable="true" class="editable" data-column="description"
                                                    data-id="{{ $place->id }}"
                                                    data-endpoint="/admin-panel/places-management/update/{{ $place->id }}"
                                                    title="{{ $place->description }}">
                                                    {{ Str::limit(optional($place)->description, 50) }}
                                                </td>
                                                <td class="photo-td">
                                                    <img src="{{ $place->getPhotoUrlAttribute() }}"
                                                        alt="Foto de portada del destino" width="50" height="50">
                                                    <form
                                                        action="{{ route('admin.places-management.update-photo', $place->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="file" name="photo" class="form-input-photo"
                                                            id="file_{{ $place->id }}" required>
                                                        <label for="file_{{ $place->id }}"
                                                            class="btn form-label-photo">Selecciona foto</label>
                                                        <button type="submit" class=" btn update-photo">Actualizar
                                                            Foto</button>
                                                    </form>
                                                </td>
                                                <td contenteditable="true" class="editable" data-column="latitude"
                                                    data-id="{{ $place->id }}"
                                                    data-endpoint="/admin-panel/places-management/update/{{ $place->id }}">
                                                    {{ optional($place)->latitude }}
                                                </td>

                                                <td contenteditable="true" class="editable" data-column="longitude"
                                                    data-id="{{ $place->id }}"
                                                    data-endpoint="/admin-panel/places-management/update/{{ $place->id }}">
                                                    {{ optional($place)->longitude }}
                                                </td>

                                                <td class="editable" data-column="city_id" data-id="{{ $place->id }}"
                                                    data-endpoint="/admin-panel/places-management/update/{{ $place->id }}">
                                                    <span
                                                        class="city-value value">{{ optional(optional($place)->city)->name }}</span>
                                                    <select class="form-select city-select select" style="display: none;">
                                                        <option value="">Selecciona una ciudad</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="action-cell">
                                                    <div class="d-flex">
                                                        <form method="POST"
                                                            action="{{ route('admin.places-management.delete', $place->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar el destino con ID {{ $place->id }}?')">
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
                            @include('partials.pagination', ['paginator' => $places])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL AÑADIR DESTINO -->
        <div class="modal fade" id="create-form" tabindex="-1" aria-hidden="true" aria-labelledby="create-place">
            <div class="modal-dialog modal-dialog-centered create-modal-dialog">
                <div class="modal-content create-modal-content">
                    <div class="modal-header create-form-header">
                        <h5 class="modal-title">Añadir nuevo Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body create-form-body">
                        <form method="POST" action="{{ route('admin.places-management.create') }}"
                            enctype="multipart/form-data" class="create-form">
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
                                <label for="latitude" class="col-form-label">Latitud</label>
                                <input id="latitude" type="text" class="form-control" name="latitude">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="longitude" class="col-form-label">Longitud</label>
                                <input id="longitude" type="longitude" class="form-control" name="longitude">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="photo" class="col-form-label">Foto de portada</label>
                                <input id="photo" type="file" class="form-control-file" name="photo">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="city_id" class="col-form-label">Ciudad</label>
                                <select id="city_id" class="form-control form-select" name="city_id" required>
                                    <option value="" disabled selected>Elige ciudad</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
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
