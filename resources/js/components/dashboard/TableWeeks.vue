<template>
    <div>
        <h1 class="p-3 text-center font-medium">{{ $t('pending-tasks-1-month') }}</h1>
        <table class="table-auto w-full shadow-lg rounded-lg p-4 overflow-hidden">
            <thead class0="rounded-t-lg">
                <tr class="bg-orange-400 text-white">
                    <th class="px-6 py-3 uppercase">{{ $t('task') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('impact') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('state') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('date') }}</th>
                    <th class="px-6 py-3 uppercase"></th>
                </tr>
            </thead>
            <tbody v-if="weekTasks != 0">
                <tr v-for="tasca in weekTasks" :key="tasca.id" class="bg-orange-50 hover:bg-orange-100 text-center">
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ tasca.recommendation }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ tasca.name }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ tasca.state }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ formatDate(tasca.final_date) }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900"><a href="kanban" class="text-base font-medium bg-blue-500 hover:bg-blue-400 text-white py-2 px-4 rounded-full transition-colors duration-300">{{ $t('go') }}</a></p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else class="p-2.5 font-medium items-center">
                {{ $t('no-results') }}
            </tbody>
        </table>
    </div>

</template>
<script>
import axios from 'axios';
import { format } from 'date-fns';

export default {
    mounted() {
        this.getTasksWeeks();
    },

    data() {
        return {
            weekTasks: [],
        }
    },

    methods: {
        async getTasksWeeks() {
            try {
                const response = await axios.get('/taskLimit')
                this.weekTasks = response.data
            } catch (error) {
                console.error(error)
            }
        },

        /** Método que formatea la fecha */
        formatDate(date) {
            return format(new Date(date), this.$t('date-format'));
        }
    },
}

</script>
