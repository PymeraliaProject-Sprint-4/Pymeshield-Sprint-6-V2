<template>
    <div class="flex justify-center mt-5">
        <div class="w-4"></div> <!-- Espacio entre los botones -->
        <button @click="redirectToVisibleUsers()" id=""
            class="mr-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded flex items-center text-center">
            <EyeIcon class="h-6 w-6 text-white-400 font-bold" />
            {{ $t('Visible.User') }}
        </button>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6 text-gray-900">
                <div class="mb-4">
                    <div id="margin_table" class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-base text-left text-gray-500 dark:text-gray-400 text-center">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-orange-400 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('name') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('lastname') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('email') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('phone') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('company') }}
                                    </th>
                                    <th scope="col" class="text-xs text-white uppercase p-4">
                                        {{ $t('functions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="user.length > 0">
                                <tr v-for="users in user" :key="id"
                                    class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ users.name }}
                                    </th>
                                    <td class="break-all px-6 py-4 font-medium text-gray-900">
                                        {{ users.last_name }}
                                    </td>
                                    <td class="break-all px-6 py-4 font-medium text-gray-900">
                                        {{ users.email }}
                                    </td>
                                    <td class="break-all px-6 py-4 font-medium text-gray-900">
                                        {{ users.phone }}
                                    </td>
                                    <td class="break-all px-6 py-4 font-medium text-gray-900">
                                        {{ users.company_name }}
                                    </td>
                                    <td class="px-4 py-4 text-center align-middle">
                                        <button
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-2 ml-2 rounded "
                                            @click="restoreUser(users)">
                                            <ArrowUpIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                        </button>
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-2 ml-2 rounded"
                                            @click="openModalEditar(users)">
                                            <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                            <h1 class="text-lg content-center" v-else>{{ $t('no-existing-records') }}</h1>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Modal editar Usuari-->
    <TransitionRoot as="template" :show="ModalEditar">
        <Dialog as="div" class="relative z-10" @close="ModalEditar = false">
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
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="xl:items-start">
                                    <div class="flex space-x-2 items-center">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center sm:mx-0 sm:h-10 sm:w-10">
                                            <i class="fas fa-edit mr-2"></i>
                                        </div>
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900"> {{
                                            $t('edituser') }}</DialogTitle>
                                    </div>

                                    <div class="mt-3 text-center md:text-left">
                                        <form>
                                            <div class="mt-2">
                                                <div class="relative">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                            $t('name') }}</label>
                                                    <input type="text" v-model="currentUser.name" id="name" name="name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pr-8"
                                                        required>
                                                    <span v-if="!currentUser.name"
                                                        class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <div class="relative">
                                                    <label for="last_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                            $t('lastname') }}</label>
                                                    <input type="text" v-model="currentUser.last_name" id="last_name"
                                                        name="last_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pr-8"
                                                        required>
                                                    <span v-if="!currentUser.last_name"
                                                        class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                </div>
                                            </div>


                                            <div class="mt-2">
                                                <div class="relative">
                                                    <label for="nick_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                            $t('username') }}</label>
                                                    <input type="text" v-model="currentUser.nick_name" id="nick_name"
                                                        name="nick_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pr-8"
                                                        required>
                                                    <span v-if="!currentUser.nick_name"
                                                        class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full relative">
                                                        <label for="email"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                                $t('email') }}</label>
                                                        <input type="email" v-model="currentUser.email" id="email"
                                                            name="email"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pr-8"
                                                            required>
                                                        <span v-if="!currentUser.email"
                                                            class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                    </div>
                                                    <div class="w-full relative">
                                                        <label for="phone"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                                $t('phone') }}</label>
                                                        <input type="text" v-model="currentUser.phone" id="phone"
                                                            name="phone"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pr-8"
                                                            required>
                                                        <span v-if="!currentUser.phone"
                                                            class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                    </div>
                                                </div>
                                                <div class="relative">
                                                    <label for="company_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                            $t('company') }}</label>
                                                    <select v-model="currentUser.company_name" id="company_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pl-6 pl-10"
                                                        required>
                                                        <option value="" disabled selected>{{ $t('select_company') }}
                                                        </option>
                                                        <option v-for="company in companies" :key="company.id"
                                                            :value="company.name">{{ company.name }}</option>
                                                    </select>
                                                    <span v-if="!currentUser.company_name"
                                                        class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                </div>
                                            </div>

                                            <div class="w-full">
                                                <div class="relative">
                                                    <label for="rols"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                            $t('Role') }}</label>
                                                    <select v-model="currentUser.type" id="rols"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pl-6 pl-10"
                                                        required>
                                                        <option value="" disabled selected>{{ $t('Select a role') }}
                                                        </option>
                                                        <option value="worker">{{ $t('Worker') }}</option>
                                                        <option value="admin">{{ $t('Admin') }}</option>
                                                        <option value="client">{{ $t('Client') }}</option>
                                                    </select>

                                                    <span v-if="!type"
                                                        class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button"
                                    class="bg-gray-300 hover:bg-gray-500 text-black font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 "
                                    @click="closeModal()" ref="cancelButtonRef"><i class="fas fa-times mr-2"></i>{{
                                        $t('cancel') }}
                                </button>

                                <button type="button"
                                    class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center"
                                    @click="submitFormEditar()"> <i class="far fa-save mr-2"></i>{{ $t('save') }}
                                </button>


                            </div>

                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: [],
            companies: [],
            currentUser: {},
            ModalEditar: false,
            ModalBaja: false,
            ModalCrear: false,
            selectedRole: '',
            selectedType: '',

        };
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        getUsers() {
            axios.get("userList/userListingHidden")
                .then(response => {
                    this.user = response.data;
                })
                .catch(error => {
                    console.log(error);
                });

                axios.get(`/listadoEmpresas/listCompanies`)
                .then((response) => {
                    this.companies = response.data;

                })
                .catch((error) => {
                    console.log(error);
                })
        },
        
        openModalEditar(user) {
            this.ModalEditar = true;
            this.currentUser = {
                id: user.id,
                name: user.name,
                last_name: user.last_name,
                nick_name: user.nick_name,
                email: user.email,
                phone: user.phone,
                type: user.type,
                company_name: user.company_name
            };
        },

        closeModal() {
            this.ModalEditar = false;
            this.currentUser = {};
        },

        submitFormEditar() {
            axios.post("userList/editUser", {
                id: this.currentUser.id,
                name: this.currentUser.name,
                last_name: this.currentUser.last_name,
                nick_name: this.currentUser.nick_name,
                email: this.currentUser.email,
                phone: this.currentUser.phone,
                company_name: this.currentUser.company_name
            })
                .then(response => {
                    this.getUsers();
                    console.log(response);
                    this.ModalEditar = false;
                    this.currentUser = {};
                })
                .catch(error => {
                    console.error(error);
                });
        },

        restoreUser(user) {
            this.selectedUser = user.id
            axios.get('/user/' + this.selectedUser + '/unHide', {})
                .then(response => {
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error.response)
                })
        },
        redirectToVisibleUsers() {
            window.location.href = "/userList";
        }
    }
}
</script>

<script setup>
import { PlusCircleIcon, ShieldCheckIcon, ArchiveBoxArrowDownIcon, PencilSquareIcon, TrashIcon, PlusIcon, EyeSlashIcon, ArrowUpIcon, EyeIcon } from '@heroicons/vue/24/outline'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

</script>

















