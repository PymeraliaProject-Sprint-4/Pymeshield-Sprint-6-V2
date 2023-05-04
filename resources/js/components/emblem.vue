<template>
  <h1 class="ml-7 mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
      class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('Admin') }}</span>
  </h1>
  <p class="ml-7 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ $t('phrase.1.emblem') }}
  </p>
  <div class="flex justify-center mt-5">
    <button id="" @click="modal_crear = true"
      class=" bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-5 flex items-center"
      type="button">
      <PlusIcon class="h-6 w-6 text-white-400 font" aria-hidden="true" />
      {{ $t('Add') }} {{ $t('Emblem') }}
    </button>
    <div class="w-4"></div> <!-- Espacio entre los botones -->

    <button @click="redirectToDeletedEmblems()"
      class="mr-5 text-white bg-orange-500 hover:bg-orange-700 font-bold focus:ring-4 focus:outline-none py-2 px-4 rounded flex items-center text-center">
      <EyeSlashIcon class="h-6 w-6 text-white-400 font-bold" />
      {{ $t('deleted.emblem') }}
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
                {{ $t('Emblems') }}
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
                <button class="bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-2 ml-2 rounded"
                  @click="modalEdit(emblem)">
                  <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                </button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-2 ml-2 rounded "
                  @click="deleteEmblem(emblem)">
                  <PencilSquareIcon class="h-6 w-6 text-white-400" aria-hidden="true" />
                </button>
              </td>
            </tr>
          </tbody>
          <h1 class="text-lg content-center" v-else>{{ $t('no-existing-records') }}</h1>
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
              <li v-for="page in Math.ceil(total / perPage)" :key="page">
                <button @click="changePage(page)" class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md"
                  :class="{ 'bg-orange-400': page === currentPage }">
                  {{ page }}
                </button>
              </li>
              <li v-if="pagination.length > 0 && currentPage < Math.ceil(emblems.length / perPage)">
                <button @click="changePage(currentPage + 1)"
                  class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-md shadow-md">
                  {{ $t('Next') }}
                </button>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

  </div>

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

              <form method="POST" v-on:submit.prevent="saveEmblem()" enctype="multipart/form-data">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                  <div class="flex items-center mx-1 my-1">
                    <div
                      class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                      <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                    </div>
                    <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                      {{ $t('Create') }} {{ $t('New') }} {{ $t('Emblem') }}
                    </DialogTitle>
                  </div>
                  <div class="sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                      <div hidden>
                        @csrf
                      </div>
                      <div>
                        <label for="name"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" v-model="name" id="name" name="name" required
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                      </div>
                      <div>
                        <label for="description"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
                        <input type="text" v-model="description" id="description" name="description" required
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                      </div>
                      <div>
                        <label for="image"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Emblema:</label>
                        <input type="file" v-on:change="setImage" id="image" name="image" required
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                      </div>
                      <label for="course_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre
                        Curso:</label>
                      <select v-model="course_id" id="course_id" name="course_id" required
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Selecciona un Curso</option>
                        <option v-for="(emblem, key) in emblems" :key="id">{{ emblem.course.id }}</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                  <button type="submit" v-bind:disabled="sending" @click="modal_crear = false"
                    class="bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-4 ml-2 mr-2 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto">
                    <i class="far fa-save mr-2"></i> {{ $t('Create') }}
                  </button>
                  <button type="button"
                    class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center inline-flex w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
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
                  <div class="flex items-center mx-1 my-1">
                    <div
                      class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                      <AcademicCapIcon class="h-6 w-6 text-orange-400" aria-hidden="true" />
                    </div>
                    <DialogTitle class="ml-2 flex text-base font-semibold leading-6 text-gray-900">
                      {{ $t('Edit') }} {{ $t('Emblem') }}
                    </DialogTitle>
                  </div>
                  <div class=" sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:mx-1 sm:text-left">
                      <div hidden>
                        @csrf
                      </div>
                      <div>
                        <label for="name_edit" class="font-medium text-gray-900 mb-2">
                          {{ $t('Name') }} {{ $t('Of') }} {{ $t('Emblem') }} </label>
                        <input maxlength="50" v-model="name_edit" type="text" name="name_edit" id="name_edit"
                          class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4">
                      </div>
                      <div>
                        <label for="description_edit" class="font-medium text-gray-900 mb-2">
                          {{ $t('Description') }} {{ $t('Of') }} {{ $t('Emblem') }} </label>
                        <textarea maxlength="254" v-model="description_edit" type="text" name="description_edit"
                          id="description_edit"
                          class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4" />
                      </div>
                      <div>
                        <label for="course_id_edit" class="font-medium text-gray-900 mb-2">
                          {{ $t('Name') }} {{ $t('Of') }} {{ $t('Course') }} </label>
                        <textarea maxlength="254" v-model="course_id_edit" type="text" name="course_id_edit"
                          id="course_id_edit"
                          class="bg-gray-100 border-gray-300 focus:ring-orange-400 focus:border-orange-400 rounded-md w-full py-2 px-3 mb-4" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                  <button type="submit" v-bind:disabled="sending" @click="open = false" class="bg-orange-400 hover:bg-orange-600 font-medium py-2 px-2 mr-2  transition-all duration-300 ease-in-out
                                    transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center
                                     w-full justify-center rounded-md text-sm shadow-sm sm:ml-3 sm:w-auto">
                    <i class="far fa-save mr-2"></i> {{ $t('Save') }}
                  </button>
                  <button type="button" class="bg-gray-300 hover:bg-gray-500 text-black  font-medium py-1 px-2  transition-all duration-300 ease-in-out
                                    transform hover:-translate-y-1 hover:scale-110 ml-auto flex items-center
                                 w-full justify-center rounded-md text-sm   shadow-sm sm:ml-3 sm:w-auto"
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
      emblems: [],
      modal_crear: false,
      modal_edit: false,
      selectedEmblem: '',
      id: '',
      name: '',
      description: '',
      image: null,
      course_id: '',
      name_edit: '',
      description_edit: '',
      image_edit: null,
      course_id_edit: '',
      searchTerm: '',
      pagination: {},
      total: 0,
      page: 1,
      perPage: 10, // cantidad de elementos por página
      currentPage: 1 // página actual
    }
  },


  setIsOpen(value) {
    modal_crear.value = value
  },

  mounted() {
    this.getEmblems(this.currentPage);
  },

  computed: {
    emblems() {
      const searchTermLower = this.searchTerm.toLowerCase();
      return this.emblems.filter(emblem => {
        const userString = emblem.name.toLowerCase() + emblem.description.toLowerCase();
        return userString.includes(searchTermLower);
      });
    }
  },


  methods: {
    getEmblems(page = 1) {
      axios.get(`/emblems/show?page=${page}`)
        .then(response => {
          this.emblems = [];
          this.emblems = response.data.emblems.data
          this.currentPage = page;
          this.total = response.data.emblems.total
        })
        .catch(error => {
          console.log(error)
        })
    },

    changePage(page) {
      this.getEmblems(page);
    },

    saveEmblem() {

      const name = document.getElementById('name').value;
      const description = document.getElementById('description').value;
      const image = document.getElementById('image').files[0];
      const course_id = document.getElementById('course_id').value;

      const data = new FormData();
      data.append('name', name);
      data.append('description', description);
      data.append('image', image);
      data.append('course_id', course_id);

      axios.post('emblems/store', data)
        .then(response => {
          this.getEmblems();
          console.log(response.data)
        })
        .catch(error => {
          console.log(response.data)
        });
    },

    onFileChange(event) {
      this.image = event.target.files[0];
    },

    modalEdit(emblem) {
      this.modal_edit = true;
      this.selectedEmblem = emblem.id;
      this.id = emblem.id;
      this.name_edit = emblem.name;
      this.description_edit = emblem.description;
      this.image_edit = emblem.image;
      this.course_id_edit = emblem.course_id;

    },

     updateCourse() {

         this.sending = true;
         this.name_edit = emblem.name;
         console.log(this.name_edit);
         this.description_edit = emblem.description;
         this.image_edit = emblem.image;
         this.course_id_edit = emblem.course_id;
         axios.put('emblems/' + this.selectedEmblem + '/edit', {})
           .then(response => {
             this.sending = false;
             this.emblems = response.data.emblems;
           })
           .catch(error => {
             console.log(error.response)
             this.sending = false;
           })

     },

    deleteEmblem(emblem) {
      this.selectedEmblem = emblem.id
      this.sending = true;
      axios.get('emblems/' + this.selectedEmblem + '/eliminar', {})
        .then(response => {
          this.getEmblems();
          this.emblems = response.data.emblems;
        })
        .catch(error => {
          console.log(error.response)
          this.sending = false;
        })
    },


    redirectToDeletedEmblems() {
      window.location.href = "emblems/restaurar";
    },


  }
}
</script>
  
<script setup>
import { ref } from 'vue';
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
