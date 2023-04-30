<template>
    <h1 class="ml-7 mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
            class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('Admin') }}</span>
    </h1>
    <p class="ml-7 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ $t('phrase.1.course') }}
    </p>

    <div style="display: flex; justify-content: center;">
        <!-- Modal toggle -->
        <button id="" @click="modal_crear = true"
            class=" bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 flex items-center"
            type="button">
            <PlusIcon class="h-6 w-6 text-white-400 font" aria-hidden="true" />
            {{ $t('Add') }} {{ $t('Course') }}
        </button>
        <!--Botó per veure cursos borrats-->
        <button @click="redirectToDeletedCourses()"
            class="ml-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded mt-5 flex items-center text-center ">
            <EyeSlashIcon class="h-6 w-6 text-white-400 font-bold" />
            {{ $t('Deleted.Course') }}
        </button>
        <button id="" @click="redirectToCategories()"
            class=" ml-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded mt-5 flex items-center text-center ">
            <ArrowRightCircleIcon class="h-6 w-6 text-white-400 font-bold" />
            {{ $t('Categories') }}
        </button>
        <button id="" @click="redirectToResources()"
            class=" ml-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded mt-5 flex items-center text-center ">
            <ArrowRightCircleIcon class="h-6 w-6 text-white-400 font-bold" />
            {{ $t('Rescources') }}
        </button>

    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <input v-model="searchTerm" type="text"
                        class="px-4 py-2 border rounded-lg w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        :placeholder="$t('Search')" />
                </div>
                <div id="margin_table" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full shadow-lg rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr class="bg-orange-400">
                                <th scope="col" class="text-xs text-white uppercase p-4">
                                    {{ $t('Course') }}
                                </th>
                                <th scope="col" class="text-xs text-white uppercase p-4">
                                    {{ $t('Description') }}
                                </th>
                                <th scope="col" class="text-xs text-white uppercase p-4">
                                    {{ $t('Options') }}

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-orange-50 hover:bg-orange-100 text-center"
                                v-for="(course, index) in filteredCourses" :key="course.id">
                                <td class="break-all px-6 py-4 font-medium text-gray-900">
                                    {{ course.name }}
                                </td>
                                <td class="break-all px-6 py-4 font-medium text-gray-900">
                                    {{ course.description }}
                                </td>
                                <td>
                                    <div class="inline-flex">
                                        <!-- Modal toggle -->
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-2 ml-2 rounded"
                                            @click="selectCourse(course)">
                                            <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                        </button>
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 ml-2 rounded "
                                            @click="deleteCourse(course)">
                                            <TrashIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex justify-center my-4">
                        <span v-if="pageCount <= maxPagesToShow">
                            <button v-for="(page, index) in pageCount" :key="index"
                                :class="{ 'bg-gray-400': currentPage === index }" @click="currentPage = index"
                                class="border-2 px-4 py-2">
                                {{ page }}
                            </button>
                        </span>
                        <span v-else>
                            <button v-for="(page, index) in maxPagesToShow" :key="index"
                                :class="{ 'bg-gray-400': currentPage === firstPageIndex + index }"
                                @click="currentPage = firstPageIndex + index" class="border-2 px-4 py-2">
                                {{ firstPageIndex + index + 1 }}
                            </button>
                            <span v-if="firstPageIndex + maxPagesToShow < pageCount">
                                ...
                                <button :class="{ 'bg-gray-400': currentPage === pageCount - 1 }"
                                    @click="currentPage = pageCount - 1" class="border-2 px-4 py-2">
                                    {{ pageCount }}
                                </button>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--//MODAL CREAR-->
    <TransitionRoot as="template" :show="modal_crear">
        <Dialog as="div" class="relative z-10" @close="modal_crear = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form action="" id="course-form" method="POST" v-on:submit.prevent="saveCourse()">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('Create') }} {{ $t('New') }} {{ $t('Course') }}
                                        </DialogTitle>
                                    </div>
                                    <div class="sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>
                                            <div>
                                                <label for="name" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Name') }} {{ $t('Of') }} {{ $t('Course') }}
                                                </label>
                                                <input maxlength="50" required v-model="name" type="text" name="name"
                                                    id="name"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>
                                            <div>
                                                <label for="description" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Description') }} {{ $t('Of') }} {{ $t('Course') }}
                                                </label>
                                                <textarea maxlength="254" required v-model="description" type="text"
                                                    name="description" id="description"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4" />
                                            </div>
                                            <div>
                                                <label for="user" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('assignable.users') }}
                                                </label>
                                                <div class="border rounded-lg mb-4 p-4 h-64 overflow-y-auto">
                                                    <div class="user" v-for="(user, index) in users" :key="index">
                                                        <label>

                                                            <input class="mr-1" type="checkbox" :value="user.id"
                                                                v-model="selectedUsers">
                                                            {{ user.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit" v-bind:disabled="sending" @click="open = false"
                                        class="
                                                                    bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out
                                                                    transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center
                                                                    inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto">
                                        <i class="far fa-save mr-2"></i> {{ $t('Create') }}
                                    </button>
                                    <button type="button"
                                        class="
                                                                    bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out
                                                                    transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center
                                                                    inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="modal_crear = false" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    
    <!--//MODAL EDITAR-->
    <TransitionRoot as="template" :show="modal_edit">
        <Dialog as="div" class="relative z-10" @close="modal_edit = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form action="" id="course-edit" method="POST" v-on:submit.prevent="updateCourse()">

                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="flex items-center flex items-center mx-1 my-1">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                                            {{ $t('Edit') }} {{ $t('Course') }}
                                        </DialogTitle>
                                    </div>
                                    <div class=" sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                                            <div hidden>
                                                @csrf
                                            </div>
                                            <div>
                                                <label for="name_edit" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Name') }} {{ $t('Of') }} {{ $t('Course') }} </label>
                                                <input maxlength="50" v-model="name_edit" type="text" name="name_edit"
                                                    id="name_edit"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                                            </div>
                                            <div>
                                                <label for="description_edit" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('Description') }} {{ $t('Of') }} {{ $t('Course') }} </label>
                                                <textarea maxlength="254" v-model="description_edit" type="text"
                                                    name="description_edit" id="description_edit"
                                                    class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4" />
                                            </div>

                                            <div>
                                                <label for="user" class="font-medium text-gray-900 mb-2">
                                                    {{ $t('assignable.users') }}
                                                </label>
                                                <div class="border rounded-lg mb-4 p-4 h-64 overflow-y-auto">
                                                    <div class="user" v-for="(user, index) in users" :key="index">
                                                        <label>
                                                            <input class="mr-1" type="checkbox" :value="user.id"
                                                                v-model="selectedUsers">
                                                            {{ user.name }}
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="submit" v-bind:disabled="sending" @click="open = false"
                                        class="
                                                                    bg-orange-400 hover:bg-orange-600 font-medium py-2 px-2 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out
                                                                    transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center
                                                                    inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto">
                                        <i class="far fa-save mr-2"></i> {{ $t('Save') }}
                                    </button>
                                    <button type="button"
                                        class="
                                                                    bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out
                                                                    transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center
                                                                    inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
                                        @click="modal_edit = false" ref="cancelButtonRef">
                                        <i class="fas fa-times mr-2"></i>
                                        {{ $t('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import { forEach } from "lodash";
import * as response from "autoprefixer";


export default {
    data() {
        return {
            courses: [],
            perPage: 10,
            currentPage: 0,
            selectedCourse: null,
            name: '',
            description: '',
            name_edit: '',
            description_edit: '',
            id: '',
            sending: false,
            modal_crear: false,
            modal_crear_categoria: false,
            modal_edit: false,
            maxPagesToShow: 5,
            searchTerm: '',
            users: [],
            selectedUser: null,
            selectedUsers: [],
            selected_users: [],
            selectedCourse: '',
            user_ids: []

        }
    },
    async created() {
        const response = await axios.get('/course/index_data')
        this.courses = response.data
        console.log(this.courses)
        const response_users = await axios.get('/course/users')
        this.users = response_users.data
    },
    computed: {
        pageCount() {
            return Math.ceil(this.courses.length / this.perPage)
        },
        firstPageIndex() {
            if (this.currentPage <= Math.floor(this.maxPagesToShow / 2)) {
                return 0
            } else if (this.currentPage >= this.pageCount - Math.floor(this.maxPagesToShow / 2)) {
                return this.pageCount - this.maxPagesToShow
            } else {
                return this.currentPage - Math.floor(this.maxPagesToShow / 2)
            }
        },
        filteredCourses() {
            if (!this.searchTerm) {
                const start = this.currentPage * this.perPage
                const end = start + this.perPage
                return this.courses.slice(start, end)
            } else {
                const start = this.currentPage * this.perPage
                const end = start + this.perPage
                const searchTermLower = this.searchTerm.toLowerCase();
                //todo buscar en todas las paginas
                return this.courses.filter(course => {
                    return course.name.toLowerCase().includes(searchTermLower);
                });
            }
        }
    },
    watch: {
        searchTerm: function () {
            this.$forceUpdate();
        }
    },
    methods: {
        saveCourse() {
            if ((this.name && this.name.length <= 50) && (this.description && this.description.length <= 255)) {
                this.sending = true;
                axios.post('/course', {
                    name: this.name,
                    description: this.description,
                    selectedUsers: this.selectedUsers
                })
                    .then(async response => {
                        this.sending = false;
                        this.name = '';
                        this.description = '';
                        this.courses = response.data.courses;
                        this.modal_crear = false;
                        this.modal_edit = false;
                        this.selectedUsers = [];
                    })
                    .catch(error => {
                        console.log(response.data)
                        console.log(error.response)
                        this.sending = false;
                    })
            } else {
                alert(this.$t('ErrorMsg.3'));
                document.querySelector('#name').classList.add('border', 'border-red-500');
                document.querySelector('#description').classList.add('border', 'border-red-500');
            }
        },

        selectCourse(course) {
            console.log(course)
            this.user_ids = course.users
            this.modal_edit = true;
            this.selectedCourse = course;
            this.id = course.id;
            this.name_edit = course.name;
            this.description_edit = course.description;
            this.selectedUsers = [];
            for (let i = 0; i < this.user_ids.length; i++) {
                let element = this.user_ids[i].user_id;
                this.selectedUsers.push(element);
            }

        },
        updateCourse() {

            if ((this.name_edit && this.name_edit.length <= 50) && (this.description_edit && this.description_edit.length <= 255)) {              // Codificación de los valores de los campos de texto
                this.sending = true;
                axios.put('/course/' + this.id, {
                    name_edit: this.name_edit,
                    description_edit: this.description_edit,
                    selectedUsers: this.selectedUsers
                })
                    .then(response => {
                        this.sending = false;
                        this.id = '';
                        this.name_edit = '';
                        this.description_edit = '';
                        this.courses = response.data.courses;
                        this.modal_crear = false;
                        this.modal_edit = false;
                    })
                    .catch(error => {
                        console.log(error.response)
                        this.sending = false;
                    })
            } else {
                alert(this.$t('ErrorMsg.3'));
                document.querySelector('#name_edit').classList.add('border', 'border-red-500');
                document.querySelector('#description_edit').classList.add('border', 'border-red-500');
            }
        }
        ,
        deleteCourse(course) {
            this.selectedCourse = course.id
            this.sending = true;
            axios.get('/course/' + this.selectedCourse + '/hide', {})
                .then(response => {
                    this.courses = response.data.courses;
                })
                .catch(error => {
                    console.log(error.response)
                    this.sending = false;
                })
        }
        ,
        redirectToDeletedCourses() {
            window.location.href = "/course/hidden";
        },

        redirectToCategories() {
            window.location.href = "course/categories";
        },

        redirectToResources() {
            window.location.href = "rescources/admin";
        },
    },
}


</script>


<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import {
    AcademicCapIcon,
    PlusIcon,
    TrashIcon,
    PencilSquareIcon,
    XMarkIcon,
    EyeSlashIcon,
    ArrowRightCircleIcon
} from '@heroicons/vue/24/outline'
</script>
