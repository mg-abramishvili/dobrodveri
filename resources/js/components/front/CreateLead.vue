<template>
    <div class="lead-form">
        <span class="modal-title">{{ subject }}</span>

        <div class="mb-4">
            <label class="form-label">Имя</label>
            <input v-model="name" placeholder="Иван Иванов" type="text" class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label">Телефон</label>
            <input v-model="phone" placeholder="+7 999 123-45-67" type="text" class="form-control">
        </div>

        <div v-if="subject == 'Заказ замера'" class="mb-4">
            <label class="form-label">Адрес</label>
            <input v-model="message" type="text" class="form-control" />
        </div>

        <div v-if="subject == 'Сообщение директору'" class="mb-4">
            <label class="form-label">Сообщение</label>
            <textarea v-model="message" class="form-control form-control-textarea"></textarea>
        </div>

        <div v-if="subject == 'Заказ'" class="mb-4">
            <label class="form-label">Заказ</label>
            <textarea v-model="messageOrder" class="form-control form-control-textarea" disabled></textarea>
        </div>

        <button @click="save()" :disabled="!views.submitButton" class="btn btn-standard">Отправить</button>

        <div v-if="errors.length" class="alert alert-danger mb-4" role="alert">
            <span v-for="error in errors">
                {{ error }}<br>
            </span>
        </div>

        <div v-if="views.success" class="alert alert-success mb-4" role="alert">
            <span>Заявка успешно отправлена!</span>
        </div>

        <small>Нажимая кнопку «Отправить» вы соглашаетесь с <a href="/policy" target="_blank">политикой конфиденциальности</a></small>
    </div>
</template>

<script>
export default {
    props: ['subject', 'quiz', 'product', 'sku', 'params', 'size', 'price'],
    data() {
        return {
            name: '',
            phone: '',
            message: '',

            errors: [],

            views: {
                submitButton: true,
                success: false,
            }
        }
    },
    computed: {
        messageOrder() {
            if(this.subject == 'Заказ') {
                let msg = []
                let productName = this.product.name
                let productPrice = this.sku.price ? this.sku.price : this.product.price
                let paramsColor = this.sku.color.name
                let paramsInnerDecor = this.sku.inner_decor ? this.sku.inner_decor.name : null
                let paramsSize = this.size
                let paramsGlass = this.sku.glass ? this.sku.glass.name : null

                msg.push(productName)

                if(paramsColor) {
                    msg.push(paramsColor)
                }
                if(paramsGlass) {
                    msg.push(paramsGlass)
                }
                if(paramsInnerDecor) {
                    msg.push(paramsInnerDecor)
                }
                if(paramsSize) {
                    msg.push(paramsSize)
                }

                msg.push(productPrice + 'руб.')

                return msg.join(' ')
            }
        }
    },
    methods: {
        save() {
            this.errors = []

            if(!this.subject) {
                this.errors.push('Укажите тему')
            }
            if(!this.name) {
                this.errors.push('Укажите имя')
            }
            if(!this.phone) {
                this.errors.push('Укажите телефон')
            }

            if(this.subject == 'Заказ') {
                this.message = this.messageOrder
            }

            if(this.subject == 'Заявка по результату опроса') {
                this.message = JSON.stringify(this.quiz)
            }

            if(!this.message) {
                if(this.subject == 'Заказ замера' || this.subject == 'Обратный звонок') {
                    this.message = '-'
                }
            }

            if(this.errors.length) {
                return
            }

            this.views.submitButton = false

            axios.post('/lead', {
                subject: this.subject,
                name: this.name,
                phone: this.phone,
                message: this.message,
            })
            .then(response => {
                this.views.success = true

                this.name = ''
                this.phone = ''
                this.message = ''

                setTimeout(() => {
                    this.views.success = false
                    this.views.submitButton = true
                }, 5000)
            })
            .catch(errors => {
                this.errors.push('Что-то пошло не так :(')

                setTimeout(() => {
                    this.views.submitButton = true
                }, 1000)
            })
        }
    },
}
</script>
