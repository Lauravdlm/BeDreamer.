@extends('admin.layouts.admin-app')

@section('title', 'BackOffice | Gestión de Comentarios')

@section('admin-content')
    <div class="content-wrapper" id="admin-main">
        <h2>GESTIÓN DE COMENTARIOS</h2>
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex align-items-center search-filter-add-users">
                    <div class="search-field-wrapper">
                        <div class="search-inner">
                            <form action="{{ route('admin.comments-management.search') }}" method="GET">
                                @csrf
                                <div class="input-group inputs-form-user-table">
                                    <input type="text" class="form-control" name="search" placeholder="Buscar..."
                                        value="{{ $searchQuery ?? '' }}" minlength="1">
                                    <button type="submit" class="btn btn-dark btn-block">Buscar</button>
                                    <a href="{{ route('admin.comments-management.index') }}" class="btn btn-danger"><i
                                            class="fi fi-sr-undo"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="data-table-title">
                    <h4>Lista de Comentarios</h4>
                </div>
                <div class="data-table-wrapper">
                    <div class="data-table-content-wrapper table-responsive">
                        <div class="card">
                            <div class="card-body table-body">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Contenido</th>
                                            <th>Usuario</th>
                                            <th>Blog</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $comment)
                                            <tr>
                                                <td contenteditable="false" data-column="id" data-id="{{ $comment->id }}">
                                                    {{ $comment->id }}</td>
                                                <td contenteditable="false" data-column="content"
                                                    data-id="{{ $comment->id }}">
                                                    {{ Str::limit(optional($comment)->content, 50) }}
                                                </td>
                                                <td contenteditable="false" data-column="user_id"
                                                    data-id="{{ $comment->id }}">
                                                    <span
                                                        class="user-value value">{{ optional(optional($comment)->user)->name }}</span>
                                                </td>
                                                <td contenteditable="false" data-column="blog_id"
                                                    data-id="{{ $comment->id }}">
                                                    <span
                                                        class="blog-value value">{{ optional(optional($comment)->blog)->title }}</span>
                                                </td>
                                                <td class="action-cell">
                                                    <div class="d-flex">
                                                        <form method="POST"
                                                            action="{{ route('admin.comments-management.delete', $comment->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="return confirm('¿Estás seguro de que deseas eliminar el comentario con ID {{ $comment->id }}?')">
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
                            @include('partials.pagination', ['paginator' => $comments])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
