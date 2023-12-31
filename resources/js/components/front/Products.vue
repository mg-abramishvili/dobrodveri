<template>
    <Loader v-if="start && views.loading" />
    
    <template v-if="start && !views.loading">
        <div v-if="productSKUs.length" class="category-products-list">
            <div v-for="sku in productSKUs" class="products-list-item">
                <SkuListItem :sku="sku" />
            </div>
        </div>
    
        <p v-if="!productSKUs.length">По вашему запросу товары не найдены.</p>
    
        <Pagination v-if="pagination.totalPages > 1" :pagination="pagination" />
    </template>
</template>

<script>
import Loader from './Loader.vue'
import SkuListItem from './products/SkuListItem.vue'
import Pagination from './products/Pagination.vue'

export default {
    data() {
        return {
            productSKUs: [],

            filterParams: '',

            order: 'price_asc',

            pagination: {
                currentPage: 1,
                prevPage: null,
                nextPage: null,
                totalPages: null,
            },

            views: {
                loading: true,
            },

            start: false,
        }
    },
    mounted() {
        this.emitter.on('product-filter', (filterParams) => {
            this.removeProductsDOM()

            this.start = true

            this.filterParams = filterParams

            this.order = filterParams.order

            this.loadProductSKUs()
        })
    },
    methods: {
        loadProductSKUs(page) {
            this.views.loading = true

            axios.get(`/_product_skus`, {
                params: {
                    filter_params: this.filterParams,
                    order: this.order,
                    page: page ? page : 1,
                }
            })
            .then(response => {
                this.productSKUs = response.data.skus

                this.setPagination(
                    response.data.pagination.total_pages,
                    response.data.pagination.current_page
                )

                window.scrollTo(0, 0)
                
                this.views.loading = false
            })
        },
        setPagination(totalPages, currentPage) {
            this.pagination.totalPages = totalPages
            this.pagination.currentPage = currentPage
            this.pagination.prevPage = this.pagination.currentPage > 1 ? this.pagination.currentPage - 1 : null
            this.pagination.nextPage = this.pagination.currentPage < this.pagination.totalPages ? this.pagination.currentPage + 1 : null
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
            
            return this.loadProductSKUs(page)
        },
        removeProductsDOM() {
            let productDOM = document.getElementById('category-products-list')

            if(productDOM) {
                productDOM.remove()
            }
        }
    },
    components: {
        Loader,
        SkuListItem,
        Pagination,
    }
}
</script>