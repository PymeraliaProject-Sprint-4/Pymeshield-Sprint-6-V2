<template>
 

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
                                        <div class="mt-2">
                                            <div class="relative">
                                                <label for="name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                        $t('name') }}</label>

                                                <input type="text" v-model="name" id="name"
                                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pr-8"
                                                    required>
                                                <span v-show="!name"
                                                    class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                            </div>

                                        </div>
                                        <div class="mt-2">
                                            <div class="relative">
                                                <label for="last_name"
                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                        $t('lastname') }}</label>
                                                <input type="text" v-model="last_name" id="last_name"
                                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pl-6 pl-10"
                                                    required>
                                                <span v-if="!last_name"
                                                    class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="relative">
                                                <div>
                                                    <label for="nick_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                            $t('username') }}</label>
                                                    <input type="text" v-model="nick_name" id="nick_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pl-6 pl-10"
                                                        required>
                                                    <span v-if="!nick_name"
                                                        class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="relative">
                                                <div class="flex w-full space-x-8">
                                                    <div class="w-full">
                                                        <label for="email"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                                $t('email') }}</label>
                                                        <input type="text" v-model="email" id="email"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pl-6 pl-10"
                                                            required>
                                                        <span v-if="!email"
                                                            class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                    </div>
                                                </div>
                                                <div class="w-full">
                                                    <div class="relative">
                                                        <label for="phone"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                                $t('phone') }}</label>
                                                        <input type="text" v-model="phone" id="phone"
                                                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pl-6 pl-10"
                                                            required>
                                                        <span v-if="!phone"
                                                            class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-full">
                                                <div class="relative">
                                                    <label for="company_name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">{{
                                                            $t('company') }}</label>
                                                    <input type="text" v-model="company_name" id="company_name"
                                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-orange-400 focus:border-orange-400 pl-6 pl-10"
                                                        required>
                                                    <span v-if="!company_name"
                                                        class="absolute right-0 top-8 mt-2 mr-2 text-red-500">*</span>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="button"
                                    class="bg-gray-300 hover:bg-gray-500 text-black font-medium py-1 px-2 rounded-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 "
                                    @click="open = false" ref="cancelButtonRef"><i class="fas fa-times mr-2"></i>{{
                                        $t('cancel') }}</button>

                                <button
                                    class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center"
                                    @click="createUser()"><i class="fas fa-plus mr-2"></i> {{ $t('add') }}</button>
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
import { PlusIcon, EyeSlashIcon } from '@heroicons/vue/24/outline'
const open = ref(false)

</script>
