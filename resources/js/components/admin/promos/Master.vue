<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h1>
                    <router-link :to="{ name: 'Promos' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </router-link>

                    <template v-if="$route.params.id">{{ promo.name }}</template>
                    <template v-else>Новая акция</template>
                </h1>
            </div>
        </div>
    </div>

    <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div class="w-100">
            <div class="box px-4 py-4 mb-4">
                <div class="box-tab-content">
                    <div class="mb-4">
                        <label class="form-label">Название</label>
                        <input v-model="name" type="text" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Текст</label>
                        <ckeditor :editor="editor" v-model="description" :config="editorConfig"></ckeditor>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Картинка</label>
                        <file-pond
                            name="promo_image"
                            ref="promo_image"
                            label-idle="Выбрать файл"
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="image/jpeg, image/png"
                            :server="filepondServer"
                            v-bind:files="filepond_image_edit"
                        />
                    </div>
                            
                    <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
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

import FilepondServer from "../FilepondServer"

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
)

import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
    data() {
        return {
            promo: {},

            name: '',
            description: '',
            image: '',

            filepond_image: [],
            filepond_image_edit: [],

            views: {
                loading: true,
                saveButton: true,
            },

            filepondServer: FilepondServer(),

            editor: ClassicEditor,
            editorConfig: {
                toolbar: [ 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo' ],
            },
        }
    },
    created() {
        if(this.$route.params.id) {
            this.loadPromo()
        }
        
        if(!this.$route.params.id) {
            this.views.loading = false
        }
    },
    methods: {
        loadPromo() {
            axios.get(`/_admin/promo/${this.$route.params.id}`)
            .then(response => {
                this.promo = response.data

                this.name = response.data.name
                this.description = response.data.description
                
                if(response.data.image) {
                    this.filepond_image_edit = [
                        {
                            source: response.data.image,
                            options: {
                                type: 'local',
                            }
                        }
                    ]
                }

                this.views.loading = false
            })
            .catch(errors => {
                return this.$toast.error(errors.response.data ? errors.response.data : errors)
            })
        },
        save() {
            if(document.getElementsByName("promo_image")[0]) {
                this.image = document.getElementsByName("promo_image")[0].value
            }

            if(!this.name) {
                return this.$toast.error('Укажите название')
            }
            if(!this.description) {
                return this.$toast.error('Напишите текст')
            }
            if(!this.image) {
                return this.$toast.error('Загрузите картинку')
            }

            this.views.saveButton = false

            let postData = {
                name: this.name,
                description: this.description,
                image: this.image
            }

            if(this.$route.params.id) {
                axios.put(`/_admin/promo/${this.$route.params.id}/update`, postData)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Promos' })
                })
                .catch(errors => {
                    this.views.saveButton = true
                
                    return this.$toast.error(errors.response.data ? errors.response.data : errors)
                })
            }
            
            if(!this.$route.params.id) {
                axios.post(`/_admin/promos`, postData)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Promos' })
                })
                .catch(errors => {
                    this.views.saveButton = true
    
                    return this.$toast.error(errors.response.data ? errors.response.data : errors)
                })
            }
        },
    },
    components: {
        FilePond
    }
}
</script>