<template>
    <Loader v-if="views.loading"></Loader>

    <div v-if="!views.loading" class="subheader w-100">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <h1>
                    <router-link :to="{ name: 'Products' }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                        </svg>
                    </router-link>
                    <template v-if="editMode">{{ product.name }}</template>
                    <template v-else>Новый товар</template>
                </h1>
            </div>
            <div class="col-12 col-md-4 text-end">
                <button :disabled="!views.saveButton"  @click="save()" class="btn btn-primary">Сохранить</button>
                <button v-if="editMode" @click="deactivate()" class="btn btn-outline-danger ms-2">Удалить</button>
            </div>
        </div>
    </div>
    
    <div v-if="!views.loading">
        <ul class="box-tabs">
            <li @click="selectTab('general')" :class="{ 'active' : views.currentTab == 'general'}">Общая информация</li>
            <li @click="selectTab('characteristics')" :class="{ 'active' : views.currentTab == 'characteristics'}">Характеристики</li>
            <li @click="selectTab('sizes')" :class="{ 'active' : views.currentTab == 'sizes'}">Размеры</li>
            <li v-if="editMode" @click="selectTab('variations')" :class="{ 'active' : views.currentTab == 'variations'}">Вариации</li>
            <li v-if="editMode" @click="selectTab('markers')" :class="{ 'active' : views.currentTab == 'markers'}">Галочки</li>
        </ul>
        <div class="box px-4 py-4 mb-4">
            <div v-show="views.currentTab == 'general'" class="box-tab-content">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-4">
                        <label class="form-label">Наименование</label>
                        <input v-model="name" @change="slugify()" type="text" class="form-control">
                    </div>
                    <div class="col-12 col-lg-6 mb-4">
                        <label class="form-label">Символьный код</label>
                        <input v-model="slug" type="text" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <SelectCategory />

                    <div class="col-12 col-lg-3 mb-4">
                        <label class="form-label">Цена</label>
                        <input v-model="price" type="number" min="0" class="form-control">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Описание</label>
                    <ckeditor :editor="editor" v-model="description" :config="editorConfig"></ckeditor>
                </div>
            </div>
            
            <div v-show="views.currentTab == 'characteristics'" class="box-tab-content">
                <SelectBalance />

                <SelectType v-if="selected.category && selected.category == 1" />

                <SelectStyle v-if="selected.category && selected.category == 1" />
                
                <SelectFactory />

                <SelectSurface v-if="selected.category && selected.category == 1" />

                <SelectConstruct v-if="selected.category && selected.category == 1" />

                <SelectPurpose v-if="selected.category && selected.category == 2" />

                <MetalDoorAttributes v-if="selected.category && selected.category == 2" />

                <SelectFurnitureType v-if="selected.category && selected.category == 3" />
            </div>

            <div v-show="views.currentTab == 'sizes'" class="box-tab-content">
                <SelectSizes v-if="selected.category" />
            </div>

            <div v-show="views.currentTab == 'variations'" class="box-tab-content">
                <div v-if="selected.category && selected.category == 2" class="mb-4">
                    <label class="form-label">Лицевая сторона металической двери</label>
                    <file-pond
                        name="vkhod_image"
                        ref="vkhod_image"
                        label-idle="Выбрать файл"
                        v-bind:allow-multiple="false"
                        v-bind:allow-reorder="false"
                        accepted-file-types="image/jpeg, image/png"
                        :server="filepondServer"
                        v-bind:files="filepond_vkhod_image_edit"
                    />
                </div>

                <div class="text-end">
                    <button v-if="!views.skuGenerator" @click="views.skuGenerator = true" class="btn btn-sm btn-outline-primary">Открыть Генератор</button>
                    <button v-if="views.skuGenerator" @click="views.skuGenerator = false" class="btn btn-sm btn-outline-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </button>
                </div>
                <SkuGenerator v-if="views.skuGenerator" :product="product" />

                <div v-if="product.skus" class="mb-4">
                    <draggable 
                        :list="product.skus"
                        :force-fallback="true"
                        ghost-class="ghost"
                        @change="onOrderChange"
                        item-key="id">
                        <template #item="{element}">
                            <SkuItem :sku="element" :product="product" />
                        </template>
                    </draggable>
                </div>
            </div>

            <div v-show="views.currentTab == 'markers'" class="box-tab-content">
                <Markers />
            </div>
        </div>
    </div>
</template>

<script>
import SelectCategory from './master/SelectCategory.vue'
import SelectType from './master/SelectType.vue'
import SelectBalance from './master/SelectBalance.vue'
import SelectFactory from './master/SelectFactory.vue'
import SelectPurpose from './master/SelectPurpose.vue'
import SelectSizes from './master/SelectSizes.vue'
import SelectStyle from './master/SelectStyle.vue'
import SelectConstruct from './master/SelectConstruct.vue'
import SelectSurface from './master/SelectSurface.vue'
import SelectFurnitureType from './master/SelectFurnitureType.vue'
import MetalDoorAttributes from './master/MetaDoorAttributes.vue'
import Markers from './master/Markers.vue'
import SkuGenerator from './master/SkuGenerator.vue'
import SkuItem from './master/SkuItem.vue'

import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

import vueFilePond from "vue-filepond"
import "filepond/dist/filepond.min.css"
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"

import FilepondServer from '../FilepondServer.js'

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
)

import draggable from 'vuedraggable'

export default {
    data() {
        return {
            product: {},

            name: '',
            slug: '',
            description: '',
            price: 0,

            hit: '',
            discount: '',
            sale: '',
            special: '',
            
            selected: {
                category: '',
                type: '',
                style: '',
                factory: '',
                surface: '',
                construct: '',
                purpose: '',
                furnituretype: '',
                sizes: [],
                balance: '',
            },

            vkhod_image: '',
            filepond_vkhod_image: [],
            filepond_vkhod_image_edit: [],
            napolnenie: '',
            tolschina_polotna: '',
            tolschina_metalla: '',
            vnutr_panel: '',
            zamok: '',
            termorazryv: '',
            noch_zadvizh: '',
            rebra_zh: '',

            skuItems: [],

            views: {
                loading: true,
                currentTab: 'general',
                skuGenerator: false,
                saveButton: false,
            },

            editor: ClassicEditor,
            editorConfig: {
                toolbar: [ 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo' ],
            },

            filepondServer: FilepondServer(),
        };
    },
    computed: {
        editMode() {
            if(this.$route.params.id) {
                return true
            }

            if(!this.$route.params.id) {
                return false
            }
        },
    },
    created() {
        this.loadProduct()
    },
    methods: {
        loadProduct() {
            if(!this.editMode) {
                this.views.saveButton = true

                return this.views.loading = false
            }

            axios.get(`/_admin/product/${this.$route.params.id}`)
            .then((response => {
                this.product = response.data
                this.name = response.data.name
                this.slug = response.data.slug
                this.price = response.data.price
                this.description = response.data.description ? response.data.description : ''
                this.selected.category = response.data.category_id
                this.selected.style = response.data.style_id
                this.selected.type = response.data.type_id
                this.selected.factory = response.data.factory_id
                this.selected.construct = response.data.construct_id
                this.selected.purpose = response.data.purpose_id
                this.selected.furnituretype = response.data.furniture_type_id
                this.vkhod_image = response.data.vkhod_image,
                this.napolnenie = response.data.napolnenie,
                this.tolschina_polotna = response.data.tolschina_polotna,
                this.tolschina_metalla = response.data.tolschina_metalla,
                this.vnutr_panel = response.data.vnutr_panel,
                this.zamok = response.data.zamok,
                this.termorazryv = response.data.termorazryv,
                this.noch_zadvizh = response.data.noch_zadvizh,
                this.rebra_zh = response.data.rebra_zh,
                this.selected.balance = response.data.balance,
                this.selected.surface = response.data.surface_id
                this.selected.sizes = response.data.sizes.map(size => size.id)

                this.hit = response.data.hit == 1 ? response.data.hit = true : false
                this.discount = response.data.discount == 1 ? response.data.discount = true : false
                this.sale = response.data.sale == 1 ? response.data.sale = true : false
                this.special = response.data.special == 1 ? response.data.special = true : false

                if(response.data.vkhod_image) {
                    this.filepond_vkhod_image_edit = [
                        {
                            source: response.data.vkhod_image,
                            options: {
                                type: 'local',
                            }
                        }
                    ]
                }

                this.views.loading = false
                this.views.saveButton = true
            }))
        },
        selectTab(tab) {
            this.views.currentTab = tab
        },
        addSKU() {
            this.skus.push({
                color: ''
            })
        },
        slugify() {
            if(this.name) {
                this.slug = this.$filters.slugify(this.name)
            }
        },
        save() {
            if(this.editMode) {
                if(document.getElementsByName("vkhod_image")[0]) {
                    this.vkhod_image = document.getElementsByName("vkhod_image")[0].value
                }

                this.skuItems = []
    
                this.product.skus.forEach(sku => {
                    if(document.querySelector(`#sku_${sku.id} input[name='image']`)) {
                        this.skuItems.push({ 'id': sku.id, 'order': sku.order, 'image': document.querySelector(`#sku_${sku.id} input[name='image']`).value, 'price': document.querySelector(`#sku_${sku.id} input[name='price']`).value })
                    }
                })
            }

            if(!this.name) {
                return this.$toast.error('Укажите название')
            }
            if(!this.slug) {
                return this.$toast.error('Укажите символьный код')
            }
            if(!this.selected.category) {
                return this.$toast.error('Укажите категорию')
            }
            if(this.price <= 0) {
                return this.$toast.error('Укажите цену')
            }

            this.views.saveButton = false
            this.views.loading = true

            let data = {
                name: this.name,
                slug: this.slug,
                price: this.price,
                category: this.selected.category,
                type: this.selected.type,
                surface: this.selected.surface,
                style: this.selected.style,
                factory: this.selected.factory,
                construct: this.selected.construct,
                purpose: this.selected.purpose,
                furnituretype: this.selected.furnituretype,
                description: this.description,
                sizes: this.selected.sizes,
                hit: this.hit,
                discount: this.discount,
                sale: this.sale,
                special: this.special,
                sku_items: this.skuItems,
                vkhod_image: this.vkhod_image,
                napolnenie: this.napolnenie,
                tolschina_polotna: this.tolschina_polotna,
                tolschina_metalla: this.tolschina_metalla,
                vnutr_panel: this.vnutr_panel,
                zamok: this.zamok,
                termorazryv: this.termorazryv,
                noch_zadvizh: this.noch_zadvizh,
                rebra_zh: this.rebra_zh,
                balance: this.selected.balance,
            }

            if(!this.editMode) {
                axios.post(`/_admin/products`, data)
                .then(response => {
                    window.location.href = '/admin/product-master/' + response.data + '/'
                })
                .catch(errors => {
                    this.views.saveButton = true
                    this.views.loading = false

                    return this.$toast.error(errors.response.data ? errors.response.data : errors)
                })
            }

            if(this.editMode) {
                axios.put(`/_admin/product/${this.$route.params.id}/update`, data)
                .then(response => {
                    this.views.saveButton = true
                    this.views.loading = false
                })
                .catch(errors => {
                    this.views.saveButton = true
                    this.views.loading = false

                    return this.$toast.error(errors.response.data ? errors.response.data : errors)
                })
            }
        },
        deactivate() {
            if (confirm("Товар будет перенесён в раздел Удаленные. Продолжить?")) {
                axios.put(`/_admin/product/${this.$route.params.id}/deactivate`)
                .then(response => {
                    this.$router.push({ name: 'Products' })
                })
                .catch(errors => {
                    return this.$toast.error(errors.response.data ? errors.response.data : errors)
                })
            }
        },
        onOrderChange() {
            this.product.skus.forEach((sku, index) => (sku.order = index))
        },
    },
    components: {
        SelectType,
        SelectCategory,
        SelectBalance,
        SelectFactory,
        SelectPurpose,
        SelectSizes,
        SelectStyle,
        SelectConstruct,
        SelectSurface,
        SelectFurnitureType,
        MetalDoorAttributes,
        Markers,
        SkuGenerator,
        SkuItem,
        FilePond,
        draggable
    }
}
</script>