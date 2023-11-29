<template>
    <aside class="category-filter">
        <ProductFilter
            :category_id="category.id"
            :types="types"
            :styles="styles"
            :surfaces="surfaces" :colors="colors"
            :glasses="glasses"
            :filterParams="filterParams"
        />

        <div v-if="!views.loading" class="category-filter-buttons">
            <button @click="loadProductSKUs()" class="category-filter-button">
                Применить фильтр
            </button>

            <button @click="resetFilter()" class="category-filter-button">
                Сбросить фильтр
            </button>
        </div>
    </aside>

    <div class="category-products" :class="{ 'overlay': views.loading }">
        <Loader v-if="views.loading" />

        <div v-if="!views.loading && !productSKUs.length" class="category-products-list">
            <div v-for="product in products" class="products-list-item">
                <ProductListItem :product="product" />
            </div>
        </div>

        <div v-if="!views.loading && productSKUs.length" class="category-products-list">
            <div v-for="sku in productSKUs" class="products-list-item">
                <SkuListItem :sku="sku" />
            </div>
        </div>

        <!-- <ProductsPagination />

        <SkusPagination /> -->

        <div v-if="!views.loading && productSKUs.length" class="pagination">
            <button @click="prevPage()" :disabled="!views.pagination.prevPage">&larr;</button>
            <button>{{ views.pagination.currentPage }}</button>
            <button @click="nextPage()" :disabled="!views.pagination.nextPage">&rarr;</button>
        </div>
    </div>
</template>

<script>
import ProductFilter from './ProductFilter.vue'
import ProductListItem from './products/ProductListItem.vue'
import SkuListItem from './products/SkuListItem.vue'
import Loader from './Loader.vue'

export default {
    props: [
        'category',
        'category_products',
        'color',
        'glass',
        'type',
        'style',
        'surface',
        'price_from',
        'price_to',
        'order',
        'order_direction',
        'innerdecor',
        'furnituretype',
        'purpose',
    ],
    data() {
        return {
            product: [],
            productSKUs: [],

            types: [],
            styles: [],
            surfaces: [],
            colors: [],
            glasses: [],

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
                glasses: [],
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
        
        if(this.price_from) {
            this.filterParams.price_from = this.price_from
        }
        if(this.price_to) {
            this.filterParams.price_to = this.price_to
        }

        if(this.color && this.color.split(',').length) {
            this.color.split(',').forEach(c => {
                this.filterParams.colors.push(c)
            })
        }

        if(this.glass && this.glass.split(',').length) {
            this.glass.split(',').forEach(c => {
                this.filterParams.glasses.push(c)
            })
        }

        this.loadProducts()
    },
    methods: {
        loadProducts(page) {
            if(!page) { page = 1 }

            axios.get(`/_products?page=${page}`)
            .then(response => {
                this.products = response.data.data

                this.loadProductSKUs()
            })
        },
        loadProductSKUs() {
            this.views.loading = true

            axios.get(`/_product_skus`, {
                params: {
                    category_id: this.filterParams.category_id,
                    colors: this.filterParams.colors,
                    glasses: this.filterParams.glasses,
                    types: this.filterParams.types,
                    styles: this.filterParams.styles,
                    surfaces: this.filterParams.surfaces,
                    page: this.page,
                }
            })
            .then(response => {
                this.colors = response.data.colors
                this.glasses = response.data.glasses
                this.types = response.data.types
                this.styles = response.data.styles
                this.surfaces = response.data.surfaces

                this.views.pagination.totalPages = response.data.pagination.total_pages
                this.views.pagination.currentPage = response.data.pagination.current_page
                this.views.pagination.prevPage = this.views.pagination.currentPage > 1 ? this.views.pagination.currentPage - 1 : null
                this.views.pagination.nextPage = this.views.pagination.currentPage < this.views.pagination.totalPages ? this.views.pagination.currentPage + 1 : null

                if(!this.isFilterApplied()) {
                    this.productSKUs = response.data.skus

                    this.genURL()
                }

                window.scrollTo(0, 0)
                
                this.views.loading = false
            })
        },
        resetFilter() {
            this.views.loading = true

            window.location.href = '/catalog/' + this.category.slug + '/'
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
        genURL() {
            let filterParamsURL = []

            if(this.filterParams.price_from.length) {
                filterParamsURL.push('&price_from=' + this.filterParams.price_from)
            }

            if(this.filterParams.price_to.length) {
                filterParamsURL.push('&price_to=' + this.filterParams.price_to)
            }

            if(this.filterParams.types.length) {
                filterParamsURL.push('&type=' + this.filterParams.types.join(','))
            }

            if(this.filterParams.styles.length) {
                filterParamsURL.push('&style=' + this.filterParams.styles.join(','))
            }

            if(this.filterParams.surfaces.length) {
                filterParamsURL.push('&surface=' + this.filterParams.surfaces.join(','))
            }

            if(this.filterParams.colors.length) {
                filterParamsURL.push('&color=' + this.filterParams.colors.join(','))
            }

            if(this.filterParams.glasses.length) {
                filterParamsURL.push('&glass=' + this.filterParams.glasses.join(','))
            }

            history.pushState(null, null, '?' + filterParamsURL.join(""))
        },
    },
    components: {
        ProductFilter,
        ProductListItem,
        SkuListItem,
        Loader
    },
}
</script>
