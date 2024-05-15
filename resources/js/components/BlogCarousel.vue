<template>
    <Carousel v-bind="settings" :breakpoints="breakpoints">
        <Slide v-for="blog in blogs" :key="blog.id">
            <a :href="blogUrl(blog.id)" class="carousel__item">
                <div class="card">
                    <div class="image-wrapper">
                        <img
                            :src="photoUrl(blog.photo)"
                            class="card-img-top"
                            alt="Foto de {{ blog.user_id }}"
                        />
                    </div>
                    <div class="card-body carousel-card-body">
                        <h5 class="card-title">
                            <a class="nav-link" :href="blogUrl(blog.id)">{{
                                blog.title
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
import { Carousel, Navigation, Slide } from "vue3-carousel";

import "vue3-carousel/dist/carousel.css";

export default defineComponent({
    name: "BlogCarousel",
    components: {
        Carousel,
        Slide,
        Navigation,
    },
    props: {
        blogs: {
            type: Array,
            required: true,
        },
    },
    methods: {
        blogUrl(blogId) {
            return `/blog/${blogId}`;
        },
        photoUrl(photoFileName) {
            if (photoFileName) {
                // Si hay una imagen especificada, devuelve la ruta completa de esa imagen
                return `/storage/blog_photos/${photoFileName}`;
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
