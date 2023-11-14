<template>
    <div class="review_form">
        <div v-if="errors.length" class="alert alert-danger mb-4" role="alert">
            <span v-for="error in errors">
                {{ error }}<br>
            </span>
        </div>

        <div v-if="views.success" class="alert alert-success mb-4" role="alert">
            <span>Спасибо за ваш отзыв!</span>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Имя:</label>
                    <input v-model="name" type="text" class="form-control" placeholder="Имя">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="mb-3">
                    <label class="form-label">Оценка:</label><br/>
                    <div class="form-check form-check-inline">
                        <input v-model="rating" class="form-check-input" type="radio" id="review_star1" value="1">
                        <label class="form-check-label" for="review_star1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input v-model="rating" class="form-check-input" type="radio" id="review_star2" value="2">
                        <label class="form-check-label" for="review_star2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input v-model="rating" class="form-check-input" type="radio" id="review_star3" value="3">
                        <label class="form-check-label" for="review_star3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input v-model="rating" class="form-check-input" type="radio" id="review_star4" value="4">
                        <label class="form-check-label" for="review_star4">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input v-model="rating" class="form-check-input" type="radio" id="review_star5" value="5">
                        <label class="form-check-label" for="review_star5">5</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Отзыв:</label>
            <textarea v-model="text" class="form-control" placeholder="Отзыв"></textarea>
        </div>

        <button @click="save()" :disabled="!views.submitButton" class="btn btn-standard">Отправить отзыв</button>
    </div>
</template>

<script>
export default {
    props: ['product_id'],
    data() {
        return {
            name: '',
            rating: '',
            text: '',

            errors: [],

            views: {
                submitButton: true,
                success: false,
            }
        }
    },
    methods: {
        save() {
            this.errors = []
            
            if(!this.name) {
                this.errors.push('Укажите имя')
            }
            if(!this.rating) {
                this.errors.push('Укажите рейтинг')
            }
            if(!this.text) {
                this.errors.push('Напишите отзыв')
            }

            if(this.errors.length) {
                return
            }

            this.views.submitButton = false

            axios.post('/review', {
                name: this.name,
                rating: this.rating,
                text: this.text,
                product_id: this.product_id,
            })
            .then(response => {
                this.views.success = true

                this.name = ''
                this.rating = ''
                this.text = ''

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
