<template>
    <h1 class="ml-10 mt-10 mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
        <span class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('All') }}</span>
    </h1>
    <p class="ml-10 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ $t('phrase.2.course') }}</p>
    <div>
        <div class="mb-4 mt-10">
            <input v-model="searchTerm" type="text" :placeholder="$t('Search')"
                class="ml-10 px-4 py-2 border rounded-lg w-100 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
        </div>
        <div v-if="courses.length" class=" ml-10 mr-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div v-for="(course) in filteredCourses" :key="course.id" class="rounded-lg shadow-lg overflow-hidden hover:bg-gray-200 cursor-pointer" @click="viewCourseRescources(course.id)">                <div class="bg-gradient-to-br from-orange-400 to-orange-300 text-center py-3">
                    <h3 class="text-2xl font-bold text-white">{{ course.name }}</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700 dark:text-gray-400 text-base">{{ course.description }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center my-4">
        <span v-if="pageCount <= maxPagesToShow">
            <button v-for="(page, index) in pageCount" :key="index" :class="{ 'bg-gray-400': currentPage === index }"
                @click="currentPage = index" class="border-2 px-4 py-2">
                {{ page }}
            </button>
        </span>
        <span v-else>
            <button v-for="(page, index) in maxPagesToShow" :key="index"
                :class="{ 'bg-gray-400': currentPage === firstPageIndex + index }"
                @click="currentPage = firstPageIndex + index" class="border-2 px-4 py-2">
                {{ firstPageIndex + index + 1 }}
            </button>
            <span v-if="firstPageIndex + maxPagesToShow < pageCount">
                ...
                <button :class="{ 'bg-gray-400': currentPage === pageCount - 1 }" @click="currentPage = pageCount - 1"
                    class="border-2 px-4 py-2">
                    {{ pageCount }}
                </button>
            </span>
        </span>
    </div>
</template>
  


<script>
import axios from 'axios';


export default {
    data() {
        return {
            courses: [],
            perPage: 9,
            currentPage: 0,
            maxPagesToShow: 5,
            searchTerm: '',

        }
    },
    async created() {
        const response = await axios.get('/course/client_data')
        this.courses = response.data
    },
    computed: {
        pageCount() {
            return Math.ceil(this.courses.length / this.perPage)
        },
        displayedCourses() {
            const start = this.currentPage * this.perPage
            const end = start + this.perPage
            return this.courses.slice(start, end)
        },
        firstPageIndex() {
            if (this.currentPage <= Math.floor(this.maxPagesToShow / 2)) {
                return 0
            } else if (this.currentPage >= this.pageCount - Math.floor(this.maxPagesToShow / 2)) {
                return this.pageCount - this.maxPagesToShow
            } else {
                return this.currentPage - Math.floor(this.maxPagesToShow / 2)
            }
        },
        filteredCourses() {
            if (!this.searchTerm) {
                const start = this.currentPage * this.perPage
                const end = start + this.perPage
                return this.courses.slice(start, end)
            } else {
                const start = this.currentPage * this.perPage
                const end = start + this.perPage
                const searchTermLower = this.searchTerm.toLowerCase();
                return this.courses.filter(course => {
                    return course.name.toLowerCase().includes(searchTermLower);
                });
            }
        }
    },
    watch: {
        searchTerm: function () {
            this.$forceUpdate();
        }
    },
    methods: {
        viewCourseRescources(id) {
            window.location.href = `/course/${id}/client/rescources`;

        }

    },
}


</script>

