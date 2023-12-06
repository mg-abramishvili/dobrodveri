<template>
    <div v-if="!views.loading" class="category-products-list favorites-products-list">
        <div v-if="skus" v-for="sku in skus" class="products-list-item">
            <a :href="sku.link">
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

                <div class="product-list-item-sku-params">
                    <div v-if="sku.color" class="product-list-item-sku-params-i">
                        Цвет:
                        <img :src="sku.color.image ? sku.color.image : '/img/no-image.jpg'" :alt="sku.color.name">
                        {{ sku.color.name }}
                    </div>
                    <div v-if="sku.glass" class="product-list-item-sku-params-i">
                        Цвет стекла:
                        <img :src="sku.glass.image ? sku.glass.image : '/img/no-image.jpg'" :alt="sku.glass.name">
                        {{ sku.glass.name }}
                    </div>
                </div>
            </a>

            <span @click="remove(sku.id)" class="favorite-remove">Удалить</span>
        </div>

        <p v-if="!skus">Товаров в избранном нет.</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                skus: [],

                views: {
                    loading: true,
                }
            }
        },
        created() {
            this.loadFavoritesSkus()
        },
        methods: {
            loadFavoritesSkus() {
                axios.get(`/_favorites`)
                .then(response => {
                    this.skus = response.data
                    
                    this.views.loading = false
                })
            },
            remove(skuID) {
                axios.delete(`/_favorite/${skuID}`)
                .then(response => {
                    this.views.loading = true

                    this.loadFavoritesSkus()
                })
            }
        }
    }
</script>