<template>
    <div class="flex flex-col items-center mt-10">
        <div class="w-full max-w-xl p-6 bg-gradient-to-r from-gray-800 to-gray-600 rounded-lg shadow-lg">
            <div class="text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold">{{ robotName }}</h2>
                    <p class="mt-2">{{ getCurrentDateTime }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold">{{ userAmount }}</p>
                    <p class="text-sm flex items-center">
                        <span class="h-2 w-2 rounded-full bg-red-500 mr-1"></span>
                        {{ status }}
                    </p>
                </div>
            </div>
            <!-- Progress Bar -->
            <div class="h-3 rounded-lg overflow-hidden mt-2 bg-gray-300">
                <!-- Porcentaje de progreso -->
                <div class="h-full bg-blue-500" :style="{ width: `${percentage}%` }"></div>
                <!-- Espacio no ocupado -->
                <div class="h-full bg-gray-300" :style="{ width: `${100 - percentage}%` }"></div>
            </div>
            <!-- Percentage Label -->
            <p class="mt-2 text-white text-center font-bold text-lg">
                {{ percentage }}%
            </p>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            robotName: "Nombre del Robot",
            userAmount: "$1000",
            status: "Finalizado",
            percentage: 100, // Cambia este valor para probar diferentes porcentajes
        };
    },
    computed: {
        getCurrentDateTime() {
            const now = new Date();
            return now.toLocaleString();
        },
    },
};
</script>
  
<style scoped></style>
  