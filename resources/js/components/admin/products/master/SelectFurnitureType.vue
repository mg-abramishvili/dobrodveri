<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Тип фурнитуры</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.furnituretype" class="form-select">
                <option value="">Не выбрано</option>
                <option v-for="furnituretype in furnituretypes" :value="furnituretype.id" :key="furnituretype.id">
                    {{ furnituretype.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            furnituretypes: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadFurnitureTypes()
    },
    methods: {
        loadFurnitureTypes() {
            axios
            .get(`/_admin/furnituretypes`)
            .then(response => {
                this.furnituretypes = response.data

                this.views.loading = false
            })
        },
    },
}
</script>