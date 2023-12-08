import './bootstrap'

import { createApp } from 'vue'

// Global Filters
import globalFilters from './globalFilters'

import mitt from 'mitt'

import Products from './components/front/Products.vue'
import ProductsFilter from './components/front/ProductsFilter.vue'
import ProductsOrder from './components/front/ProductsOrder.vue'
import ProductSlider from './components/front/ProductSlider.vue'
import SelectColorAndGlass from './components/front/SelectColorAndGlass.vue'
import CreateLead from './components/front/CreateLead.vue'
import CreateProductReview from './components/front/CreateProductReview.vue'
import Favorites from './components/front/Favorites.vue'
import FavoritesCounter from './components/front/FavoritesCounter.vue'
import AddToFavorites from './components/front/AddToFavorites.vue'
import Quiz from './components/front/Quiz.vue'

const emitter = mitt()

const app = createApp({})

app.component('products-filter', ProductsFilter)
app.component('products-order', ProductsOrder)
app.component('products', Products)
app.component('product-slider', ProductSlider)
app.component('select-color-glass', SelectColorAndGlass)
app.component('create-lead', CreateLead)
app.component('create-product-review', CreateProductReview)
app.component('favorites', Favorites)
app.component('favorites-counter', FavoritesCounter)
app.component('add-to-favorites', AddToFavorites)
app.component('quiz', Quiz)

app.config.globalProperties.$filters = globalFilters
app.config.globalProperties.emitter = emitter
app.mount('#front')