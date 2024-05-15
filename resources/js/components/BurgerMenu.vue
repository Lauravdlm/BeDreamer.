<template>
    <div>
        <button @click="toggleNav" class="burger-button">
            <i
                :class="
                    isNavVisible
                        ? 'fi fi-rr-bars-staggered'
                        : 'fi fi-rr-menu-burger'
                "
            ></i>
        </button>
        <div :class="{ active: isNavVisible }" id="navbarNav">
            <nav class="navbar-nav-wrapper">
                <button @click="toggleNav" class="burger-button-close">
                    <i class="fi fi-br-cross"></i>
                </button>
                <ul class="navbar-nav">
                    <li
                        class="nav-item"
                        :class="{ active: isActiveRoute(home) }"
                    >
                        <a
                            class="nav-link"
                            :href="home"
                            @click="changeRoute(home)"
                            >Inicio</a
                        >
                    </li>
                    <li
                        class="nav-item"
                        :class="{ active: isActiveRoute(places) }"
                    >
                        <a
                            class="nav-link"
                            :href="places"
                            @click="changeRoute(places)"
                            >Explorar Destinos</a
                        >
                    </li>
                    <li
                        class="nav-item"
                        :class="{ active: isActiveRoute(blogs) }"
                    >
                        <a
                            class="nav-link"
                            :href="blogs"
                            @click="changeRoute(blogs)"
                            >Blogs</a
                        >
                    </li>
                    <div v-if="isAuthenticated">
                        <li class="user-name-photo">
                            <img
                                class="user-avatar rounded-circle"
                                :src="userPhotoUrl(photo)"
                                alt="Foto de usuario"
                            />
                            <p>{{name}} {{surname}}</p>

                        </li>
                        <li
                            class="nav-item"
                            :class="{ active: isActiveRoute(userPanelRoute) }"
                        >
                            <a
                                class="nav-link"
                                :href="userPanelRoute"
                                @click="changeRoute(userPanelRoute)"
                                >Mi perfil</a
                            >
                        </li>
                        <li
                            class="nav-item"
                            :class="{
                                active: isActiveRoute(userFavoriteRoute),
                            }"
                        >
                            <a
                                class="nav-link"
                                :href="userFavoriteRoute"
                                @click="changeRoute(userFavoriteRoute)"
                                >Mis favoritos</a
                            >
                        </li>
                        <!-- Sólo para usuarios con rol de Administrador -->
                        <div v-if="isAdmin" class="nav-admin-section">
                            <li
                                class="nav-item"
                                :class="{
                                    active: isActiveRoute(adminPanelRoute),
                                }"
                            >
                                <a
                                    class="nav-link"
                                    :href="adminPanelRoute"
                                    @click="changeRoute(adminPanelRoute)"
                                    >Panel de Administración</a
                                >
                            </li>
                        </div>
                    </div>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isNavVisible: false, // Variable para ocultar el div correspondiente al login
            isAuthenticated: false, // Variable para verificar si el usuario está autenticado
            isAdmin: false, // Variable para verificar si el usuario es administrador
            userPanelRoute: "/user-panel",
            userFavoriteRoute: "/user-favorites",
            home: "/",
            blogs: "/blogs",
            places: "/places",
            adminPanelRoute: "/admin-panel", // Ruta hacia el panel de administrador
            name: "",
            surname: "",
            photo: "",
            currentRoute: window.location.pathname,
        };
    },
    methods: {
        userPhotoUrl(photoFileName) {
            if (photoFileName) {
                // Si hay una foto de perfil asignada, devuelve la ruta completa de esa foto
                return `/storage/profile_photos/${photoFileName}`;
            } else {
                // Si no hay foto de perfil asignada, devuelve la ruta de la imagen genérica
                return "/storage/profile_photos/no-avatar.png";
            }
        },
        changeRoute(route) {
            this.currentRoute = route;
        },
        isActiveRoute(route) {
            return this.currentRoute === route;
        },
        toggleNav() {
            this.isNavVisible = !this.isNavVisible;
        },
        async checkAuthentication() {
            try {
                const token = localStorage.getItem("token"); // Obtener el token de localStorage

                // Verificar si hay un token presente
                if (!token) {
                    console.info(
                        "No hay token de autenticación, el usuario no está autenticado."
                    );
                    this.isAuthenticated = false;
                    return;
                }

                const response = await axios.get("/user", {
                    headers: {
                        Authorization: `Bearer ${token}`, // Enviar el token en el encabezado de Autorización
                    },
                });

                // Manejar la respuesta del servidor
                const userData = response.data;
                this.name = userData.name;
                this.surname = userData.surname;
                this.photo = userData.photo;
                this.isAuthenticated = true;
                // Después de obtener los datos del usuario, verifica si es administrador
                this.isAdmin = userData.role_id === 1; // Si es igual a 1, es un usuario administrador
            } catch (error) {
                console.info(
                    "Error al obtener los datos del usuario, no está autenticado"
                );
                this.isAuthenticated = false;
            }
        },
    },
    created() {
        // Verificar si hay un token almacenado al cargar la aplicación
        const token = localStorage.getItem("token");
        // Verificar si hay un token presente antes de llamar a la función checkAuthentication()
        if (token) {
            this.checkAuthentication();
        } else {
            console.info(
                "No hay token de autenticación, el usuario no está autenticado."
            );
            this.isAuthenticated = false;
        }
    },
};
</script>
