<template>
    <div class="relative overflow-x-auto mb-2">
        <div class="flex justify-between mx-12">
            <div class="ml-auto">
                <form class="flex">
                    <div class="w-full relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" @keyup="buscarDispositivos" v-model="buscar" id="voice-search"
                            class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-orange-600 sm:text-sm sm:leading-6 pl-10"
                            :placeholder="$t('inventory.search.device')">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto shadow-md sm:rounded-lg m-5">
        <table class="table-auto w-full shadow-lg rounded-lg">
            <thead class="bg-orange-500 text-white">
                <tr class="bg-orange-400 text-white">
                    <th class="px-6 py-3 uppercase">{{ $t('inventory.brand') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('inventory.model') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('inventory.mac.ethernet') }} / {{ $t('inventory.mac.wifi') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('inventory.type') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('inventory.description') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('inventory.state') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('inventory.serial.number') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="dispositivo in dispositivoD.data" :key="dispositivo.id"
                    class="bg-orange-50 hover:bg-orange-100 text-center">
                    <td class="px-6 py-4">{{ dispositivo.band }}</td>
                    <td class="px-6 py-4">{{ dispositivo.model }}</td>
                    <td class="px-6 py-4">{{ dispositivo.mac_ethernet }} / {{ dispositivo.mac_wifi }}</td>
                    <td class="px-6 py-4">{{ dispositivo.name }}</td>
                    <td class="px-6 py-4">{{ dispositivo.description }}</td>
                    <td class="px-6 py-4">{{ dispositivo.state }}</td>
                    <td class="px-6 py-4">{{ dispositivo.serial_number }}</td>
                </tr>
            </tbody>

        </table>

    </div>

    <div class="flex justify-center m-4">
        <TailwindPagination :data="dispositivoD" @pagination-change-page="cargarDispositivos" />
    </div>
</template>
<script>
import { ref } from 'vue';
import axios from 'axios';
import { TailwindPagination } from 'laravel-vue-pagination';

export default {
    components: {
        TailwindPagination,
    },
    setup() {
        const dispositivoD = ref({});
        const dispositivosInventario = ref([]);
        const buscar = ref('');
        const setTimeoutBuscadore = ref('');
        const paginaActual = ref(1);

        function cargarDispositivos(page = 1) {
            axios
                .get('/listInventory?page=' + page, {
                    params: {
                        buscar: buscar.value,
                    },
                })
                .then((response) => {
                    dispositivoD.value = response.data;
                    dispositivoD.data = response.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        }

        function buscarDispositivos() {
            clearTimeout(setTimeoutBuscadore.value);
            setTimeoutBuscadore.value = setTimeout(cargarDispositivos, 360);
        }

        cargarDispositivos();

        return {
            dispositivoD,
            dispositivosInventario,
            buscar,
            setTimeoutBuscadore,
            paginaActual,
            cargarDispositivos,
            buscarDispositivos,
        };
    },
};
</script>
