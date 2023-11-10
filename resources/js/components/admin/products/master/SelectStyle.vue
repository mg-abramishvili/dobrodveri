<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Стиль</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.style" class="form-select">
                <option value="">Не выбрано</option>
                <option v-for="style in styles" :value="style.id" :key="style.id">
                    {{ style.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            styles: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadStyles()
    },
    methods: {
        loadStyles() {
            axios
            .get(`/_admin/styles`)
            .then(response => {
                this.styles = response.data

                this.views.loading = false
            })
        },
    },
}
</script>