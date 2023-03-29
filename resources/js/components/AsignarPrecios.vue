<template>
    <table class="w-4/5 mt-10 mx-auto text-center">
        <thead class="bg-gray-700 text-white">
            <tr class="bg-orange-400 text-white">
                <th class="px-6 py-3 uppercase">Tarea</th>
                <th class="px-6 py-3 uppercase">Fecha de inicio</th>
                <th class="px-6 py-3 uppercase">Fecha de fin</th>
                <th class="px-6 py-3 uppercase">Precio</th>
                <th class=""></th>
                <th class="px-6 py-3 uppercase"></th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-orange-50 hover:bg-orange-100 text-center" v-for="tarea in tareas" :key="tarea.id">
                <td class="w-1/5 p-4">{{ tarea.recommendation }}</td>
                <td class="w-1/5">
                    <div v-if="!tarea.editing" class="py-2 px-4">
                        <input v-model="tarea.start_date"
                            class="shadow appearance-none border-2 text-center border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="date">
                    </div>
                    <!-- Fem un binding (lliguem) les possibles respostes, 
                        si es true "font-bold" si es false "font-bold text-red-500"-->
                    <div v-else class="py-2 px-4"
                        :class="{ 'font-bold': tarea.start_date, 'font-bold text-red-500': !tarea.start_date }">
                        <!-- Utilizem un operador ternari de javascript -->
                        {{ tarea.start_date ? tarea.start_date : 'No hay fecha de inicio' }}
                    </div>

                </td>
                <td class="w-1/5">
                    <div v-if="!tarea.editing" class="py-2 px-4">
                        <input v-model="tarea.final_date"
                            class="shadow appearance-none border-2 text-center border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="date">
                    </div>
                    <div v-else class="py-2 px-4"
                        :class="{ 'font-bold': tarea.final_date, 'font-bold text-red-500': !tarea.final_date }">
                        {{ tarea.final_date ? tarea.final_date : 'No hay fecha de finalización' }}
                    </div>
                </td>
                <td class="w-1/5">
                    <div v-if="!tarea.editing" class="py-2 px-4">
                        <input v-model="tarea.price"
                            class="shadow appearance-none border-2 text-center border-gray-200 rounded-lg w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            type="number" step="0.01" @input="sumPrices">
                    </div>
                    <div v-else class="" :class="{ 'font-bold': tarea.price, 'font-bold text-red-500': !tarea.price }">
                        {{ tarea.price ? tarea.price : 'No hay precio' }}
                    </div>
                </td>
                <td class="font-bold">€</td>
                <td class="flex-column w-1/5 px-4 py-2">
                    <button v-if="!tarea.editing"
                        class="w-full max-w-sm text-black table-auto bg-orange-400 font-bold hover:bg-orange-700 hover:text-white py-2 px-4 rounded-lg"
                        @click="tarea.editing = true; updateSingleTask(tarea)">
                        Guardar
                    </button>
                    <button v-else
                        class="w-full bg-green-500 hover:bg-green-700 text-black font-bold hover:text-white py-2 px-4 rounded-lg"
                        @click="tarea.editing = false">
                        Editar
                    </button>
                </td>
            </tr>
            <tr class="bg-orange-300 text-center">
                <td class="w-1/5 h-10 font-bold">Total : </td>
                <td class=""></td>
                <td class=""></td>
                <td class="font-bold">{{ total }}</td>
                <td class="font-bold">€</td>
                <td> </td>

            </tr>
        </tbody>
    </table>
    <div class="flex justify-center mt-10">

        <button @click="updateTasks();"
            class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 block flex justify-center">
            Enviar todas las tareas
        </button>


    </div>
    <div class="bg-gray-100 rounded-md p-2 w-22 my-7">
        <div class="flex justify-center">
            <nav class="isolate inline-flex Fspace-x-px rounded-md shadow-sm" aria-label="Pagination">
                <TailwindPagination :data="taskdata" @pagination-change-page="onPageChanged"
                    :current-page="taskdata.current_page" />
            </nav>
        </div>
    </div>
</template>

<script setup>
import RadioGroupComponent from '../components/Radio.vue'
</script>

<script>
import axios from 'axios';
import { TailwindPagination } from 'laravel-vue-pagination';
import Swal from 'sweetalert2'

export default {
    components: {
        'laravel-pagination': TailwindPagination,
    },
    data() {
        return {
            tareas: [],
            test: {},
            taskdata: {},
            itemsPerPage: 10,
            currentPage: 1,
            tarea: { id: "", price: "", start_date: "", final_date: "" },
            pagination: {},
        };
    },
    mounted() {
        this.getTasks()
    },
    methods: {
        getTasks(page = 1) {
            this.paginate(this.currentPage);
            let id = this.$route.params.id;
            this.$axios.get(`/mostrar-tareas/${id}`, {
                params: {
                    page,
                }
            })
                .then((response) => {
                    this.tareas = response.data.data;
                    this.taskdata = response.data;
                })
                .catch((error) => {
                });
        },

        onPageChanged(page) {
            this.getTasks(page);
        },
        paginate(page) {
            this.$axios.get(`/mostrar-tareas/${this.$route.params.id}?page=${page}&itemsPerPage=${this.itemsPerPage}`)
                .then((response) => {
                    this.pagination = response.data.pagination;
                    this.currentPage = page;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        updateTasks() {
            let data = this.tareas.map(tarea => {
                return [tarea.id, tarea.price, tarea.start_date, tarea.final_date];
            });
            this.$axios.put('/actualizar-tareas', { data: data })
                .then(response => {
                })
                .catch(error => {
                });
                Swal.fire({
                        icon: 'success',
                        text: 'Tareas enviadas correctamente!',
                        confirmButtonText: '<a href="http://localhost/llista_pressupostos">Volver a presupuestos</a>'
                    })
        },
        updateSingleTask: function (tarea) {
            this.$axios.put('/update-task/' + tarea.id, {
                price: tarea.price,
                start_date: tarea.start_date,
                final_date: tarea.final_date,
            })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        sumPrices() {
            for (let i = 0; i < this.tareas.length; i++) {
                this.total += this.tareas[i].price;
            }
            this.total = this.tareas.reduce((accumulator, tarea) => accumulator + tarea.price, 0);
        },

    },
};
</script>
