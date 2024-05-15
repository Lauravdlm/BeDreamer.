import axios from "axios";

// Establecer la URL base de la API
axios.defaults.baseURL = "http://127.0.0.1:8000";
// axios.defaults.baseURL = "http://bedreamer.divli.fr/";

// Permitir cookies con CORS
axios.defaults.withCredentials = true;

// Obtener el token de localStorage
const token = localStorage.getItem("token");

// Si hay un token, configurar el encabezado Authorization para todas las solicitudes
if (token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}

// Interceptar todas las solicitudes y agregar el token de autenticación si está disponible
axios.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem("token");
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default axios;
