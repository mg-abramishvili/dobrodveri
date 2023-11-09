import './bootstrap'

import { createApp } from 'vue'
import mitt from 'mitt'

import CatalogCategory from './components/front/CatalogCategory'
import ProductSlider from './components/front/ProductSlider'
import SelectColorAndGlass from './components/front/SelectColorAndGlass'
import Lead from './components/front/Lead'
import ProductReview from './components/front/ProductReview'

const emitter = mitt()

const app = createApp({})

app.component('catalog-category', CatalogCategory)
app.component('product-slider', ProductSlider)
app.component('select-color-glass', SelectColorAndGlass)
app.component('create-lead', Lead)
app.component('product-review', ProductReview)

app.config.globalProperties.emitter = emitter
app.mount('#app')