// dayjs
import dayjs from 'dayjs'
import 'dayjs/locale/ru'
import utc from 'dayjs/plugin/utc'
dayjs.extend(utc)

export default {
    date(date) {
        return dayjs(date).locale('ru').utcOffset(5).format('DD-MM-YYYY H:mm')
    },
    currency(value) {
        if (!value) return '0'
        return parseInt(value).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' ₽' 
    },
    currencyWithoutRubSign(value) {
        if (!value) return '0'
        return parseInt(value).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    },
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
      
        return n_str.join('').replace(/\s+/g, '-').toLocaleLowerCase()
    },
    SkuUrl(sku) {
        let urlInitial = '/product/' + sku.slug
        let urlParams = []

        if(sku.color) {
            urlParams.push('&color=' + sku.color.slug)
        }
        if(sku.glass) {
            urlParams.push('&glass=' + sku.glass.slug)
        }

        if(urlParams.length) {
            return urlInitial + '?' + urlParams.join("")
        }

        return urlInitial
    },
}