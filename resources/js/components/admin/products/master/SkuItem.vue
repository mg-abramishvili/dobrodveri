<template>
    <div class="sku-item" :id="'sku_' + sku.id">
        <div class="row align-items-center">
            <div class="col-2">
                <file-pond
                    name="image"
                    ref="image"
                    label-idle="Выбрать файл"
                    v-bind:allow-multiple="false"
                    v-bind:allow-reorder="false"
                    accepted-file-types="image/jpeg, image/png"
                    :server="filepondServer"
                    v-bind:files="filepond_image_edit"
                />
            </div>
            <div class="col-2">
                <span class="d-block fw-bolder text-muted"><small>цвет</small></span>
                {{ sku.color.name }}
            </div>
            <div class="col-3">
                <template v-if="sku.glass">
                    <span class="d-block fw-bolder text-muted"><small>остекление</small></span>
                    {{ sku.glass.name }}
                </template>
                <template v-if="sku.innerdecor">
                    <span class="d-block fw-bolder text-muted"><small>внутр.отделка</small></span>
                    {{ sku.innerdecor.name }}
                </template>
            </div>
            <div class="col-2">
                <input v-model="price" type="number" name="price" class="form-control" placeholder="цена">
            </div>
            <div class="col-3 text-end">
                <!-- <button @click="save()" class="btn btn-sm btn-outline-primary">Сохранить</button> -->
                <button @click="del()" class="btn btn-sm btn-outline-danger ms-1">Удалить</button>
            </div>
        </div>
    </div>
</template>

<script>
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

import FilepondServer from '../../FilepondServer.js'

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
);

export default {
    props: ['sku', 'product'],
    data() {
        return {
            price: '',
            image: '',

            filepond_image: [],
            filepond_image_edit: [],

            filepondServer: FilepondServer(this.product.id),
        }
    },
    created() {
        this.price = this.sku.price
        
        if(this.sku.image) {
            this.filepond_image_edit = [
                {
                    source: this.sku.image,
                    options: {
                        type: 'local',
                    }
                }
            ]
        }
    },
    methods: {
        save() {
            if(document.querySelector(`#sku_${this.sku.id} input[name='image']`)) {
                this.image = document.querySelector(`#sku_${this.sku.id} input[name='image']`).value
            }

            axios.put(`/_admin/sku/${this.sku.id}/update`, {
                price: this.price,
                image: this.image,
            })
            .then(response => {
                this.$parent.loadProduct()
            })
            .catch(errors => {
                return this.$toast.error(errors.response.data ? errors.response.data : errors)
            })
        },
        del() {
            if (confirm("Точно удалить?")) {
                axios.delete(`/_admin/sku/${this.sku.id}/delete`)
                .then(response => {
                    this.$parent.loadProduct()
                })
            }
        },
    },
    components: {
        FilePond,
    },
}
</script>