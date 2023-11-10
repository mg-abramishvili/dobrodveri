<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Фабрика</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.factory" class="form-select">
                <option value="">Не выбрано</option>
                <option v-for="factory in factories" :value="factory.id">
                    {{ factory.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            factories: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadFactories()
    },
    methods: {
        loadFactories() {
            axios
            .get(`/_admin/factories`)
            .then(response => {
                this.factories = response.data

                this.views.loading = false
            })
        },
    },
}
</script>