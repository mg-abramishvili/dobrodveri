<template>
    <div class="row align-items-center mb-2">
        <div class="col-12 col-md-12">
            <span class="color_size_label">Цвет:</span>
        </div>
        <div class="col-12 col-md-12">
            <ul class="product-colors-list">
                <li v-for="sku in colors" :key="'color_' + sku.id">
                    <button @click="selectColor(sku.color)" data-bs-toggle="tooltip" data-bs-placement="bottom" :title="sku.color.name" class="product-color-button" :class="{'product-size-button_active': selected.color == sku.color.id}" :style="{'background-image': 'url(' + sku.color.image + ')'}"></button>
                </li>
            </ul>
        </div>
    </div>
    <div v-if="glasses.length" class="row align-items-center mb-2">
        <div class="col-12 col-md-12">
            <span class="color_size_label">Остекление:</span>
        </div>
        <div class="col-12 col-md-12">
            <ul class="product-colors-list">
                <li v-for="(sku, index) in glasses" :key="'glass_' + sku.id">
                    <button @click="selectGlass(sku.glass)" :title="sku.glass.name" class="product-color-button" :class="{'product-size-button_active': selected.glass == sku.glass.id}">
                        {{ index + 1 }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div v-if="innerdecors.length" class="row align-items-center mb-2">
        <div class="col-12 col-md-12">
            <span class="color_size_label">Цвет внутренней отделки:</span>
        </div>
        <div class="col-12 col-md-12">
            <ul class="product-colors-list">
                <li v-for="(sku, index) in innerdecors" :key="'innerdecor_' + sku.id">
                    <button @click="selectInnerDecor(sku.innerdecor)" :title="sku.innerdecor.name" class="product-color-button" :class="{'product-size-button_active': selected.innerdecor == sku.innerdecor.id}">
                        {{ index + 1 }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="row align-items-center mb-2">
        <div class="col-12 col-md-12">
            <span class="color_size_label">Размер:</span>
        </div>
        <div class="col-12 col-md-12">
            <ul class="product-sizes-list">
                <li v-for="size in product.sizes" :key="'size_' + size.id">
                    <button @click="selectSize(size)" class="product-size-button" :class="{'product-size-button_active': selected.size == size.id}">
                        {{ size.name }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="price mt-1 mb-2">
        <del v-if="priceOld">
            {{ priceOld }}
            <i style="font-style: normal; color: rgb(179, 179, 183); font-weight: 400;">₽</i>
        </del>
        <br v-if="priceOld">
        {{ price }}
        <i style="font-style: normal; color: rgb(179, 179, 183); font-weight: 400;">₽</i>
    </div>

    <button data-bs-toggle="modal" data-bs-target="#order" class="btn-standard btn-addtocart">Заказать</button>

    <!-- <div>
        {{ product.name }}
        {{ selctedTextFormat.color }}
        {{ selctedTextFormat.size }}
        {{ selctedTextFormat.glass }}
        {{ selctedTextFormat.innerdecor }}
    </div> -->

    <div class="modal fade" id="order" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Оформить заказ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <create-lead subject="Заказ" :product="product" :params="selctedTextFormat" :price="price"></create-lead>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['product', 'color', 'glass', 'innerdecor', 'size'],
    data() {
        return {
            selected: {
                color: '',
                glass: '',
                innerdecor: '',
                size: '',
            },

            selctedTextFormat: {
                color: '',
                glass: '',
                innerdecor: '',
                size: '',
            },
        }
    },
    computed: {
        colors() {
            let filteredColors = []

            this.product.skus.forEach(sku => {
                if(sku.color_id) {
                    filteredColors.push(sku)
                }
            })

            return filteredColors.filter((v,i,a)=>a.findIndex(v2=>(v2.color_id===v.color_id))===i)
        },
        glasses() {
            let filteredGlasses = []

            this.product.skus.forEach(sku => {
                if(sku.glass_id) {
                    filteredGlasses.push(sku)
                }
            })

            return filteredGlasses.filter((v,i,a)=>a.findIndex(v2=>(v2.glass_id===v.glass_id))===i)
        },
        innerdecors() {
            let filteredInnerDecors = []

            this.product.skus.forEach(sku => {
                if(sku.inner_decor_id) {
                    filteredInnerDecors.push(sku)
                }
            })

            return filteredInnerDecors.filter((v,i,a)=>a.findIndex(v2=>(v2.inner_decor_id===v.inner_decor_id))===i)
        },
        price() {
            let sku

            if(this.selected.glass) {
                sku = this.product.skus.find(sku => sku.color_id == this.selected.color && sku.glass_id == this.selected.glass)

                if(sku && sku.price) {
                    return sku.price
                }
                
                return this.product.price
            }

            if(this.selected.innerdecor) {
                sku = this.product.skus.find(sku => sku.color_id == this.selected.color && sku.inner_decor_id == this.selected.innerdecor)

                if(sku && sku.price) {
                    return sku.price
                }
                
                return this.product.price
            }

            sku = this.product.skus.find(sku => sku.color_id == this.selected.color && sku.price)

            if(sku && sku.price) {
                return parseFloat(sku.price).toFixed(0)
            }
            
            return parseFloat(this.product.price).toFixed(0)
        },
        priceOld() {
            if(this.product.old_price && this.product.old_price != this.product.price) {
                return parseFloat(this.product.old_price).toFixed(0)
            }
        },
    },
    created() {
        if(this.color) {
            this.selectColor(this.colors.find(color => color.color.slug == this.color).color)
        }
        if(this.glass) {
            this.selectGlass(this.glasses.find(glass => glass.glass.slug == this.glass).glass)
        }
        if(this.innerdecor) {
            this.selectInnerDecor(this.innerdecors.find(innerdecor => innerdecor.innerdecor.slug == this.innerdecor).innerdecor)
        }
    },
    methods: {
        selectColor(color) {
            this.selected.color = color.id
            this.selctedTextFormat.color = color.name

            if(!this.selected.glass && this.glasses.length) {
                this.selected.glass = this.glasses[0].glass.id
            }
            if(!this.selected.innerdecor && this.innerdecors.length) {
                this.selected.innerdecor = this.innerdecors[0].innerdecor.id
            }

            this.emitter.emit('product-slider', this.selected)
        },
        selectGlass(glass) {
            this.selected.glass = glass.id
            this.selctedTextFormat.glass = glass.name

            if(!this.selected.color) {
                this.selected.color = this.colors[0].color.id
            }

            this.emitter.emit('product-slider', this.selected)
        },
        selectInnerDecor(innerDecor) {
            this.selected.innerdecor = innerDecor.id
            this.selctedTextFormat.innerdecor = innerDecor.name

            if(!this.selected.color) {
                this.selected.color = this.colors[0].color.id
            }

            this.emitter.emit('product-slider', this.selected)
        },
        selectSize(size) {
            this.selected.size = size.id
            this.selctedTextFormat.size = size.name
        }
    }
}
</script>
