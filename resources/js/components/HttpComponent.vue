<template>
    <br>
    <div class="flex flex-row justify-between items-start">
        <button class="ml-5 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" @click="getData()">Obtener datos</button>
        <button class="mr-5 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click="removeData()">Borrar datos</button>
    </div>

    <div class="m-5">
        <table class="w-full text-base text-left text-gray-500 dark:text-gray-400 text-center">
            <tbody v-if="datos.length > 0">
            <tr v-for="(dato, key) in datos" :key="key" class="bg-gray-100 border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ dato.name }}
                </th>
                <td class="px-6 py-4">
                    {{ dato.email }}
                </td>
            </tr>
            </tbody>
            <h1 class="text-lg content-center" v-else>{{$t('no-existing-records')}}</h1>
        </table>
    </div>

</template>

<script>
export default {
    name: 'http',
    data() {
        return {
            datos: []
        };
    },
    methods: {
        async getData() {
            try {
                const response = await this.$axios.get('/users')
                this.datos = response.data
            } catch (error) {
                console.error(error)
            }
        },
        removeData(){
            this.datos = [];
        }
    }
};
</script>

