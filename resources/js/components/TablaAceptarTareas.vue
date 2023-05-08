<template>
    <h1 class="text-2xl font-bold sm:text-3xl text-center pt-10">Aceptar Tareas</h1>
    <div>
        <div class="flex justify-end mt-4 mx-5">
            <div class="xl:w-96">
                <div class="input-group relative flex flex-wrap items-stretch w-full">
                    <input type="search"
                        class="form-control relative flex-auto min-w-0 block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition  m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        placeholder="Buscar" aria-label="Search" aria-describedby="button-addon3"
                        v-model="buscador /* ruteado a la variable buscador de data() */"
                        @keyup="buscarTareas /* llama al método cuando acabas de pulsar la tecla */">
                    <!-- <button
                        class="btn inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                        type="button" id="button-addon3">Buscar
                    </button> -->
                </div>
            </div>
        </div>
    </div><!-- Buscador -->
    <div v-if="tasques != 0" class="pt-5 px-5 overflow-x-auto">
        <table class="table-auto w-full shadow-lg rounded-lg">
            <thead>
                <tr class="bg-orange-400 text-white">
                    <th scope="col" class="px-6 py-3 uppercase">
                        Pregunta
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        Recomendación
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        Nivel de Peligro
                    </th>
                    <th scope="col" class="px-6 py-3 uppercase">
                        Aceptación Tareas
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-orange-50 hover:bg-orange-100 text-center" v-for="tasca in tasques" :key="tasca.id">
                    <th scope="col" class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ tasca.description }}</p>
                    </th>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ tasca.recommendation }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ tasca.name }}</p>
                    </td>
                    <td class="px-6 py-4 flex justify-center">

                        <label for="manages" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            <RadioGroupComponent :default="this.selectedValues[tasca.id]"
                                @selectedValue="(value) => updateSelectedValue(value, tasca.id)" />
                        </label><!-- selector manages -->
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div v-else class="flex justify-center">
        NO SE HAN ENCONTRADO RESULTADOS
    </div><!-- Contenido Tabla-->

    <div class="p-5 flex justify-between">
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <TailwindPagination :data="taskdata" @pagination-change-page="onPageChanged"
                :current-page="taskdata.current_page" />
        </nav>

        <div class="flex justify-end ">

            <boton-enviar v-if="!loading" @click="enviarTareasAceptadas"
                :class="{ 'opacity-50 pointer-events-none': loading }" @click.prevent="loading = true">
            </boton-enviar>
            <div class="fixed top-0 left-0 w-full h-full flex justify-center items-center bg-white-50 z-50" v-if="loading">
                <div class="absolute inset-0 z-500 bg-white bg-opacity-75" v-if="loading"></div>
                <half-circle-spinner :animation-duration="1000" :size="60" color="#7fc3d7" />
                <div class="text-center m-4 font-bold relative text-black">Enviando Tareas Aceptadas...</div>
            </div>
        </div>
    </div><!-- Paginación -->



    <!-- Botón Enviar -->
</template>

<script>
/** AQUI PODEMOS IMPORTAR MÁS COMPONENTES DENTRO DEL COMPONENTE */
import { TailwindPagination } from 'laravel-vue-pagination';
//Importar libreria axios (AJAX de VUE) hace peticiones HTTP GET a una URL específica (datos-tasques)

import { HalfCircleSpinner } from 'epic-spinners';
import RadioGroupComponent from '../components/Radio.vue';
import BotonEnviar from '../components/BotonEnviar.vue'


//export contiene las propiedades y métodos que definen el comportamiento del componente, y default indica que es el export por defecto de este modulo
export default {
    components: {
        TailwindPagination,
        HalfCircleSpinner,
        RadioGroupComponent,
        BotonEnviar,
    },
    beforeMount() {
        this.getTasksIdAccepted()
        this.getTasksAccepted()
    },
    mounted: function () {
        console.log(this.tasques)
    },
    //La data devuelve un objeto con una propiedad "tasques" inicializada como un array vacío, donde se guardaran los datos.
    data() {
        return {
            taskdata: {},
            tasques: [],
            /** Declaramos los datos de paginacion todos a 0 para despues que cambien cuando se haga la consulta
             * los parametros son los mismo que en el return de la query del controlador
            */
            offset: 2, //esta variable mostrará las páginas por delante y por detras que tiene la página donde estamos situados
            /** Buscador */
            buscador: '', //variable donde se guarda el texto que buscamos
            setTimeOutBuscador: '', //Variable donde se guarda setTimeOut
            loading: false,
            selectedValue: 'no',
            selectedValues: {}
        }
    },
    //dentro de methods declaramos las funciones
    methods: {
        updateSelectedValue(value, id) {
            console.log('hola', value, id)
            console.log(this.selectedValues)
            this.selectedValues[id] = value
            console.log(this.selectedValues)
        },
        /** Método que recoge datos de una url */
        //le pasamos el parámetro page para que pueda ir cambiando de páginas en la URL
        getTasksAccepted(page = 1) {
            let id = window.location.pathname.split("/").pop()
            this.$axios.get('datos-tasques/' + id, {
                params: {
                    page,
                    buscador: this.buscador
                }
            }).then(res => { //utilizamos axios y el método get
                this.tasques = res.data.data, //guardamos en la variable tasques lo que recuperamos por data, en este caso usamos tasks.data ya que viene de la paginación, si no quisieramos paginar usariamos tan solo res.data
                    this.taskdata = res.data
            });
        },
        getTasksIdAccepted() {
            let id = window.location.pathname.split("/").pop()
            this.$axios.get('datos-tasques/' + id).then(res => {
                console.log('OK', res)
                res.data.data.map((value) => {
                    console.log(value.id)
                    this.selectedValues[value.id] = 'No aceptada'
                })
                console.log(this.selectedValues)
            })
        },
        // /** Método que cambia de página */
        onPageChanged(page) {
            this.getTasksAccepted(page); //trae el listado de la nueva página
        },

        /** Método que busca tareas */
        buscarTareas() {
            // Si l'input són espais en blanc i hi ha dades, no busquis
            if (!this.buscador.trim() && this.tasques.length !== 0) return
            /* La suma de estos dos métodos permitirá que solo se envie 1 vez lo que se escriba y no cada vez que se escribe */
            clearTimeout(this.setTimeOutBuscador)
            this.setTimeOutBuscador = setTimeout(this.getTasksAccepted, 360)
        },

        /** Muestra una animación de carga al darle al botón enviar */
        enviarTareasAceptadas() {
            //Muestra la animacion y el mensaje de carga
            this.loading = true;

            this.$axios.post('crear-tareas', {
                data: this.selectedValues
            }).then(() => {
                setTimeout(() => {
                    this.loading = false;
                    location.href = 'http://localhost/llista_pressupostos'
                }, 2000);
            })
        }
    }
}
</script>
