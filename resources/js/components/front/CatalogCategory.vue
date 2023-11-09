<template>
    <div class="category">
        <div class="row">
            <div class="col-12 col-lg-3">
                <CategoryFilter :category="category.id" :filterParams="filter" />

                <button @click="loadProducts()" class="btn btn-standard w-100 btn-cat-filter">Применить фильтр</button>
            </div>
            <div class="col-12 col-lg-9">
                <select v-model="filter.order_direction" @change="loadProducts()" class="form-select">
                    <option value="asc">По возрастанию цены</option>
                    <option value="desc">По убыванию цены</option>
                </select>

                <Loader v-if="views.loading" />

                <div v-if="!views.loading" class="row">
                    <div v-if="!views.filterIsActivated" v-for="product in products" class="col-12 col-lg-4 mb-4">
                        <a :href="'/product/' + product.slug" class="category-product-item">
                            <swiper
                                :slides-per-view="1"
                                :space-between="50"
                                @swiper="onSwiper"
                                class="category-product-item-images"
                            >
                                <swiper-slide v-for="(sku, index) in product.skus">
                                    <template v-if="product.category_id == 1 && sku.image">
                                        <img :src="sku.image" alt="">
                                    </template>
                                    <template v-else-if="product.category_id == 2 && sku.image">
                                        <img :src="product.vkhod_image" alt="" class="double">
                                        <img :src="sku.image" alt="" class="double">
                                    </template>
                                    <template v-else-if="product.category_id == 3 && sku.image">
                                        <img :src="sku.image" alt="">
                                    </template>
                                    <template v-else>
                                        <img src="/img/no-image2.jpg" alt="">
                                    </template>
                                </swiper-slide>
                            </swiper>

                            <span>{{ product.price }}</span>

                            <strong>{{ product.name }}</strong>
                            <!-- <ul>
                                <li v-for="sku in product.skus">
                                    {{ sku.id }}
                                </li>
                            </ul> -->
                        </a>
                    </div>

                    <template v-if="views.filterIsActivated" v-for="product in products">
                        <div v-for="sku in product.skus" class="col-12 col-lg-4 mb-4">
                            <a :href="productLink(product, sku)" class="category-product-item">
                                <swiper
                                    :slides-per-view="1"
                                    :space-between="50"
                                    @swiper="onSwiper"
                                    class="category-product-item-images"
                                >
                                    <swiper-slide>
                                        <img v-if="sku.image" :src="sku.image" alt="">
                                        <img v-else src="/img/no-image2.jpg" alt="">
                                    </swiper-slide>
                                </swiper>

                                <span>
                                    <template v-if="sku.price">{{ sku.price }}</template>
                                    <template v-else>{{ product.price }}</template>
                                </span>

                                <strong>{{ product.name }}</strong>
                            </a>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryFilter from './CategoryFilter'
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';

import Loader from './Loader'

export default {
    props: ['category', 'types', 'surfaces', 'colors', 'glasses', 'price_from', 'price_to', 'order', 'order_direction', 'furnituretypes', 'purposes', 'innerdecors'],
    data() {
        return {
            products: [],

            filter: {
                price_from: 0,
                price_to: 100000,
                order: 'price',
                order_direction: 'asc',
                types: [],
                surfaces: [],
                colors: [],
                glasses: [],
                innerdecors: [],
                purposes: [],
                furnituretypes: [],
            },

            views: {
                loading: true,
                filterIsActivated: false,
            }
        }
    },
    created() {
        if(this.price_from) {
            this.filter.price_from = this.price_from
        }
        if(this.price_to) {
            this.filter.price_to = this.price_to
        }
        // if(this.order) {
        //     this.filter.order = this.order
        // }
        if(this.order_direction) {
            this.filter.order_direction = this.order_direction
        }
        if(this.types) {
            this.types.split(',').forEach(type => {
                this.filter.types.push(type)
            })
        }
        if(this.surfaces) {
            this.surfaces.split(',').forEach(surface => {
                this.filter.surfaces.push(surface)
            })
        }
        if(this.purposes) {
            this.purposes.split(',').forEach(purpose => {
                this.filter.purposes.push(purpose)
            })
        }
        if(this.furnituretypes) {
            this.furnituretypes.split(',').forEach(furnituretype => {
                this.filter.furnituretypes.push(furnituretype)
            })
        }
        if(this.colors) {
            this.colors.split(',').forEach(color => {
                this.filter.colors.push(color)
            })
        }
        if(this.glasses) {
            this.glasses.split(',').forEach(glass => {
                this.filter.glasses.push(glass)
            })
        }
        if(this.innerdecors) {
            this.innerdecors.split(',').forEach(innerdecor => {
                this.filter.innerdecors.push(innerdecor)
            })
        }

        this.loadProducts(this.category.id)
    },
    mounted() {
        document.getElementsByClassName('category')[0].remove()
    },
    methods: {
        loadProducts(category) {
            if(this.filter.types.length || this.filter.colors.length || this.filter.glasses.length || this.filter.surfaces.length || this.filter.innerdecors.length || this.filter.purposes.length || this.filter.furnituretypes.length || this.filter.price_from || this.filter.price_to) {
                this.views.filterIsActivated = true

                history.pushState(null, this.category.name, '/catalog/' + this.category.slug + '?' + this.urlPart('types') + this.urlPart('surfaces') + this.urlPart('colors') + this.urlPart('glasses') + this.urlPart('innerdecors') + this.urlPart('purposes') + this.urlPart('furnituretypes') + this.urlPart('price_from') + this.urlPart('price_to') + this.urlPart('order') + this.urlPart('order_direction'))
            } else {
                this.views.filterIsActivated = false
            }

            this.views.loading = true
            
            axios.get(`/_catalog/${this.category.id}`, { params: this.filter })
            .then(response => {
                this.products = response.data.products

                window.scrollTo(0, 0)

                this.views.loading = false
            })
        },
        urlPart(slug) {
            let url

            if(slug == 'price_from') {
                return url = '&' + slug + '=' + this.filter.price_from
            }
            if(slug == 'price_to') {
                return url = '&' + slug + '=' + this.filter.price_to
            }
            if(slug == 'order') {
                return url = '&' + slug + '=' + this.filter.order
            }
            if(slug == 'order_direction') {
                return url = '&' + slug + '=' + this.filter.order_direction
            }

            url = []

            if(this.filter[slug].length) {
                this.filter[slug].forEach(el => {
                    url.push(el)
                })
                
                return url = '&' + slug + '=' + url.join()
            }

            return ''
        },
        productLink(product, sku) {
            let color = ''
            if(sku && sku.color) {
                color = '&color=' + sku.color.slug
            }

            let glass = ''
            if(sku && sku.glass) {
                glass = '&glass=' + sku.glass.slug
            }

            let innerdecor = ''
            if(sku && sku.innerdecor) {
                innerdecor = '&innerdecor=' + sku.innerdecor.slug
            }

            return '/product/' + product.slug + '?' + color + glass + innerdecor
        },
        onSwiper(swiper) {
            this.swiper = swiper
        },
    },
    components: {
        CategoryFilter,
        Swiper,
        SwiperSlide,
        Loader
    },
}
</script>
