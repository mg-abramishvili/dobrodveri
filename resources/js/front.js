import './bootstrap'

import { createApp } from 'vue'
import mitt from 'mitt'

import Products from './components/front/Products.vue'
import ProductSlider from './components/front/ProductSlider.vue'
import SelectColorAndGlass from './components/front/SelectColorAndGlass.vue'
import Lead from './components/front/Lead.vue'
import ProductReview from './components/front/ProductReview.vue'

const emitter = mitt()

const app = createApp({})

app.component('products', Products)
app.component('product-slider', ProductSlider)
app.component('select-color-glass', SelectColorAndGlass)
app.component('create-lead', Lead)
app.component('product-review', ProductReview)

app.config.globalProperties.emitter = emitter
app.mount('#front')