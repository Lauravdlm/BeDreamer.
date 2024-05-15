@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Administrador | Gestión de Blogs')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE BLOGS</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.blogs-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.blogs-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Blogs</h4>
                </div>
                <div class="data-table-wrapper">
                    <div class="data-table-content-wrapper table-responsive">
                        <div class="card">
                            <div class="card-body table-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Contenido</th>
                                            <th>Portada</th>
                                            <th>Usuario</th>
                                            <th>Destino</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($blogs as $blog)
                                            <tr>
                                                <td>{{ $blog->id }}</td>
                                                <td contenteditable="true" class="editable" data-column="title"
                                                    data-id="{{ $blog->id }}"
                                                    data-endpoint="/admin-panel/blogs-management/update/{{ $blog->id }}">
                                                    {{ optional($blog)->title }}
                                                </td>
                                                <td contenteditable="false" data-column="content"
                                                    data-id="{{ $blog->id }}" title="{{ $blog->content }}">
                                                    {{ Str::limit(optional($blog)->content, 50) }}
                                                </td>
                                                <td class="photo-td">
                                                    <img src="{{ $blog->getPhotoUrlAttribute() }}"
                                                        alt="Foto de portada del blog" width="50" height="50">
                                                    <form
                                                        action="{{ route('admin.blogs-management.update-photo', $blog->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="file" name="photo" class="form-input-photo"
                                                            id="file_{{ $blog->id }}" required>
                                                        <label for="file_{{ $blog->id }}" class="btn form-label-photo">Selecciona
                                                            foto</label>
                                                        <button type="submit" class=" btn update-photo">Actualizar
                                                            Foto
                                                        </button>
                                                    </form>
                                                </td>
                                                <td contenteditable="false" data-column="user_id"
                                                    data-id="{{ $blog->id }}">
                                                    <span
                                                        class="user-value value">{{ optional(optional($blog)->user)->name }}</span>
                                                </td>
                                                <td class="editable" data-column="place_id" data-id="{{ $blog->id }}"
                                                    data-endpoint="/admin-panel/blogs-management/update/{{ $blog->id }}">
                                                    <span
                                                        class="place-value value">{{ optional(optional($blog)->place)->name }}</span>
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
                                                            action="{{ route('admin.blogs-management.delete', $blog->id) }}"
                                                            class="ajax-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar el blog con ID {{ $blog->id }}?')">
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
                            <!-- Paginación -->
                            <div class="pagination-outer">
                                @include('partials.pagination', ['paginator' => $blogs])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
