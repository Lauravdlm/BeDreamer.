<template>
    <!-- Botón panel de usuario -->
    <div class="users-login">
        <a href="#" @click.prevent="openModal">
            <span class="user-icon">
                <i class="fi fi-rs-user"></i>
            </span>
        </a>
    </div>

    <!-- Modal Inicio Sesión -->
    <div
        class="modal fade create-login-modal"
        id="loginModal"
        tabindex="-1"
        aria-labelledby="loginModalLabel"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-dialog-centered create-login-modal-dialog"
            role="dialog"
        >
            <div class="modal-content create-login-modal-content">
                <div class="modal-header create-login-modal-header">
                    <div class="form-title text-center">
                        <h4>Acceso</h4>
                    </div>
                    <button
                        type="button"
                        class="close-modal-button"
                        data-dismiss="modal"
                        aria-label="Close"
                        @click="closeModal"
                    >
                        <span aria-hidden="true">
                            <i class="bi bi-x-lg"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body create-login-modal-body">
                    <!-- Si está autenticado-->
                    <div class="users-panel-wrapper" v-if="isAuthenticated">
                        <div class="users-panel">
                            <div class="user-name-and-photo d-flex">
                                <div class="user-photo-wrapper">
                                    <img
                                        class="user-avatar rounded-circle"
                                        :src="userPhotoUrl(photo)"
                                        alt="Foto de usuario"
                                    />
                                </div>
                                <div class="user-name-wrapper-panel-link">
                                    <a class="nav-link" :href="userPanelRoute"
                                    >{{ name }} {{ surname }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Botón para cerrar sesión -->
                        <button
                            @click="logout"
                            class="btn btn-logout yellow-button"
                        >
                            Cerrar sesión
                        </button>
                    </div>
                    <!-- Mostrar formulario de inicio de sesión si no está autenticado -->
                    <div class="d-flex flex-column text-center" v-else>
                        <form @submit.prevent="login" method="post">
                            <input
                                type="hidden"
                                name="_token"
                                :value="csrfToken"
                            />
                            <div class="form-group">
                                <input
                                    v-model="email"
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    autocomplete="email"
                                    placeholder="Email"
                                    required
                                />
                            </div>
                            <div class="form-group singin-input-wrapper">
                                <input
                                    v-model="password"
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    placeholder="Contraseña"
                                    autocomplete="password"
                                    required
                                />
                            </div>
                            <button
                                type="submit"
                                class="btn btn-signin yellow-button"
                            >
                                Iniciar sesión
                            </button>
                            <p v-if="errorMessage" class="error">
                                {{ errorMessage }}
                            </p>
                        </form>
                        <div
                            class="modal-footer d-flex justify-content-center create-login-modal-footer"
                        >
                            <!-- Abrir modal de registrar usuario-->
                            <div class="signup-section">
                                <span class="text-info"
                                >¿No tienes cuenta?
                                    <i class="bi bi-arrow-down-short"></i
                                    ></span>
                                <button
                                    class="btn logout-btn button-55"
                                    role="button"
                                    @click="openRegisterModal"
                                >
                                    Crear cuenta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    emits: ["open-register-modal", "open-register-modal"], // Declarar el evento openRegisterModal como un evento personalizado del componente

    data() {
        return {
            isAuthenticated: false, // Variable para verificar si el usuario está autenticado
            csrfToken: "{{ csrf_token() }}",
            email: "",
            password: "",
            errorMessage: "",
            name: "",
            surname: "",
            photo: "",
            userPanelRoute: "/user-panel", // Ruta del panel de usuario
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
        openRegisterModal() {
            console.log("Evento open-register-modal emitido");
            $("#loginModal").modal("hide"); // Ocultar el modal de inicio de sesión
            $("#createUserModal").modal("show"); // Mostrar el modal de registro
            this.$emit("open-register-modal"); // Emitir el evento open-register-modal
        },
        openModal() {
            $("#loginModal").modal("show");
        },
        closeModal() {
            $("#loginModal").modal("hide");
        },
        async login() {
            try {
                this.errorMessage = "";
                const response = await axios.post("/login", {
                    email: this.email,
                    password: this.password,
                });

                const token = response.data.token;
                localStorage.setItem("token", token);
                this.isAuthenticated = true;
                this.closeModal();
                this.getUserData();
                // Recargar la página
                window.location.reload();
                //  Toast.fire({
                //    icon: "success",
                //      title: "¡Inicio de sesión exitoso!",
                //      showConfirmButton: false,
                //   timer: 3000,
                //    });
                console.log("Usuario autenticado");
            } catch (error) {
                this.errorMessage = error.response.data.error;
                // Toast.fire({
                //    icon: "error",
                //     title: "Error al iniciar sesión",
                //    showConfirmButton: false,
                //   timer: 2000,
                //  });
                console.error("Error al iniciar sesión:", error);
            }
        },
        async logout() {
            try {
                await axios.post("/logout");
                localStorage.removeItem("token");
                this.isAuthenticated = false;
                this.email = "";
                this.password = "";
                this.name = "";
                this.surname = "";
                this.photo = "";
                window.location.href = "/";
                //Toast.fire({
                //   icon: "success",
                //   title: "Cerrado de sesión exitoso!",
                //   showConfirmButton: false,
                //   timer: 2000,
                //  });
                console.log("Usuario ha cerrado sesión");
            } catch (error) {
                //Toast.fire({
                // icon: "error",
                // title: "Error al cerrar sesión",
                // showConfirmButton: false,
                //  timer: 2000,
                //  });
                console.error("Error al cerrar sesión:", error);
            }
        },
        async getUserData() {
            try {
                const token = localStorage.getItem("token");
                const response = await axios.get("/user", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });
                const userData = response.data;
                if (userData) {
                    this.name = userData.name || "Invitado";
                    this.surname = userData.surname || "";
                    this.photo = userData.photo || "/no-avatar.png";
                }
            } catch (error) {
                // Manejar la respuesta del servidor
                if (error.response.status === 401) {
                    console.info(
                        "No se pudo obtener datos del usuario: Usuario no autenticado."
                    );
                    this.isAuthenticated = false; // Establecer isAuthenticated en false si la solicitud no está autorizada
                } else {
                    console.error("Error al obtener datos del usuario:", error);
                }
            }
        },
    },
    created() {
        // Verificar si hay un token almacenado al cargar la aplicación
        const token = localStorage.getItem("token");
        if (token) {
            this.isAuthenticated = true;
            this.getUserData(); // Obtener los datos del usuario después de cargar la aplicación si está autenticado
        } else {
            console.info(
                "No hay token de autenticación, el usuario no está autenticado."
            );
            this.isAuthenticated = false;
        }
    },
};
</script>
