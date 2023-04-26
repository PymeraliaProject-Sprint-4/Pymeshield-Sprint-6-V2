<template>
  <div class="flex justify-center mt-5">
      <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center" @click="ModalCrear = true">
          <PlusIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
          <span class="ml-2">{{ $t('create-emblem') }}</span>
      </button>
      <div class="w-4"></div> <!-- Espacio entre los botones -->
      <button @click="redirectToDeletedCompany()" id="" class="mr-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded flex items-center text-center">
          <EyeSlashIcon class="h-6 w-6 text-white-400 font-bold" />
          {{ $t('delete-emblem') }}
      </button>
  </div>
  
  
      <div class="m-5">
          
          <table class="w-full text-base text-left text-gray-500 dark:text-gray-400 text-center">
              <thead class="text-xs text-gray-700 uppercase bg-orange-400 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3 ">
                          {{ $t('emblem-name') }}
                      </th>
                      <th scope="col" class="px-6 py-3">
                          {{ $t('emblem-description') }}
                      </th>
                      <th scope="col" class="px-6 py-3">
                          {{ $t('emblem-image') }}
                      </th>
                      <th scope="col" class="px-6 py-3">
                          {{ $t('emblem-name-course') }}
                      </th>
                      <th scope="col" class="px-6 py-3">
                          {{ $t('functions') }}
                      </th>
                  </tr>
              </thead>
              <tbody v-if="emblems.length > 0">
                  <tr v-for="(emblem, key) in emblems" :key="id"
                      class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                      <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white    ">
                          {{ emblem.name }}
                      </th>
                      <td class="px-6 py-4">
                          {{ emblem.description }}
                      </td>
                      <td class="px-6 py-4">
                        <img :src="emblem.image" class="img-flud" width="60">
                      </td>
                      <td class="px-6 py-4">
                          {{ emblem.course.name }}
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
      
  </template>

<script>
  import axios from 'axios';
  import { ref } from 'vue';
  import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
  import { PlusCircleIcon, ShieldCheckIcon, ArchiveBoxArrowDownIcon, PencilSquareIcon, EyeSlashIcon } from '@heroicons/vue/24/outline'

  export default {
    data() {
      return {
        emblems: []
      }
    },
    mounted() {
          this.getEmblems();
      },
    methods: {
      getEmblems() {
        axios.get('/emblems/show')
          .then(response => {
            this.emblems = response.data.emblems.data
          })
          .catch(error => {
            console.log(error)
          })
      }
    }
  }
</script>
  
  <script setup>
  import { ref } from 'vue';
  import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
  import { PlusCircleIcon, ShieldCheckIcon, ArchiveBoxArrowDownIcon, PencilSquareIcon, EyeSlashIcon } from '@heroicons/vue/24/outline'
  </script>
