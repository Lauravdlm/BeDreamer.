@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Administrador | Gestión de Ciudades')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE CIUDADES</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.cities-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.cities-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Ciudades</h4>
                    <div class="add-button add-button ms-2">
                        <button id="create-user-btn" class="create-user-btn btn btn-block btn-warning" data-bs-toggle="modal"
                            data-bs-target="#create-form">
                            <i class="fi fi-sr-square-plus"></i> Añadir Ciudad
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
                                            <th>Pais</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cities as $city)
                                            <tr>
                                                <td>{{ $city->id }}</td>
                                                <td contenteditable="true" class="editable" data-column="name"
                                                    data-id="{{ $city->id }}"
                                                    data-endpoint="/admin-panel/cities-management/update/{{ $city->id }}">
                                                    {{ optional($city)->name }}
                                                </td>
                                                <td class="editable" data-column="country_id" data-id="{{ $city->id }}"
                                                    data-endpoint="/admin-panel/cities-management/update/{{ $city->id }}">
                                                    <span
                                                        class="country-value value">{{ optional(optional($city)->country)->name }}</span>
                                                    <select class="form-select country-select select"
                                                        style="display: none;">
                                                        <option value="">Selecciona una pais</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}">{{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="action-cell">
                                                    <div class="d-flex">
                                                        <form method="POST"
                                                            action="{{ route('admin.cities-management.delete', $city->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar la ciudad con ID {{ $city->id }}?')">
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
                            @include('partials.pagination', ['paginator' => $cities])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL AÑADIR CIUDAD -->
        <div class="modal fade" id="create-form" tabindex="-1" aria-hidden="true" aria-labelledby="create-city">
            <div class="modal-dialog modal-dialog-centered create-modal-dialog">
                <div class="modal-content create-modal-content">
                    <div class="modal-header create-form-header">
                        <h5 class="modal-title">Añadir Ciudad</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body create-form-body">
                        <form method="POST" action="{{ route('admin.cities-management.create') }}"
                            enctype="multipart/form-data" class="create-form">
                            @csrf
                            <div class="form-group create-form-group">
                                <label for="name" class="col-form-label">Nombre</label>
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="country_id" class="col-form-label">Pais</label>
                                <select id="country_id" class="form-control form-select" name="country_id" required>
                                    <option value="" disabled selected>Elige país</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
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
