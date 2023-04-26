<template>
  <div class="mx-auto max-w-7xl my-auto pb-10">
    <h1 class="ml-7 mb-4 mt-8 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl text-left">
      <span class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('Select') }}</span>
      {{ $t('a') }} {{ $t('course') }}
    </h1>
    <p class="ml-7 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400 mb-5">{{ $t('phrase.selectCourses') }}
    </p>
    <div class="mb-4">
      <input v-model="searchTerm" type="text" :placeholder="$t('Search')"
        class="ml-7 mr-7 px-4 py-2 border rounded-lg w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
    </div>

    <div class="ml-7 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="course in filteredCourses"
        class="p-4 bg-gradient-to-r to-orange-500 from-orange-300 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 cursor-pointer"
        :key="course.id" @click="viewCourseActivities(course.id)">
        <div class="flex flex-col justify-center items-center h-full">
          <p class="text-gray-700 dark:text-gray-400 font-bold">{{ course.name }}</p>
          <div class="h-1 w-full rounded-full mt-4" :class="course.color"></div>
        </div>
      </div>
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
    fetch(`/CursosCalificar-datos`)
      .then(response => response.json())
      .then(data => {
        this.courses = data;
      })
  },
  computed: {
    filteredCourses() {
      const searchTermLower = this.searchTerm.toLowerCase();
      return this.courses.filter(course => {
        return course.name.toLowerCase().includes(searchTermLower);
      });
    }
  },
  methods: {
    viewCourseActivities(id) {
      window.location.href = `/CursosCalificar/${id}/activities`;
    }
  },
}
</script>
