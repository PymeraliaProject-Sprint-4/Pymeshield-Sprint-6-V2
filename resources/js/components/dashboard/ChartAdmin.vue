<template>
    <div>
        <canvas id="chartAdmin"></canvas>
    </div>
</template>

<script>
import axios from 'axios';
import Chart from 'chart.js/auto'; //modulo para hacer graficos

export default {
    mounted() {
        this.getChartUserData();
    },

    data() {
        return {
            dataGraphic: [],
        }
    },

    methods: {

        /**
         * getChartUserData() recupera los datos de una api externa
         */
        async getChartUserData() {
            try {
                const response = await axios.get('/graphicAdminData')
                this.dataGraphic = response.data
                this.createChart(); //llama al método que crea el gráfico
            } catch (error) {
                console.error(error)
            }
        },

        /**
         * createChart() és el método que crea el gráfico de datos
         */
        createChart() {
            const canvas = document.getElementById('chartAdmin');
            let data = {};

            if (this.dataGraphic.length != 0) {
                data = {
                    labels: [this.$t('dashboard.admin.devices'), this.$t('dashboard.admin.courses'), this.$t('dashboard.admin.companies'), this.$t('dashboard.admin.users')], //nombre de los datos del gráfico
                    datasets: [{
                        label: this.$t('quantity'), //nombre de la propiedad
                        data: [this.dataGraphic.countDevices, this.dataGraphic.countCourses, this.dataGraphic.countCompanies, this.dataGraphic.countUsers], //número que recuperamos de la api para mostrar en el gráfico (dato real que queremos mostrar)
                        backgroundColor: ['rgba(255, 99, 132)', 'rgba(75, 192, 192)', 'rgba(153, 102, 255)', 'rgb(54, 162, 235)'],
                        borderColor: ['rgba(255, 99, 132)', 'rgba(75, 192, 192)', 'rgba(153, 102, 255)', 'rgb(54, 162, 235)'],
                        borderWidth: 1
                    }
                    ]
                };
            } else {
                data = {
                    labels: [this.$t('no-results')], //nombre de los datos del gráfico
                    datasets: [{
                        label: '', //nombre de la propiedad
                        data: [1], //número que recuperamos de la api para mostrar en el gráfico (dato real que queremos mostrar)
                        backgroundColor: ['rgba(210, 215, 211)'],
                        borderColor: ['rgba(210, 215, 211)'],
                        borderWidth: 1
                    }
                    ]
                };
            }

            const options = { //hace referencia a las coordenadas X e Y
                plugins: {
                    tooltip: {
                        enabled: this.dataGraphic != 0 ? true : false //esta opción deshabilita el hover con la info si dataGraphic es menor que 0
                    }
                }
            };

            /**
             * se instancia un nuevo Gráfico con Chart(),
             * canvas hace referencia a la etiqueta y tipos de etiqueta donde se va a renderizar el gráfico
             */
            const chart = new Chart(canvas, {
                type: 'pie', //tipo de gráfico que se va a mostrar
                data: data, //contiene los datos a representar en el gráfico y hace referéncia a la constante data
                options: options //contiene opciones de configuración del gráfico y hace referéncia a la constante options
            });
        },
    }
}
</script>
