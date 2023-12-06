import './bootstrap'

import { createApp } from 'vue'

import Router from './router'

import App from './components/admin/App.vue'

// Global Filters
import globalFilters from './globalFilters'

// Loader
import Loader from './components/admin/Loader.vue'

// Vue Toast Notification
import ToastPlugin from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-default.css'

// CKEditor
import CKEditor from '@ckeditor/ckeditor5-vue'

const app = createApp(App)
            .component('Loader', Loader)
            .use(Router)
            .use(CKEditor)
            .use(ToastPlugin, {
                position: 'top'
            })

app.config.globalProperties.$filters = globalFilters

app.mount('#admin')