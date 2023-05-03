<template>
    <h1 class="mt-10 ml-10 text-3xl font-bold text-gray-900 dark:text-white mb-8">{{ $t('Rescources.Tittles') }} <span
            class="text-transparent bg-clip-text bg-gradient-to-r to-orange-500 from-orange-300">"{{ courseName }}"
        </span>
    </h1>

    <div class="flex-1 flex-col ml-2">
        <div class="bg-orange-200 rounded-lg p-5 m-2" v-for="category in rescources" :key="category.category_id">
            <div class="flex justify-between">
                <h2 class="font-bold text-lg m-2">{{ $t('category-name') }} {{ category.category_name }}</h2>
                <div class="block m-2"></div>
            </div>
            <ul>
                <li class="bg-orange-400 rounded-lg p-5 m-2">
                    <p class="font-bold">{{ $t('text-resources') }}</p>
                    <ul>
                        <li v-for="resource in category.resources.filter(r => r.resource_type === 'text')"
                            :key="resource.resource_name">
                            {{ resource.resource_name}} - {{
                                resource.resource_description ?? '' }}
                        </li>
                    </ul>

                </li>

                <li class="bg-orange-400 rounded-lg p-5 m-2">
                    <p class="font-bold">{{ $t('url-resources') }}</p>
                    <ul>
                        <li v-for="resource in category.resources.filter(r => r.resource_type === 'url')"
                            :key="resource.resource_name">
                            {{ resource.resource_name}} - {{
                                resource.resource_location ?? '' }}
                        </li>
                    </ul>
                </li>

                <li class="bg-orange-400 rounded-lg p-5 m-2">
                    <p class="font-bold">{{ $t('file-resources') }}</p>
                    <ul>
                        <li v-for="resource in category.resources.filter(r => r.resource_type === 'file')"
                            :key="resource.resource_name">
                            {{ resource.resource_name}} - {{
                                resource.resource_location ?? '' }}
                        </li>
                    </ul>
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
            })
    },

    methods: {

    },
}
</script>
