<template>
    <div>
        <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                <tr>

                    <th scope="col" class="px-6 py-3">
                        Nombre Cliente
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Apellido
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nombre Empresa
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha Inicio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha Final
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Estado
                            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 ml-1" aria-hidden="true"
                                    fill="currentColor" viewBox="0 0 320 512">
                                    <path
                                        d="M27.66 224h264.7c24.6 0 36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45 8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54 47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2 317.8 316.9 288 292.3 288z" />
                                </svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Asignar Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <button type="button" data-modal-target="default-modal" data-modal-toggle="default-modal"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </th>
                </tr>

            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="task in tasks" :key="task.id">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ task.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ task.accepted }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.state }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.user }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.price }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.start_date }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.final_date }}
                    </td>
                    <td class="px-6 py-4">
                        <!-- Modal toggle -->
                        <button @click="openEditTask(task)"
                            class="block text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            type="button">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="default-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                            {{ title }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                                <input type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.name" required>
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aceptado</label>
                                <input type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.accepted" required>
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                <input type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.state" required>
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuario</label>
                                <input type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.user" required>
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                                <input type="number" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.price" required>
                            </div>
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha
                                    Inicio</label>
                                <input type="datetime-local" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.start_date" required>
                            </div>
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha
                                    Final</label>
                                <input type="datetime-local" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.final_date" required>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            @click.prevent="editTask">Create Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'flowbite';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    mounted() {
        this.getTasks()
        const options = {
            placement: 'bottom-right',
            backdrop: false,
            backdropClasses: false,
            closable: true,
            onHide: () => {
                console.log('modal is hidden');
            },
            onShow: () => {
                console.log('modal is shown');
            },
            onToggle: () => {
                console.log('modal has been toggled');
            }
        };
        this.targetEl = document.getElementById('default-modal');
        this.modal = new Modal(this.targetEl, options);

    },
    data() {
        return {
            tasks: [],
            dataTask: { name: '', accepted: '', state: '', user: '', price: '', start_date: '', final_date: '' },
            idTask: '',
            title: '',
            targetEl: null,
            modal: null,
        }
    },
    methods: {
        getTasks() {
            axios.get('tasks-data').then(res => {
                this.tasks = res.data;
            });
        },
        openEditTask(task_data) {
            this.dataTask = { name: task_data.name, accepted: task_data.accepted, state: task_data.state, user: task_data.user, price: task_data.price, start_date: task_data.start_date, final_date: task_data.final_date }
            this.title = 'Edit Task'
            this.idTask = task_data.id
            this.modal.show();
        },
        editTask() {
            axios.put('edit-task/' + this.idTask, this.dataTask).then(res => {
                this.idTask = ''
                this.getTasks()
                this.modal.hide();
                Swal.fire({
                    title: "Edited!",
                    text: "The task " + this.dataTask.name + " has been edited!",
                    icon: "success"
                });
                // setTimeout(function () {
                // }, 2000);
            }).catch(function (error) {
                Swal.fire({
                    title: 'Sorry!',
                    text: 'Something went wrong!',
                    icon: 'error',
                });
            });
        },
    }
}
</script>
