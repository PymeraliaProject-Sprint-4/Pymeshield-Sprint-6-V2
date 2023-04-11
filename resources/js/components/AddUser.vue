<template>
    <div class="grid justify-items-end  flex">
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 flex items-center"
            @click="open = true">
            <PlusIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
            <span class="ml-2">{{ $t('create-user') }}</span>
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
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="xl:items-start">
                                    <div class="flex space-x-2 items-center">
                                        
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                            {{ $t('create-user') }}</DialogTitle>
                                    </div>

                                    <div class="mt-3 text-center md:text-left">
                                        <form @submit.prevent="submitForm">
                                            <div class="mt-2">
                                                <div>
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('name') }}</label>
                                                    <span v-if="!name" class="text-red-500">*</span>
                                                    <input type="text" v-model="name" id="name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label for="last_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('lastname') }}</label>
                                                    <span v-if="!last_name" class="text-red-500">*</span>
                                                    <input type="text" v-model="last_name" id="last_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div>
                                                    <label for="nick_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('username') }}</label>
                                                    <span v-if="!nick_name" class="text-red-500">*</span>
                                                    <input type="text" v-model="nick_name" id="nick_name"
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
                                                        <input type="email" v-model="email" id="email"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                    <div class="w-full">
                                                        <label for="phone"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('phone') }}</label>
                                                        <span v-if="!phone" class="text-red-500">*</span>
                                                        <input type="text" v-model="phone" id="phone"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <label for="company_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{ $t('company') }}</label>
                                                    <span v-if="!company_name" class="text-red-500">*</span>
                                                    <input type="text" v-model="company_name" id="company_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400"
                                                        required>
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
                                    @click="open = false" ref="cancelButtonRef"><i class="fas fa-times mr-2"></i>{{ $t('cancel') }}</button>
                           
                                <button type="submit"
                                class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center"
                                    @click="submitForm()"><i class="fas fa-plus mr-2"></i> {{ $t('add') }}</button>
                                </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { PlusCircleIcon, PlusIcon } from '@heroicons/vue/24/outline'
const open = ref(false)
const name = ref('')
const last_name = ref('')
const nick_name = ref('')
const email = ref('')
const phone = ref('')
const company_name = ref('')
const password = ref('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
const submitForm = () => {
    

        try {
            axios.post('addUser', {
                name: name.value,
                last_name: last_name.value,
                nick_name: nick_name.value,
                email: email.value,
                phone: phone.value,
                company_name: company_name.value,
                password: password.value,
            })
                .then(response => {
                    console.log(response.data); // imprimir la respuesta en la consola
                    this.$emit('usuario-restaurado');
                    this.props.actualizarUsuarios();
                })
                .catch(error => {
                    console.log(response.data); // imprimir la respuesta en la consola
                    this.$emit('usuario-restaurado');
                    this.props.actualizarUsuarios();

                });

        } catch {
            alert('fallo aixos')
            this.props.actualizarUsuarios();

        }

    }

</script>
