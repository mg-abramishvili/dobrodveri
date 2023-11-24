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
        if(this.$route.params.id) {
            this.loadPage()
        }
        
        if(!this.$route.params.id) {
            this.views.loading = false
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
            
            this.views.saveButton = false

            let postData = {
                name: this.name,
                slug: this.slug,
                text: this.text
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
}
</script>