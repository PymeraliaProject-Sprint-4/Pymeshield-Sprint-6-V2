<template>
  <div class="mx-auto max-w-7xl my-auto pb-10">
    <h1 class="mb-4 mt-8 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl text-left">
      <span class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('Select') }}</span>
      {{ $t('a') }} {{ $t('course') }}
    </h1>
    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400 mb-5">{{ $t('phrase.selectCourses') }}</p>

    <div class="mb-4">
      <input v-model="searchTerm" type="text" :placeholder="$t('Search')"
        class="px-4 py-2 border rounded-lg w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
<<<<<<< HEAD
        <a v-for="course in filteredCourses" :key="course.id"
        :href="'/CursosCalificar/' + course.id + '/activities'">
        <div
          class="p-4 bg-gradient-to-r to-orange-500 from-orange-300 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105">
          <div class="flex flex-col justify-center items-center h-full">
            <p class="text-gray-700 dark:text-gray-400 font-bold">{{ course.name }}</p>
            <div class="h-1 w-full rounded-full mt-4" :class="course.color"></div>
          </div>
        </div>
    </a>
=======
      <div v-for="course in filteredCourses"
        class="p-4 bg-gradient-to-r to-orange-500 from-orange-300 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 cursor-pointer"
        :key="course.id" @click="viewCourseActivities(course.id)">
        <div class="flex flex-col justify-center items-center h-full">
          <p class="text-gray-700 dark:text-gray-400 font-bold">{{ course.name }}</p>
          <div class="h-1 w-full rounded-full mt-4" :class="course.color"></div>
        </div>
      </div>
>>>>>>> CursosCalificar
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      courses: [],
      searchTerm: '',
    };
  },
  mounted() {
<<<<<<< HEAD
    // Usar la instancia de axios creada en el plugin
    this.$axios.get('/CursosCalificar')
      .then(response => {
        this.courses = response.data;
      })
      .catch(error => {
        console.log(error);
=======
    fetch(`/CursosCalificar-datos`)
      .then(response => response.json())
      .then(data => {
        this.courses = data;
>>>>>>> CursosCalificar
      });
  },
  computed: {
    filteredCourses() {
      if (!this.searchTerm) {
        return this.courses;
      } else {
        const searchTermLower = this.searchTerm.toLowerCase();
        return this.courses.filter(course => {
          return course.name.toLowerCase().includes(searchTermLower);
        });
      }
    }
  },
  methods: {
    viewCourseActivities(id) {
      window.location.href = `/CursosCalificar/${id}/activities`;
      
    }
  },
};
</script>
