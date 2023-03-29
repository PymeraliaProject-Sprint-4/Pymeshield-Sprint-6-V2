<template>
    <br>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full border-collapse shadow-lg rounded-lg">
            <thead class="bg-orange-400">
                <tr class="text-xs text-white uppercase">
                    <th class="py-3 px-4 text-left">Actividad</th>
                    <th class="py-3 px-4 text-left">Descripcion</th>
                    <th class="py-3 px-4 text-center">Opción</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="activity in activities" :key="activity.id" class="bg-gray-100 hover:bg-gray-200">
                    <td class="py-4 px-6 text-gray-900">{{ activity.name }}</td>
                    <td class="py-4 px-6 text-gray-900">{{ activity.description }}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center">
                            <a href="#"
                                class="inline-block text-sm bg-green-500 text-white py-1 px-3 rounded-l-full hover:bg-green-400"
                                @click="openModal(activity)">
                                Edit
                            </a>
                            <router-link
                                class="inline-block text-sm bg-blue-500 text-white py-1 px-3 rounded-r-full hover:bg-blue-400"
                                :to="{ name: 'deliveries.show', params: { id: activity.id } }">
                                View
                            </router-link>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="pagination flex mt-4">
        <button v-if="pagination.prev_page_url"
            class="ml-1 px-3 py-2 bg-orange-500 text-white rounded hover:bg-orange-400 focus:outline-none"
            @click="loadPage(pagination.current_page - 1)">
            Anterior
        </button>
        <button v-if="pagination.next_page_url"
            class="ml-1 px-3 py-2 bg-orange-500 text-white rounded hover:bg-orange-400 focus:outline-none"
            @click="loadPage(pagination.current_page + 1)">
            Siguiente
        </button>
    </div>
    <!-- MODAL -->
    <div v-if="showModal" class="fixed z-50 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                <div class="p-4">
                    <form>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre Actividad</label>
                            <input type="text" id="name" name="name" class="border-gray-300 rounded-md w-full py-2 px-3"
                                v-model="currentActivity.name">
                        </div>
                        <div class="mb-6">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Descripción</label>
                            <textarea id="description" name="description" rows="3"
                                class="border-gray-300 rounded-md w-full py-2 px-3"
                                v-model="currentActivity.description"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button class="bg-red-500 text-white px-4 py-2 rounded-lg mr-4"
                                @click="closeModal">Cancelar</button>
                            <button class="bg-green-500 text-white px-4 py-2 rounded-lg"
                                @click="submitActivity">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            activities: [],
            pagination: {},
            showModal: false,
            currentActivity: {},
        };
    },
    mounted() {
        this.loadPage(1);
    },
    methods: {
        loadPage(page) {
            axios
                .get(`/activities-datos?page=${page}`)
                .then((response) => {
                    this.activities = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        openModal(activity) {
            this.showModal = true;
            this.currentActivity = Object.assign({}, activity);
        },
        closeModal() {
            this.showModal = false;
            this.currentActivity = {};
        },
        submitActivity() {
            const activityId = this.currentActivity.id;
            axios
                .post(`/activity/${activityId}`, {
                    name: this.currentActivity.name,
                    description: this.currentActivity.description,
                })
                .then(() => {
                    this.closeModal();
                })

        },
    },
}
</script>