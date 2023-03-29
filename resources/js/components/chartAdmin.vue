<template>
    <div>
        <canvas id="chartAdmin"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
    mounted() {
        this.createChart();
    },
    methods: {
        createChart() {
            const canvas = document.getElementById('chartAdmin');
            const data = {
                labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                datasets: [{
                    label: 'Actividad Cursos',
                    data: [2, 4, 5, 7, 15, 12, 13],
                    backgroundColor: 'rgb(50, 205, 50, 0.2)',
                    borderColor: 'rgb(34, 139, 34, 1)',
                    borderWidth: 1
                },
                    {
                        label: 'Actividad Dispositivos',
                        data: [5, 7, 10, 8, 12, 15, 20],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Actividad Usuarios',
                        data: [4, 10, 3, 5, 2, 10, 7],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
            };
            const options = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };

            const chart = new Chart(canvas, {
                type: 'line',
                data: data,
                options: options
            });
        }
    }
}
</script>
