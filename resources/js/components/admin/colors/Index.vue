<template>         
    <div class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h1>Цвета</h1>
            </div>
            <div class="col-12 col-md-6 text-end">
                <router-link :to="{ name: 'ColorMaster' }" class="btn btn-primary">Добавить</router-link>
            </div>
        </div>
    </div>

    <Loader v-if="views.loading" />

    <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div class="w-100">
            <div v-if="colors.length" class="box mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="color in colors" :key="color.id">
                            <td>{{ color.name }}</td>
                            <td class="text-end">
                                <router-link :to="{ name: 'ColorMaster', params: {id: color.id} }" class="btn btn-sm btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </router-link>

                                <button @click="del(color.id)" class="btn btn-sm btn-outline-danger ms-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p v-else>Пусто</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            colors: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadColors()
    },
    methods: {
        loadColors() {
            axios.get('/_admin/colors')
            .then(response => {
                this.colors = response.data
                this.views.loading = false
            })
        },
        del(id) {
            if (confirm("Точно удалить цвет?")) {
                axios.delete(`/_admin/color/${id}/delete`)
                .then(response => {
                    this.loadColors()
                })
                .catch(errors => {
                    return this.$toast.error(errors.response.data ? errors.response.data : errors)
                })
            }
        },
    },
}
</script>
