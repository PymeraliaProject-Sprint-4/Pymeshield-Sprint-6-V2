
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
const navbar = defineAsyncComponent(() => import('./components/layouts/Navbar.vue'));
app.component('navbar', navbar);

const admin = defineAsyncComponent(() => import('./components/layouts/AdminPanel.vue'));
app.component('admin-layout', admin);

const listcompany = defineAsyncComponent(() => import('./components/ListCompany.vue'));
app.component('list-company', listcompany);

const ListCompanyHidden = defineAsyncComponent(() => import('./components/ListCompanyHidden.vue'));
app.component('list-company-hidden', ListCompanyHidden);

const quillEditor = defineAsyncComponent(() => import('./components/rules/Editor.vue'));
app.component('editor', quillEditor);

const listusers = defineAsyncComponent(() => import('./components/ListUsers.vue'));
app.component('list-users', listusers);


const ListUsersHidden = defineAsyncComponent(() => import('./components/ListUsersHidden.vue'));
app.component('list-users-hidden', ListUsersHidden);

const perfilPersonal = defineAsyncComponent(() => import('./components/profile/PerfilPersonal.vue'));
app.component('PerfilPersonal', perfilPersonal);

const perfilPersonal_Admin = defineAsyncComponent(() => import('./components/profile/PerfilPersonalAdmin.vue'));
app.component('PerfilPersonalAdmin', perfilPersonal_Admin);

const perfilPersonal_Worker = defineAsyncComponent(() => import('./components/profile/PerfilPersonalWorker.vue'));
app.component('PerfilPersonalWorker', perfilPersonal_Worker);

const EditarPerfilAdmin = defineAsyncComponent(() => import('./components/profile/EditarPerfilAdmin.vue'));
app.component('EditarPerfilAdmin', EditarPerfilAdmin);

const EditarPerfilWorker = defineAsyncComponent(() => import('./components/profile/EditarPerfilWorker.vue'));
app.component('EditarPerfilWorker', EditarPerfilWorker);

const contacte = defineAsyncComponent(() => import('./components/contacte/Contacte.vue'));
app.component('contacte', contacte);

const tableWeeks = defineAsyncComponent(() => import('./components/dashboard/TableWeeks.vue'));
app.component('table-weeks', tableWeeks);

const activityWeeks = defineAsyncComponent(() => import('./components/dashboard/ActivityWeeks.vue'));
app.component('activity-weeks', activityWeeks);

const chartUser = defineAsyncComponent(() => import('./components/dashboard/ChartUser.vue'));
app.component('chart-user', chartUser);

const chartAdmin = defineAsyncComponent(() => import('./components/dashboard/ChartAdmin.vue'));
app.component('chart-admin', chartAdmin);

//EQUIPO2

const createQuestion = defineAsyncComponent(() => import('./components/question/CreateQuestion.vue'));
app.component('create-question', createQuestion);

const questionnaireFormComponent = defineAsyncComponent(() => import('./components/questionnaire/QuestionnaireForm.vue'));
app.component('questionnaire-component', questionnaireFormComponent);

const audit = defineAsyncComponent(() => import('./components/audit/Audit.vue'));
app.component('audit', audit);

const createReport = defineAsyncComponent(() => import('./components/CreateReport.vue'));
app.component('create-report', createReport);


//EQUIP3

const index_course = defineAsyncComponent(() => import('./components/course/index_course.vue'));
app.component('index_course', index_course);

const hidden_course = defineAsyncComponent(() => import('./components/course/hidden_course.vue'));
app.component('hidden_course', hidden_course);

const client_course = defineAsyncComponent(() => import('./components/course/client_course.vue'));
app.component('client_course', client_course);

const client_rescources = defineAsyncComponent(() => import('./components/rescource/Rescources_Client.vue'));
app.component('client_rescources', client_rescources);

const coursecategories = defineAsyncComponent(() => import('./components/rescource/Categories_Admin.vue'));
app.component('course-categories', coursecategories);

const rescources_admin = defineAsyncComponent(() => import('./components/rescource/Rescources_Admin.vue'));
app.component('rescources-admin', rescources_admin);


const CursosCalificar = defineAsyncComponent(() => import('./components/Cursos.vue'));
app.component('cursos_calificar', CursosCalificar);

const CategoriasCurso = defineAsyncComponent(() => import('./components/Categorias_curso.vue'));
app.component('categorias_curso', CategoriasCurso);

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

const kanban = defineAsyncComponent(() => import('./components/kanban/Kanban.vue'));
app.component('kanban', kanban);

const budgetsAdmin = defineAsyncComponent(() => import('./components/BudgetsAdmin.vue'));
app.component('show_budgets_admin', budgetsAdmin);

const budgetsClient = defineAsyncComponent(() => import('./components/BudgetsClient.vue'));
app.component('show_budgets_client', budgetsClient);

const inventory = defineAsyncComponent(() => import('./components/inventory/Inventory.vue'));
app.component('inventory', inventory);

//EQUIP 5
const listdevices = defineAsyncComponent(() => import('./components/ListDevices.vue'));
app.component('list-devices', listdevices);

const swiper = defineAsyncComponent(() => import('./components/swiper.vue'));
app.component('swiper', swiper);

//Restaurar
const retoredevices = defineAsyncComponent(() => import('./components/restaurar.vue'));
app.component('restore-devices', retoredevices);

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
