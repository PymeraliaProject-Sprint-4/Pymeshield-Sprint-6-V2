import { createRouter, createWebHistory } from 'vue-router';


const ListCompany = () => import ('../components/ListCompany.vue')
const PerfilPersonal = () => import ('../components/PerfilPersonal.vue')
const TableWeeks = () => import ('../components/TableWeeks.vue')
const perfilPersonal_Admin = () => import ('../components/PerfilPersonal_Admin.vue')
const perfilPersonal_Worker = () => import ('../components/PerfilPersonal_Worker.vue')
const ComponentOne = () => import ('../components/compOne.vue')
const ComponentTwo = () => import ('../components/compTwo.vue')
const DeliveriesTable = () => import("../components/deliveries.vue");
const Cursos = () => import("../components/Cursos.vue");
const Categorias_Curso = () => import("../components/Categorias_curso.vue");



const routes=[
    {
        path:'/llistatEmpreses',
        name:'llistatEmpreses',
        component:ListCompany
    },
    {
        path:'/Personal_Profile',
        name:'PerfilPersonal',
        component:PerfilPersonal
    },
    {
        path:'/PerfilPersonal_Admin',
        name:'PerfilPersonal_Admin',
        component:perfilPersonal_Admin
    },
    {
        path:'/home',
        name:'home',
        component:TableWeeks
    },
    {
        path:'/PerfilPersonal_Admin/EditarPerfilAdmin',
        name:'EditarPerfilAdmin',
        component:EditarPerfilAdmin
    },
    {
        path:'/PerfilPersonal_Admin/EditarPerfilWorker',
        name:'EditarPerfilWorker',
        component:EditarPerfilWorker
    },
    // {
    //     path:'/acceptacio-tasques',
    //     name:'tasques',
    //     component:TablaAceptarTareas
    // },
    // {
    //     path:'/my-tasks',
    //     name:'my-tasks',
    //     component:CustomerTaskTableComponent
    // },
    {
        path:'/',
        name:'component 1',
        component:ComponentOne
    },
    {
        path:'/graphic',
        name:'component 2',
        component:ComponentTwo
    },
    {
        path: "/CursosCalificar/:id/activities/:activityId",
        name: "ActivityDeliveries",
        component: DeliveriesTable,
    },
    {
        path: "/CursosCalificar",
        name: "Calificar.cursos",
        component: Cursos,
    },
    {
        path: "/CursosCalificar/:id/activities",
        name: "courseActivities",
        component: Categorias_Curso,
    },
];

const router = createRouter({
 history: createWebHistory(import.meta.env.BASE_URL),
 routes
});

export default router;
