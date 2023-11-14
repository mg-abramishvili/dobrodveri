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
</template>

<script>
    export default {
        props: ['product', 'color', 'glass', 'innerdecor'],
        data() {
            return {
                selected: {
                    color: '',
                    glass: '',
                }
            }
        },
        mounted() {
            this.selectColor()
            this.selectGlass()
        },
        watch: {
            selected: {
                deep: true,
                handler() {
                    let selectedSKU

                    if(this.selected.color && this.selected.glass) {
                        selectedSKU = this.product.skus.find((sku) => sku.color_id == this.selected.color.id && sku.glass_id == this.selected.glass.id)
                        
                        return this.emitSKU(selectedSKU)
                    }

                    if(this.selected.color) {
                        selectedSKU = this.product.skus.find((sku) => sku.color_id == this.selected.color.id)
                        
                        return this.emitSKU(selectedSKU)
                    }
                }
            }
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
            emitSKU(selectedSKU) {
                this.emitter.emit('product-sku-index', this.product.skus.indexOf(selectedSKU))
            }
        }
    }
</script>