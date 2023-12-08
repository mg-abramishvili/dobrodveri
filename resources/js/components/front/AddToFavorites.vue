<template>
    <button v-if="!SkuInFavorites" @click="addToFavorites()" :disabled="!views.addToFavoritesButton">
        <template v-if="views.addToFavoritesButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
            </svg>
        </template>

        <template v-if="!views.addToFavoritesButton">
            <LoaderSpinner />
        </template>
    </button>
        
    <button v-if="SkuInFavorites">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-heart-fill" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
        </svg>
    </button>
</template>

<script>
import LoaderSpinner from './LoaderSpinner.vue'

export default {
    props: ['sku_id'],
    data() {
        return {
            favorites: '',

            views: {
                addToFavoritesButton: false,
            }
        }
    },
    mounted() {
        this.loadFavorites()

        this.emitter.on('favorites-response', (message) => {
            this.favorites = message
            this.views.addToFavoritesButton = true
        })
    },
    computed: {
        SkuInFavorites() {
            if(this.sku_id && this.favorites.length && this.favorites.includes(this.sku_id.toString())) {
                return true
            }

            return false
        },
    },
    methods: {
        loadFavorites() {
            this.views.addToFavoritesButton = false

            this.emitter.emit('get-favorites', '1')
        },
        addToFavorites() {
            if(!this.sku_id) {
                return
            }

            this.views.addToFavoritesButton = false

            axios.post('/_favorites', { id: this.sku_id })
            .then(response => {
                this.emitter.emit('favorite-count', 'New Favorite Item Added!')

                setTimeout(() => {
                    this.views.addToFavoritesButton = true

                    this.loadFavorites()
                }, 1000)
            })
        },
    },
    components: {
        LoaderSpinner
    }
}
</script>