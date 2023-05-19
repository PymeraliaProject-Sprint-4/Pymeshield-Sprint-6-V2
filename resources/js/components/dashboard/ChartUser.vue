<template>
  <div>
    <h1 class="p-3 text-center font-medium">{{ $t('info-user') }}</h1>
    <canvas
      id="chartUser"></canvas><!-- Utilizamos la etiqueta canvas y el atributo id para llamar al gráfico con el mismo id-->
    <!-- <h1 v-else class="p-3 text-center font-medium">{{ $t('no-results') }}</h1> -->
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
        const response = await axios.get('/graphicUserData')
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
      const canvas = document.getElementById('chartUser');
      let data = {};

      if (this.dataGraphic.length != 0) {
        data = {
          labels: [this.$t('devices'), this.$t('courses-to-be-completed'), this.$t('tasks-to-do')], //nombre de los datos del gráfico
          datasets: [{
            label: this.$t('quantity'), //nombre de la propiedad
            data: [this.dataGraphic.countDevices[0].num_devices, this.dataGraphic.countCourses[0].num_courses, this.dataGraphic.countTasks[0].num_tasks], //número que recuperamos de la api para mostrar en el gráfico (dato real que queremos mostrar)
            backgroundColor: ['rgba(255, 99, 132)', 'rgba(75, 192, 192)', 'rgba(153, 102, 255)'],
            borderColor: ['rgba(255, 99, 132)', 'rgba(75, 192, 192)', 'rgba(153, 102, 255)'],
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
        type: 'doughnut', //tipo de gráfico que se va a mostrar
        data: data, //contiene los datos a representar en el gráfico y hace referéncia a la constante data
        options: options //contiene opciones de configuración del gráfico y hace referéncia a la constante options
      });
    },
  }
}
</script>
