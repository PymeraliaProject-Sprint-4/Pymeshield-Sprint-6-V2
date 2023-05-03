<template>
    <div class="modificarReport">
    <div class="flex items-center pt-4 justify-between m-5">
      <a @click="open = true">
        <button class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-3 ml-2 rounded"
                data-modal-target="modificar{{ id }},{{ name }},{{ status }}" 
                data-modal-toggle="modificar{{ id }},{{ name }},{{ status }}">
            <i class="fa-regular fa-pen-to-square "></i>
        </button>
      </a>
    </div>
    </div>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <form>
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-orange-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                            </svg>

                                        </div>
                                        <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">
                                                {{ $t('survey.modify') }}</DialogTitle>
                                                <div class="mt-2">
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="name"
                                                        class="block text-sm font-medium leading-6 text-gray-900">{{
                                                            $t('survey.name') }}</label>
                                                    <input required v-model="nameModificar" type="text" name="name"
                                                        id="name" autocomplete="given-name"
                                                        class="my-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6" />
                                                </div>
                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="status"
                                                        class="block text-sm font-medium leading-6 text-gray-900">{{
                                                            $t('survey.status') }}</label>
                                                    <select required v-model="statusModificar" id="status"
                                                        name="status" autocomplete="status-state"
                                                        class="my-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6">
                                                        <option :value="null" disabled>{{ $t('messages.option')}}</option>
                                                        <option value="done">Done</option>
                                                        <option value="pending">Pending</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- mostrar mensaje error/success -->
                                <div class="p-4 text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                    role="alert" v-if="hasError === 0">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 inline-block"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4">
                                        </circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">{{ $t('survey.created') }}</span> {{ $t('survey.success', {
                                        seconds: '3'
                                    }) }}
                                </div>
                                <div class="p-4 text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert"
                                    v-if="hasError === 1">
                                    <span class="font-medium">{{ $t('survey.error') }}</span> {{ $t('survey.failed') }}
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-center">
                                    <button type="submit" id="yes"
                                            class="w-full rounded-md bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 sm:ml-3 sm:w-auto marginBotons"
                                            :class="{ 'opacity-50 cursor-not-allowed': hasError === 0 }" 
                                            :disabled="hasError === 0" 
                                            @click="modificarReport" 
                                            >
                                            {{ $t('savechanges') }}
                                    </button>
                                    <button type="button" 
                                            class="w-full rounded-md bg-gray-300 px-3 py-2 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 sm:w-auto"
                                            @click="open = false">
                                            {{ $t('cancel') }}
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

<script setup>
import { defineProps, ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from 'axios'

// datos para rellenar el modal
const props = defineProps({
  id: String,
  name: String,
  status: String
});

const nameModificar = ref(props.name);
const statusModificar = ref(props.status);

// por si hay errores
const hasError = ref(null);

// v-models

// abrir modal
const open = ref(false)

// enviar asignación cuestionario
async function modificarReport() {
   
    console.log(props.name)
    try {
   
        const response = await axios.post(`/report/${props.id}`, {
  name: nameModificar.value,
  status: statusModificar.value,
});

        hasError.value = 0
        setTimeout(() => {
            open.value = false;
            window.location.href = '/report'
        }, 3000);
    } catch (error) {
        console.log(error);
        // mostrar errores
        hasError.value = 1
    }
}
</script>
