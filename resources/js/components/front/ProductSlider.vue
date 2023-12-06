<template>
    <div class="product-detail-sliders-wrapper">
        <swiper
            :slides-per-view="4"
            :space-between="10"
            direction="vertical"
            @swiper="OnSwiperMini"
            class="product-detail-slider-mini"
        >
            <swiper-slide v-for="(sku, index) in product.skus" @click="selectThumb(index)" :id="'mini-slide' + index">
                <img v-if="sku.image" :src="sku.image" alt="">
                <img v-else src="/img/no-image.jpg" alt="">
            </swiper-slide>
            
            <button v-if="product.skus.length > 4" @click="prevMini()" class="button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
                </svg>
            </button>
            <button v-if="product.skus.length > 4" @click="nextMini()" class="button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                </svg>
            </button>
        </swiper>

        <swiper
            :slides-per-view="1"
            :space-between="0"
            @swiper="OnSwiperBig"
            class="product-detail-slider"
            :class="{'product-detail-slider-vkhod': product.category.id == 2}"
        >
            <swiper-slide v-for="(sku, index) in product.skus">
                <img v-if="product.vkhod_image" :src="product.vkhod_image" alt="">

                <img v-if="sku.image" :src="sku.image" alt="">
                <img v-else src="/img/no-image.jpg" alt="">
            </swiper-slide>
        </swiper>
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue'
import 'swiper/css'

export default {
    props: ['product'],
    mounted() {
        this.emitter.on('product-sku-index', (index) => {
            this.swiperBig.slideTo(index)
            
            return this.markSelectedMiniSlideAsActive(index)
        })
    },   
    methods: {
        OnSwiperBig(swiper) {
            this.swiperBig = swiper
        },
        OnSwiperMini(swiper) {
            this.swiperMini = swiper
        },
        selectThumb(index) {
            this.swiperBig.slideTo(index)

            this.markSelectedMiniSlideAsActive(index)
        },
        prevMini() {
            this.swiperMini.slidePrev()
        },
        nextMini() {
            this.swiperMini.slideNext()
        },
        markSelectedMiniSlideAsActive(index) {
            let allMiniSlides = document.querySelectorAll('.product-detail-slider-mini .swiper-slide')

            allMiniSlides.forEach(s => {
                s.classList.remove('actvd')
            })

            document.getElementById('mini-slide' + index).classList.add('actvd')
        }
    },
    components: {
        Swiper,
        SwiperSlide,
    },
}
</script>