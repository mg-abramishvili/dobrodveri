<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="col-12 col-lg-6 mb-4">
        <label class="form-label">Категория</label>
        <select v-model="$parent.selected.category" class="form-select" :disabled="$parent.editMode">
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
        </select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            categories: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadCategories()
    },
    methods: {
        loadCategories() {
            axios
            .get(`/_admin/categories`)
            .then(response => {
                this.categories = response.data

                this.views.loading = false
            })
        },
    },
}
</script>