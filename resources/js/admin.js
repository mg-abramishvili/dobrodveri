import './bootstrap'

import { createApp } from 'vue'
import Router from './router'

import App from './components/admin/App.vue'

import Loader from './components/admin/Loader.vue'

// SweetAlerts
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'

import moment from 'moment'

const app = createApp(App)
            .component('Loader', Loader)
            .use(Router)
            .use(VueSweetalert2)

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
    datetime(date) {
        return moment.utc(date).utcOffset(5).format('DD.MM.YYYY H:mm')
    },
    date(date) {
        return moment.utc(date).utcOffset(5).format('DD.MM.YYYY')
    },
}

app.mount('#admin')