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
                    {{ page.name }}
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
                        <label class="form-label">Текст</label>
                        <ckeditor :editor="editor" v-model="text" :config="editorConfig"></ckeditor>
                    </div>
                            
                    <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
    data() {
        return {
            page: {},

            name: '',
            slug: '',
            text: '',

            views: {
                loading: true,
                saveButton: true,
            },

            editor: ClassicEditor,
            editorConfig: {
                toolbar: [ 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo' ],
            }
        }
    },
    created() {
        this.loadPage()
    },
    methods: {
        loadPage() {
            axios.get(`/_admin/page/${this.$route.params.id}`)
            .then(response => {
                this.page = response.data

                this.name = response.data.name
                this.slug = response.data.slug
                this.text = response.data.text

                this.views.loading = false
            })
            .catch(errors => {
                //
            })
        },
        slugify() {
            if(this.name) {
                this.slug = this.$filters.slugify(this.name)
            }
        },
        save() {
            if(!this.name) {
                return this.$swal({
                    text: 'Укажите название',
                    icon: 'error',
                })
            }
            if(!this.slug) {
                return this.$swal({
                    text: 'Укажите символьный код',
                    icon: 'error',
                })
            }
            if(!this.text) {
                return this.$swal({
                    text: 'Загрузите картинку',
                    icon: 'error',
                })
            }
            
            this.views.saveButton = false

            axios.put(`/_admin/page/${this.$route.params.id}/update`, {
                name: this.name,
                slug: this.slug,
                text: this.text
            })
            .then(response => {
                this.views.saveButton = true
                this.$router.push({ name: 'Pages' })
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
        ckeditor: CKEditor.component
    }
}
</script>