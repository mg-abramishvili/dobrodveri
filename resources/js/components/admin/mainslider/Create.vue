<template>
    <div class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h1>
                    <router-link :to="{ name: 'MainSlider' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </router-link>
                    Новый слайд
                </h1>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div class="w-100">
            <div class="box px-4 py-4 mb-4">
                <div class="box-tab-content">
                    <div class="mb-4">
                        <label class="form-label">Заголовок</label>
                        <input v-model="header" type="text" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Текст</label>
                        <input v-model="text" type="text" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Ссылка</label>
                        <input v-model="link" type="text" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Изображение (2000 &times; 625)</label>
                        <file-pond
                            name="mainslide_image"
                            ref="mainslide_image"
                            label-idle="Выбрать файл"
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="image/jpeg, image/png"
                            :server="server"
                            v-bind:files="filepond_image_edit"
                        />
                    </div>
                            
                    <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
                    <button @click="del()" class="btn btn-outline-danger ms-2">Удалить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vueFilePond from "vue-filepond"
import "filepond/dist/filepond.min.css"
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
)

export default {
    data() {
        return {
            header: '',
            text: '',
            image: '',
            link: '',

            filepond_image: [],
            filepond_image_edit: [],

            views: {
                saveButton: true,
            },

            server: {
                remove(filename, load) {
                    load('1');
                },
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
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
    methods: {
        save() {
            if(document.getElementsByName("mainslide_image")[0]) {
                this.image = document.getElementsByName("mainslide_image")[0].value
            }

            if(!this.header) {
                return this.$swal({
                    text: 'Укажите название',
                    icon: 'error',
                })
            }
            if(!this.image) {
                return this.$swal({
                    text: 'Загрузите изображение',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            axios.post(`/_admin/mainslider`, {
                header: this.header,
                text: this.text,
                image: this.image,
                link: this.link,
            })
            .then(response => {
                this.views.saveButton = true
                this.$router.push({ name: 'MainSlider' })
            })
            .catch(errors => {
                this.views.saveButton = true

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
    },
    components: {
        FilePond
    }
}
</script>