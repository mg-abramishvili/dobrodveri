<template>
    <h1 class="title-header">{{ category.name }}</h1>

    <div class="overlay" v-if="views.loading">
        <Loader />
    </div>

    <aside class="category-filter">
        <ProductFilter
            :category_id="category.id"
            :types="types"
            :styles="styles"
            :surfaces="surfaces" :colors="colors"
            :glasses="glasses"
            :filterParams="filterParams"
        />

        <!-- <div class="category-filter-buttons">
            <button @click="loadProductSKUs()" class="category-filter-button">
                Применить фильтр
            </button>

            <button @click="resetFilter()" class="category-filter-button">
                Сбросить фильтр
            </button>
        </div> -->
    </aside>

    <div v-if="!views.loading" class="category-products">
        <!-- <AppliedFiltersRemover v-if="views.aplliedFiltersRemover" :filterParams="filterParams" /> -->

        <div v-if="products.length && !productSKUs.length" class="category-products-list">
            <div v-for="product in products" class="products-list-item">
                <ProductListItem :product="product" />
            </div>
        </div>

        <div v-if="productSKUs.length && !products.length" class="category-products-list">
            <div v-for="sku in productSKUs" class="products-list-item">
                <SkuListItem :sku="sku" />
            </div>
        </div>

        <p v-if="!productSKUs.length && !products.length">
            По вашему запросу товары не найдены.
        </p>

        <Pagination v-if="pagination.totalPages > 1" :pagination="pagination" />
    </div>
</template>

<script>
import Loader from './Loader.vue'
import ProductFilter from './ProductFilter.vue'
import ProductListItem from './products/ProductListItem.vue'
import SkuListItem from './products/SkuListItem.vue'
import AppliedFiltersRemover from './products/AppliedFiltersRemover.vue'
import Pagination from './products/Pagination.vue'

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

            pagination: {
                currentPage: 1,
                prevPage: null,
                nextPage: null,
                totalPages: null,
            },
            
            views: {
                loading: true,
                aplliedFiltersRemover: false,
            }
        }
    },
    created() {
        this.filterParams = JSON.parse(JSON.stringify(this.initialFilterParams))
        
        this.loadRequestedFilterParams()
    },
    methods: {
        loadRequestedFilterParams() {
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
        loadProducts(page) {
            // window.scrollTo(0, 0)
            
            this.views.loading = true
            
            axios.get(`/_products`, {
                params: {
                    category_id: this.filterParams.category_id,
                    page: page ? page : 1,
                }
            })
            .then(response => {
                this.products = response.data.data

                this.setPagination(
                    response.data.last_page,
                    response.data.current_page
                )

                this.loadProductSKUs()
            })
        },
        loadProductSKUs(page) {
            // window.scrollTo(0, 0)
            
            this.views.loading = true

            axios.get(`/_product_skus`, {
                params: {
                    category_id: this.filterParams.category_id,
                    colors: this.filterParams.colors,
                    glasses: this.filterParams.glasses,
                    types: this.filterParams.types,
                    styles: this.filterParams.styles,
                    surfaces: this.filterParams.surfaces,
                    page: page ? page : 1,
                }
            })
            .then(response => {
                this.colors = response.data.colors
                this.glasses = response.data.glasses
                this.types = response.data.types
                this.styles = response.data.styles
                this.surfaces = response.data.surfaces
                
                if(!this.isFilterApplied()) {
                    this.products = []
                    this.productSKUs = response.data.skus

                    this.setPagination(
                        response.data.pagination.total_pages,
                        response.data.pagination.current_page
                    )

                    this.genURL()

                    this.views.aplliedFiltersRemover = true
                }
                
                this.views.loading = false
            })
        },
        resetFilter() {
            window.location.href = '/catalog/' + this.category.slug + '/'
        },
        setPagination(totalPages, currentPage) {
            this.pagination.totalPages = totalPages
            this.pagination.currentPage = currentPage
            this.pagination.prevPage = this.pagination.currentPage > 1 ? this.pagination.currentPage - 1 : null
            this.pagination.nextPage = this.pagination.currentPage < this.pagination.totalPages ? this.pagination.currentPage + 1 : null
        },
        isFilterApplied() {
            if(JSON.stringify(this.filterParams) === JSON.stringify(this.initialFilterParams)) {
                return true
            }

            return false
        },
        prevPage() {
            this.pagination.currentPage = this.pagination.prevPage

            this.goToPage(this.pagination.prevPage)
        },
        nextPage() {
            this.pagination.currentPage = this.pagination.nextPage

            this.goToPage(this.pagination.nextPage)
        },
        goToPage(page) {
            window.scrollTo(0, 0)
            
            if(!this.productSKUs.length) {
                return this.loadProducts(page)
            }

            if(this.productSKUs.length) {
                return this.loadProductSKUs(page)
            }
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
        AppliedFiltersRemover,
        Pagination,
        Loader
    },
}
</script>
