<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Назначение двери</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.purpose" class="form-select">
                <option value="">Не выбрано</option>
                <option v-for="purpose in purposes" :value="purpose.id" :key="purpose.id">
                    {{ purpose.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            purposes: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadPurposes()
    },
    methods: {
        loadPurposes() {
            axios
            .get(`/_admin/purposes`)
            .then(response => {
                this.purposes = response.data

                this.views.loading = false
            })
        },
    },
}
</script>