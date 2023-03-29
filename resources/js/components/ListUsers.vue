<template>
    <div class="grid justify-items-end mr-5">
        <AddUser></AddUser>
        <!-- <UpUser></UpUser> -->
    </div>

    <div class="m-5">
        <table class="w-full text-base text-left text-gray-500 dark:text-gray-400 text-center">
            <thead class="text-xs text-gray-700 uppercase bg-orange-400 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ $t('name') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ $t('lastname') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ $t('email') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ $t('phone') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ $t('functions') }}
                    </th>
                </tr>
            </thead>
            <tbody v-if="varusers.length > 0">
                <tr v-for="(user, key) in varusers" :key="key"
                    class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ user.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ user.last_name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ user.email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ user.phone }}
                    </td>
                    <td class="px-4 py-4 text-center align-middle">
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 ml-2 rounded "
                            @click="this.openModalBaja(company.id)">
                            <TrashIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                        </button> <button class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-2 ml-2 rounded"
                            @click="this.openModalEditar(company.id, company.name, company.email, company.phone, company.cif)">
                            <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                        </button>
                    </td>

                </tr>
            </tbody>
            <h1 class="text-lg content-center" v-else>{{ $t('no-existing-records') }}</h1>
        </table>

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
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <PlusCircleIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Editar
                                            Usuario</DialogTitle>
                                    </div>

                                    <div class="mt-3 text-center md:text-left">
                                        <form @submit.prevent="submitForm">
                                            <div class="mt-2">
                                                <div>
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('name') }}</label>
                                                    <span v-if="!name" class="text-red-500">*</span>
                                                    <input type="text" v-model="editar.nameEditar" id="name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label for="last_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('lastname') }}</label>
                                                    <span v-if="!last_name" class="text-red-500">*</span>
                                                    <input type="text" v-model="editar.last_nameEditar" id="last_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label for="nick_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('username') }}</label>
                                                    <span v-if="!nick_name" class="text-red-500">*</span>
                                                    <input type="text" v-model="editar.nick_nameEditar" id="nick_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label for="email"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('email') }}</label>
                                                        <span v-if="!email" class="text-red-500">*</span>
                                                        <input type="email" v-model="editar.emailEditar" id="email"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                    <div class="w-full">
                                                        <label for="phone"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('phone') }}</label>
                                                        <span v-if="!phone" class="text-red-500">*</span>
                                                        <input type="text" v-model="editar.phoneEditar" id="phone"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <label for="company_id"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('company') }}</label>
                                                    <span v-if="!company_id" class="text-red-500">*</span>
                                                    <input type="text" v-model="editar.company_idEditar" id="company_id"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                                <input type="hidden" v-model="editar.password">

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
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                    @click="submitFormEditar()">Guardar</button>
                                <button type="button"
                                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                    @click="open = false" ref="cancelButtonRef">Cancel</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <!--Modal baja Usuari-->
    <TransitionRoot as="template" :show="ModalBaja">
        <Dialog as="div" class="relative z-10" @close="ModalBaja = false">
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
                            <form @submit.prevent="submitForm">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="xl:items-start">
                                        <div class="flex space-x-2 items-center">
                                            <div
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <PencilSquareIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                            </div>
                                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                                {{ $t('deregister user') }}</DialogTitle>
                                        </div>

                                        <div class="mt-3 text-center md:text-left">

                                            <div class="mt-2">
                                                <div>
                                                    <label
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{
                                                            $t('deregistration-reason') }}</label>
                                                    <textarea maxlength="255" v-model="baja.removed_reason"
                                                        class="w-full h-24 align-top bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        cols="auto" rows="10"></textarea>
                                                    <input type="hidden" v-model="baja.id">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="submitFormBaja()">{{ $t('Deregister') }}</button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="ModalBaja = false" ref="cancelButtonRef">{{ $t('cancel') }}</button>
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

//Importem el botó d'afegir usuaris
import AddUser from './AddUser.vue';
//import UpUser from './upUser.vue';

export default {
    data() {
        return {
            varusers: [],
            ModalBaja: false,
            baja: { id: "", removed_reason: "" },
            editar: { id: "", nameEditar: "", last_nameEditar: "", nick_nameEditar: "", emailEditar: "", phoneEditar: "", company_idEditar: "", password: "" },
            user: [],
            ModalEditar: false,

        };
    },
    mounted() {
        this.getUsers()
    },
    methods: {
        getUsers() {
            axios.get("userList/userListing")
                .then(response => {
                    this.varusers = [];
                    this.varusers = response.data;
                    //dd(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        openModalBaja(id) {
            this.baja.id = id;
            this.ModalBaja = true;
        },
        submitFormBaja() {
            this.ModalBaja = true;
            axios.post('/userDown', {
                user_id: this.baja.id,
                removed_reason: this.baja.removed_reason,
            })
                .then(response => {
                    this.getUsers();
                    console.log(response);
                    this.ModalBaja = false;
                    this.NotificacionBaja = true;
                    setTimeout(() => { this.NotificacionBaja = false; }, 2000);
                })
                .catch(error => {
                    console.error(error);
                });

        },
        openModalEditar(id, name, last_name, nick_name, email, phone, company_id, password,) {
            this.ModalEditar = true;
            this.editar.id = id
            this.editar.nameEditar = name;
            this.editar.last_nameEditar = last_name;
            this.editar.nick_nameEditar = nick_name;
            this.editar.emailEditar = email;
            this.editar.phoneEditar = phone;
            this.editar.company_idEditar = company_id;
            this.editar.password = password;
            console.log(this.editar.password);
        },
        submitFormEditar() {
            try {
                axios.post('/editUser', {
                    user_id: this.editar.id,
                    name: this.editar.nameEditar,
                    last_name: this.editar.last_nameEditar,
                    nick_name: this.editar.nick_nameEditar,
                    email: this.editar.emailEditar,
                    phone: this.editar.phoneEditar,
                    company_id: this.editar.company_idEditar,
                    password: this.editar.password,

                })
                    .then(response => {
                        // Lógica para manejar la respuesta del controlador
                        alert('Usuario editado con exito')
                        this.ModalEditar = false
                        //open = false
                    })
                    .catch(error => {
                        // Lógica para manejar el error
                        //alert('error crear user')
                    });

            } catch {
                alert('fallo aixos')
            }
        }
    },

    components: { AddUser }
};
</script>
<script setup>
import { PlusCircleIcon, ShieldCheckIcon, ArchiveBoxArrowDownIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

</script>

















