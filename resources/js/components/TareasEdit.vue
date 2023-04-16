<template>
    <div>
        <div class="mb-3">
            <form>
                <label for="buscador" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Busca</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" id="buscador"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Busca la tarea" autocomplete="off" v-model="buscado" required>
                    <button type="submit" @click.prevent="buscar"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>
        </div>
        <table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aceptado
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Usuario
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Precio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha Inicio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha Final
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <input type="hidden" data-modal-target="default-modal" data-modal-toggle="default-modal"
                            @click="openNewTask"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <!-- <i class="fa-solid fa-plus"></i> -->
                        <!-- </button> -->
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="task in tasks" :key="task.id">
                    <th scope="col" class="px-6 py-4">
                        {{ task.recommendation }}
                    </th>
                    <td class="px-6 py-4">
                        <label class="relative inline-flex items-center mb-4 cursor-pointer">
                            <input type="checkbox" v-model="task.accepted" value="" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
                        </label>
                    </td>
                    <td class="px-6 py-4">
                        {{ task.state }}
                    </td>
                    <td class="px-6 py-4">
                        {{ task.name }}
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
                        <div class="w-1/2 flex justify">
                            <button @click="openEditTask(task)"
                                class="block text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                type="button">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                            <button @click="openDeleteTask(task)"
                                class="block text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                type="button">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
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
                            @click="closeModal">
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
                                    v-model="dataTask.recommendation" required>
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Aceptado</label>
                                <ul
                                    class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li
                                        class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center px-3">
                                            <input id="horizontal-list-radio-si" type="radio" value="true" name="si-radio"
                                                v-model="dataTask.accepted"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-si"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Si
                                            </label>
                                        </div>
                                    </li>
                                    <li
                                        class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center px-3">
                                            <input id="horizontal-list-radio-no" type="radio" value="false" name="no-radio"
                                                v-model="dataTask.accepted"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-no"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                                <ul
                                    class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <li
                                        class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center px-3">
                                            <input id="horizontal-list-radio-todo" type="radio" value="ToDo"
                                                name="todo-radio" v-model="dataTask.state"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-todo"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">To
                                                do</label>
                                        </div>
                                    </li>
                                    <li
                                        class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center px-3">
                                            <input id="horizontal-list-radio-inprogress" type="radio" value="InProgress"
                                                name="inprogress-radio" v-model="dataTask.state"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-inprogress"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">In
                                                progress</label>
                                        </div>
                                    </li>
                                    <li
                                        class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                        <div class="flex items-center px-3">
                                            <input id="horizontal-list-radio-done" type="radio" value="Done"
                                                name="done-radio" v-model="dataTask.state"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="horizontal-list-radio-done"
                                                class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Done</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuario</label>
                                <select v-model="dataTask.user_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    <option class="text-white" disabled value="">Selecciona uno</option>
                                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="precio"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                                <input type="number" name="precio" id="precio"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.price">
                            </div>
                            <!-- <div>
                                <label for="questionnaires" v-show="select"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Questionnaires</label>
                                <select v-model="dataTask.questionnaire_id" v-show="select"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                    <option class="text-white" disabled value="">Selecciona uno</option>
                                    <option v-for="questionnaire in questionnaires" :key="questionnaire.id"
                                        :value="questionnaire.id">{{ questionnaire.name }}
                                    </option>
                                </select>
                            </div> -->
                            <div>
                                <label for="fecha_i"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha
                                    Inicio</label>
                                <input type="datetime-local" name="fecha_i" id="fecha_i"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.start_date" required>
                            </div>
                            <div>
                                <label for="fecha_f"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha
                                    Final</label>
                                <input type="datetime-local" name="fecha_f" id="fecha_f"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    v-model="dataTask.final_date" required>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            @click.prevent="editTask" v-show="btnEdit">Edit Task
                        </button>
                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            @click.prevent="createTask" v-show="btnCreate">Create Task
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import { Modal } from 'flowbite';
import axios from 'axios';
import swal from 'sweetalert';

export default {
    mounted() {
        this.getTasks()
        this.getUsers()
        this.getQuestionnaires()
        const options = {
            placement: 'center',
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
            url: 'tasks-data',
            buscado: '',
            tasks: [],
            users: [],
            questionnaires: [],
            dataTask: { recommendation: '', accepted: '', state: '', user_id: '', price: '', questionnaire_id: '', start_date: '', final_date: '' },
            idTask: '',
            title: '',
            targetEl: null,
            modal: null,
            btnCreate: false,
            btnEdit: false,
            select: false,
        }
    },
    methods: {
        //Función para cerrar el modal.
        closeModal() {
            this.modal.hide();
        },
        buscar() {
            if (this.buscado != null) {
                axios.get('buscador-tasks/' + this.buscado).then(res => {
                    this.buscados = res.data;
                    this.url = 'buscador-tasks/' + this.buscado;
                    this.getTasks();
                    this.buscado = null
                }).catch(function (error) {
                    swal("Oh no!", "Algo no funciona!", "danger");
                });
            }else{
                this.url = 'tasks-data/';
                this.getTasks()
                swal("Vacío!", "No has introducido los datos!", "danger");
            }
        },

        //Aquesta funció recupera les dades de les tasques fent una sol·licitud GET a l'URL 'tasks-data' mitjançant la biblioteca axios.
        //En cas de resposta correcta, actualitza l'estat de "tasques" del component amb les dades retornades de l'API.
        getTasks() {
            axios.get(this.url).then(res => {
                this.tasks = res.data;
            });
        },
        //Aquesta funció recupera les dades dels usuaris fent una sol·licitud GET a l'URL 'users-data' mitjançant la biblioteca axios.
        //En cas de resposta correcta, actualitza l'estat de "users" del component amb les dades retornades de l'API.
        getUsers() {
            axios.get('users-data').then(res => {
                this.users = res.data;
            });
        },
        //Aquesta funció recupera les dades dels qüestionaris fent una sol·licitud GET a l'URL 'questionnaires-data' mitjançant la biblioteca axios.
        //En cas de resposta correcta, actualitza l'estat de "questionnaires" del component amb les dades retornades de l'API.
        getQuestionnaires() {
            axios.get('questionnaires-data').then(res => {
                this.questionnaires = res.data;
            });
        },
        // Inicia la función para abrir una nueva tarea
        // Establece el título de la tarea como 'Nueva Tarea'
        // Habilita el botón 'Crear' y muestra la selección
        // Deshabilita el botón 'Editar'
        // Inicializa el objeto 'dataTask' con valores vacíos
        // Muestra el modal.
        openNewTask() {
            this.title = 'Nueva Tarea'
            this.btnCreate = true
            this.select = true
            this.btnEdit = false
            this.dataTask = { recommendation: '', accepted: '', state: '', user_id: '', price: '', questionnaire_id: '', start_date: '', final_date: '' }
            this.modal.show();
        },
        // Asigna datos de la tarea a dataTask
        // Cambia el título del modal a "Editar Tarea"
        // Desactiva el botón de creación y activa el botón de edición
        // Guarda el id de la tarea
        // Muestra el modal
        openEditTask(task_data) {
            this.dataTask = { recommendation: task_data.recommendation, accepted: task_data.accepted, state: task_data.state, user_id: task_data.user_id, price: task_data.price, start_date: task_data.start_date, final_date: task_data.final_date }
            this.title = 'Editar Tarea'
            this.btnCreate = false
            this.btnEdit = true
            this.idTask = task_data.id
            this.modal.show();
        },
        // Se hace una petición POST a la dirección "new-task", utilizando Axios
        // Se invoca la función "getTasks()" para actualizar las tareas
        // Se esconde el modal
        // Se muestra un mensaje de éxito en un "sweet alert"
        // Si ocurre un error se muestra un mensaje en un "sweet alert"
        createTask() {
            axios.post('new-task', this.dataTask).then(res => {
                this.dataTask = { recommendation: '', accepted: '', state: '', user_id: '', price: '', questionnaire_id: '', start_date: '', final_date: '' }
                this.getTasks()
                this.modal.hide();
                swal("Creada!", "La tarea ha sido creada!", "success");
            }).catch(function (error) {
                swal("Oh no!", "Algo no funciona!", "danger");
            });
        },
        //La función `editTask` hace una petición `PUT` utilizando la librería axios para actualizar una tarea en el servidor, pasando el identificador de la tarea `this.idTask` y los nuevos
        //datos de la tarea `this.dataTask`. Si la petición es exitosa, se ejecutan las siguientes acciones:

        //1.  Se asigna un valor vacío a `this.idTask`
        //2.  Se invoca la función `getTasks` para actualizar la lista de tareas
        //3.  Se oculta el modal que contiene el formulario de edición
        //4.  Se muestra un mensaje de éxito "La tarea ha sido editada" utilizando la librería swal.

        //En caso contrario (capcatch), se muestra un mensaje de error "Algo no funciona".
        editTask() {
            axios.put('edit-task/' + this.idTask, this.dataTask).then(res => {
                this.idTask = ''
                this.getTasks()
                this.modal.hide();
                swal("Editada!", "La tarea " + this.dataTask.recommendation + " ha sido editada!", "success");
                // setTimeout(function () {
                // }, 2000);
            }).catch(function (error) {
                swal("Oh no!", "Algo no funciona!", "danger");
            });
        },
        // Se muestra un cuadro de dialogo para confirmar la eliminacion de la tarea
        // La propiedad title muestra un mensaje de confirmacion
        // La propiedad text muestra un mensaje adicional con el nombre de la tarea
        // La propiedad icon muestra un icono de advertencia
        // La propiedad buttons especifica si existen opciones para confirmar o cancelar la operacion
        // La propiedad dangerMode activa el modo peligroso
        // El metodo then recibe la respuesta de la Confirmacion y se realiza la accion correspondiente, sea la eliminacion o un mensaje de que la tarea no se eliminó
        // Si se confirma la eliminación, se hace una petición HTTP DELETE a través de axios y se muestra un mensaje de éxito
        // Si hay algún error en la operación, se muestra un mensaje de error
        openDeleteTask(task_data) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover the task " + task_data.recommendation + " !",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        axios.delete('delete-task/' + task_data.id).then(res => {
                            this.getTasks()
                            swal("Poof! Esta tarea ha sido eliminada!", {
                                icon: "success",
                            });
                        }).catch(function (error) {
                            swal("Oh no!", "Algo no funciona!", "danger");
                        });
                    } else {
                        swal("La tarea " + task_data.recommendation + " no se eliminó!");
                    }
                });
        },
    }
}
</script>
