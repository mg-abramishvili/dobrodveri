<template>
    <div class="product-list-item-inner">
        <a :href="sku.link">
            <div class="products-list-item-image">
                <img :src="sku.image ? sku.image : '/img/no-image.jpg'" :alt="sku.name">
            </div>
    
            <div class="products-list-item-price">
                {{$filters.currencyWithoutRubSign(sku.price)}} <small>₽</small>
                
                <div v-if="sku.old_price" class="products-list-item-price-old">
                    {{ $filters.currencyWithoutRubSign(sku.old_price) }} <small>₽</small>
                </div>
            </div>
    
            <div class="products-list-item-name">
                {{ sku.name }}
            </div>
            
            <div v-if="sku.percent" class="products-list-item-percent">
                {{ sku.percent }}
            </div>

            <div v-if="sku.balance" class="products-list-item-balance">
                <svg v-if="sku.balance == 'В наличии в Уфе'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                </svg>

                {{ sku.balance }}
            </div>

            <div class="products-list-item-credit">
                Рассрочка 0%
            </div>
    
            <div class="products-list-item-tags">
                <div v-if="sku.hit" class="products-list-item-tag products-list-item-tag-hit">Хит</div>
                <div v-if="sku.special" class="products-list-item-tag products-list-item-tag-special">Акция</div>
            </div>
            
            <div v-if="sku.colors && sku.colors.length" class="products-list-item-colors">
                <ul>
                    <li v-for="color in sku.colors">
                        <img :src="color.image" :alt="color.name" />
                    </li>
                </ul>

                <span v-if="sku.other_colors && sku.other_colors.length" class="products-list-item-colors-more">
                    +{{ sku.other_colors.length }}
                </span>
            </div>
        </a>
    
        <div class="products-list-item-buttons">
            <a href="tel:+79378504040">Заказать</a>
            <a :href="sku.link">Подробнее</a>
        </div>

        <div class="products-list-item-heart">
            <AddToFavorites :sku_id="sku.id" />
        </div>
    </div>
</template>

<script>
import AddToFavorites from '../AddToFavorites.vue'

export default {
    props: ['sku'],
    components: {
        AddToFavorites
    },
}
</script>