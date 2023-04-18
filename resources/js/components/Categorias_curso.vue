<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">{{ $t('CategoriesActivities') }} <span
                class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">"{{ courseName
                }}"</span>
        </h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div v-for="(category, index) in categories" :key="index"
                class="bg-white dark:bg-gray-700 rounded-lg shadow-md">
                <div class="p-4 bg-gradient-to-r to-orange-500 from-orange-300 rounded-t-lg">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ category.name }}</h2>
                </div>
                <div class="px-4 py-2">
                    <ul>
                        <li v-for="(activity, index) in category.activities" :key="index"
                            @click="viewActivityDeliveries(activity.id)"
                            class="text-gray-700 dark:text-gray-400 hover:bg-gray-200 cursor-pointer">
                            {{ activity.name }}
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div>
            <button
                class="mt-5 px-3 py-2 bg-orange-500 text-white font-bold rounded-full hover:bg-orange-400 focus:outline-none transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110"
                @click="goBack()">
                {{ $t('Back') }}
            </button>
        </div>
    </div>
</template>

<script>

import axios from 'axios';

export default {
    props: {
        id: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            courseName: "",
            categories: []
        }
    },
    mounted() {
        const url = new URL(window.location.href);
        const id = url.pathname.split('/')[2];
        axios.get(`/CursosCalificar/${id}/activities-Datos`)
            .then(response => {
                this.courseName = response.data.courseName;
                this.categories = response.data.categories;
            });

    },
    methods: {
        goBack() {
            window.history.back();

        },

        viewActivityDeliveries(activityId) {
            const url = new URL(window.location.href);
            const id = url.pathname.split('/')[2];
            window.location.href = `/CursosCalificar/${id}/activities/${activityId}`;

        }
    }

}
</script>