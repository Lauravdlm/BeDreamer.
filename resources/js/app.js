// Importa Bootstrap
import "./bootstrap";
// Importamos Vue
import { createApp } from "vue";
// Importamos SweetAlert
import Swal from "sweetalert2";
// Importamos axios
import axios from "./axios";
// Importamos AdminLTE
import 'admin-lte';
// Importamos Charts.js
import 'chart.js';
import Chart from 'chart.js/auto';

// Inicialización global de axios
window.axios = axios;
// Iniciamos Chart.js globalmente para que sea accesible
window.Chart = Chart;

// Configurar SweetAlert2
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: false,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    },
});
// Iniciamos Toast de SweetAlert globalmente para que sea accesible
window.Toast = Toast;
// Iniciamos SweetAlert globalmente para que sea accesible
window.Swal = Swal;

// Importar componentes
import BurgerMenu from "./components/BurgerMenu.vue";
import DestinationCarousel from "./components/DestinationCarousel.vue";
import BlogCarousel from "./components/BlogCarousel.vue";
import LoginModal from "./components/LoginModal.vue";
import RegisterModal from "./components/RegisterModal.vue";

// Crear y montar la aplicación Vue para el componente BurgerMenu
const burgermenu = createApp({});
burgermenu.component("burger-menu", BurgerMenu);
burgermenu.mount("#burgermenu");

// Crear y montar la aplicación Vue para el componente Carousel
const destinationcarousel = createApp({});
destinationcarousel.component("destination-carousel", DestinationCarousel);
destinationcarousel.mount("#destination-carousel");

const blogcarousel = createApp({});
blogcarousel.component("blog-carousel", BlogCarousel);
blogcarousel.mount("#blog-carousel");

// Crear y montar la aplicación Vue para el componente LoginModal
const optionmodal = createApp({});
optionmodal.component("user-option", LoginModal);
optionmodal.component("register-component", RegisterModal);
optionmodal.mount("#options-list");
