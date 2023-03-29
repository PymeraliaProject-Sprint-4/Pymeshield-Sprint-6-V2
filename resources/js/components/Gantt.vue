<template>
  <g-gantt-chart chart-start="2021-07-12 12:00" chart-end="2021-07-30 12:00" :bars="bars">

    <g-gantt-row v-for="(rowData, index) in rows" :key="index" :label="rowData.label" />

  </g-gantt-chart>
</template>

<script>

import axios from "axios";
import { ref } from "vue"

export default {
  setup() {
    const rows = ref([]);

    axios.get("/tasks").then((response) => {
      rows.value = response.data.map((data, index) => {
        return {
          label: `Tarea ${index + 1}`,
          bars: [
            {
              start: data.start_date,
              end: data.final_date,
              ganttBarConfig: {
                id: `${index + 1}`,
                hasHandles: true,
                label: data.recommendation,
                style: {
                  background: "black",
                  borderRadius: "20px",
                  color: "white",
                }
              },
            }
          ]
        }
      })
    });

    const bars = ref([]);
    console.log(bars);
    const updateBars = () => {
      bars.value = rows.value.flatMap(row => row.bars);
    }

    updateBars();

    return {
      rows,
      bars,
      updateBars
    };
  },
};
</script>
