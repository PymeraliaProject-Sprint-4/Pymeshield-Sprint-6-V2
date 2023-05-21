
//defineAsync para cargar los componentes de forma asíncrona
import { createApp, defineAsyncComponent } from "vue/dist/vue.esm-bundler";
import laravelPermissionToVuejs from 'laravel-permission-to-vuejs';
import { i18nVue } from 'laravel-vue-i18n'; //Importacion de vue-i18n con Laravel integrado

//Grafico

const app = createApp({})

//registramos los componentes
const navbar = defineAsyncComponent(() => import('./components/layouts/Navbar.vue'));
app.component('navbar', navbar);

const perfilPersonal = defineAsyncComponent(() => import('./components/profile/PerfilPersonal.vue'));
app.component('PerfilPersonal', perfilPersonal);

const contacte = defineAsyncComponent(() => import('./components/contacte/Contacte.vue'));
app.component('contacte', contacte);

const chartUser = defineAsyncComponent(() => import('./components/dashboard/ChartUser.vue'));
app.component('chart-user', chartUser);

const chartAdmin = defineAsyncComponent(() => import('./components/dashboard/ChartAdmin.vue'));
app.component('chart-admin', chartAdmin);


//laravel-permission-to-vuejs
app.use(laravelPermissionToVuejs)


/**
 * Middleware que permite cargar automáticamente los archivos de idioma de la aplicación según el idioma seleccionado por el usuario.
 *
 * * resolve és una función asíncrona que recibe como parámetro el código del idioma que queremos traducir
 * * la funcion import.meta.glob es una función que retorna un objeto con un mapeo de todas las rutas relativas que coinciden con el patrón especificado
 *
 */
app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../lang/*.json');
        return await langs[`../lang/${lang}.json`]();
    }
});

// se monta la app
app.mount("#app");
