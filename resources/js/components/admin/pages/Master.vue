<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h1>
                    <router-link :to="{ name: 'Pages' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </router-link>

                    <template v-if="$route.params.id">{{ page.name }}</template>
                    <template v-else>Новая страница</template>
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
                        <input v-model="name" @change="slugify()" type="text" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Символьный код</label>
                        <input v-model="slug" type="text" class="form-control">
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input v-model="is_folder1" class="form-check-input" type="checkbox" :value="1" id="is_folder1">
                            <label class="form-check-label" for="is_folder1">
                                В папку "Дизайнерам"
                            </label>
                        </div>
                        <div class="form-check">
                            <input v-model="is_folder2" class="form-check-input" type="checkbox" :value="1" id="is_folder2">
                            <label class="form-check-label" for="is_folder2">
                                В папку "Полезное"
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Текст</label>
                        <ckeditor :editor="editor" v-model="text" :config="editorConfig"></ckeditor>
                    </div>

                    <div class="mb-4 page-gallery">
                        <label class="form-label">Галерея</label>
                        <file-pond
                            name="page_gallery[]"
                            ref="page_gallery"
                            label-idle="Выбрать файл"
                            v-bind:allow-multiple="true"
                            v-bind:allow-reorder="true"
                            accepted-file-types="image/jpeg, image/png"
                            :server="filepondServer"
                            v-bind:files="filepond_gallery_edit"
                        />
                    </div>

                    <div v-if="is_folder1 || is_folder2" class="mb-4 page-gallery">
                        <label class="form-label">Картинка-обложка</label>
                        <file-pond
                            name="page_cover"
                            ref="page_cover"
                            label-idle="Выбрать файл"
                            v-bind:allow-multiple="false"
                            v-bind:allow-reorder="false"
                            accepted-file-types="image/jpeg, image/png"
                            :server="filepondServer"
                            v-bind:files="filepond_cover_edit"
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
            page: {},

            name: '',
            slug: '',
            text: '',
            gallery: [],
            cover: '',
            is_folder1: false,
            is_folder2: false,

            views: {
                loading: true,
                saveButton: true,
            },

            filepond_cover: [],
            filepond_cover_edit: [],
            filepond_gallery: [],
            filepond_gallery_edit: [],

            filepondServer: FilepondServer(),

            editor: ClassicEditor,
            editorConfig: {
                toolbar: [ 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo' ],
            }
        }
    },
    created() {
        if(this.$route.params.id) {
            this.loadPage()
        }
        
        if(!this.$route.params.id) {
            this.views.loading = false
        }
    },
    watch: {
        is_folder1: {
            handler() {
                if(this.is_folder1 == true) {
                    this.is_folder2 = false
                }
            }
        },
        is_folder2: {
            handler() {
                if(this.is_folder2 == true) {
                    this.is_folder1 = false
                }
            }
        }
    },
    methods: {
        loadPage() {
            axios.get(`/_admin/page/${this.$route.params.id}`)
            .then(response => {
                this.page = response.data

                this.name = response.data.name
                this.slug = response.data.slug
                this.text = response.data.text
                this.is_folder1 = response.data.is_folder1 == 1 ? true : false
                this.is_folder2 = response.data.is_folder2 == 1 ? true : false

                if(response.data.gallery) {
                    this.filepond_gallery_edit = response.data.gallery.map(function(element){
                        {
                            return {
                                source: element,
                                options: {
                                    type: 'local',
                                }
                            } 
                        }
                    })
                }

                if(response.data.cover) {
                    this.filepond_cover_edit = [
                        {
                            source: response.data.cover,
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
        slugify() {
            if(this.name) {
                this.slug = this.$filters.slugify(this.name)
            }
        },
        save() {
            if(!this.name) {
                return this.$toast.error('Укажите название')
            }
            if(!this.slug) {
                return this.$toast.error('Укажите символьный код')
            }
            if(!this.text) {
                return this.$toast.error('Напишите текст страницы')
            }

            if(document.getElementsByName("page_gallery[]")) {
                this.gallery = []
                document.getElementsByName("page_gallery[]").forEach((galleryItem) => {
                    if(galleryItem.value) {
                        this.gallery.push(galleryItem.value)
                    }
                })
            }

            if(document.getElementsByName("page_cover")[0]) {
                this.cover = document.getElementsByName("page_cover")[0].value
            }
            
            this.views.saveButton = false

            let postData = {
                name: this.name,
                slug: this.slug,
                text: this.text,
                gallery: this.gallery,
                cover: this.cover,
                is_folder1: this.is_folder1,
                is_folder2: this.is_folder2,
            }

            if(this.$route.params.id) {
                axios.put(`/_admin/page/${this.$route.params.id}/update`, postData)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Pages' })
                })
                .catch(errors => {
                    this.views.saveButton = true
                
                    return this.$toast.error(errors.response.data ? errors.response.data : errors)
                })
            }

            if(!this.$route.params.id) {
                axios.post(`/_admin/pages`, postData)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Pages' })
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