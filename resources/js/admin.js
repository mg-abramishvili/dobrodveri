import './bootstrap'

import { createApp } from 'vue'

import Router from './router'

import App from './components/admin/App.vue'

// Global Filters
import globalFilters from './globalFilters'

// Loader
import Loader from './components/admin/Loader.vue'

// SweetAlerts
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

// CKEditor
import CKEditor from '@ckeditor/ckeditor5-vue'

const app = createApp(App)
            .component('Loader', Loader)
            .use(Router)
            .use(VueSweetalert2)
            .use(CKEditor)

app.config.globalProperties.$filters = globalFilters

app.mount('#admin')