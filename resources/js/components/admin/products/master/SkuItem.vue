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
                    :server="server"
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

            server: {
                remove(filename, load) {
                    load('1');
                },
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    formData.append('product_id', this.product.id);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/_admin/file/upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            load(request.responseText);
                        }
                        else {
                            error('oh no');
                        }
                    };
                    request.send(formData);
                    return {
                        abort: () => {
                            request.abort();
                            abort();
                        }
                    };
                },
                revert: (filename, load) => {
                    load(filename)
                },
                load: (source, load, error, progress, abort, headers) => {
                    var myRequest = new Request(source);
                    fetch(myRequest).then(function(response) {
                        response.blob().then(function(myBlob) {
                            load(myBlob)
                        });
                    });
                },
            },
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
                let errorMessage = ''

                if(errors.response.data) {
                    errorMessage = errors.response.data
                } else {
                    errorMessage = errors
                }

                return this.$swal({
                    text: errorMessage,
                    icon: 'error',
                })
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