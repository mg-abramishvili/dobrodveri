<template>
    <Loader v-if="views.loading" />

    <div v-else>
        <div class="filter-box">
            <p class="fw-bold mb-1">Цена</p>

            <PriceRangeSlider :min="selected.price_from" :max="selected.price_to" />
        </div>

        <div v-if="category == 1" class="filter-box">
            <p class="fw-bold mb-1">Тип двери</p>
            
            <div v-for="type in types" class="form-check">
                <input v-model="selected.types" class="form-check-input" type="checkbox" :value="type.slug" :id="'type_' + type.slug">
                <label class="form-check-label" :for="'type_' + type.slug">
                    {{ type.name }}
                </label>
            </div>
        </div>

        <div class="filter-box">
            <p v-if="category == 1" class="fw-bold mb-1">Цвет</p>
            <p v-if="category == 2" class="fw-bold mb-1">Цвет внутренней панели</p>
            <p v-if="category == 3" class="fw-bold mb-1">Цвет</p>

            <div class="filter-box-search">
                <input v-model="search.colorInput" type="text" class="form-control">
            </div>
            <div class="filter-short">
                <div v-for="color in filteredColors" class="form-check">
                    <input v-model="selected.colors" class="form-check-input" type="checkbox" :value="color.slug" :id="'color_' + color.slug">
                    <label class="form-check-label" :for="'color_' + color.slug">
                        <img :src="color.image" alt="" style="width: 15px; height: 15px;">
                        <span>{{ color.name }}</span>
                    </label>
                </div>
            </div>
        </div>

        <div v-if="category == 1" class="filter-box">
            <p class="fw-bold mb-1">Цвет стекла</p>

            <div v-for="glass in glasses" class="form-check">
                <input v-model="selected.glasses" class="form-check-input" type="checkbox" :value="glass.slug" :id="'glass_' + glass.slug">
                <label class="form-check-label" :for="'glass_' + glass.slug">
                    {{ glass.name }}
                </label>
            </div>
        </div>

        <div v-if="category == 1" class="filter-box">
            <p class="fw-bold mb-1">Покрытие</p>
            
            <div v-for="surface in surfaces" class="form-check">
                <input v-model="selected.surfaces" class="form-check-input" type="checkbox" :value="surface.slug" :id="'surface_' + surface.slug">
                <label class="form-check-label" :for="'surface_' + surface.slug">
                    {{ surface.name }}
                </label>
            </div>
        </div>

        <div v-if="category == 2" class="filter-box">
            <p class="fw-bold mb-1">Внутренняя отделка</p>

            <div v-for="innerdecor in innerdecors" class="form-check">
                <input v-model="selected.innerdecors" class="form-check-input" type="checkbox" :value="innerdecor.slug" :id="'innerdecor_' + innerdecor.slug">
                <label class="form-check-label" :for="'innerdecor_' + innerdecor.slug">
                    {{ innerdecor.name }}
                </label>
            </div>
        </div>

        <div v-if="category == 2" class="filter-box">
            <p class="fw-bold mb-1">Назначение двери</p>
            
            <div v-for="purpose in purposes" class="form-check">
                <input v-model="selected.purposes" class="form-check-input" type="checkbox" :value="purpose.slug" :id="'purpose_' + purpose.slug">
                <label class="form-check-label" :for="'purpose_' + purpose.slug">
                    {{ purpose.name }}
                </label>
            </div>
        </div>

        <div v-if="category == 3" class="filter-box">
            <p class="fw-bold mb-1">Тип фурнитуры</p>
            
            <div v-for="furnituretype in furnituretypes" class="form-check">
                <input v-model="selected.furnituretypes" class="form-check-input" type="checkbox" :value="furnituretype.slug" :id="'furnituretype_' + furnituretype.slug">
                <label class="form-check-label" :for="'furnituretype_' + furnituretype.slug">
                    {{ furnituretype.name }}
                </label>
            </div>
        </div>
    </div>
</template>

<script>
import Loader from './Loader'
import PriceRangeSlider from './PriceRangeSlider'

export default {
    props: ['category', 'filterParams'],
    data() {
        return {
            price_from: '',
            price_to: '',
            order: '',
            order_direction: '',
            types: [],
            surfaces: [],
            colors: [],
            glasses: [],
            innerdecors: [],
            purposes: [],
            furnituretypes: [],

            selected: {
                price_from: '',
                price_to: '',
                order: '',
                order_direction: '',
                types: [],
                surfaces: [],
                colors: [],
                glasses: [],
                innerdecors: [],
                purposes: [],
                furnituretype: [],
            },

            search: {
                colorInput: ''
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
                this.$parent.filter = this.selected
            }
        }
    },
    computed: {
        filteredColors() {
            return this.colors.filter(color => {
                return color.name.toLowerCase().includes(this.search.colorInput.toLowerCase())
            })
        },
    },
    created() {
        this.loadFilterData()

        this.selected = this.filterParams
    },
    methods: {
        loadFilterData() {
            axios.get(`/_filterdata/${this.category}`)
            .then(response => {
                this.colors = response.data.colors
                this.types = response.data.types
                this.surfaces = response.data.surfaces
                this.glasses = response.data.glasses
                this.innerdecors = response.data.innerdecors
                this.purposes = response.data.purposes
                this.furnituretypes = response.data.furnituretypes

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
