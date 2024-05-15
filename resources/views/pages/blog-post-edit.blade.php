@extends('layouts.app')

@section('title', $blog->title . ' | Editar')

@section('content')
    <div class="container blog-edit-container blog-edit-create-container">
        <form id="form" action="{{ route('blog.update', ['id' => $blog->id]) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <fieldset>
                <leyend>
                    @if (request()->routeIs('blog.edit'))
                        <h1>Panel de edición</h1>
                    @elseif (request()->routeIs('blog.create'))
                        <h1>Panel de creación</h1>
                    @endif
                </leyend>

                <div class="blog-edit-title input-holder">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" name="title" value="{{ $blog->title }}" class="form-control" maxlength="50">
                </div>

                <div class="blog-edit-photo input-holder">
                    <div title="Cambiar portada del Blog" class="blog-picture-wrapper">
                        <label for="photo" class="form-label">Portada</label>
                        <img src="{{ $blog->getPhotoUrlAttribute() }}" alt="Portada del Blog" class="blog-photo">
                        <input id="change-photo" type="file" name="photo" id="photo" class="form-control">
                    </div>
                </div>

                <div class="blog-edit-content input-holder">
                    <label for="content" class="form-label">Contenido</label>
                    <textarea id="content" name="content">{{ $blog->content }}</textarea>
                </div>

                <div class="blog-edit-city input-holder">
                    <label for="place_id" class="form-label">Destino</label>
                    <select name="place_id" class="form-control">
                        @foreach ($places as $place)
                            <option value="{{ $place->id }}" {{ $blog->place_id == $place->id ? 'selected' : '' }}>
                                {{ $place->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn yellow-button save" title="Guardar Blog" id="save">
                        <span>Guardar
                            <i class="bi bi-send"></i>
                        </span>
                    </button>
                </div>
            </fieldset>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script defer>
        $(document).ready(function() {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    removePlugins: ['CodeBlock', 'Code'],
                    // Configuración específica del Simple Upload Adapter
                    simpleUpload: {
                        // URL del endpoint de carga de archivos en Laravel
                        uploadUrl: '{{ route('photoblog.upload') }}',
                        fieldName: 'upload',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                        }
                    },

                })
                .then(editor => {
                    // Escucha el evento 'change' para capturar el valor del contenido cuando cambia
                    editor.model.document.on('change:data', () => {
                        // Obtén el contenido del editor
                        const content = editor.getData();
                        // Asigna el contenido al campo textarea adecuado
                        document.querySelector('#content').value = content;
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
