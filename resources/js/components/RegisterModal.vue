<template>
    <!-- Modal Crear Usuario -->
    <div
        class="modal fade create-login-modal"
        id="createUserModal"
        tabindex="-1"
        aria-labelledby="createUserModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered create-login-modal-dialog" role="dialog">
            <div class="modal-content create-login-modal-content">
                <div class="modal-header create-login-modal-header">
                    <div class="form-title text-center">
                        <h4>Crear Cuenta</h4>
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
                    <div class="d-flex flex-column text-center">
                        <form @submit.prevent="register" method="post">
                            <div class="form-group">
                                <input
                                    v-model="username"
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    placeholder="Nombre de usuario"
                                    required
                                />
                            </div>

                            <div class="form-group">
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    v-model="email"
                                    placeholder="Email"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    v-model="password"
                                    placeholder="Contraseña"
                                    required
                                />
                            </div>
                            <p v-if="errorMessage" class="error">
                                {{ errorMessage }}
                            </p>
                            <div class="modal-footer">
                                <button type="submit" class="btn yellow-button">
                                    Registrarse
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: "",
            email: "",
            password: "",
            errorMessage: "",
        };
    },
    methods: {
        register() {
            // Validar los campos del formulario
            if (!this.email || !this.password || !this.username) {
                console.error("Por favor, complete todos los campos.");
                return;
            }

            // Realizar la solicitud POST al backend para registrar al usuario
            axios
                .post("/register", {
                    username: this.username,
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    // Limpiar los campos del formulario después de registrar al usuario
                    this.username = "";
                    this.email = "";
                    this.password = "";
                    // Cerrar el modal después de registrar al usuario
                    $("#createUserModal").modal("hide");
                    //  Toast.fire({
                    //   icon: "success",
                    //   title: "Usuario registrado correctamente",
                    //   showConfirmButton: false,
                    //   timer: 2000,
                    //  });
                    console.log("Usuario registrado correctamente.");
                })
                .catch((error) => {
                    // Manejar errores de registro
                    // Toast.fire({
                    //   icon: "error",
                    //   title: "Error al registrar al usuario",
                    //   showConfirmButton: false,
                    //   timer: 2000,
                    //  });
                    console.error("Error al registrar al usuario:", error);
                });
        },
        closeModal() {
            $("#createUserModal").modal("hide");
        },
    },
};
</script>
