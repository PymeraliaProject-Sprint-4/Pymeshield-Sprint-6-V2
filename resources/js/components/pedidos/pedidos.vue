<template>
    <div class="flex flex-col items-center mt-10">
        <div v-for="pedido in pedidos" :key="pedido.id"
            class="w-full max-w-xl p-6 bg-gradient-to-r from-gray-800 to-gray-600 rounded-lg shadow-lg mb-4">
            <div class="text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold">{{ pedido.Name_robot }}</h2>
                    <p class="mt-2">{{ pedido.start_time }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold">{{ pedido.amount }}</p>
                    <p class="text-sm flex items-center">
                        <span class="h-2 w-2 rounded-full bg-green-500 mr-1"></span>
                        {{ pedido.status }}
                    </p>
                </div>
            </div>
            <!-- Progress Bar -->
            <div class="h-3 rounded-lg overflow-hidden mt-2 bg-gray-300">
                <!-- Porcentaje de progreso -->
                <div class="h-full bg-blue-500"
                    :style="{ width: `${calculatePercentage(pedido.start_time, pedido.end_time)}%` }"></div>
                <!-- Espacio no ocupado -->
                <div class="h-full bg-gray-300"
                    :style="{ width: `${100 - calculatePercentage(pedido.start_time, pedido.end_time)}%` }"></div>
            </div>
            <!-- Percentage Label -->
            <p class="mt-2 text-white text-center font-bold text-lg">
                {{ Math.floor(calculatePercentage(pedido.start_time, pedido.end_time)) }}%
            </p>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    data() {
        return {
            pedidos: [],
        };
    },
    computed: {
        getCurrentDateTime() {
            const now = new Date();
            return now.toLocaleString();
        },
    },
    methods: {
        calculatePercentage(startTime, endTime) {
            const startDate = new Date(startTime);
            const endDate = new Date(endTime);
            const currentDate = new Date();

            // Obtener la diferencia de tiempo en milisegundos entre la fecha actual y la fecha de inicio
            const timeDifference = currentDate.getTime() - startDate.getTime();

            // Obtener la diferencia de tiempo total en milisegundos entre la fecha de inicio y la fecha de finalización
            const totalTime = endDate.getTime() - startDate.getTime();

            // Calcular el porcentaje de progreso
            let percentage = (timeDifference / totalTime) * 100;

            // Asegurarse de que el porcentaje esté dentro del rango válido (0-100)
            percentage = Math.max(0, Math.min(percentage, 100));

            return percentage;
        },

        fetchPedidos() {
            // Realiza la petición Axios para obtener los pedidos de la ruta "allPedidos"
            axios.get('allPedidos')
                .then(response => {
                    this.pedidos = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
    created() {
        // Llama al método para obtener los pedidos al cargar la página
        this.fetchPedidos();
    },
};
</script>
  
<style scoped>
.mb-4 {
    margin-bottom: 1rem;
}
</style>
  