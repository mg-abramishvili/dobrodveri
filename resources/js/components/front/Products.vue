<template>
    <aside class="category-filter">
        <ProductFilter :category="category.id" :types="types" :styles="styles" :surfaces="surfaces" :filterParams="filterParams" />

        <button @click="loadProducts()" class="category-filter-button">Применить фильтр</button>
    </aside>

    <div class="category-products">
        <Loader v-if="views.loading" />

        <div class="category-products-list">
            <div v-for="product in products" class="products-list-item">
                <a :href="'/product/' + product.slug">
                    <div v-if="product.image" class="products-list-item-image">
                        <img :src="product.image" :alt="product.name">
                    </div>

                    <div class="products-list-item-price">
                        {{ product.price }} <small>₽</small>
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

            filterParams: {
                category_id: this.category.id,
                price_from: 0,
                price_to: 100000,
                order: 'price',
                order_direction: 'asc',
                types: [],
                styles: [],
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
            axios.get(`/_products`, {
                params: {
                    category_id: this.filterParams.category_id,
                    types: this.filterParams.types,
                    styles: this.filterParams.styles,
                    surfaces: this.filterParams.surfaces,
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
    },
    components: {
        ProductFilter,
        Loader
    },
}
</script>
