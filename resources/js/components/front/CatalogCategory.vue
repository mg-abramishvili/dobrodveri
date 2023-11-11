<template>
    <aside class="category-filter">
        <CategoryFilter :category="category.id" :filterParams="filterParams" />

        <button @click="loadProducts()" class="category-filter-button">Применить фильтр</button>
    </aside>

    <div class="category-products">
        <Loader v-if="views.loading" />

        <div class="category-products-list">
            <div v-for="product in products" class="products-list-item">
                <a>
                    <p class="products-list-item-name">
                        {{ product.name }}
                    </p>

                    <div class="products-list-item-price">
                        {{ product.price }} <small>₽</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import CategoryFilter from './CategoryFilter.vue'

import Loader from './Loader.vue'

export default {
    props: ['category'],
    data() {
        return {
            products: [],

            filterParams: {
                price_from: 0,
                price_to: 100000,
                order: 'price',
                order_direction: 'asc',
                types: [],
                surfaces: [],
            },

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadProducts()
    },
    methods: {
        loadProducts() {
            axios.get(`/_catalog/${this.category.id}`, { params: this.filterParams })
            .then(response => {
                this.products = response.data.products

                window.scrollTo(0, 0)

                this.views.loading = false
            })
        },
    },
    components: {
        CategoryFilter,
        Loader
    },
}
</script>
