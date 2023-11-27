<template>
    <div class="quiz">{{ quizResult }}
        <div v-show="currentQuestion == question.id" v-for="question in questions" class="quiz-question">
            <h5>{{ question.title }}</h5>
            <ul>
                <li @click="selectAnswer(question, answer)" v-for="answer in question.answers" :class="{'active': isAnswerIsActive(question, answer)}">{{ answer.title }}</li>
            </ul>

            <button v-if="currentQuestion != 1" @click="prevQuestion()">Назад</button>
            <button @click="nextQuestion()">Дальше</button>
        </div>

        <div v-show="currentQuestion == 100" class="quiz-form">
            <button @click="prevQuestion()">Назад</button>

            <CreateLead :subject="'Квиз'" :quiz="quizResult" />
        </div>
    </div>
</template>

<script>
import CreateLead from './CreateLead.vue'

export default {
    data() {
        return {
            currentQuestion: 1,

            questions: [
                {
                    id: 1,
                    title: 'Куда требуются двери?',
                    multipleAnswer: false,
                    answers: [
                        {
                            title: 'В квартиру',
                            image: null,
                        },
                        {
                            title: 'В офис',
                            image: null,
                        },
                        {
                            title: 'В частный дом',
                            image: null,
                        }
                    ],
                },
                {
                    id: 2,
                    title: 'Какие двери вам нужны?',
                    multipleAnswer: true,
                    answers: [
                        {
                            title: 'Межкомнатные двери',
                            image: null,
                        },
                        {
                            title: 'Входная дверь',
                            image: null,
                        },
                        {
                            title: 'Скрытая дверь',
                            image: null,
                        },
                        {
                            title: 'Другое',
                            image: null,
                        }
                    ],
                },
                {
                    id: 3,
                    title: 'Двери какого оттенка хотите?',
                    multipleAnswer: false,
                    answers: [
                        {
                            title: 'Светлые двери',
                            image: null,
                        },
                        {
                            title: 'Темные дверь',
                            image: null,
                        },
                        {
                            title: 'Другое',
                            image: null,
                        }
                    ],
                },
                {
                    id: 4,
                    title: 'Какое количество дверей необходимо?',
                    multipleAnswer: false,
                    answers: [
                        {
                            title: '1',
                            image: null,
                        },
                        {
                            title: '2',
                            image: null,
                        },
                        {
                            title: '3',
                            image: null,
                        },
                        {
                            title: '4 и более',
                            image: null,
                        }
                    ],
                },
                {
                    id: 5,
                    title: 'Нужен ли Вам выезд замерщика?',
                    multipleAnswer: false,
                    answers: [
                        {
                            title: 'Да, было бы удобно',
                            image: null,
                        },
                        {
                            title: 'Нет, замер есть',
                            image: null,
                        },
                    ],
                },
                {
                    id: 6,
                    title: 'Когда нужно установить двери?',
                    multipleAnswer: false,
                    answers: [
                        {
                            title: 'Через 2-3 дня',
                            image: null,
                        },
                        {
                            title: 'На этой неделе',
                            image: null,
                        },
                        {
                            title: 'На следующей неделе',
                            image: null,
                        },
                        {
                            title: 'В течение месяца',
                            image: null,
                        },
                        {
                            title: 'Еще не определился(-ась)',
                            image: null,
                        },
                    ],
                }
            ],

            name: '',
            tel: '',
            quizResult: [],
        }
    },
    methods: {
        prevQuestion() {
            if(this.currentQuestion == 100) {
                return this.currentQuestion = this.questions[this.questions.length - 1].id
            }

            let prevQuestion = this.questions.find(q => q.id == this.currentQuestion - 1)

            if(prevQuestion) {
                this.currentQuestion = prevQuestion.id
            }
        },
        nextQuestion() {
            let nextQuestion = this.questions.find(q => q.id == this.currentQuestion + 1)

            if(nextQuestion) {
                this.currentQuestion = nextQuestion.id
            } else {
                this.currentQuestion = 100
            }
        },
        selectAnswer(question, answer) {
            let quizResultQuestion = this.quizResult.find(q => q.id == question.id)

            if(!quizResultQuestion) {
                return this.quizResult.push({
                    id: question.id,
                    questionTitle: question.title,
                    answer: question.multipleAnswer ? answer.title.split(",") : answer.title
                })
            }

            if(!question.multipleAnswer) {
                quizResultQuestion.answer = answer.title
            }

            if(question.multipleAnswer) {
                if(Array.isArray(quizResultQuestion.answer) && quizResultQuestion.answer.length) {
                    if(quizResultQuestion.answer.find(a => a == answer.title)) {
                        quizResultQuestion.answer = quizResultQuestion.answer.filter(a => a != answer.title)
                    } else {
                        quizResultQuestion.answer.push(answer.title)
                    }
                } else {
                    quizResultQuestion.answer = []
                    quizResultQuestion.answer.push(answer.title)
                }
            }
        },
        isAnswerIsActive(question, answer) {
            let quizResultQuestion = this.quizResult.find(q => q.id == question.id)

            if(!quizResultQuestion) {
                return
            }

            if(question.multipleAnswer) {
                if(Array.isArray(quizResultQuestion.answer) && quizResultQuestion.answer.length) {
                    if(quizResultQuestion.answer.find(a => a == answer.title)) {
                        return true
                    }
                }
            }

            if(!question.multipleAnswer) {
                if(quizResultQuestion && quizResultQuestion.answer == answer.title) {
                    return true
                }
            }

            return false
        },
    },
    components: {
        CreateLead
    }
}
</script>

<style scoped>
    .active {
        border: 2px solid red;
    }
</style>