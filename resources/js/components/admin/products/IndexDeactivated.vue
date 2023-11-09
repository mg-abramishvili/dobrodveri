<template>         
    <div class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-3">
                <h1>Удаленные</h1>
            </div>
            <div class="col-12 col-md-6">
                <div class="d-flex">
                    <input v-model="productSearchInput" type="text" class="form-control form-control-sm" placeholder="Поиск по товарам...">
                </div>
            </div>
        </div>
    </div>

    <Loader v-if="views.loading" />

    <div v-if="!views.loading" class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div class="w-100">
            <div v-if="productsFiltered.length" class="box mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in productsFiltered" :key="product.id">
                            <td>{{ product.name }}</td>
                            <td class="text-end">
                                <button @click="activate(product.id)" class="btn btn-sm btn-outline-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
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
            products: [],

            productSearchInput: '',

            views: {
                loading: true,
            }
        }
    },
    computed: {
        productsFiltered() {
            return this.products.filter(product => {
                return product.name.toLowerCase().includes(this.productSearchInput.toLowerCase())
            })
        },
    },
    created() {
        this.loadProducts()
    },
    methods: {
        loadProducts() {
            axios.get('/_admin/deactivated-products')
            .then(response => {
                this.products = response.data
                this.views.loading = false
            })
        },
        activate(id) {
            if (confirm("Точно восстановить?")) {
                axios.put(`/_admin/product/${id}/activate`)
                .then(response => {
                    this.$router.push({ name: 'Products' })
                })
                .catch(errors => {
                    return this.$swal({
                        text: errors,
                        icon: 'error',
                    })
                })
            }
        },
    },
}
</script>
