<template>         
    <div class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h1>Заявки</h1>
            </div>
        </div>
    </div>

    <Loader v-if="views.loading" />

    <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div class="w-100">
            <div v-if="leads.length" class="box mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Тема</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="lead in leads" :key="lead.id">
                            <td class="w-25">{{ $dayjs(lead.created_at).locale('ru').utcOffset(5).format('DD-MM-YYYY H:mm') }}</td>
                            <td>{{ lead.subject }}</td>
                            <td class="text-end">
                                <router-link :to="{ name: 'Lead', params: {id: lead.id} }" class="btn btn-sm btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                </router-link>
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
            leads: [],

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.loadLeads()
    },
    methods: {
        loadLeads() {
            axios.get('/_admin/leads')
            .then(response => {
                this.leads = response.data
                this.views.loading = false
            })
        },
    },
}
</script>