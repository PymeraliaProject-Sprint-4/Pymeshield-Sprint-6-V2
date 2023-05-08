<template>
    <div class="mx-auto section-courses">
      <h1 class="ml-10 mt-10 mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
        <span class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('All') }}</span>
      </h1>
      <p class="ml-10 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{ $t('phrase.2.course') }}</p>
      <div class="mb-4 mt-10">
        <input v-model="searchTerm" type="text" :placeholder="$t('Search')"
          class="ml-10 px-4 py-2 border rounded-lg w-100 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
      </div>
      <div v-if="courses.length" class="ml-10 mr-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <div v-for="course in filteredCourses" :key="course.id" class="rounded-lg shadow-lg overflow-hidden cursor-pointer" @click="viewCourseRescources(course.id)">
            <a @click="viewCourseRescources(course.id)" class="block w-full">
              <div class="flip-card">
                <div class="flip-card-inner">
                  <div class="flip-card-front" :style="{ backgroundImage: `url(${getImage(course.id)})`, backgroundSize: 'cover' }">
                    <p class="title">{{ course.name }}</p>
                    <p>{{ course.description }}</p>
                </div>
              </div>
            </div>
          </a>
        </div>
    </div>
    <div v-if="pageCount > 1" class="flex justify-center my-4">
        <span v-if="pageCount <= maxPagesToShow">
          <button v-for="(page, index) in pageCount" :key="index" :class="{ 'bg-gray-400': currentPage === index }" @click="currentPage = index" class="border-2 px-4 py-2">{{ page }}</button>
        </span>
        <span v-else>
          <button v-for="(page, index) in maxPagesToShow" :key="index" :class="{ 'bg-gray-400': currentPage === firstPageIndex + index }" @click="currentPage = firstPageIndex + index" class="border-2 px-4 py-2">{{ firstPageIndex + index + 1 }}</button>
          <span v-if="firstPageIndex + maxPagesToShow < pageCount">...</span>
          <button :class="{ 'bg-gray-400': currentPage === pageCount - 1 }" @click="currentPage = pageCount - 1" class="border-2 px-4 py-2">{{ pageCount }}</button>
        </span>
      </div>
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
                const start = this.currentPage * this.perPage;
                const end = start + this.perPage;
                return this.courses.slice(start, end);
            } else {
                const searchTermLower = this.searchTerm.toLowerCase();
                const filtered = this.courses.filter(course => {
                    return course.name.toLowerCase().includes(searchTermLower);
                });
                const pageCount = Math.ceil(filtered.length / this.perPage);
                this.maxPagesToShow = pageCount < this.maxPagesToShow ? pageCount : this.maxPagesToShow;
                const start = this.currentPage * this.perPage;
                const end = start + this.perPage;
                return filtered.slice(start, end);
            }
        }



    },
    watch: {
        searchTerm: function () {
        if (!this.searchTerm) {
            this.maxPagesToShow = 5;
        }
        this.$forceUpdate();
    }
    },
    methods: {
        viewCourseRescources(id) {
            window.location.href = `/course/${id}/client/rescources`;

        },

        getImage(id) {
  return `/storage/img/imatgescursos/${this.getCourseImage(id)}`
},
getCourseImage(id) {
  return this.courses.find(course => course.id === id).image;
},



    },
}


</script>

