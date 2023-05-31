<template>
    <div class="flex justify-center items-center h-screen">
        <div class="max-w-md mx-auto">
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Instrucciones:</h2>
                <p class="text-gray-600">Ingrese el nombre del robot y haga clic en "Guardar".</p>
            </div>
            <div class="bg-blue-500 rounded-lg shadow-lg p-8">
                <h1 class="text-3xl font-bold text-white mb-6">ROBOT</h1>
                <form @submit.prevent="saveRobot" class="flex">
                    <input v-model="robotName" type="text" placeholder="Nombre del robot"
                        class="flex-grow rounded-l-md border border-r-0 px-4 py-2 focus:outline-none focus:ring-blue-300" />
                    <button type="submit"
                        class="bg-green-500 text-white font-bold px-4 py-2 rounded-r-md hover:bg-green-600 transition-colors"
                        :disabled="saving">
                        <template v-if="!saving && !loading">Guardar</template>
                        <template v-else>
                            <template v-if="loading">
                                <svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042.647 5.91 1.823 8.465l2.829-2.829zM12 20c-3.042 0-5.91-.647-8.465-1.823l2.829-2.829A7.962 7.962 0 0112 16h4v4zm5.177-5.177l2.829 2.829C18.353 17.91 16.036 18.536 14 18.536V14h4zM16.536 10H14V5.464a9.952 9.952 0 00-3.536 0V10H7.464a9.952 9.952 0 000 3.536H12v4.536a9.952 9.952 0 003.536 0V13h4.536A9.952 9.952 0 0024 12c0-2.036-.626-4.353-1.823-6.177l-2.829 2.829zM6.177 6.177L3.348 3.348C5.464 1.624 8.041 1 10.5 1V6.5a1.5 1.5 0 11-1.5 1.5H1v4h4.5a1.5 1.5 0 110 3H1v4h4.5a1.5 1.5 0 11-1.5 1.5H1v4h4.5c2.459 0 5.036-.624 7.152-2.348l-2.829-2.829A9.952 9.952 0 0112 12c0-2.036-.626-4.353-1.823-6.177z">
                                    </path>
                                </svg>
                            </template>
                            <template v-else>
                                Guardando...
                            </template>
                        </template>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';

export default {
    data() {
        return {
            robotName: '',
            saving: false,
            loading: false,
        };
    },
    methods: {
        saveRobot() {
            if (!this.robotName) {
                // Validar que el campo robotName no esté vacío
                console.error('El nombre del robot no puede estar vacío');
                return;
            }

            this.saving = true; // Activar el estado de guardado

            // Realizar la petición POST con Axios
            axios
                .post('/save-robot', { robotName: this.robotName })
                .then(() => {
                    // Petición exitosa
                    console.log('Robot guardado exitosamente');
                    this.robotName = ''; // Limpiar el campo del nombre del robot
                    this.loading = true; // Activar el estado de carga
                    setTimeout(() => {
                        location.reload(); // Recargar la página después de 5 segundos
                    }, 5000);
                })
                .catch((error) => {
                    // Error en la petición
                    console.error('Error al guardar el robot:', error);
                })
                .finally(() => {
                    this.saving = false; // Desactivar el estado de guardado
                });
        },
    },
};
</script>
  
<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

.container {
    animation: fadeIn 1s;
}
</style>
    