<template>
    <div class="container-boards w-full">
        <div class="boards gap-2.5 m-5 grid md:grid-cols-3">
            <div class="board border-solid border-2 border-black bg-orange-50 rounded-lg h-screen overflow-y-auto"
                v-for="(board, index) in boards" :key="index"
                @dragover.prevent
                @drop="onDrop(board)">
                <div class="flex font-bold border-b-4 border-black p-6 text-lg justify-between sticky top-0 bg-orange-400">
                    {{ board.name }} :<div class=""> {{ taskCount(board.id) }} {{ taskCount(board.id) == 1 ? $t('kanban.task') : $t('kanban.tasks') }}</div>
                </div>
                <div class="items flex p-2 gap-2.5 flex-col mt-4">
                    <div class="hover:border-solid hover:border-2 border-black p-2 rounded-lg select-none"
                        v-for="task in board.items" :key="task.id" 
                        @click="showAlert(task)" 
                        @dragstart="onDragStart(task)"
                        :class="{ 'bg-orange-300': task.manages === 'Me aconseja Pymeralia', 'bg-gray-300': task.manages === 'Me lo gestiono yo' }"
                        :draggable="task.manages === 'Me aconseja Pymeralia' ? false : true">
                        {{ task.recommendation }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import axios from "axios";
import { reactive } from "@vue/reactivity";

export default {
    data() {
        return {
            boards: reactive([
                {
                    id: "to-do",
                    name: "To Do",
                    state: "ToDo",
                    items: [],
                },
                {
                    id: "in-progress",
                    name: "In Progress",
                    state: "InProgress",
                    items: [],
                },
                {
                    id: "done",
                    name: "Done",
                    state: "Done",
                    items: [],
                },
            ]),
            // Pas de valor a columnes
            stateMap: {
                ToDo: "to-do",
                InProgress: "in-progress",
                Done: "done",
            },
        };
    },
    mounted() {
        axios.get("/tasks").then((response) => {
            this.loadTasks(response.data);
        });
    },
    methods: {
        loadTasks(tasks) {
            tasks.forEach((task) => {
                let taskData = {
                    id: task.id,
                    recommendation: task.recommendation,
                    state: task.state,
                    manages: task.manages,
                };
                let boardId = this.stateMap[task.state];
                let board = this.boards.find((b) => b.id === boardId);
                board.items.push(taskData);
            });
        },
        onDragStart(task) {
            this.draggingTask = task;

        },
        showAlert(task) {
            if (task.manages === 'Me aconseja Pymeralia') {
                Swal.fire({
                    text: this.$t('kanban.alert'),
                    icon: 'warning',
                    confirmButtonText: this.$t('kanban.alert.back')
                })
            }
        },
        onDrop(board) {
            const targetState = board.state;
            const task = this.draggingTask;
            const currentState = task.state;
            if (currentState !== targetState) {
                task.state = targetState;
                axios
                    .put(`/tasks-update/${task.id}`, { state: targetState })
                    .then(() => {
                    })
                    .catch((error) => {
                    });
                const sourceBoard = this.boards.find((b) => b.state === currentState);
                sourceBoard.items.splice(sourceBoard.items.indexOf(task), 1);
                board.items.push(task);
            }
            this.draggingTask = null;
        },
        taskCount(boardId) {
            const board = this.boards.find((board) => board.id === boardId);
            return board.items.length;
        },

    },
};
</script>
