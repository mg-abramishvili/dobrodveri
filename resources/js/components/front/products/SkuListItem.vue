<template>
    <a :href="$filters.SkuUrl(sku)">
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
</template>

<script>
export default {
    props: ['sku'],   
}
</script>