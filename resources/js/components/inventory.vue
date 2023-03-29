<template>
<div class="relative overflow-x-auto mb-2">
    <div class="flex justify-between mx-12">
       <div class="ml-auto">
            <form class="flex">   
                <div class="w-full relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" @keyup="buscarDispositivos" v-model="buscar" id="voice-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar dispositivo">
                </div>
            </form>
        </div> 
    </div>
</div>

<div class="flex justify-center overflow-x-auto">
    <table class="container table-auto w-full shadow-lg rounded-lg">
        <thead class="bg-orange-500 text-white">
            <tr class="bg-orange-400 text-white">
            <th class="px-6 py-3 uppercase">{{ $t('brand') }}</th>
            <th class="px-6 py-3 uppercase">{{ $t('model') }}</th>
            <th class="px-6 py-3 uppercase">{{ $t('MAC-ethernet') }}</th>
            <th class="px-6 py-3 uppercase">{{ $t('MAC-wifi') }}</th>
            <th class="px-6 py-3 uppercase">{{ $t('Type') }}</th>
            <th class="px-6 py-3 uppercase">{{ $t('Desc') }}</th>
            <th class="px-6 py-3 uppercase">{{ $t('State') }}</th>
            <th class="px-6 py-3 uppercase">{{ $t('SerialN') }}</th>          
            </tr>
        </thead>
        <tbody>        
            <tr v-for="dispositivo in dispositivoD.data" :key="dispositivo.id" class="bg-orange-50 hover:bg-orange-100 text-center">
            <td class="px-6 py-4">{{dispositivo.brand}}</td>
            <td class="px-6 py-4">{{dispositivo.model}}</td>
            <td class="px-6 py-4">{{dispositivo.mac_ethernet}}</td>
            <td class="px-6 py-4">{{dispositivo.mac_wifi}}</td>
            <td class="px-6 py-4">{{dispositivo.type_device_id}}</td>
            <td class="px-6 py-4">{{dispositivo.description}}</td>
            <td class="px-6 py-4">{{dispositivo.state}}</td>
            <td class="px-6 py-4">{{dispositivo.serial_number}}</td>
            </tr>
        </tbody>
        
        </table>

</div>

<div class="flex justify-center m-4">
    <TailwindPagination
    :data="dispositivoD"
    @pagination-change-page="caragrDispositivos"
/>
</div>
     
</template>
<script>
        
export default{
    data() {
        return{
            dispositivosInventario: [],
            buscar: '',
            setTimeoutBuscadore: '',
            paginaActual: 1,
            };
        },
        mounted() {
         },
        methods: {
            buscarDispositivos(){
                clearTimeout( dispositivoD.setTimeoutBuscadore)
                dispositivoD.setTimeoutBuscadore = setTimeout(dispositivoD.caragrDispositivos, 360)
            },
        },
    }; 
</script>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { TailwindPagination } from 'laravel-vue-pagination';
    
const dispositivoD = ref({});
    
function caragrDispositivos(page=1){
    axios.get("/listInventory?page=" + page,{
                    params: {
                        buscar: dispositivoD.buscar
                    }
                })
                .then(response => {
                    dispositivoD.value = response.data;
                    dispositivoD.data = response.data.data;
                })
                    .catch(error => {
                    console.log(error);
            });
            }
    
    
caragrDispositivos()
</script>