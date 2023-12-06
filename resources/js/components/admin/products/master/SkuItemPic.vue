<template>
    <div class="offcanvas offcanvas-end" tabindex="-1" :id="'offcanvas' + sku.id">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Картинка</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div>
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

                <button @click="save()" class="btn btn-primary">Сохранить</button>
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
)

export default {
    props: ['sku', 'product'],
    data() {
        return {
            image: '',
            filepond_image_edit: [],

            filepondServer: FilepondServer(this.product.id),
        }
    },
    created() {
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
            if (document.querySelector(`#sku_${this.sku.id} input[name='image']`)) {
                this.image = document.querySelector(`#sku_${this.sku.id} input[name='image']`).value;
            }

            this.$parent.image = this.image

            document.querySelector('[data-bs-dismiss="offcanvas"]').click()
        }
    },
    components: {
        FilePond,
    },
}
</script>