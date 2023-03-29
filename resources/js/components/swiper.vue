<template>
    <swiper-container 
        navigation="true"
        pagination="true" paginationClickable="true"
        loop="true"
        class="w-full h-60">
        
        

        <swiper-slide class="flex align-center justify-center flex-none" v-for="(item, index) in images" :key="index">
            <a :href="getAbsoluteUrl(item)" target="_blank" class="flex align-center justify-center flex-none">
                <img :src="getAbsoluteUrl(item)" alt="image" class="h-full rounded-md object-cover">
            </a>
        </swiper-slide>
                
    </swiper-container>
</template>

<script>
import { register } from 'swiper/element/bundle';
register()
export default {
    props: ['images'],
    data() {
        return {
            
        }
    },
    methods: {
        getAbsoluteUrl(url) {
            // Check if the URL is already an absolute URL
            if (url.startsWith('http://') || url.startsWith('https://')) {
                return url;
            }

            // If the URL is a relative URL, construct an absolute URL from the base URL
            return 'http://localhost/' + url.replace('dispositivo/', '');
        }
        
    }
}
</script>