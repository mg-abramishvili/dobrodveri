<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" v-for="size in sizes" class="form-check">
        <input v-model="$parent.selected.sizes" class="form-check-input" type="checkbox" :value="size.id" :id="'size_' + size.id">
        <label class="form-check-label" :for="'size_' + size.id">
            {{ size.name }}
        </label>
    </div>
</template>

<script>
export default {
    data() {
        return {
            sizes: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadSizes()
    },
    methods: {
        loadSizes() {
            axios
            .get(`/_admin/sizes`)
            .then(response => {
                this.sizes = response.data

                this.views.loading = false
            })
        },
    },
}
</script>