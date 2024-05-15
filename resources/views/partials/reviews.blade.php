<section class="container comment-section">
    <div class="row height d-flex justify-content-center align-items-center">
        <div class="card comment-card">
            <div class="p-2">
                <h6>Reseñas <small class="comments-counts">({{ $reviews->count() }})</small></h6>
                <h6>Media <small class="average-reviews"> ({{ number_format($averageScore, 2) }} <i
                            class="bi bi-star-fill"></i>) </small></h6>
            </div>
            <!--  SÓLO USUARIOS AUTENTICADOS PODRÁN DEJAR RESEÑAS -->
            @auth
                @if (Auth::check())
                    <div class="mt-2 d-flex flex-row align-items-start p-3 form-comment">
                        <img src="{{ auth()->user()->getPhotoUrlAttribute() }}" width="50" height="50"
                            class="rounded-circle mr-2" />
                        <form action="{{ route($type . '.review.store', [$entity => $entity_id]) }}" method="post"
                            id="comment-form">
                            @csrf
                            <input type="hidden" name="entity_id" value="{{ $entity_id }}">
                            <div class="rating-div">
                                {{-- <label class="form-label" for="score">Puntuación*:</label> --}}
                                <div class="star-rating">
                                    <i class="bi bi-star" data-rating="1"></i>
                                    <i class="bi bi-star" data-rating="2"></i>
                                    <i class="bi bi-star" data-rating="3"></i>
                                    <i class="bi bi-star" data-rating="4"></i>
                                    <i class="bi bi-star" data-rating="5"></i>
                                </div>
                            </div>
                            <input type="hidden" name="score" id="score" required>
                            <input type="text" class="form-control" id="review" name="content"
                                placeholder="Añade tu reseña.." rows="8" aria-required="true" required></textarea>
                            <button name="submit" type="submit" id="submit" class="btn yellow-button"
                                placeholder="Enviar">Enviar</button>
                        </form>
                    </div>
                @endif
            @endauth
            @foreach ($reviews as $review)
                <div class="mt-2">
                    <div class="d-flex flex-row p-3">
                        <img src="{{ $review->user->getPhotoUrlAttribute() }}" width="40" height="40"
                            class="rounded-circle mr-3 user-photo-comment" />
                        <div class="w-100 comment-content-wrapper">
                            <div class="d-flex align-items-start comment-content">
                                <div class="d-flex flex-row align-items-center">
                                    <span class="mr-2 comment-name">{{ $review->user->name }}
                                        <small class="comment-username"><i
                                                class="bi bi-at"></i>{{ $review->user->username }}</small>
                                    </span>
                                </div>
                                <span class="comment-date">
                                    <small>{{ $review->creat_at_diff }}</small>
                                </span>
                            </div>
                            <div class="review-content">
                                <div class="star-rating">
                                    <small>{{ $review->score }}</small>
                                    <!-- Función para generar estrellas dependiendo de la puntuación -->
                                    @php
                                        $rating = $review->score;
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <i class="fi fi-sr-star"></i>
                                        @else
                                            <i class="fi fi-rr-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-justify comment-text mb-0">
                                {{ $review->content }}
                            </p>
                            <!-- SÓLO USUARIOS AUTENTICADOS  Y ADMINISTRADORES PODRÁN ELIMINAR RESEÑAS -->
                            @if (Auth::check() && Auth::user()->role->name === 'Administrador')
                                <form action="{{ route('admin.reviews-management.delete', ['id' => $review->id]) }}"
                                    method="POST" class="delete-form-comment">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" title="Eliminar reseña"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta reseña?')">
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
