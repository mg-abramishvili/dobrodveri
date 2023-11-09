import './bootstrap'

import { createApp } from 'vue'

import Router from './router'

import App from './components/admin/App.vue'

// Loader
import Loader from './components/admin/Loader.vue'

// SweetAlerts
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

// CKEditor
import CKEditor from '@ckeditor/ckeditor5-vue'

// dayjs
import dayjs from 'dayjs'
import 'dayjs/locale/ru'
import utc from 'dayjs/plugin/utc'
dayjs.extend(utc)

const app = createApp(App)
            .component('Loader', Loader)
            .use(Router)
            .use(VueSweetalert2)
            .use(CKEditor)

app.config.globalProperties.$dayjs = dayjs

app.config.globalProperties.$filters = {
    slugify(str) {
        let ru = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 
            'е': 'e', 'ё': 'e', 'ж': 'zh', 'з': 'z', 'и': 'i', 
            'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 
            'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 
            'ф': 'f', 'х': 'kh', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 
            'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'yu', 'я': 'ya'
        }, n_str = [];

        str = str.replace(/[ъь!|/|_\\'"<>/№;%:?*()@#$^&*+=,~.]+/g, '').replace(/й/g, 'i');
  
        for (let i = 0; i < str.length; ++i) {
            n_str.push(
                ru[str[i]] || ru[str[i].toLowerCase()] == undefined && str[i] || ru[str[i].toLowerCase()]
            )
        }
      
        return n_str.join('').replace(/\s+/g, '-')
    },
}

app.mount('#admin')