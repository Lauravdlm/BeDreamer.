<template>
    <Carousel v-bind="settings" :breakpoints="breakpoints">
        <Slide v-for="place in places" :key="place.id">
            <a :href="placeUrl(place.id)" class="carousel__item">
                <div class="card">
                    <div class="image-wrapper">
                        <img
                            :src="photoUrl(place.photo)"
                            class="card-img-top"
                            :alt="'Foto de ' + place.name"
                        />
                    </div>
                    <div class="card-body carousel-card-body">
                        <h5 class="card-title">
                            <a class="nav-link" :href="placeUrl(place.id)">{{
                                place.name
                            }}</a>
                        </h5>
                    </div>
                </div>
            </a>
        </Slide>

        <template #addons>
            <Navigation />
        </template>
    </Carousel>
</template>

<script>
import { defineComponent } from "vue";
import { Carousel, Navigation, Slide } from "vue3-carousel"; // Importamos librería vue3-carousel para la formación de los sliders
import "vue3-carousel/dist/carousel.css"; // Importamos los estilos de librería vue3-carousel

export default defineComponent({
    name: "DestinationCarousel",
    components: {
        Carousel,
        Slide,
        Navigation,
    },
    props: {
        places: {
            type: Array,
            required: true,
        },
    },
    methods: {
        placeUrl(placeId) {
            return `/place/${placeId}`;
        },
        photoUrl(photoFileName) {
            if (photoFileName) {
                // Si hay una imagen especificada, devuelve la ruta completa de esa imagen
                return `/storage/places_photos/${photoFileName}`;
            } else {
                // Si no hay imagen especificada, devuelve la ruta de la imagen genérica
                return "/storage/no-available-image.jpg";
            }
        },
    },
    data() {
        return {
            settings: {
                itemsToShow: 1,
                snapAlign: "center",
            },
            // Puntos de ruptura
            breakpoints: {
                576: {
                    itemsToShow: 2,
                    snapAlign: "center",
                },
                768: {
                    itemsToShow: 3,
                    snapAlign: "center",
                },
                992: {
                    itemsToShow: 3,
                    snapAlign: "center",
                },
                1200: {
                    itemsToShow: 4,
                    snapAlign: "start",
                },
                1440: {
                    itemsToShow: 5,
                    snapAlign: "start",
                },
            },
        };
    },
});
</script>
