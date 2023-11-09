<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h1>
                    <router-link :to="{ name: 'Leads' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </router-link>
                    Заявка - {{ lead.subject }}
                </h1>
            </div>
        </div>
    </div>

    <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div class="w-100">
            <div class="box px-4 py-4 mb-4">
                <div class="box-tab-content">
                    <p>
                        <strong>Дата:</strong>
                        {{ $filters.datetime(lead.created_at) }}
                    </p>

                    <p>
                        <strong>Имя:</strong>
                        {{ lead.name }}
                    </p>

                    <p>
                        <strong>Телефон:</strong>
                        {{ lead.phone }}
                    </p>

                    <p class="mb-0">
                        <strong>Сообщение:</strong>
                        {{ lead.message }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            lead: {},

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadLead()
    },
    methods: {
        loadLead() {
            axios.get(`/_admin/lead/${this.$route.params.id}`)
            .then(response => {
                this.lead = response.data

                this.views.loading = false
            })
            .catch(errors => {
                //
            })
        },
    },
}
</script>