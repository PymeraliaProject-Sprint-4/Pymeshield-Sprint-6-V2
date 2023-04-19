<template>
    <div>
        <button class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded mt-5 flex items-center " @click="showUsersTable"><ArchiveBoxArrowDownIcon class="h-6 w-6 text-white-400" aria-hidden="true" /><span class="ml-2">{{ $t('restore') }}      </span>
        </button>
    </div>
    <TransitionRoot as="template" :show="showTable">
        <Dialog as="div" class="relative z-10" @close="showTable = false">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xxl transition-all ">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="xl:items-start">
                                    <div class="flex space-x-2 items-center">
                                        
                                        <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">Dar de alta Usuario</DialogTitle>
                                    </div>
                                    <table v-if="showTable" class="table-auto w-full shadow-lg rounded-lg">
                                        <thead class="text-xs text-gray-700 uppercase bg-orange-400">
                                            <tr scope="col" class="bg-orange-400 text-white">
                                            <th scope="col" class="px-6 py-3 uppercase">{{$t('nick_name')}}</th>
                                            <th scope="col" class="px-6 py-3 uppercase">{{$t('email')}}</th>
                                            <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(user, key) in users" :key="key" class="bg-orange-50 hover:bg-orange-100 text-center">
                                                
                                                <td class="px-6 py-4">{{ user.nick_name }}</td>
                                                <td class="px-6 py-4">{{ user.email }}</td>
                                                <td>
                                                <button class="bg-orange-400 hover:bg-orange-600 font-medium py-1 px-2 mr-4 rounded-lg  transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110 ml-auto block flex items-center" @click="submitFormUp(user.id)">
                                                    <i class="far fa-save mr-2">{{$t('restore') }}</i>
                                                </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
      users: [], // Cambiado de users a users
      showTable: false
    };
  },
  mounted() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      axios.get('userList/userListingHidden')
        .then(response => {
          this.users = response.data; // Actualizamos users con la respuesta de la API
        })
        .catch(error => {
          console.log(error);
        });
    },
    submitFormUp(user_id) {
    try {
        axios.post('/upUser', {
            user_id: user_id,
            hidden: null,
        })
        .then(response => {
            //alert('Usuario restaurado');
            this.showTable=false;
            this.$emit('usuario-restaurado', usuario.id);
        })
        .catch(error => {
            console.log(error);
            this.showTable=false;
            //alert('Error al restaurar usuario');
        });
    } catch (error) {
        console.log(error);
        this.showTable=false;
        //alert('Error al restaurar usuario');
    }
}
,
    showUsersTable() {
      this.showTable = !this.showTable; // Cambiamos el valor de showTable al hacer clic en el botón
    }
  }
};
</script>

<script setup>
import { PlusCircleIcon, ShieldCheckIcon, ArchiveBoxArrowDownIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

</script>

















