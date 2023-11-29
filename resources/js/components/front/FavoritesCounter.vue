<template>
    <div class="favorites-coutner">
        {{ counter }}
    </div>
</template>

<script>
export default {
    data() {
        return {
            counter: '',
        }
    },
    mounted() {
        this.emitter.on('favorite-count', (message) => {
            this.loadFavoritesSkus()
        })
    },
    created() {
        this.loadFavoritesSkus()
    },
    methods: {
        loadFavoritesSkus() {
            axios.get(`/_favorites`)
            .then(response => {
                this.counter = Object.keys(response.data).length
            })
        }
    }
}
</script>