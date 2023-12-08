<template>
    <div v-if="product.colors.length" class="product-colors">
        <p>Цвет</p>
        <ul class="product-colors-list">
            <li v-for="color in product.colors">
                <button @click="selectColor(color)" class="product-color-button" :class="{'product-color-button_active': selected.color.id == color.id}" :style="{'background-image': 'url(' + color.image + ')'}"></button>
            </li>
        </ul>
    </div>

    <div v-if="product.glasses.length" class="product-glasses">
        <p>Остекление</p>
        <ul class="product-glasses-list">
            <li v-for="glass in product.glasses">
                <button @click="selectGlass(glass)" class="product-glass-button" :class="{'product-glass-button_active': selected.glass.id == glass.id}" :style="{'background-image': 'url(' + glass.image + ')'}"></button>
            </li>
        </ul>
    </div>

    <div v-if="product.inner_decors.length" class="product-innerdecors">
        <p>Внутренняя отделка</p>
        <ul class="product-innerdecors-list">
            <li v-for="inner_decor in product.inner_decors">
                <button @click="selectInnerDecor(inner_decor)" class="product-innerdecor-button" :class="{'product-innerdecor-button_active': selected.inner_decor.id == inner_decor.id}">
                    {{ inner_decor.name }}
                </button>
            </li>
        </ul>
    </div>

    <div v-if="product.sizes.length" class="product-sizes">
        <p>Размер</p>
        <ul class="product-sizes-list">
            <li v-for="size in product.sizes">
                <button @click="selectSize(size)" class="product-size-button" :class="{'product-size-button_active': selected.size.id == size.id}">
                    {{ size.name }}
                </button>
            </li>
        </ul>
    </div>

    <div class="product-price">
        <del v-if="priceOld">{{ $filters.currencyWithoutRubSign(priceOld) }} <i>₽</i></del>
        <br v-if="priceOld"/>
        {{ $filters.currencyWithoutRubSign(price) }} <i>₽</i>
    </div>

    <div class="product-order">
        <button onclick="openModal('Order')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            Заказать
        </button>
        <button @click="addToFavorites()" :disabled="!views.addToFavoritesButton">
            <template v-if="views.addToFavoritesButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"></path>
                </svg>
                В избранное
            </template>

            <template v-if="!views.addToFavoritesButton">
                <LoaderSpinner />
            </template>
        </button>

        <div v-if="product.balance" class="product-balance" :class="{'product-balance-green': product.balance == 'В наличии в Уфе'}">
            <template v-if="product.balance != 'В наличии в Уфе'">срок изготовления:<br/></template>

            {{ product.balance }}
        </div>
    </div>

    <div id="modal_Order" class="modal">
        <div class="modal-content">
            <button onclick="closeModal()" class="modal-close">&times;</button>

            <create-lead v-if="selectedSKU && selected.size" subject="Заказ" :product="product" :size="selected.size.name" :sku="selectedSKU" />
        </div>
    </div>
</template>

<script>
import LoaderSpinner from './LoaderSpinner.vue'

export default {
    props: ['product', 'size', 'color', 'glass', 'inner_decor'],
    data() {
        return {
            selected: {
                color: '',
                glass: '',
                inner_decor: '',
                size: '',
            },
            
            selectedSKU: '',

            views: {
                addToFavoritesButton: true,
            }
        }
    },
    mounted() {
        this.selectColor()
        this.selectGlass()
        this.selectInnerDecor()
        this.selectSize()

        if(this.color && this.product.colors.length) {
            this.selectColor(this.product.colors.find(c => c.slug == this.color))
        }

        if(this.glass && this.product.glasses.length) {
            this.selectGlass(this.product.glasses.find(g => g.slug == this.glass))
        }

        if(this.inner_decor && this.product.inner_decors.length) {
            this.selectInnerDecor(this.product.inner_decors.find(i => i.slug == this.inner_decor))
        }

        if(this.size && this.product.sizes.length) {
            this.selectSize(this.product.sizes.find(s => s.slug == this.size))
        }
    },
    watch: {
        selected: {
            deep: true,
            handler() {
                let selectedSKU

                if(this.selected.color && this.selected.glass) {
                    selectedSKU = this.product.skus.find((sku) => sku.color_id == this.selected.color.id && sku.glass_id == this.selected.glass.id)
                    
                    this.selectedSKU = selectedSKU
                    
                    return this.emitSKU(selectedSKU)
                }

                if(this.selected.color && this.selected.inner_decor) {
                    selectedSKU = this.product.skus.find((sku) => sku.color_id == this.selected.color.id && sku.inner_decor_id == this.selected.inner_decor.id)
                    
                    this.selectedSKU = selectedSKU
                    
                    return this.emitSKU(selectedSKU)
                }

                if(this.selected.color) {
                    selectedSKU = this.product.skus.find((sku) => sku.color_id == this.selected.color.id)
                    
                    this.selectedSKU = selectedSKU
                    
                    return this.emitSKU(selectedSKU)
                }
            }
        }
    },
    computed: {
        price() {
            if(this.selectedSKU && this.selectedSKU.price > 0) {
                return this.selectedSKU.price
            } else {
                return this.product.price
            }
        },
        priceOld() {
            if(this.selectedSKU && this.selectedSKU.old_price > 0) {
                return this.selectedSKU.old_price
            } else {
                return this.product.old_price ? this.product.old_price : null
            }
        },
    },
    methods: {
        selectColor(color) {
            if(!this.product.colors.length) {
                return
            }

            if(color) {
                this.selected.color = color
            } else {
                this.selected.color = this.product.colors[0] ? this.product.colors[0] : null
            }
        },
        selectGlass(glass) {
            if(!this.product.glasses.length) {
                return
            }

            if(glass) {
                this.selected.glass = glass
            } else {
                this.selected.glass = this.product.glasses[0] ? this.product.glasses[0] : null
            }
        },
        selectInnerDecor(inner_decor) {
            if(!this.product.inner_decors.length) {
                return
            }

            if(inner_decor) {
                this.selected.inner_decor = inner_decor
            } else {
                this.selected.inner_decor = this.product.inner_decors[0] ? this.product.inner_decors[0] : null
            }
        },
        selectSize(size) {
            if(!this.product.sizes.length) {
                return
            }

            if(size) {
                this.selected.size = size
            } else {
                this.selected.size = this.product.sizes[0] ? this.product.sizes[0] : null
            }
        },
        emitSKU(selectedSKU) {
            this.emitter.emit('product-sku-index', this.product.skus.indexOf(selectedSKU))
        },
        addToFavorites() {
            if(!this.selectedSKU) {
                return
            }

            this.views.addToFavoritesButton = false

            axios.post('/_favorites', { id: this.selectedSKU.id })
            .then(response => {
                this.emitter.emit('favorite-count', 'New Favorite Item Added!')

                setTimeout(() => {
                    this.views.addToFavoritesButton = true
                }, 1000)
            })
        },
    },
    components: {
        LoaderSpinner
    }
}
</script>