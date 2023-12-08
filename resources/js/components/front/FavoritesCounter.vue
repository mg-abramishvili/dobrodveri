<template>
    <div class="favorites-counter">
        {{ counter }}
    </div>
</template>

<script>
export default {
    data() {
        return {
            counter: '',

            favorites: [],
        }
    },
    mounted() {
        this.emitter.on('favorite-count', (message) => {
            this.loadFavoritesSkus()
        })

        this.emitter.on('get-favorites', (message) => {
            setTimeout(() => {
                this.emitter.emit('favorites-response', this.favorites)
            }, 1000)
        })
    },
    created() {
        this.loadFavoritesSkus()
    },
    methods: {
        loadFavoritesSkus() {
            axios.get(`/_favorites`)
            .then(response => {
                this.favorites = Object.keys(response.data)

                this.counter = Object.keys(response.data).length
            })
        }
    }
}
</script>