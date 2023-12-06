<template>
    <div class="sku-item" :id="'sku_' + sku.id">
        <div class="sku-item-pic">
            <img
            :src="image ? image : '/img/no-image.jpg'"
            data-bs-toggle="offcanvas"
            :data-bs-target="'#offcanvas' + sku.id"
            />

            <SkuItemPic :sku="sku" :product="product" />
        </div>
        <div class="sku-item-color">
            <span class="d-block fw-bolder text-muted"><small>цвет</small></span>
            {{ sku.color.name }}
        </div>
        <div class="sku-item-glass">
            <template v-if="sku.glass">
                <span class="d-block fw-bolder text-muted"><small>остекление</small></span>
                {{ sku.glass.name }}
            </template>
            <template v-if="sku.innerdecor">
                <span class="d-block fw-bolder text-muted"><small>внутр.отделка</small></span>
                {{ sku.innerdecor.name }}
            </template>
        </div>
        <div class="sku-item-price">
            <input v-model="price" type="number" name="price" class="form-control" placeholder="цена">
        </div>
        <div class="sku-item-del">
            <button @click="del()" class="btn btn-sm btn-outline-danger ms-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import SkuItemPic from './SkuItemPic.vue'

export default {
    props: ['sku', 'product'],
    data() {
        return {
            price: '',
            image: '',
        };
    },
    created() {
        this.price = this.sku.price
        this.image = this.sku.image
    },
    methods: {
        del() {
            if (confirm("Точно удалить?")) {
                axios.delete(`/_admin/sku/${this.sku.id}/delete`)
                    .then(response => {
                    this.$parent.loadProduct();
                });
            }
        },
    },
    components: { SkuItemPic }
}
</script>