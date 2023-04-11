<template>
  <div>
    <h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl text-left">
      <span class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">{{ $t('Select') }}</span>
      {{ $t('a') }} {{ $t('course') }}
    </h1>
    <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400 mb-5">{{ $t('phrase.selectCourses') }}</p>

    <div class="mb-4">
      <input v-model="searchTerm" type="text" :placeholder="$t('Search')"
        class="px-4 py-2 border rounded-lg w-full text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div
        class="p-4 bg-gradient-to-r to-orange-500 from-orange-300 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105">
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
    fetch(`/activitiesProva/${this.$route.params.id}/activities-Datos`)
      .then(response => response.json())
      .then(data => {
        this.courseName = data.courseName;
        this.categories = data.categories;
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
  watch: {
    searchTerm: function () {
      this.$forceUpdate();
    }
  }
};
</script>