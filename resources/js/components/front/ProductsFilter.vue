<template>
    <div class="filter-inner" :class="{'filter-inner-overlay': views.loading }">
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
                            <img :src="color.image" :alt="color.name"/> {{ color.name }} <small v-if="color.skus_count > 0">{{ color.skus_count }}</small>
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
                            <img :src="glass.image" :alt="glass.name"/> {{ glass.name }} <small v-if="glass.skus_count > 0">{{ glass.skus_count }}</small>
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

        <div v-if="category_id == 2" class="filter-box">
            <p>Внутренняя отделка</p>
            
            <div class="filter-box-list">
                <template v-for="innerdecor in innerdecors">
                    <div class="form-check">
                        <input v-model="selected.innerdecors" class="form-check-input" type="checkbox" :value="innerdecor.slug" :id="'innerdecor_' + innerdecor.slug" :disabled="innerdecor.skus_count == 0">
                        <label class="form-check-label" :class="{ 'form-check-label-disabled': innerdecor.skus_count == 0 }" :for="'innerdecor_' + innerdecor.slug">
                            {{ innerdecor.name }} <small>{{ innerdecor.skus_count }}</small>
                        </label>
                    </div>
                </template>
            </div>
        </div>

        <div v-if="category_id == 2" class="filter-box">
            <p>Назначение двери</p>
            
            <div class="filter-box-list">
                <template v-for="purpose in purposes">
                    <div class="form-check">
                        <input v-model="selected.purposes" class="form-check-input" type="checkbox" :value="purpose.slug" :id="'purpose_' + purpose.slug" :disabled="purpose.skus_count == 0">
                        <label class="form-check-label" :class="{ 'form-check-label-disabled': purpose.skus_count == 0 }" :for="'purpose_' + purpose.slug">
                            {{ purpose.name }} <small>{{ purpose.skus_count }}</small>
                        </label>
                    </div>
                </template>
            </div>
        </div>

        <div v-if="category_id == 3" class="filter-box">
            <p>Тип фурнитуры</p>
            
            <div class="filter-box-list">
                <template v-for="furnituretype in furnituretypes">
                    <div class="form-check">
                        <input v-model="selected.furnituretypes" class="form-check-input" type="checkbox" :value="furnituretype.slug" :id="'furnituretype_' + furnituretype.slug" :disabled="furnituretype.skus_count == 0">
                        <label class="form-check-label" :class="{ 'form-check-label-disabled': furnituretype.skus_count == 0 }" :for="'furnituretype_' + furnituretype.slug">
                            {{ furnituretype.name }} <small>{{ furnituretype.skus_count }}</small>
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
    </div>
</template>

<script>
import PriceRangeSlider from './PriceRangeSlider.vue'

export default {
    props: [
        'category_id',
        'category_slug',
        'req_order',
        'req_price_from',
        'req_price_to',
        'req_type',
        'req_style',
        'req_color',
        'req_glass',
        'req_surface',
        'req_innerdecor',
        'req_purpose',
        'req_furnituretype',
    ],
    data() {
        return {
            types: [],
            styles: [],
            colors: [],
            glasses: [],
            surfaces: [],
            innerdecors: [],
            purposes: [],
            furnituretypes: [],

            selected: {},

            initialFilterParams: {
                category_id: this.category_id,
                order: 'price_asc',
                price_from: 0,
                price_to: 100000,
                types: [],
                styles: [],
                colors: [],
                glasses: [],
                surfaces: [],
                innerdecors: [],
                purposes: [],
                furnituretypes: [],
            },

            views: {
                loading: true,
            }
        }
    },
    created() {
        this.selected = JSON.parse(JSON.stringify(this.initialFilterParams))

        this.loadRequestedFilterParams()
    },
    mounted() {
        this.$watch('selected', function() {
            this.loadFilter()
        }, {
            deep: true
        })
    },
    methods: {
        loadRequestedFilterParams() {
            if(this.req_order) {
                this.selected.order = this.req_order
            }

            if(this.req_price_from) {
                this.selected.price_from = this.req_price_from
            }
            
            if(this.req_price_to) {
                this.selected.price_to = this.req_price_to
            }

            if(this.req_type && this.req_type.split(',').length) {
                this.req_type.split(',').forEach(c => {
                    this.selected.types.push(c)
                })
            }

            if(this.req_style && this.req_style.split(',').length) {
                this.req_style.split(',').forEach(c => {
                    this.selected.styles.push(c)
                })
            }
            
            if(this.req_color && this.req_color.split(',').length) {
                this.req_color.split(',').forEach(c => {
                    this.selected.colors.push(c)
                })
            }

            if(this.req_glass && this.req_glass.split(',').length) {
                this.req_glass.split(',').forEach(c => {
                    this.selected.glasses.push(c)
                })
            }

            if(this.req_surface && this.req_surface.split(',').length) {
                this.req_surface.split(',').forEach(c => {
                    this.selected.surfaces.push(c)
                })
            }

            if(this.req_innerdecor && this.req_innerdecor.split(',').length) {
                this.req_innerdecor.split(',').forEach(c => {
                    this.selected.innerdecors.push(c)
                })
            }

            if(this.req_purpose && this.req_purpose.split(',').length) {
                this.req_purpose.split(',').forEach(c => {
                    this.selected.purposes.push(c)
                })
            }

            if(this.req_furnituretype && this.req_furnituretype.split(',').length) {
                this.req_furnituretype.split(',').forEach(c => {
                    this.selected.furnituretypes.push(c)
                })
            }

            this.loadFilter()
        },
        loadFilter() {
            this.views.loading = true

            axios.get(`/_product_filter`, {
                params: {
                    category_id: this.selected.category_id,
                    types: this.selected.types,
                    styles: this.selected.styles,
                    colors: this.selected.colors,
                    glasses: this.selected.glasses,
                    surfaces: this.selected.surfaces,
                    innerdecors: this.selected.innerdecors,
                    purposes: this.selected.purposes,
                    furnituretypes: this.selected.furnituretypes,
                }
            })
            .then(response => {
                this.types = response.data.types,
                this.styles = response.data.styles,
                this.colors = response.data.colors,
                this.glasses = response.data.glasses,
                this.surfaces = response.data.surfaces,
                this.innerdecors = response.data.innerdecors,
                this.purposes = response.data.purposes,
                this.furnituretypes = response.data.furnituretypes,

                this.views.loading = false
            })
        },
        applyFilter() {
            this.emitter.emit('product-filter', this.selected)

            this.genURL()
        },
        resetFilter() {
            window.location.href = '/catalog/' + this.category_slug + '/'
        },
        genURL() {
            let filterParamsURL = []

            if(this.selected.types.length) {
                filterParamsURL.push('&type=' + this.selected.types.join(','))
            }

            if(this.selected.styles.length) {
                filterParamsURL.push('&style=' + this.selected.styles.join(','))
            }

            if(this.selected.colors.length) {
                filterParamsURL.push('&color=' + this.selected.colors.join(','))
            }

            if(this.selected.glasses.length) {
                filterParamsURL.push('&glass=' + this.selected.glasses.join(','))
            }

            if(this.selected.surfaces.length) {
                filterParamsURL.push('&surface=' + this.selected.surfaces.join(','))
            }

            if(this.selected.innerdecors.length) {
                filterParamsURL.push('&innerdecor=' + this.selected.innerdecors.join(','))
            }

            if(this.selected.purposes.length) {
                filterParamsURL.push('&purpose=' + this.selected.purposes.join(','))
            }

            if(this.selected.furnituretypes.length) {
                filterParamsURL.push('&furnituretype=' + this.selected.furnituretypes.join(','))
            }

            if(this.selected.price_from.length) {
                filterParamsURL.push('&price_from=' + this.selected.price_from)
            }

            if(this.selected.price_to.length) {
                filterParamsURL.push('&price_to=' + this.selected.price_to)
            }

            if(this.selected.order.length) {
                filterParamsURL.push('&order=' + this.selected.order)
            }

            history.pushState(null, null, '?' + filterParamsURL.join(""))
        },
    },
    components: {
        PriceRangeSlider
    }
}
</script>
