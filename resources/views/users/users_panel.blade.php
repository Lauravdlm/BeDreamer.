@extends('layouts.app')

@section('title', 'Panel de usuario')

@section('content')
    <div class="container user-panel-container">

        <section class="profile-container container">
            <div class="main-body">
                <div class="row">
                    <form id="form" action="{{ route('user.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="card user-panel-greetings">
                            <div class="avatar">
                                <div class="d-flex flex-column align-items-center text-center avatar-container">
                                    <div title="Cambiar foto" class="user-picture-wrapper d-flex">
                                        <img id="user-picture"
                                            src="{{ asset(Auth::user()->getPhotoUrlAttribute() ?? 'img/profile/no-avatar.png') }}"
                                            alt="Imagen perfil del usuario" class="user-photo rounded-circle">
                                        <span id="change-photo" class="change-photo">CAMBIAR FOTO</span>
                                        <input type="file" name="photo" id="photo" style="display: none;">
                                    </div>
                                </div>
                            </div>
                            <div class="user-greeting fadeInLeft">
                                <h4 class="greeting"> Hola, {{ Auth::user()->name ?? 'Invitado' }}</h4>
                                <p class="text-secondary"> <i class="bi bi-at"></i>{{ Auth::user()->username ?? ' ' }}
                                </p>
                            </div>
                            @if (Auth::user()->role_id === 1)
                                <div class="admin-btn-wrapper">
                                    <a href="{{ route('admin.index') }}" class="btn button-55 admin-btn">
                                        <span title="Ir al panel de administración">
                                            <i class="fi fi-sr-settings-sliders"></i> Panel de Administración
                                        </span>
                                    </a>
                                </div>
                            @endif
                            <div class="my-favs-link">
                                <a title="Ir a mis favoritos" href="{{ route('user.favorites') }}"
                                    class="btn button-55 favs-btn">
                                    <span title="Ir a mis favoritos">
                                        <i class="bi bi-heart-fill"></i> Mis Favoritos
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="avatar-container">
                            <div class="card user-panel-edit">
                                <div class="field input-holder">
                                    <label class="label" for="webpage">Página web</label>
                                    <a class="edit">Editar</a>
                                    <input type="text" name="webpage" id="webpage"
                                        value="{{ optional(Auth::user())->webpage }}" class="text-secondary" disabled>
                                </div>
                                <div class="field input-holder">
                                    <label class="label" for="instagram">Instagram</label>
                                    <a class="edit">Editar</a>
                                    <input type="text" name="instagram" id="instagram"
                                        value="{{ optional(Auth::user())->instagram }}" class="text-secondary" disabled>
                                </div>
                                <div class="field input-holder">
                                    <label class="label" for="name">Nombre</label>
                                    <a class="edit">Editar</a>
                                    <input type="text" name="name" id="name"
                                        value="{{ optional(Auth::user())->name }}" disabled>
                                </div>
                                <div class="field input-holder">
                                    <label class="label" for="surname">Apellidos</label>
                                    <a class="edit">Editar</a>
                                    <input type="text" name="surname" id="surname"
                                        value="{{ optional(Auth::user())->surname }}" disabled>
                                </div>
                                <div class="field input-holder">
                                    <label class="label" for="city_name">Ciudad</label>
                                    <a class="edit">Editar</a>
                                    <input type="text" name="city_name" id="city_name"
                                        placeholder="Ingrese al menos 3 letras para buscar una ciudad"
                                        value="{{ optional(optional(Auth::user())->city)->name }}" disabled>
                                    <select name="city_id" id="city_select" style="display: none;">
                                        <!-- Las opciones de las ciudades se agregarán aquí dinámicamente -->
                                    </select>
                                </div>
                                <div class="field input-holder">
                                    <label class="label" for="email">Correo electrónico</label>
                                    <input type="text" name="email" id="email"
                                        value="{{ optional(Auth::user())->email }}" disabled>
                                </div>
                                <div class="field input-holder">
                                    <label for="password">Contraseña</label>
                                    <a class="edit edit-password">Editar</a>

                                    <div class="input-pass">
                                        <input class="password" type="password" name="old_password" value="      "
                                            placeholder="Contraseña actual" disabled>
                                        <span class="input-icon">
                                            <i class="hidepassword bi bi-eye-fill"></i>
                                        </span>
                                    </div>
                                    <div class="input-pass hide-me hide">
                                        <input class="" type="password" name="new_password" value=""
                                            placeholder="Nueva contraseña">
                                        <span class="input-icon hide-me hide">
                                            <i class="hidepassword bi bi-eye-fill"></i>
                                        </span>
                                    </div>
                                    <div class="input-pass hide-me hide">
                                        <input class="" type="password" name="confirm_new_password" value=""
                                            placeholder="Confirma la nueva contraseña">
                                        <span class="input-icon hide-me hide">
                                            <i class="hidepassword bi bi-eye-fill"></i>
                                        </span>
                                    </div>

                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="submit" class="save hide btn yellow-button" title="Save"
                                        id="save">GUARDAR</button>
                                </div>
                            </div>
                        </div>
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
            </div>
        </section>
        <section class="profile-blogs-container">
            <div class="container">
                <div class="d-flex profile-blog-title">
                    <h1>Mis Blogs</h1>
                    <a href="{{ route('blog.create') }}" class="btn button-55">Añadir Nuevo Blog</a>
                </div>
                <div class="d-flex profile-blogs-list">
                    @foreach ($blogs as $blog)
                        <article>
                            <div class="card user-blogs-cards">
                                <div class="card-body user-blogs-card-body">
                                    <h5 class="card-title">{{ $blog->title }}</h5>
                                    <div class="blog-options">
                                        <a href="{{ route('blog.show', $blog->id) }}" class="btn see-btn"
                                            title="Ver"><i class="bi bi-box-arrow-right"></i></i></a>
                                        @if ($blog->user_id === auth()->id())
                                            <a href="{{ route('blog.edit', $blog->id) }}" class="btn edit-btn"
                                                title="Editar"><i class="bi bi-pencil-square"></i></a>
                                            <form method="POST" action="{{ route('blog.delete', $blog->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn delete-btn" title="Eliminar"
                                                    id="delete-btn"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este Blog: {{ $blog->title ?? '' }}?')">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            // Función para cambiar el estado del input y el texto del enlace
            // $('.edit').click(function() {
            // var input = $(this).siblings('input'); // Obtener el input asociado al enlace
            // var button = $(this).closest('.card').find('.save'); // Obtener el botón "Guardar"

            // // Cambiar el texto del enlace
            // if ($(this).text() === 'Editar') {
            // $(this).text('Cancelar');
            // input.prop('disabled', false); // Habilitar el input
            // button.removeClass('hide'); // Mostrar el botón "Guardar"
            // } else {
            // $(this).text('Editar');
            // input.prop('disabled', true); // Deshabilitar el input
            // button.addClass('hide');
            // }
            // });


            // Función para cambiar el estado del input y el texto del enlace
            $('.edit').click(function() {
                var input = $(this).siblings('input'); // Obtener el input asociado al enlace
                var button = $(this).closest('.card').find('.save'); // Obtener el botón "Guardar"
                var newText = ($(this).text() === 'Editar') ? 'Cancelar' : 'Editar';

                // Cambiar el texto del enlace
                $(this).text(newText);

                // Habilitar o deshabilitar el input
                input.prop('disabled', newText === 'Editar');

                // Mostrar u ocultar el botón "Guardar"
                var hayEdicionActiva = false;
                $('.edit').each(function() { // Por cada
                    if ($(this).text() === 'Cancelar') {
                        hayEdicionActiva = true;
                        return false; // Salir del bucle
                    }
                });
                button.toggleClass('hide', !hayEdicionActiva);
            });


            //Simular un click en el input de la foto al clicar en "Cambiar Foto"
            $('#change-photo').click(function() {
                $('#photo').click();
            });
            // Evento de cambio para el input de tipo archivo
            $('#photo').change(function() {
                $('#form').submit(); // Envía el formulario cuando se selecciona una foto
            });

            // Obtener el valor del input
            var passwordValue = $('input[name="old_password"]').val();

            //Evento al clicar en editar password
            $('.edit-password').click(function() {
                $('.hide-me').toggleClass('hide');
                // Verificar si se está editando la contraseña
                if ($(this).text() === 'Cancelar') {
                    // Si se está editando, eliminar el valor del campo de contraseña
                    $('input[name="old_password"]').val('');
                    $('input[name="old_password"]').prop('disabled', false);
                } else {
                    $(this).text('Editar');
                    $('input[name="old_password"]').val(passwordValue);
                    $('input[name="old_password"]').prop('disabled', true); // Deshabilitar el input
                }
            });

            // Manejar el clic en el ícono del ojo solo cuando la edición de contraseña esté activa
            $('.hidepassword').click(function() {
                // Verificar si la edición de contraseña está activa
                if ($('.edit-password').text() === 'Cancelar') {
                    // Obtener el input asociado al ícono del ojo
                    // var input = $(this).siblings('input');
                    var input = $(this).closest('.input-pass').find('input');

                    // Cambiar el tipo de entrada del input
                    if (input.attr('type') === 'password') {
                        input.attr('type', 'text');
                        // Cambiar el ícono del ojo a tachado
                        $(this).removeClass('bi-eye-fill').addClass('bi-eye-slash');
                    } else {
                        input.attr('type', 'password');
                        // Cambiar el ícono del ojo a lleno
                        $(this).removeClass('bi-eye-slash').addClass('bi-eye-fill');
                    }
                }
            });
            // Buscador dinámico de ciudades
            $('#city_name').on('keyup', function() {
                var query = $(this).val();
                if (query.length >= 3) {
                    $.ajax({
                        url: "{{ route('cities.search') }}",
                        type: 'POST',
                        data: {
                            query: query,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#city_select').html(data).show();
                            $('#city_select').show();
                        }
                    });
                } else {
                    $('#city_select').html('').hide();
                    $('#city_select').hide();
                }
            });

            // Evento de cambio para el select de ciudades
            $('#city_select').change(function() {
                var selectedCity = $(this).val();
                var cityName = $('#city_select option:selected').text();
                $('#city_name').val(cityName).prop('disabled',
                    false); // Habilitar el input de nombre de la ciudad
                $('input[name="city_id"]').val(selectedCity); // Establecer el valor del ID de la ciudad
                $('#city_select').hide();
            });


        });
    </script>
@endsection
