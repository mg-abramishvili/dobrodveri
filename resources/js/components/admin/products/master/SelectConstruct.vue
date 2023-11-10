<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Конструкция</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.construct" class="form-select">
                <option value="">Не выбрано</option>
                <option v-for="construct in constructs" :value="construct.id" :key="construct.id">
                    {{ construct.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            constructs: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadConstructs()
    },
    methods: {
        loadConstructs() {
            axios
            .get(`/_admin/constructs`)
            .then(response => {
                this.constructs = response.data

                this.views.loading = false
            })
        },
    },
}
</script>