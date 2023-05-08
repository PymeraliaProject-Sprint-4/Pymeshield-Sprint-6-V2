<template>
    <br> <button
        class="ml-10 mb-10 mr-20 mt-10 px-3 py-2 bg-orange-500 text-white font-bold rounded-full hover:bg-orange-400 focus:outline-none transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110"
        @click="goBack()">
        {{ $t('Back') }}
    </button>
    <table id="tableQualify">
        <thead>
            <tr class="bg-orange-400 text-white">
                <th class="px-6 py-3 uppercase">{{ $t('User') }}</th>
                <th class="px-6 py-3 uppercase">{{ $t('Grade') }}</th>
                <th class="px-6 py-3 uppercase">{{ $t('Task') }}</th>
                <th class="px-6 py-3 uppercase">{{ $t('Feedback') }}</th>
                <th class="px-6 py-3 uppercase">{{ $t('Option') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="users in user" :key="users.id" class="bg-orange-50 hover:bg-orange-100 text-center">
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-900">{{ users.name }}</p>
                </td>
                <td class="px-6 py-4">{{ users.grade ?? '-' }} </td>
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-900">
                        <a v-if="users.locate"
                            :href="appUrl + users.locate.substring(users.locate.lastIndexOf('/files') + 1)"
                            class="text-blue-500 underline" download>{{
                                users.locate.substring(users.locate.lastIndexOf('/') + 1) }}</a>
                        <span class="text-red-600" v-else>X</span>
                    </p>
                </td>
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-900">{{ users.feedback ?? '-' }}</p>
                </td>
                <td class="px-6 py-4">
                    <a href="#"
                        class="text-base font-medium bg-green-500 hover:bg-green-400 text-white py-2 px-4 rounded-full transition-colors duration-300"
                        @click="openModal(users)" data-testid="modal-button">
                        {{ $t('Qualify') }}
                    </a>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-center items-center mt-8">
        <nav class="bg-white p-6 rounded-lg shadow-lg">
            <ul class="flex space-x-4">
                <li v-if="pagination.length > 0 && currentPage > 1">
                    <button @click="changePage(currentPage - 1)"
                        class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md">
                        {{ $t('Previous') }}
                    </button>
                </li>
                <li v-for="page in Math.ceil(user.length / perPage)" :key="page">
                    <button @click="changePage(page)" class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md"
                        :class="{ 'bg-orange-400': page === currentPage }">
                        {{ page }}
                    </button>
                </li>
                <li v-if="pagination.length > 0 && currentPage < Math.ceil(user.length / perPage)">
                    <button @click="changePage(currentPage + 1)"
                        class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md">
                        {{ $t('Next') }}
                    </button>
                </li>
            </ul>
        </nav>
    </div>


    <TransitionRoot as="template" :show="modal_calificar">
        <Dialog as="div" class="fixed z-50 inset-0 overflow-y-auto" @close="modal_calificar = false">
            <div class="flex items-center justify-center min-h-screen px-4">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <DialogOverlay class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <TransitionChild as="template" enter="ease-out duration-300"
                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full md:w-1/2 lg:w-1/3">
                        <form>
                            <div class="p-4">
                                <div class="mb-4">
                                    <label for="name" class="block text-gray-700 font-bold mb-2">{{ $t('Name')
                                    }}</label>
                                    <input type="text" id="name" name="name"
                                        class="border-gray-300 rounded-md w-full py-2 px-3" v-model="currentUser.name"
                                        disabled>
                                </div>

                                <div class="mb-6">
                                    <label for="grade" class="block text-gray-700 font-bold mb-2">{{ $t('Qualification')
                                    }}</label>
                                    <input type="number" id="grade" name="grade"
                                        class="border-gray-300 rounded-md w-full py-2 px-3" v-model="currentUser.grade"
                                        :class="{ 'border-red-500': error !== '' }" @input="error = ''">
                                    <span class="text-red-500" v-if="error !== ''">{{ error }}</span>
                                </div>

                                <div class="mb-6">
                                    <label for="feedback" class="block text-gray-700 font-bold mb-2">{{ $t('Comment')
                                    }}</label>
                                    <textarea id="feedback" name="feedback" rows="3"
                                        class="border-gray-300 rounded-md w-full py-2 px-3"
                                        v-model="currentUser.feedback"></textarea>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button"
                                        class="bg-gray-300 hover:bg-gray-400 text-black font-medium py-2 px-3 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 mr-2 ml-4 flex items-center"
                                        @click="closeModal()">
                                        <i class="fas fa-times mr-2"></i>{{ $t('Cancel') }}
                                    </button>
                                    <button
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 ml-4 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 flex items-center"
                                        @click="submitGrade">
                                        <i class="fas fa-sync-alt mr-2"></i>{{ $t('Update') }}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import axios from "axios";
let appUrl = import.meta.env.APP_URL;
export default {

    data() {
        return {
            user: [],
            currentUserIndex: 0,
            pagination: {},
            showModal: false,
            currentUser: {},
            page: 2,
            modal_calificar: false,
            error: '',
            perPage: 2, // cantidad de elementos por página
            currentPage: 1 // página actual
        };
    },

    mounted() {
        this.loadDeliveries(this.currentPage);
    },

    paginate() {
        const start = (this.currentPage - 1) * this.perPage;
        const end = start + this.perPage;
        this.pagination = this.user.slice(start, end);
    },


    methods: {
        loadDeliveries(page = 1) {
            const url = new URL(window.location.href);
            const cursoId = url.pathname.split('/')[2];
            const activityId = url.pathname.split('/')[4];

            axios
                .get(`/CursosCalificar/${cursoId}/activities-Datos/${activityId}?page=${page}`)
                .then((response) => {
                    this.user = response.data;
                    this.currentPage = page;
                    this.paginate(); // llamada al método paginate() para dividir los datos en páginas
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        changePage(page) {
            this.loadDeliveries(page);
        },



        openModal(user) {
            this.modal_calificar = true;
            this.currentUser = {
                id: user.id,
                name: user.name,
                grade: user.grade,
                feedback: user.feedback
            };
            this.currentUserIndex = users.indexOf(user);

        },

        closeModal() {
            this.modal_calificar = false;
            this.currentUser = {};
        },

        goBack() {
            window.history.back();
        },

        submitGrade(event) {
            event.preventDefault()
            const userId = this.currentUser.id;
            const grade = this.currentUser.grade;

            if (grade > 10) {
                this.error = this.$t('ErrorMsg.1');
                return;
            }
            if (grade < 0) {
                this.error = this.$t('ErrorMsg.2');
                return;
            }

            const url = new URL(window.location.href);
            const activityId = url.pathname.split('/')[4];

            axios.post(`/activity/${activityId}/user/${userId}/qualify`, {
                grade: this.currentUser.grade,
                feedback: this.currentUser.feedback,
            }).then(() => {
                this.closeModal();
                this.loadDeliveries(this.pagination.current_page);
            }).catch(error => {
                console.log(error.response.data.message);
            });
        },
    }
}
</script>
<script setup>
import { Dialog, DialogOverlay, TransitionChild, TransitionRoot } from '@headlessui/vue'
</script>

<style scoped>
#tableQualify {
    height: 300px;
    width: 1200px;
    margin-left: 4%;

}
</style>
