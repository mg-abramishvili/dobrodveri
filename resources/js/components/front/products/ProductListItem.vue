<template>
    <a :href="'/product/' + product.slug">
        <div class="products-list-item-image">
            <img v-if="product.skus[0].image" :src="product.skus[0].image" :alt="product.name">
            <img v-else src="/img/no-image.jpg" :alt="product.name">
        </div>

        <div class="products-list-item-price">
            {{ $filters.currencyWithoutRubSign(price) }} <small>₽</small>
        </div>

        <p class="products-list-item-name">
            {{ product.name }}
        </p>

        <div v-if="product.colors && product.colors.length" class="products-list-item-colors">
            <ul>
                <li v-for="color in product.colors.slice(0,3)">
                    <img :src="color.image" />
                </li>
            </ul>

            <span
                v-if="product.colors.length > product.colors.slice(0,3)"
                class="products-list-item-colors-more">
                    {{ '+' + product.colors.length - product.colors.slice(0,3).length }}
            </span>
        </div>
    </a>
</template>

<script>
export default {
    props: ['product'],
    computed: {
        price() {
            if(this.product.skus && this.product.skus.length) {
                return this.product.skus[0].price ? this.product.skus[0].price : this.product.price
            }

            return this.product.price
        },
    }
}
</script>