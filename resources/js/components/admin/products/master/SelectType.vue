<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Тип</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.type" class="form-select">
                <option value="">Не выбрано</option>
                <option v-for="type in types" :value="type.id">
                    {{ type.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            types: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadTypes()
    },
    methods: {
        loadTypes() {
            axios
            .get(`/_admin/types`)
            .then(response => {
                this.types = response.data

                this.views.loading = false
            })
        },
    },
}
</script>