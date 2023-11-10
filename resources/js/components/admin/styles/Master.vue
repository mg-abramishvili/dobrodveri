<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h1>
                    <router-link :to="{ name: 'Styles' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </router-link>

                    <template v-if="$route.params.id">{{ style.name }}</template>
                    <template v-else>Новый стиль</template>
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
                            
                    <button @click="save()" :disabled="!views.saveButton" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            style: {},

            name: '',
            slug: '',

            views: {
                loading: true,
                saveButton: true,
            }
        }
    },
    created() {
        if(this.$route.params.id) {
            this.loadStyle()
        }

        if(!this.$route.params.id) {
            this.views.loading = false
        }
    },
    methods: {
        loadStyle() {
            axios.get(`/_admin/style/${this.$route.params.id}`)
            .then(response => {
                this.style = response.data

                this.name = response.data.name
                this.slug = response.data.slug

                this.views.loading = false
            })
            .catch(errors => {
                return this.$swal({
                    text: errors.response.data ? errors.response.data : errors,
                    icon: 'error',
                })
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
            if(!this.slug) {
                return this.$swal({
                    text: 'Укажите цвет',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            let postData = {
                name: this.name,
                slug: this.slug,
            }

            if(this.$route.params.id) {
                axios.put(`/_admin/style/${this.$route.params.id}/update`, postData)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Styles' })
                })
                .catch(errors => {
                    this.views.saveButton = true
    
                    return this.$swal({
                        text: errors.response.data ? errors.response.data : errors,
                        icon: 'error',
                    })
                })
            }

            if(!this.$route.params.id) {
                axios.post(`/_admin/styles`, postData)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Styles' })
                })
                .catch(errors => {
                    this.views.saveButton = true
    
                    return this.$swal({
                        text: errors.response.data ? errors.response.data : errors,
                        icon: 'error',
                    })
                })
            }
        },
    },
}
</script>