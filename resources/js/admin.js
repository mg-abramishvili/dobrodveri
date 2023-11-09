import './bootstrap'

import { createApp } from 'vue'
import Router from './admin-router'

import App from './components/admin/App.vue'

import Loader from './components/admin/Loader.vue'

const app = createApp(App).component('Loader', Loader).use(Router)

// app.config.globalProperties.$filters = {
//     datetime(date) {
//         return moment.utc(date).utcOffset(3).format('DD.MM.YYYY H:mm')
//     },
//     date(date) {
//         return moment.utc(date).utcOffset(3).format('DD.MM.YYYY')
//     },
// }

app.mount('#admin')