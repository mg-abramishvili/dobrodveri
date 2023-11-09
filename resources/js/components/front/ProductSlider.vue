<template>
    <div>
        <div class="product-sliders-wrapper">
            <swiper
                :slides-per-view="4"
                :space-between="10"
                direction="vertical"
                @swiper="OnSwiperMini"
                class="product-slider-mini"
            >
                <swiper-slide v-for="(sku, index) in product.skus" @click="selectThumb(index)" :id="'mini-slide' + index">
                    <img v-if="sku.image" :src="sku.image" alt="">
                    <img v-else src="/img/no-image.jpg" alt="">
                </swiper-slide>
                
                <button @click="prevMini()" class="button-prev"></button>
                <button @click="nextMini()" class="button-next"></button>
            </swiper>

            <swiper
                :slides-per-view="1"
                :space-between="50"
                @swiper="OnSwiperBig"
                class="product-slider"
            >
                <swiper-slide v-for="(sku, index) in product.skus">
                    <img v-if="sku.image" :src="sku.image" alt="">
                    <img v-else src="/img/no-image.jpg" alt="">
                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

export default {
    props: ['product'],
    data() {
        return {
            selected: ''
        }
    },
    mounted() {
        this.emitter.on('product-slider', (data) => {
            this.selected = data

            let selectedSku

            if(data.glass) {
                selectedSku = this.product.skus.find(sku => sku.color_id == this.selected.color && sku.glass_id == this.selected.glass)
            } else {
                selectedSku = this.product.skus.find(sku => sku.color_id == this.selected.color)
            }
            
            this.swiperBig.slideTo(this.product.skus.indexOf(selectedSku))
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

            let allMiniSlides = document.querySelectorAll('.product-slider-mini .swiper-slide')

            allMiniSlides.forEach(s => {
                s.classList.remove('actvd')
            })

            document.getElementById('mini-slide' + index).classList.add('actvd')
        },
        prevMini() {
            console.log('prev')
            this.swiperMini.slidePrev()
        },
        nextMini() {
            console.log('next')
            this.swiperMini.slideNext()
        },
    },
    components: {
        Swiper,
        SwiperSlide,
    },
}
</script>