<template>
    <div class="grid justify-items-end mr-10 flex">
        <button class="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-2 ml-2 rounded " @click="open = true"><ArchiveBoxArrowUpIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
            <PlusIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
            <span class="ml-2">{{ $t('up-user') }}</span>
        </button>
    </div>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
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
                           
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <PlusCircleIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                                        </div>
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                            {{ $t('up-user') }}</DialogTitle>

    
        <table class="w-full text-base text-left text-gray-500 dark:text-gray-400 text-center">
            <thead class="text-xs text-gray-700 uppercase bg-orange-400 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{$t('name')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{$t('lastname')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{$t('email')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{$t('phone')}}
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ $t('functions') }}
                </th>
            </tr>
        </thead>
        <tbody v-if="varusers.length > 0">
            <tr v-for="(user, key) in varusers" :key="key" class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
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
                <td class="px-4 py-4 text-center align-middle" >
                    <button class="bg-green-600 hover:bg-green-500 text-white font-bold py-2 px-2 ml-2 rounded " @click="submitFormUp(user.user_id)"><ArchiveBoxArrowUpIcon class="h-6 w-6 text-white-400" aria-hidden="true" /></button>
                </td>
                
                
            </tr>
        </tbody>
        <h1 class="text-lg content-center" v-else>{{$t('no-existing-records')}}</h1>
    </table>

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
            varusers: [],

        };
    },
    mounted() {
        this.getUsers()
    },
    methods:{
        getUsers(){
            axios.get("userList/userListingHidden")
                .then(response => {
                this.varusers = [];
                this.varusers.push(...response.data);
                 //dd(response.data);
            })
            .catch(error => {
            console.log(error);
            });
        },   
        submitFormUp(user_id) {
                try{
                    axios.post('/upUser', {
                        hidden: null,
                        id: user_id,
                        })
                        .then(response => {
                            // Lógica para manejar la respuesta del controlador
                            alert('Usuario restored')
                            //open = false
                        })
                        .catch(error => {
                            // Lógica para manejar el error
                            //alert('error crear user')
                        });

                    }catch{
                        alert('fallo aixos')
                    }
                } 
            },  
};
</script>
<script setup>
import { PlusCircleIcon, ShieldCheckIcon, ArchiveBoxArrowUpIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

</script>

















