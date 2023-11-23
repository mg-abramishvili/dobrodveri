<template>
    <aside class="category-filter">
        <ProductFilter :category="category.id" :types="types" :styles="styles" :surfaces="surfaces" :colors="colors" :filterParams="filterParams" />

        <div v-if="!views.loading" class="category-filter-buttons">
            <button @click="loadProductSKUs()" class="category-filter-button">Применить фильтр</button>
            <button @click="resetFilter()" class="category-filter-button">Сбросить фильтр</button>
        </div>
    </aside>

    <div class="category-products" :class="{ 'overlay': views.loading }">
        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="category-products-list">
            <div v-for="sku in productSKUs" class="products-list-item">
                <a :href="'/product/' + sku.slug">
                    <div v-if="sku.image" class="products-list-item-image">
                        <img :src="sku.image" :alt="sku.name">
                    </div>

                    <div class="products-list-item-price">
                        {{ $filters.currencyWithoutRubSign(sku.price) }} <small>₽</small>
                    </div>

                    <p class="products-list-item-name">
                        {{ sku.name }}
                    </p>
                </a>
            </div>
        </div>

        <div class="pagination">
            <button @click="prevPage()" :disabled="!views.pagination.prevPage">Предыдущая страница</button>
            <button>{{ views.pagination.currentPage }}</button>
            <button @click="nextPage()" :disabled="!views.pagination.nextPage">Следующая страница</button>
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
            productSKUs: [],

            types: [],
            styles: [],
            surfaces: [],
            colors: [],

            filterParams: {},

            page: 1,

            
            views: {
                loading: true,
                pagination: {
                    prevPage: null,
                    nextPage: null,
                    currentPage: 1,
                    totalPages: null,
                },
            }
        }
    },
    created() {
        this.resetFilter()
    },
    methods: {
        loadProductSKUs() {
            this.views.loading = true
            
            axios.get(`/_product_skus`, {
                params: {
                    category_id: this.filterParams.category_id,
                    colors: this.filterParams.colors,
                    types: this.filterParams.types,
                    styles: this.filterParams.styles,
                    surfaces: this.filterParams.surfaces,
                    page: this.page,
                }
            })
            .then(response => {
                this.colors = response.data.colors
                this.types = response.data.types
                this.styles = response.data.styles
                this.surfaces = response.data.surfaces

                this.views.pagination.totalPages = response.data.pagination.total_pages
                this.views.pagination.currentPage = response.data.pagination.current_page
                this.views.pagination.prevPage = this.views.pagination.currentPage > 1 ? this.views.pagination.currentPage - 1 : null
                this.views.pagination.nextPage = this.views.pagination.currentPage < this.views.pagination.totalPages ? this.views.pagination.currentPage + 1 : null

                this.productSKUs = response.data.skus

                // window.scrollTo(0, 0)
                
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
            this.filterParams.colors = []

            this.page = 1

            this.loadProductSKUs()
        },
        prevPage() {
            this.page = this.views.pagination.prevPage

            this.loadProductSKUs()
        },
        nextPage() {
            this.page = this.views.pagination.nextPage

            this.loadProductSKUs()
        },
    },
    components: {
        ProductFilter,
        Loader
    },
}
</script>
