<template>
    <div class="sku-generator">
        <Loader v-if="views.loading"></Loader>

        <div v-if="!views.loading" class="row align-items-end">
            <div class="col">
                <span v-if="product.category_id == 1" class="fw-bolder">Цвет</span>
                <span v-if="product.category_id == 2" class="fw-bolder">Цвет внутренней панели</span>
                <span v-if="product.category_id == 3" class="fw-bolder">Цвет</span>

                <div style="height: 300px; overflow-y: auto;">
                    <div v-for="color in colors" :key="color.id" class="form-check">
                        <input v-model="selected.colors" type="checkbox" :value="color.id" :id="'color_' + color.id" class="form-check-input">
                        <label :for="'color_' + color.id" class="form-check-label">{{ color.name }}</label>
                    </div>
                </div>

            </div>
            <div v-if="product.category_id == 1" class="col">
                <span class="fw-bolder">Остекление</span>

                <div style="height: 300px; overflow-y: auto;">
                    <div v-for="glass in glasses" :key="glass.id" class="form-check">
                        <input v-model="selected.glasses" type="checkbox" :value="glass.id" :id="'glass_' + glass.id" class="form-check-input">
                        <label :for="'glass_' + glass.id" class="form-check-label">{{ glass.name }}</label>
                    </div>
                </div>
            </div>
            <div v-if="product.category_id == 2" class="col">
                <span class="fw-bolder">Внутренняя отделка</span>
                <div v-for="innerdecor in innerdecors" :key="innerdecor.id" class="form-check">
                    <input v-model="selected.innerdecors" type="checkbox" :value="innerdecor.id" :id="'innerdecor_' + innerdecor.id" class="form-check-input">
                    <label :for="'innerdecor_' + innerdecor.id" class="form-check-label">{{ innerdecor.name }}</label>
                </div>
            </div>
            <div class="col text-end">
                <button :disabled="views.saveButton == false"  @click="save()" class="btn btn-sm btn-primary">Создать вариации</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['product'],
    data() {
        return {
            glasses: [],
            colors: [],
            innerdecors: [],

            selected: {
                colors: [],
                glasses: [],
                innerdecors: [],
            },

            views: {
                loading: true,
                saveButton: true,
            },
        }
    },
    created() {
        this.loadColors()
        this.loadGlasses()
        this.loadInnerDecors()
    },
    methods: {
        loadColors() {
            axios
            .get(`/_admin/colors`)
            .then((response => {
                this.colors = response.data
            }));
        },
        loadGlasses() {
            axios
            .get(`/_admin/glasses`)
            .then((response => {
                this.glasses = response.data

                this.views.loading = false
            }))
        },
        loadInnerDecors() {
            axios
            .get(`/_admin/innerdecors`)
            .then((response => {
                this.innerdecors = response.data

                this.views.loading = false
            }))
        },
        save() {
            axios.post('/_admin/skus', {
                product_id: this.product.id,
                colors: this.selected.colors,
                glasses: this.selected.glasses,
                innerdecors: this.selected.innerdecors
            })
            .then(response => {
                this.$parent.views.skuGenerator = false,
                this.$parent.loadProduct()
            })
            .catch(errors => {
                this.views.saveButton = true

                let errorMessage = ''

                if(errors.response.data) {
                    errorMessage = errors.response.data
                } else {
                    errorMessage = errors
                }

                return this.$swal({
                    text: errorMessage,
                    icon: 'error',
                })
            })
        },
    },
}
</script>
