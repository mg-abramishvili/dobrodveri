<template>
    <div class="pagination">
        <button @click="$parent.prevPage()" :disabled="!pagination.prevPage">
            &larr; Предыдущая
        </button>

        <button @click="$parent.goToPage(page)" v-for="page in pages" :disabled="page == pagination.currentPage">
            {{ page }}
        </button>

        <button @click="$parent.nextPage()" :disabled="!pagination.nextPage">
            &rarr; Следующая
        </button>
    </div>
</template>

<script>
export default {
    props: ['pagination'],
    data() {
        return {
            pages: [...Array(this.pagination.totalPages + 1).keys()].slice(1),
        }
    },
    created() {
        //
    },
    methods: {
        //
    }
}
</script>