<template>
  <g-gantt-chart
    chart-start="2023-01-01 00:00"
    chart-end="2023-12-31 00:00"
    precision="month"
    bar-start="beginDate"
    bar-end="endDate"
  >
    <g-gantt-row
      v-for="(task, index) in taskList"
      :key="'Tarea-' + (index + 1)"
      :label="'Tarea ' + (index + 1)"
      :bars="[
        {
          beginDate: task.start_date,
          endDate: task.final_date,
          ganttBarConfig: {
            id: 'task-' + (index + 1),
            label: task.recommendation,
            hasHandles: true,
            style: {
              background: 'orange',
              borderRadius: '20px',
              color: 'black'
            }
          }
        }
      ]"
    />
  </g-gantt-chart>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const taskList = ref([])
const bars = ref([])

onMounted(() => {
  axios.get('/tasks').then(response => {
    taskList.value = response.data
    bars.value = taskList.value.map((task, index) => {
      return {
        beginDate: task.start_date,
        endDate: task.final_date,
        ganttBarConfig: {
          id: 'Tarea-' + (index + 1),
          label: task.recommendation,
          hasHandles: true,
          style: {
            background: 'orange',
            borderRadius: '20px',
            color: 'black'
          }
        }
      }
    })
  })
})
</script>