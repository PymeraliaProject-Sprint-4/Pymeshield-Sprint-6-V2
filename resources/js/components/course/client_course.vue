<template>
    <h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl"><span
        class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{$t('All')}}</span></h1>
    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">{{$t('phrase.2.course')}}</p>



    <div class="flex justify-center my-4">
                            <span v-if="pageCount <= maxPagesToShow">
                              <button v-for="(page, index) in pageCount"
                                      :key="index"
                                      :class="{ 'bg-gray-400': currentPage === index }"
                                      @click="currentPage = index"
                                      class="border-2 px-4 py-2">
                                {{ page }}
                              </button>
                            </span>
        <span v-else>
                              <button v-for="(page, index) in maxPagesToShow"
                                      :key="index"
                                      :class="{ 'bg-gray-400': currentPage === firstPageIndex + index }"
                                      @click="currentPage = firstPageIndex + index"
                                      class="border-2 px-4 py-2">
                                {{ firstPageIndex + index + 1 }}
                              </button>
                              <span v-if="firstPageIndex + maxPagesToShow < pageCount">
                                ...
                                <button :class="{ 'bg-gray-400': currentPage === pageCount - 1 }"
                                        @click="currentPage = pageCount - 1"
                                        class="border-2 px-4 py-2">
                                  {{ pageCount }}
                                </button>
                              </span>
                        </span>
    </div>

    <div>
        <div class="mb-4 ">
            <input v-model="searchTerm" type="text" :placeholder="$t('Search')"
                   class=" px-4 py-2 border rounded-lg w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
        </div>
        <div v-if="courses.length" class="card-container">
            <div v-for="(course, index) in filteredCourses" :key="course.id" class="card1">
                <!-- Aquí s'haurà de posar les activitats d'un determinar curs -->
                <a :href="'/recursos/'">
                    <div class="flip-card">
                        <div class="flip-card-inner">
                            <div class="flip-card-front">
                                <p class="title">{{ course.name }}</p>
                                <p style="margin-top: 100px; margin-left: 30px; margin-right: 30px">
                                    {{ course.description }} </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <p v-else>No hi han dades disponibles.</p>
    </div>

    <div class="flex justify-center my-4">
                            <span v-if="pageCount <= maxPagesToShow">
                              <button v-for="(page, index) in pageCount"
                                      :key="index"
                                      :class="{ 'bg-gray-400': currentPage === index }"
                                      @click="currentPage = index"
                                      class="border-2 px-4 py-2">
                                {{ page }}
                              </button>
                            </span>
        <span v-else>
                              <button v-for="(page, index) in maxPagesToShow"
                                      :key="index"
                                      :class="{ 'bg-gray-400': currentPage === firstPageIndex + index }"
                                      @click="currentPage = firstPageIndex + index"
                                      class="border-2 px-4 py-2">
                                {{ firstPageIndex + index + 1 }}
                              </button>
                              <span v-if="firstPageIndex + maxPagesToShow < pageCount">
                                ...
                                <button :class="{ 'bg-gray-400': currentPage === pageCount - 1 }"
                                        @click="currentPage = pageCount - 1"
                                        class="border-2 px-4 py-2">
                                  {{ pageCount }}
                                </button>
                              </span>
                        </span>
    </div>
</template>

<script>
import axios from 'axios';
import {ref} from 'vue';


export default {
    data() {
        return {
            courses: [],
            perPage: 9,
            currentPage: 0,
            selectedCourse: null,
            name: '',
            description: '',
            id: '',
            sending: false,
            modal_crear: false,
            modal_edit: false,
            maxPagesToShow: 5,
            searchTerm: '',

        }
    },
    async created() {
        const response = await axios.get('/course/index_data')
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
        selectCourse(course) {
            this.modal_edit = true;
            this.selectedCourse = course;
            this.id = course.id;
            this.name_edit = course.name;
            this.description_edit = course.description;
        },
    },
}


</script>

