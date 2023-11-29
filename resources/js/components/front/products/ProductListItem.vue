<template>
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
</template>

<script>
export default {
    props: ['product'],   
}
</script>