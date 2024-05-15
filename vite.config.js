import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import vue from "@vitejs/plugin-vue";

// import fs from 'fs';
// import { homedir } from 'os';
// import { resolve } from 'path';
// const host = 'my-app.test';

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/main.scss", "resources/js/app.js", "resources/js/axios.js", "resources/js/bootstrap.js"],
            refresh: true,
            // Si queremos refrescar automáticamente otras rutas temenos que modificarlas aquí
            // refresh: [
            //     'resources/routes/**',
            //     'routes/**',
            //     'resources/views/**',
            // ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // The Vue plugin will re-write asset URLs, when referenced
                    // in Single File Components, to point to the Laravel web
                    // server. Setting this to `null` allows the Laravel plugin
                    // to instead re-write asset URLs to point to the Vite
                    // server instead.
                    base: null,

                    // The Vue plugin will parse absolute URLs and treat them
                    // as absolute paths to files on disk. Setting this to
                    // `false` will leave absolute URLs un-touched so they can
                    // reference assets in the public directory as expected.
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
});

// Método que verifica la existencia de los certificados generados por Valet por si salta un aviso de que no hay certificado de seguridad
// function detectServerConfig(host) {
//     let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`)
//     let certificatePath = resolve(homedir(), `.config/valet/Certificates/${host}.crt`)

//     if (!fs.existsSync(keyPath)) {
//         return {}
//     }

//     if (!fs.existsSync(certificatePath)) {
//         return {}
//     }

//     return {
//         hmr: { host },
//         host,
//         https: {
//             key: fs.readFileSync(keyPath),
//             cert: fs.readFileSync(certificatePath),
//         },
//     }
// }
