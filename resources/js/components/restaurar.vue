<template>

  <div class="mx-5 mt-3">
    <div class="flex justify-between">
        <div class="flex items-center">
            <p class="text-2xl font-semibold">Reparar dispositivos</p>
        </div>
        <div class="flex items-center">
        </div>
    </div>
  
            <table class="mt-2 table-fixed w-full text-base text-left text-gray-800 dark:text-gray-400 text-center">
                <thead class="bg-orange-500 text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 ">Marca</th>
                        <th scope="col" class="px-6 py-3">Modelo</th>
                        <th scope="col" class="px-6 py-3">MAC-ethernet</th>
                        <th scope="col" class="px-6 py-3">MAC-wifi</th>
                        <th scope="col" class="px-6 py-3">Tipo</th>
                        <th scope="col" class="px-6 py-3">Descripcion</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="w-29 px-6 py-3">Funciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="device in restoreData.data" :key="device.id" class="bg-orange-50 hover:bg-orange-100 border-b dark:border-gray-700">
                        <td class="px-6 py-3">
                            {{ device.brand }}
                        </td>
                        <td class="px-6 py-3">
                            {{ device.model }}
                        </td>
                        <td class="px-6 py-3">
                            {{ device.mac_ethernet }}
                        </td>
                        <td class="px-6 py-3">
                            {{ device.mac_wifi }}
                        </td>
                        <td class="px-6 py-3">
                            {{ device.type_device_id }}
                        </td>
                        <td class="px-6 py-3">
                            {{ device.description }}
                        </td>
                        <td class="px-6 py-3">
                            {{ device.state }}
                        </td>
                        <td class="px-4 py-4 text-center align-middle" >
                            <!-- Funciona sense cap problema: 
                                <button @click="dispositiurestaurat(device.id)" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"> Restaurar </button> -->
                            <div >
                                <!-- <button
                                  type="button"
                                  @click="openModal()"
                                  class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                >
                                  Restaurar
                                </button> -->
                                <button
                                type="button"
                                @click="openModal(device.id)"
                                class="rounded-md bg-black bg-opacity-20 px-4 py-2 text-sm font-medium text-white hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                              >
                                Restaurar
                              </button>
                              </div>
                              <TransitionRoot appear :show="isOpen" as="template">
                                <Dialog as="div" @close="closeModal" class="relative z-10">
                                  <TransitionChild
                                    as="template"
                                    enter="duration-300 ease-out"
                                    enter-from="opacity-0"
                                    enter-to="opacity-100"
                                    leave="duration-200 ease-in"
                                    leave-from="opacity-100"
                                    leave-to="opacity-0"
                                  >
                                    <div class="fixed inset-0 bg-black bg-opacity-25" />
                                  </TransitionChild>
                            
                                  <div class="fixed inset-0 overflow-y-auto">
                                    <div
                                      class="flex min-h-full items-center justify-center p-4 text-center"
                                    >
                                      <TransitionChild
                                        as="template"
                                        enter="duration-300 ease-out"
                                        enter-from="opacity-0 scale-95"
                                        enter-to="opacity-100 scale-100"
                                        leave="duration-200 ease-in"
                                        leave-from="opacity-100 scale-100"
                                        leave-to="opacity-0 scale-95"
                                      >
                                        <DialogPanel
                                          class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                                        >
                                        <div class="mt-2" style="text-align: center;  align-items: center;">
                                            <svg style="margin-bottom: 25px;"  aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                          </div>
                                            <DialogTitle 
                                                as="h3"
                                                style="text-align: center; font-size:25px"                                    
                                            >
                                                ¿Estás seguro de restaurar este dispositivo?
                                            </DialogTitle>
                                          &nbsp;
                                          <div class="mt-4" style="text-align: center;">
                                            <button 
                                              class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                              @click="closeModal"
                                            >
                                              Cancelar
                                            </button>
                                            <button
                                              style="margin: 20px;"
                                              class="inline-flex justify-center rounded-md border border-transparent bg-red-100 px-4 py-2 text-sm font-medium text-black-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                                              @click="dispositiurestaurat()"
                                            >
                                              Confirmar
                                            </button>
                                        </div>
    
                                        </DialogPanel>
                                      </TransitionChild>
                                    </div>
                                  </div>
                                </Dialog>
                              </TransitionRoot>
                        </td>
                    </tr>
                </tbody>
            </table>
        <!-- Paginació amb TailWind -->

    </div>
    <div class="flex justify-center mt-4">
      <TailwindPagination
      :data="restoreData"
      @pagination-change-page="getDevices"
  />
  </div>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            restoreData: [],
            deviceId: null, // Agrega una propiedad para guardar la ID del dispositivo
            isOpen: false
        }
    },
    methods: {
        dispositiurestaurat() {
        axios.post(`/restore/${this.deviceId}`)
            .then(response => {
                console.log(response);
                location.reload(); // A partir d'aquest mètode de Javascript, s'autorefresca 
            })
            .catch(error => {
                console.log(error);
            })
    },
 
    openModal(id) {
      console.log(id)
      this.isOpen = true;
      this.deviceId = id; // Guarda la ID del dispositivo en la propiedad de datos
    },
    closeModal() {
  this.isOpen = false
  localStorage.setItem('modalIsOpen', 'false')
}
 
    }
}


</script>
<script setup>
import { ref } from 'vue'
import { TailwindPagination } from 'laravel-vue-pagination';
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'

//const isOpen = ref(localStorage.getItem('modalIsOpen') === 'true');
/*function closeModal() {
  isOpen.value = false
  localStorage.setItem('modalIsOpen', 'false')
}*/

const restoreData = ref({});
function getDevices(page = 1) {
    axios.get("/restaurar?page=" + page)
        .then(response => {
        restoreData.value = response.data;
        restoreData.data = response.data.data;
    })
        .catch(error => {
        console.log(error);
    });
}
getDevices()
</script>