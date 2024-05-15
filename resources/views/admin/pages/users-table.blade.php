@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Gestión de usuarios')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE USUARIOS</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.users-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.users-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Usuarios</h4>
                    <div class="d-flex">
                        <div class="add-button ms-2">
                            <button id="create-user-btn" class="create-user-btn btn btn-block btn-warning"
                                data-bs-toggle="modal" data-bs-target="#create-form">
                                <i class="fi fi-sr-square-plus"></i> Añadir Usuario
                            </button>
                        </div>
                        <!-- Botón para generar un informe PDF de los datos de usuarios -->
                        <div class="generate-pdf-button add-button ms-2">
                            <a href="{{ route('admin.generate-pdf') }}" class="create-user-btn btn btn-block btn-success">
                                <i class="bi bi-file-pdf"></i> Generar PDF
                            </a>
                        </div>
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
                                            <th>Apellidos</th>
                                            <th>Nombre de usuario</th>
                                            <th>Foto de perfil</th>
                                            <th>Email</th>
                                            <th>Instagram</th>
                                            <th>Página web</th>
                                            <th>Ciudad</th>
                                            <th>Rol</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>

                                                <td contenteditable="true" class="editable" data-column="name"
                                                    data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    {{-- {{ optional($user)->name }} --}}
                                                    {{ (optional($user)->name ?? '-') }}
                                                </td>

                                                <td contenteditable="true" class="editable" data-column="surname"
                                                    data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    {{-- {{ optional($user)->surname }} --}}
                                                    {{ (optional($user)->surname ?? '-') }}
                                                </td>

                                                <td contenteditable="true" class="editable" data-column="username"
                                                    data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    {{-- {{ optional($user)->username }} --}}
                                                    {{ (optional($user)->username ?? '-') }}
                                                </td>

                                                <td class="photo-td">
                                                    <img src="{{ $user->getPhotoUrlAttribute() }}"
                                                        alt="Foto de perfil del ususario" width="50" height="50">
                                                    <form
                                                        action="{{ route('admin.users-management.update-photo', $user->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="file" name="photo" class="form-input-photo" id="file_{{ $user->id }}" required>
                                                        <label for="file_{{ $user->id }}" class="btn form-label-photo">Selecciona foto</label>
                                                        <button type="submit" class=" btn update-photo">Actualizar
                                                            Foto
                                                        </button>
                                                    </form>
                                                </td>

                                                <td contenteditable="true" class="editable" data-column="email"
                                                    data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    {{-- {{ optional($user)->email }} --}}
                                                    {{ (optional($user)->email ?? '-') }}
                                                </td>

                                                <td contenteditable="true" class="editable" data-column="instagram"
                                                    data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    {{-- {{ optional($user)->instagram }} --}}
                                                    {{ (optional($user)->instagram ?? '-') }}
                                                </td>

                                                <td contenteditable="true" class="editable" data-column="webpage"
                                                    data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    {{-- {{ optional($user)->webpage }} --}}
                                                    {{ (optional($user)->webpage ?? '-') }}
                                                </td>

                                                <td class="editable" data-column="city_id" data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    <span
                                                        class="city-value value">{{ optional(optional($user)->city)->name }}</span>
                                                    <select class="form-select city-select select" style="display: none;">
                                                        <option value="">Selecciona una ciudad</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="editable" data-column="role_id" data-id="{{ $user->id }}"
                                                    data-endpoint="/admin-panel/users-management/update/{{ $user->id }}">
                                                    <span
                                                        class="role-value value">{{ optional(optional($user)->role)->name }}</span>
                                                    <select class="form-select role-select select" style="display: none;">
                                                        <option value="">Selecciona una ciudad</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="action-cell">
                                                    <div class="d-flex">
                                                        <form method="POST"
                                                            action="{{ route('admin.users-management.delete', $user->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar el usuario con ID {{ $user->id }}?')">
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
                            @include('partials.pagination', ['paginator' => $users])
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL AÑADIR USUARIO -->
        <div class="modal fade" id="create-form" tabindex="-1" aria-hidden="true" aria-labelledby="create-user">
            <div class="modal-dialog modal-dialog-centered create-modal-dialog">
                <div class="modal-content create-modal-content">
                    <div class="modal-header create-form-header">
                        <h5 class="modal-title">Añadir Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body create-form-body">
                        <form method="POST" action="{{ route('admin.users-management.create') }}"
                            enctype="multipart/form-data" class="create-form">
                            @csrf
                            <div class="form-group create-form-group">
                                <label for="name">Nombre</label>
                                <input id="name" type="text" class="form-control" name="name" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="surname">Apellidos</label>
                                <input id="surname" type="text" class="form-control" name="surname" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="username">Nombre de usuario</label>
                                <input id="username" type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="password">Contraseña</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="photo">Foto de perfil</label>
                                <input id="photo" type="file" class="form-control-file" name="photo">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="instagram">Instagram</label>
                                <input id="instagram" type="text" class="form-control" name="instagram">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="webpage">Página Web</label>
                                <input id="webpage" type="text" class="form-control" name="webpage">
                            </div>
                            <div class="form-group create-form-group">
                                <label for="city_id">Ciudad</label>
                                <select id="city_id" class="form-control form-select" name="city_id" required>
                                    <option value="" disabled selected>Elige ciudad</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group create-form-group">
                                <label for="role_id">Rol</label>
                                <select id="role_id" class="form-control form-select" name="role_id" required>
                                    <option value="" disabled selected>Elige Rol</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
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
