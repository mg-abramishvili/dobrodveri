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
                    <template v-if="editMode == true">{{ product.name }}</template>
                    <template v-else>Новый товар</template>
                </h1>
            </div>
            <div class="col-12 col-md-4 text-end">
                <button :disabled="views.saveButton == false"  @click="save()" class="btn btn-primary">Сохранить</button>
                <button v-if="editMode == true" @click="deactivate()" class="btn btn-outline-danger ms-2">Удалить</button>
            </div>
        </div>
    </div>
    
    <div v-if="!views.loading">
        <ul class="box-tabs">
            <li @click="selectTab('general')" :class="{ 'active' : views.currentTab == 'general'}">Общая информация</li>
            <li @click="selectTab('characteristics')" :class="{ 'active' : views.currentTab == 'characteristics'}">Характеристики</li>
            <li @click="selectTab('sizes')" :class="{ 'active' : views.currentTab == 'sizes'}">Размеры</li>
            <li v-if="editMode == true" @click="selectTab('variations')" :class="{ 'active' : views.currentTab == 'variations'}">Вариации</li>
            <li v-if="editMode == true" @click="selectTab('markers')" :class="{ 'active' : views.currentTab == 'markers'}">Галочки</li>
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
                    <div class="col-12 col-lg-6 mb-4">
                        <label class="form-label">Категория</label>
                        <select v-model="selected.category" class="form-select" :disabled="editMode == true">
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <label class="form-label">Цена</label>
                        <input v-model="price" type="number" min="0" class="form-control">
                    </div>
                    <div class="col-12 col-lg-3 mb-4">
                        <label class="form-label">Старая цена</label>
                        <input v-model="old_price" type="number" min="0" class="form-control" disabled>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Описание</label>
                    <ckeditor :editor="editor" v-model="description" :config="editorConfig"></ckeditor>
                </div>
            </div>
            
            <div v-show="views.currentTab == 'characteristics'" class="box-tab-content">
                <div class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Наличие</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.balance" class="form-select">
                            <option value="В наличии в Уфе">В наличии в Уфе</option>
                            <option value="3-7 дней">3-7 дней</option>
                            <option value="7-14 дней">7-14 дней</option>
                            <option value="15-30 дней">15-30 дней</option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 1" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Тип</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.type" class="form-select">
                            <option value="">Не выбрано</option>
                            <option v-for="type in types" :value="type.id" :key="type.id">
                                {{ type.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 1" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Стиль</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.style" class="form-select">
                            <option value="">Не выбрано</option>
                            <option v-for="style in styles" :value="style.id" :key="style.id">
                                {{ style.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Фабрика</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.factory" class="form-select">
                            <option value="">Не выбрано</option>
                            <option v-for="factory in factories" :value="factory.id" :key="factory.id">
                                {{ factory.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 1" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Покрытие</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.surface" class="form-select">
                            <option value="">Не выбрано</option>
                            <option v-for="surface in surfaces" :value="surface.id" :key="surface.id">
                                {{ surface.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 1" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Конструкция</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.construct" class="form-select">
                            <option value="">Не выбрано</option>
                            <option v-for="construct in constructs" :value="construct.id" :key="construct.id">
                                {{ construct.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Назначение двери</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.purpose" class="form-select">
                            <option value="">Не выбрано</option>
                            <option v-for="purpose in purposes" :value="purpose.id" :key="purpose.id">
                                {{ purpose.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Наполнение</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="napolnenie" class="form-select">
                            <option value="">Не выбрано</option>
                            <option value="Пенополистерол">Пенополистерол</option>
                            <option value="Базальтовая плита">Базальтовая плита</option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Толщина полотна</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <input v-model="tolschina_polotna" class="form-control">
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Толщина металла</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <input v-model="tolschina_metalla" class="form-control">
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Внутренняя панель</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <input v-model="vnutr_panel" class="form-control">
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Замок</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <input v-model="zamok" class="form-control">
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Терморазрыв</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="termorazryv" class="form-select">
                            <option value="">Не выбрано</option>
                            <option value="Да">Да</option>
                            <option value="Нет">Нет</option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Ночная задвижка</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="noch_zadvizh" class="form-select">
                            <option value="">Не выбрано</option>
                            <option value="Да">Да</option>
                            <option value="Нет">Нет</option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 2" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Ребра жесткости</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="rebra_zh" class="form-select">
                            <option value="">Не выбрано</option>
                            <option value="Да">Да</option>
                            <option value="Нет">Нет</option>
                        </select>
                    </div>
                </div>

                <div v-if="selected.category == 3" class="row align-items-center my-4">
                    <div class="col-12 col-lg-5">
                        <label class="form-label">Тип фурнитуры</label>
                    </div>
                    <div class="col-12 col-lg-7">
                        <select v-model="selected.furnituretype" class="form-select">
                            <option value="">Не выбрано</option>
                            <option v-for="furnituretype in furnituretypes" :value="furnituretype.id" :key="furnituretype.id">
                                {{ furnituretype.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div v-show="views.currentTab == 'sizes'" class="box-tab-content">
                <div v-for="size in sizes" class="form-check">
                    <input v-model="selected.sizes" class="form-check-input" type="checkbox" :value="size.id" :id="'size_' + size.id">
                    <label class="form-check-label" :for="'size_' + size.id">
                        {{ size.name }}
                    </label>
                </div>
            </div>

            <div v-show="views.currentTab == 'variations'" class="box-tab-content">
                <div class="mb-4">
                    <label class="form-label">Лицевая сторона металической двери</label>
                    <file-pond
                        name="vkhod_image"
                        ref="vkhod_image"
                        label-idle="Выбрать файл"
                        v-bind:allow-multiple="false"
                        v-bind:allow-reorder="false"
                        accepted-file-types="image/jpeg, image/png"
                        :server="server"
                        v-bind:files="filepond_vkhod_image_edit"
                    />
                </div>

                <div class="text-end">
                    <button v-if="!views.skuGenerator" @click="views.skuGenerator = true" class="btn btn-sm btn-outline-primary">Открыть Генератор</button>
                    <button v-if="views.skuGenerator" @click="views.skuGenerator = false" class="btn btn-sm btn-outline-primary">Закрыть Генератор</button>
                </div>
                <SkuGenerator v-if="views.skuGenerator" :product="product" />

                <div v-if="product.skus" class="mb-4">
                    <SkuItem v-for="sku in product.skus" :key="sku.id" :sku="sku" :product="product" />
                </div>
            </div>

            <div v-show="views.currentTab == 'markers'" class="box-tab-content">
                <div class="form-check">
                    <input v-model="hit" class="form-check-input" type="checkbox" id="hit">
                    <label class="form-check-label" for="hit">
                        Хит
                    </label>
                </div>

                <div class="form-check">
                    <input v-model="discount" class="form-check-input" type="checkbox" id="discount">
                    <label class="form-check-label" for="discount">
                        Скидка
                    </label>
                </div>

                <div class="form-check">
                    <input v-model="sale" class="form-check-input" type="checkbox" id="sale">
                    <label class="form-check-label" for="sale">
                        Распродажа
                    </label>
                </div>

                <div class="form-check">
                    <input v-model="special" class="form-check-input" type="checkbox" id="special">
                    <label class="form-check-label" for="special">
                        Акция
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SkuGenerator from './master/SkuGenerator.vue'
import SkuItem from './master/SkuItem.vue'

import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

import vueFilePond from "vue-filepond"
import "filepond/dist/filepond.min.css"
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview
)

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

            categories: [],
            types: [],
            styles: [],
            factories: [],
            surfaces: [],
            constructs: [],
            purposes: [],
            furnituretypes: [],
            colors: [],
            sizes: [],
            
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
            editorData: '',
            editorConfig: {
                toolbar: [ 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'insertTable', '|', 'undo', 'redo' ],
            },

            server: {
                remove(filename, load) {
                    load('1');
                },
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/_admin/file/upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function() {
                        if (request.status >= 200 && request.status < 300) {
                            load(request.responseText);
                        }
                        else {
                            error('oh no');
                        }
                    };
                    request.send(formData);
                    return {
                        abort: () => {
                            request.abort();
                            abort();
                        }
                    };
                },
                revert: (filename, load) => {
                    load(filename)
                },
                load: (source, load, error, progress, abort, headers) => {
                    var myRequest = new Request(source);
                    fetch(myRequest).then(function(response) {
                        response.blob().then(function(myBlob) {
                            load(myBlob)
                        });
                    });
                },
            },
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
        old_price() {
            if(this.product.factory && this.product.factory.coef) {
                return Math.ceil((parseInt(this.price) * 100 / (100 - parseInt(this.product.factory.coef)) / 10)) * 10
            } else {
                return this.price
            }
        },
    },
    created() {
        this.loadCategories()
    },
    methods: {
        loadCategories() {
            axios
            .get(`/_admin/categories`)
            .then(response => {
                this.categories = response.data

                this.loadTypes()
            })
        },
        loadTypes() {
            axios
            .get(`/_admin/types`)
            .then(response => {
                this.types = response.data

                this.loadFactories()
            })
        },
        loadFactories() {
            axios
            .get(`/_admin/factories`)
            .then(response => {
                this.factories = response.data

                this.loadSurfaces()
            })
        },
        loadPurposes() {
            axios
            .get(`/_admin/purposes`)
            .then(response => {
                this.purposes = response.data

                this.loadFurnitureTypes()
            })
        },
        loadFurnitureTypes() {
            axios
            .get(`/_admin/furnituretypes`)
            .then(response => {
                this.furnituretypes = response.data

                this.loadSizes()
            })
        },
        loadSizes() {
            axios
            .get(`/_admin/sizes`)
            .then(response => {
                this.sizes = response.data

                this.loadProduct()
            })
        },
        loadConstructs() {
            axios
            .get(`/_admin/constructs`)
            .then(response => {
                this.constructs = response.data

                this.loadStyles()
            })
        },
        loadSurfaces() {
            axios
            .get(`/_admin/surfaces`)
            .then(response => {
                this.surfaces = response.data

                this.loadConstructs()
            })
        },
        loadStyles() {
            axios
            .get(`/_admin/styles`)
            .then(response => {
                this.styles = response.data

                this.loadPurposes()
            })
        },
        loadProduct() {
            if(this.editMode == false) {
                this.views.saveButton = true
                return this.views.loading = false
            }

            axios
            .get(`/_admin/product/${this.$route.params.id}`)
            .then((response => {
                this.product = response.data
                this.name = response.data.name
                this.slug = response.data.slug
                this.price = response.data.price
                this.description = response.data.description
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

                if(response.data.hit == 1) { this.hit = true } else { this.hit = false }
                if(response.data.discount == 1) { this.discount = true } else { this.discount = false }
                if(response.data.sale == 1) { this.sale = true } else { this.sale = false }
                if(response.data.special == 1) { this.special = true } else { this.special = false }

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
            if(this.editMode == true) {
                if(document.getElementsByName("vkhod_image")[0]) {
                    this.vkhod_image = document.getElementsByName("vkhod_image")[0].value
                }

                this.skuItems = []
    
                this.product.skus.forEach(sku => {
                    if(document.querySelector(`#sku_${sku.id} input[name='image']`)) {
                        this.skuItems.push({ 'id': sku.id, 'image': document.querySelector(`#sku_${sku.id} input[name='image']`).value, 'price': document.querySelector(`#sku_${sku.id} input[name='price']`).value })
                    }
                })
            }

            if(!this.name) {
                return this.$swal({
                    text: 'Укажите название',
                    icon: 'error',
                })
            }
            if(!this.slug) {
                return this.$swal({
                    text: 'Укажите символьный код',
                    icon: 'error',
                })
            }
            if(!this.selected.category) {
                return this.$swal({
                    text: 'Укажите категорию',
                    icon: 'error',
                })
            }
            if(this.price <= 0) {
                return this.$swal({
                    text: 'Укажите цену',
                    icon: 'error',
                })
            }

            this.views.saveButton = false

            let data = {
                name: this.name,
                slug: this.slug,
                price: this.price,
                old_price: this.old_price,
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

            if(this.editMode == false) {
                axios.post(`/_admin/products`, data)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Products' })
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
            }

            if(this.editMode == true) {
                axios.put(`/_admin/product/${this.$route.params.id}/update`, data)
                .then(response => {
                    this.views.saveButton = true
                    this.$router.push({ name: 'Products' })
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
            }
        },
        deactivate() {
            if (confirm("Точно удалить?")) {
                axios.put(`/_admin/product/${this.$route.params.id}/deactivate`)
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
    components: {
        SkuGenerator,
        SkuItem,
        FilePond
    }
}
</script>