<template>
    <h1 class="mt-10 ml-10 text-3xl font-bold text-gray-900 dark:text-white mb-8">{{ $t('Rescources.Tittles') }} <span
            class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">"{{ courseName }}"
        </span>
    </h1>

    <div class="flex-1 flex-col ml-2">
        <div v-if="!noResources" class="bg-orange-200 rounded-lg p-5 m-2" v-for="category in rescources"
            :key="category.category_id">
            <div class="flex justify-between">
                <h2 class="font-bold text-lg m-2">{{ category.category_name }}</h2>
                <div class="block m-2"></div>
            </div>
            <ul>
                <li class="bg-orange-400 rounded-lg p-5 m-2" v-for="resource in category.resources"
                    :key="resource.resource_text_name">
                    <p class="font-bold ">Recursos de tipus text: </p>{{ resource.resource_text_name ?? 'No existeixen recursos de aquest tipus' }} {{
                        resource.description_rescource_text ?? '-' }}
                </li>

                <li class="bg-orange-400 rounded-lg p-5 m-2" v-for="resource in category.resources"
                    :key="resource.resource_url_name">
                    <p class="font-bold ">Recursos de tipus url: </p>{{ resource.resource_url_name ?? 'No te recursos de tipus url' }} {{ resource.rescource_url_location }}
                </li>

                <li class="bg-orange-400 rounded-lg p-5 m-2" v-for="resource in category.resources"
                    :key="resource.resource_file_name">
                    <p class="font-bold ">Recursos de tipus fitxer: </p> {{ resource.resource_file_name ?? 'No te recursos de tipus fitxer' }} {{ resource.rescource_file_location }}
                </li>

            </ul>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            courseName: "",
            rescources: [],
            noResources: false,
        };
    },
    mounted() {
        const url = new URL(window.location.href);
        const id = url.pathname.split('/')[2];
        fetch(`/course/${id}/client/rescources-datos`)
            .then(response => response.json())
            .then(data => {
                this.courseName = data.course_name;
                this.rescources = data.categories;
                if (this.rescources.length === 0) {
                    this.noResources = true;
                }
            })
    },

    methods: {

    },
}
</script>
