<template>
    <swiper v-if="images.length > 0" :spaceBetween="30" :centeredSlides="true" :pagination="clickable = true"
        :navigation="true" :modules="modules">

        <swiper-slide v-for="(item, index) in images" :key="index">
            <a :href="getAbsoluteUrl(item)" target="_blank">
                <img :src="getAbsoluteUrl(item)" alt="image" class="object-contain max-w-96 mx-auto" />
            </a>
        </swiper-slide>

    </swiper>

    <h4 v-else class="font-bold">No hay imagenes disponibles.</h4>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Pagination, Navigation } from 'swiper';
export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    props: ['images'],
    setup() {
        return {
            modules: [Pagination, Navigation],
        };
    },
    methods: {
        getAbsoluteUrl(url) {
            // Check if the URL is already an absolute URL
            if (url.startsWith('http://') || url.startsWith('https://')) {
                return url;
            }

            // If the URL is a relative URL, construct an absolute URL from the base URL
            return url.replace('dispositivo/', '');
        }

    }
}
</script>
