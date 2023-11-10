<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Покрытие</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.surface" class="form-select">
                <option value="">Не выбрано</option>
                <option v-for="surface in surfaces" :value="surface.id" :key="surface.id">
                    {{ surface.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            surfaces: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadSurfaces()
    },
    methods: {
        loadSurfaces() {
            axios
            .get(`/_admin/surfaces`)
            .then(response => {
                this.surfaces = response.data

                this.views.loading = false
            })
        },
    },
}
</script>