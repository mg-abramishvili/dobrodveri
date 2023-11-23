<template>
    <aside class="category-filter">
        <ProductFilter :category="category.id" :types="types" :styles="styles" :surfaces="surfaces" :filterParams="filterParams" />

        <div v-if="!views.loading" class="category-filter-buttons">
            <button @click="loadProducts()" class="category-filter-button">Применить фильтр</button>
            <button @click="resetFilter()" class="category-filter-button">Сбросить фильтр</button>
        </div>
    </aside>

    <div class="category-products" :class="{ 'overlay': views.loading }">
        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="category-products-list">
            <div v-for="product in products" class="products-list-item">
                <a :href="'/product/' + product.slug">
                    <div v-if="product.image" class="products-list-item-image">
                        <img :src="product.image" :alt="product.name">
                    </div>

                    <div class="products-list-item-price">
                        {{ $filters.currencyWithourRubSign(product.price) }} <small>₽</small>
                    </div>

                    <p class="products-list-item-name">
                        {{ product.name }}
                    </p>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import ProductFilter from './ProductFilter.vue'

import Loader from './Loader.vue'

export default {
    props: ['category'],
    data() {
        return {
            products: [],
            types: [],
            styles: [],
            surfaces: [],

            filterParams: {},

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.resetFilter()
    },
    methods: {
        loadProducts() {
            this.views.loading = true
            
            axios.get(`/_products`, {
                params: {
                    category_id: this.filterParams.category_id,
                    types: this.filterParams.types,
                    styles: this.filterParams.styles,
                    surfaces: this.filterParams.surfaces,
                    price_from: this.filterParams.price_from,
                    price_to: this.filterParams.price_to,
                }
            })
            .then(response => {
                this.types = response.data.types
                this.styles = response.data.styles
                this.surfaces = response.data.surfaces

                this.products = response.data.products

                window.scrollTo(0, 0)
                
                this.views.loading = false
            })
        },
        resetFilter() {
            this.filterParams.category_id = this.category.id
            this.filterParams.price_from = 0
            this.filterParams.price_to = 100000
            this.filterParams.order = 'price'
            this.filterParams.order_direction = 'asc'
            this.filterParams.types = []
            this.filterParams.styles = []
            this.filterParams.surfaces = []

            this.loadProducts()
        },
    },
    components: {
        ProductFilter,
        Loader
    },
}
</script>
