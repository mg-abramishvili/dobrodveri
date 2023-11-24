<template>
    <aside class="category-filter">
        <ProductFilter :category_id="category.id" :types="types" :styles="styles" :surfaces="surfaces" :colors="colors" :filterParams="filterParams" />

        <div v-if="!views.loading" class="category-filter-buttons">
            <button @click="loadProductSKUs()" class="category-filter-button">Применить фильтр</button>
            <button @click="resetFilter()" class="category-filter-button">Сбросить фильтр</button>
        </div>
    </aside>

    <div class="category-products" :class="{ 'overlay': views.loading }">
        <Loader v-if="views.loading" />

        <div v-if="!views.loading && !productSKUs.length" class="category-products-list">
            <div v-for="product in products" class="products-list-item">
                <a :href="'/product/' + product.slug">
                    <div class="products-list-item-image">
                        <img v-if="product.skus[0].image" :src="product.skus[0].image" :alt="product.name">
                        <img v-else src="/img/no-image.jpg" :alt="product.name">
                    </div>

                    <div class="products-list-item-price">
                        {{ $filters.currencyWithoutRubSign(product.price) }} <small>₽</small>
                    </div>

                    <p class="products-list-item-name">
                        {{ product.name }}
                    </p>
                </a>
            </div>
        </div>

        <div v-if="!views.loading && productSKUs.length" class="category-products-list">
            <div v-for="sku in productSKUs" class="products-list-item">
                <a :href="'/product/' + sku.slug">
                    <div class="products-list-item-image">
                        <img v-if="sku.image" :src="sku.image" :alt="sku.name">
                        <img v-else src="/img/no-image.jpg" :alt="sku.name">
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

        <div v-if="!views.loading && productSKUs.length" class="pagination">
            <button @click="prevPage()" :disabled="!views.pagination.prevPage">&larr;</button>
            <button>{{ views.pagination.currentPage }}</button>
            <button @click="nextPage()" :disabled="!views.pagination.nextPage">&rarr;</button>
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
            product: [],
            productSKUs: [],

            types: [],
            styles: [],
            surfaces: [],
            colors: [],

            filterParams: {},

            initialFilterParams: {
                category_id: this.category.id,
                price_from: 0,
                price_to: 100000,
                order: 'price',
                order_direction: 'asc',
                types: [],
                styles: [],
                surfaces: [],
                colors: [],
            },

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
        this.filterParams = JSON.parse(JSON.stringify(this.initialFilterParams))

        this.loadProducts()
    },
    methods: {
        loadProducts() {
            this.products = this.category.products
            
            this.loadProductSKUs()
        },
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

                if(!this.isFilterApplied()) {
                    this.productSKUs = response.data.skus
                }

                window.scrollTo(0, 0)
                
                this.views.loading = false
            })
        },
        resetFilter() {
            this.filterParams = JSON.parse(JSON.stringify(this.initialFilterParams))

            this.productSKUs = []

            this.types = [],
            this.styles = [],
            this.surfaces = [],
            this.colors = [],

            this.page = 1

            this.loadProducts()
        },
        isFilterApplied() {
            if(JSON.stringify(this.filterParams) === JSON.stringify(this.initialFilterParams)) {
                return true
            }

            return false
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
