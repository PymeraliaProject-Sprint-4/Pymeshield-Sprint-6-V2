
//defineAsync para cargar los componentes de forma asíncrona
import { createApp, defineAsyncComponent } from "vue/dist/vue.esm-bundler";
import laravelPermissionToVuejs from 'laravel-permission-to-vuejs';
import { i18nVue } from 'laravel-vue-i18n'; //Importacion de vue-i18n con Laravel integrado
import ganttastic from '@infectoone/vue-ganttastic'

//Grafico

const app = createApp({})

import axiosPlugin from '../js/plugin-axios/plugins/axios-plugin';
app.use(axiosPlugin)

//registramos los componentes
const navbar = defineAsyncComponent(() => import('./components/Navbar.vue'));
app.component('navbar', navbar);

const admin = defineAsyncComponent(() => import('./components/AdminPanel.vue'));
app.component('admin-layout', admin);

const listcompany = defineAsyncComponent(() => import('./components/ListCompany.vue'));
app.component('list-company', listcompany);

const quillEditor = defineAsyncComponent(() => import('./components/Editor.vue'));
app.component('editor', quillEditor);

const listusers = defineAsyncComponent(() => import('./components/ListUsers.vue'));
app.component('list-users', listusers);

const perfilPersonal = defineAsyncComponent(() => import('./components/PerfilPersonal.vue'));
app.component('PerfilPersonal', perfilPersonal);

const perfilPersonal_Admin = defineAsyncComponent(() => import('./components/PerfilPersonal_Admin.vue'));
app.component('PerfilPersonalAdmin', perfilPersonal_Admin);

const perfilPersonal_Worker = defineAsyncComponent(() => import('./components/PerfilPersonal_Worker.vue'));
app.component('PerfilPersonalWorker', perfilPersonal_Worker);

const EditarPerfilAdmin = defineAsyncComponent(() => import('./components/EditarPerfilAdmin.vue'));
app.component('EditarPerfilAdmin', EditarPerfilAdmin);

const EditarPerfilWorker = defineAsyncComponent(() => import('./components/EditarPerfilWorker.vue'));
app.component('EditarPerfilWorker', EditarPerfilWorker);


const contacte = defineAsyncComponent(() => import('./components/contacte.vue'));
app.component('contacte',contacte);

const tableWeeks = defineAsyncComponent(() => import('./components/TableWeeks.vue'));
app.component('table-weeks', tableWeeks);

const activityWeeks = defineAsyncComponent(() => import('./components/ActivityWeeks.vue'));
app.component('activity-weeks', activityWeeks);

const chartUser = defineAsyncComponent(() => import('./components/chartUser.vue'));
app.component('chart-user', chartUser);

const chartAdmin = defineAsyncComponent(() => import('./components/chartAdmin.vue'));
app.component('chart-admin', chartAdmin);

//EQUIPO2

const formComponent = defineAsyncComponent(() => import('./components/Form.vue'));
app.component('form-component', formComponent);

const questionnaireFormComponent = defineAsyncComponent(() => import('./components/QuestionnaireForm.vue'));
app.component('questionnaire-component', questionnaireFormComponent);

const survey = defineAsyncComponent(() => import('./components/Survey.vue'));
app.component('survey', survey);

const createReport = defineAsyncComponent(() => import('./components/CreateReport.vue'));
app.component('create-report', createReport);


//EQUIP3
const index_course = defineAsyncComponent(() => import('./components/course/index_course.vue'));
app.component('index_course', index_course);

const hidden_course = defineAsyncComponent(() => import('./components/course/hidden_course.vue'));
app.component('hidden_course', hidden_course);

const client_course = defineAsyncComponent(() => import('./components/course/client_course.vue'));
app.component('client_course', client_course);

const cursos = defineAsyncComponent(() => import('./components/Cursos.vue'));
app.component('cursos', cursos);

const categoriasCurso = defineAsyncComponent(() => import('./components/Categorias_curso.vue'));
app.component('categorias-curso', categoriasCurso);

const deliveries = defineAsyncComponent(() => import('./components/deliveries.vue'));
app.component('deliveries', deliveries);

// EQUIP 4

const accept_tasks_table = defineAsyncComponent(() => import('./components/TablaAceptarTareas.vue'));
app.component('tabla_aceptar_tareas', accept_tasks_table);

const modify_budget = defineAsyncComponent(() => import('./components/ModifyBudget.vue'));
app.component('modificar_presupuesto', modify_budget);

const modify_task = defineAsyncComponent(() => import('./components/TareasEdit.vue'));
app.component('modificar_tareas', modify_task);

const assign_prices = defineAsyncComponent(() => import('./components/AsignarPrecios.vue'));
app.component('asignar_precios', assign_prices);

const gantt = defineAsyncComponent(() => import('./components/Gantt.vue'));
app.component('gantt', gantt);

const kanban = defineAsyncComponent(() => import('./components/Kanban.vue'));
app.component('kanban', kanban);

const budgets = defineAsyncComponent(() => import('./components/Budgets.vue'));
app.component('show_budgets', budgets);

//EQUIP 5
const listdevices = defineAsyncComponent(() => import('./components/ListDevices.vue'));
app.component('list-devices', listdevices);

//Restaurar
const retoredevices = defineAsyncComponent(() => import('./components/restaurar.vue'));
app.component('restore-devices', retoredevices);

//Mapa
const mapa = defineAsyncComponent(() => import('./components/Map.vue'));
app.component('mapa-pymeralia', mapa);



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

app.use(ganttastic)

// se monta la app
app.mount("#app");
