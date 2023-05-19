<template>
    <div>
        <h1 class="p-3 text-center font-medium">{{ $t('pending-activities-1-month') }}</h1>
        <table class="w-full shadow-lg rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-orange-400 text-white">
                    <th class="px-6 py-3 uppercase"></th>
                    <th class="px-6 py-3 uppercase">{{ $t('course-name') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('category-name') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('activity-name') }}</th>
                    <th class="px-6 py-3 uppercase">{{ $t('date') }}</th>
                    <th class="px-6 py-3 uppercase"></th>
                </tr>
            </thead>
            <tbody v-if="weekActivities != 0">
                <tr v-for= "activity in weekActivities" :key="activity.id" class="bg-orange-50 hover:bg-orange-100 text-center">
                    <td class="px-2 py-2">
                        <img :src="activity.image" class="text-sm text-gray-900 rounded-lg w-20 m-3" :alt="$t('image-activity')">
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ activity.name }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ activity.categoryName }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ activity.activityName }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900">{{ formatDate (activity.final_date) }}</p>
                    </td>
                    <td class="px-2 py-2 text-center">
                        <p class="text-sm text-gray-900"><a href="course/client" class="text-base font-medium bg-blue-500 hover:bg-blue-400 text-white py-2 px-4 rounded-full transition-colors duration-300">{{ $t('go') }}</a></p>
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
import { format } from 'date-fns'; //modulo para dar formato a fechas

export default {
    mounted() {
        this.getTasksWeeks();
    },

    data() {
        return {
            weekActivities: [],
        }
    },

    methods: {
        async getTasksWeeks() {
            try {
                const response = await axios.get('/activitiesLimit')
                this.weekActivities = response.data
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
