<section class="container comment-section">
    <div class="row height d-flex justify-content-center align-items-center">
        <div class="card comment-card">
            <div class="p-2">
                <h6>Comentarios <small class="comments-counts">({{ $comments->count() }})</small></h6>
            </div>
            <!--  SÓLO USUARIOS AUTENTICADOS PODRÁN DEJAR COMENTARIOS -->
            @auth
                @if (Auth::check())
                    <div class="mt-2 d-flex flex-row align-items-start p-3 form-comment">
                        <img src="{{ auth()->user()->getPhotoUrlAttribute() }}" width="50" height="50" class="rounded-circle mr-2" />
                        <form action="{{ route('comments.store', ['blog' => $blog->id]) }}" method="post"
                            id="comment-form">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                            <input type="text" id="comment" name="content" class="form-control"
                                placeholder="Deja tu comentario..." required />
                            <button name="submit" type="submit" id="submit" class="btn yellow-button"
                                placeholder="Enviar">Enviar</button>
                        </form>
                    </div>
                @endif
            @endauth
            @foreach ($comments as $comment)
                <div class="mt-2">
                    <div class="d-flex flex-row p-3">
                        <img src="{{ $comment->user->getPhotoUrlAttribute() }}" width="40" height="40"
                            class="rounded-circle mr-3 user-photo-comment" />

                        <div class="w-100 comment-content-wrapper">
                            <div class="d-flex align-items-start comment-content">
                                <div class="d-flex flex-row align-items-center">
                                    <span class="mr-2 comment-name">{{ $comment->user->name }}
                                        <small class="comment-username"><i
                                                class="bi bi-at"></i>{{ $comment->user->username }}</small>
                                    </span>
                                </div>
                                <span class="comment-date">
                                    <small>{{ $comment->creat_at_diff }}</small>
                                </span>
                            </div>
                            <p class="text-justify comment-text mb-0">
                                {{ $comment->content }}
                            </p>
                            <!-- SÓLO USUARIOS AUTENTICADOS  Y ADMINISTRADORES PODRÁN ELIMINAR COMENTARIOS -->
                            @if (Auth::check() && Auth::user()->role->name === 'Administrador')
                                <form action="{{ route('admin.comments-management.delete', ['id' => $comment->id]) }}"
                                    method="POST" class="delete-form-comment">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" title="Eliminar comentario"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
