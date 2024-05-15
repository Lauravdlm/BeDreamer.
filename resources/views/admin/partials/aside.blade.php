<aside class="sidebar-admin main-sidebar sidebar-dark-primary hide" id="sidenav-main">
    <!-- Título del sidebar -->
    <a class="d-flex align-items-center justify-content-center brand-link"
        href="{{ route('admin.index') }}">
        <div class="sidebar-admin-icon">
            <i class="nav-icon fi fi-rr-settings-sliders"></i>
        </div>
        <span class="brand-text font-weight-light">ADMINISTRACIÓN</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <!-- Divisor -->
                <hr class="sidebar-divider my-0">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.index') }}">
                        <i class="nav-icon fi fi-ss-chart-histogram"></i>
                        <span>Dashboard</span></a>
                </li>
                <!-- Divisor -->
                <hr class="sidebar-divider">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users-management.index') }}">
                        <i class="nav-icon fi fi-ss-users-alt"></i>
                        <span>Gestión de usuarios</span>
                    </a>
                </li>
                <!-- Divisor -->
                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#place-collaspse" role="button"
                        aria-expanded="false" aria-controls="place-collaspse" id="collapse-nav-item">
                        <i class="nav-icon fi fi-sr-land-layer-location"></i>
                        <span>Gestión de ubicaciones</span>
                        <i class="bi bi-caret-down-fill"></i>
                    </a>
                </li>
                <div class="collapse" id="place-collaspse">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.places-management.index') }}">
                            <span>Destinos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.cities-management.index') }}">
                            <span>Ciudades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"href="{{ route('admin.countries-management.index') }}">
                            <span>Países</span>
                        </a>
                    </li>
                </div>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.blogs-management.index') }}">
                        <i class="nav-icon fi fi-br-blog-text"></i>
                        <span>Blogs</span>
                    </a>
                </li>
                <!-- Divisor -->
                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.restaurants-management.index') }}">
                        <i class="nav-icon fi fi-rr-restaurant"></i>
                        <span>Restaurantes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.hotels-management.index') }}">
                        <i class="nav-icon fi fi-sr-bed"></i>
                        <span>Hoteles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.activities-management.index') }}">
                        <i class="nav-icon fi fi-rr-palette"></i>
                        <span>Actividades</span>
                    </a>
                </li>
                <!-- Divisor -->
                <hr class="sidebar-divider">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.comments-management.index') }}">
                        <i class="nav-icon bi bi-chat-dots"></i>
                        <span>Comentarios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.reviews-management.index') }}">
                        <i class="nav-icon bi bi-star-fill"></i>
                        <span>Reseñas</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.favorites-management.index') }}">
                        <i class="nav-icon bi bi-chat-square-heart-fill"></i>
                        <span>Favoritos</span>
                    </a>
                </li>
                <!-- Divisor -->
                <hr class="sidebar-divider">
                <li class="nav-item" id="nav-item-back">
                    <a class="nav-link" href="{{ route('home') }}">
                        <span>
                            <p>Volver a Inicio</p>
                            <i class="fi fi-rr-address-card"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
