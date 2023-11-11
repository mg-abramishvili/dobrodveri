<template>
    <Loader v-if="views.loading" />

    <div v-else>
        <button @click="loadFilterData()">test</button>
        <div class="filter-box">
            <p class="fw-bold mb-1">Цена</p>

            <PriceRangeSlider :min="selected.price_from" :max="selected.price_to" />
        </div>

        <div v-if="category == 1" class="filter-box">
            <p class="fw-bold mb-1">Тип двери</p>
            
            <div v-for="type in types" class="form-check">
                <input v-model="selected.types" class="form-check-input" type="checkbox" :value="type.slug" :id="'type_' + type.slug" :disabled="type.products_count == 0">
                <label class="form-check-label" :class="{ 'form-check-label-disabled': type.products_count == 0 }" :for="'type_' + type.slug">
                    {{ type.name }} <small>{{ type.products_count }}</small>
                </label>
            </div>
        </div>

        <div v-if="category == 1" class="filter-box">
            <p class="fw-bold mb-1">Покрытие</p>
            
            <div v-for="surface in surfaces" class="form-check">
                <input v-model="selected.surfaces" class="form-check-input" type="checkbox" :value="surface.slug" :id="'surface_' + surface.slug" :disabled="surface.products_count == 0">
                <label class="form-check-label" :class="{ 'form-check-label-disabled': surface.products_count == 0 }" :for="'surface_' + surface.slug">
                    {{ surface.name }} <small>{{ surface.products_count }}</small>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from './Loader.vue'
import PriceRangeSlider from './PriceRangeSlider.vue'

export default {
    props: ['category', 'filterParams'],
    data() {
        return {
            types: [],
            surfaces: [],

            selected: {
                price_from: '',
                price_to: '',
                order: '',
                order_direction: '',
                types: [],
                surfaces: [],
            },

            views: {
                loading: true,
            }
        }
    },
    watch: {
        selected: {
            deep: true,
            handler() {
                this.$parent.filterParams = this.selected
            }
        }
    },
    created() {
        this.loadFilterData()

        this.selected = this.filterParams
    },
    methods: {
        loadFilterData() {
            axios.get(`/_filterdata`, {
                params: {
                    category_id: this.category.id,
                    surfaces: this.filterParams.surfaces,
                }
            })
            .then(response => {
                this.types = response.data.types
                this.surfaces = response.data.surfaces

                this.views.loading = false
            })
        },
    },
    components: {
        Loader,
        PriceRangeSlider
    }
}
</script>
