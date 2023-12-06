<template>
    <div class="filter-box">
        <p class="fw-bold mb-1">Цена</p>

        <PriceRangeSlider :min="selected.price_from" :max="selected.price_to" />
    </div>

    <div class="filter-box">
        <p v-if="category_id == 1">Цвет</p>
        <p v-if="category_id == 2">Цвет внутренней панели</p>
        <p v-if="category_id == 3">Цвет</p>
        
        <div class="filter-box-list filter-box-list-large">
            <template v-for="color in colors">
                <div class="form-check">
                    <input v-model="selected.colors" class="form-check-input" type="checkbox" :value="color.slug" :id="'color_' + color.slug" :disabled="color.skus_count == 0">
                    <label class="form-check-label" :class="{ 'form-check-label-disabled': color.skus_count == 0 }"  :for="'color_' + color.slug">
                        <img :src="color.image"/> {{ color.name }} <small v-if="color.skus_count > 0">{{ color.skus_count }}</small>
                    </label>
                </div>
            </template>
        </div>
    </div>

    <div v-if="category_id == 1" class="filter-box">
        <p>Цвет стекла</p>
        
        <div class="filter-box-list">
            <template v-for="glass in glasses">
                <div class="form-check">
                    <input v-model="selected.glasses" class="form-check-input" type="checkbox" :value="glass.slug" :id="'glass_' + glass.slug" :disabled="glass.skus_count == 0">
                    <label class="form-check-label" :class="{ 'form-check-label-disabled': glass.skus_count == 0 }"  :for="'glass_' + glass.slug">
                        <img :src="glass.image"/> {{ glass.name }} <small v-if="glass.skus_count > 0">{{ glass.skus_count }}</small>
                    </label>
                </div>
            </template>
        </div>
    </div>

    <div v-if="category_id == 1" class="filter-box">
        <p>Тип двери</p>
        
        <div class="filter-box-list">
            <template v-for="type in types">
                <div class="form-check">
                    <input v-model="selected.types" class="form-check-input" type="checkbox" :value="type.slug" :id="'type_' + type.slug" :disabled="type.skus_count == 0">
                    <label class="form-check-label" :class="{ 'form-check-label-disabled': type.skus_count == 0 }" :for="'type_' + type.slug">
                        {{ type.name }} <small>{{ type.skus_count }}</small>
                    </label>
                </div>
            </template>
        </div>
    </div>

    <div v-if="category_id == 1" class="filter-box">
        <p>Стиль</p>
        
        <div class="filter-box-list">
            <template v-for="style in styles">
                <div class="form-check">
                    <input v-model="selected.styles" class="form-check-input" type="checkbox" :value="style.slug" :id="'style_' + style.slug" :disabled="style.skus_count == 0">
                    <label class="form-check-label" :class="{ 'form-check-label-disabled': style.skus_count == 0 }" :for="'style_' + style.slug">
                        {{ style.name }} <small>{{ style.skus_count }}</small>
                    </label>
                </div>
            </template>
        </div>
    </div>

    <div v-if="category_id == 1" class="filter-box">
        <p>Покрытие</p>
        
        <div class="filter-box-list">
            <template v-for="surface in surfaces">
                <div class="form-check">
                    <input v-model="selected.surfaces" class="form-check-input" type="checkbox" :value="surface.slug" :id="'surface_' + surface.slug" :disabled="surface.skus_count == 0">
                    <label class="form-check-label" :class="{ 'form-check-label-disabled': surface.skus_count == 0 }" :for="'surface_' + surface.slug">
                        {{ surface.name }} <small>{{ surface.skus_count }}</small>
                    </label>
                </div>
            </template>
        </div>
    </div>

    <div class="category-filter-buttons">
        <button @click="applyFilter()" class="category-filter-button">
            Применить фильтр
        </button>

        <button @click="resetFilter()" class="category-filter-button">
            Сбросить фильтр
        </button>
    </div>
</template>

<script>
import PriceRangeSlider from './PriceRangeSlider.vue'

export default {
    props: [
        'category_id',
        'reqTypes',
        'reqStyles',
        'reqSurfaces',
        'reqColors',
        'reqGlasses',
    ],
    data() {
        return {
            types: [],
            styles: [],
            surfaces: [],
            colors: [],
            glasses: [],

            selected: {},

            initialFilterParams: {
                category_id: this.category_id,
                price_from: 0,
                price_to: 100000,
                order: 'price',
                order_direction: 'asc',
                types: [],
                styles: [],
                surfaces: [],
                colors: [],
                glasses: [],
            },

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.selected = JSON.parse(JSON.stringify(this.initialFilterParams))

        this.loadFilter()
    },
    mounted() {
        this.$watch('selected', function() {
            this.loadFilter()
        }, {
            deep: true
        })
    },
    methods: {
        loadFilter() {
            axios.get(`/_product_filter`, {
                params: {
                    category_id: this.selected.category_id,
                    colors: this.selected.colors,
                    glasses: this.selected.glasses,
                    types: this.selected.types,
                    styles: this.selected.styles,
                    surfaces: this.selected.surfaces,
                }
            })
            .then(response => {
                this.types = response.data.types
                this.styles = response.data.styles
                this.surfaces = response.data.surfaces
                this.colors = response.data.colors
                this.glasses = response.data.glasses

                this.views.loading = false
            })
        },
        applyFilter() {
            this.emitter.emit('product-filter', this.selected)
        },
        resetFilter() {
            this.selected = JSON.parse(JSON.stringify(this.initialFilterParams))
        },
    },
    components: {
        PriceRangeSlider
    }
}
</script>
