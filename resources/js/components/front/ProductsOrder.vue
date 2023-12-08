<template>
    <select @change="changeOrder($event)" class="category-products-order">
        <option value="price_asc" :selected="req_order == 'price_asc'">По возрастанию цены</option>
        <option value="price_desc" :selected="req_order == 'price_desc'">По убыванию цены</option>
        <option value="popular" :selected="req_order == 'popular'">По популярности</option>
    </select>
</template>

<script>
export default {
    props: ['req_order'],
    data() {
        return {
            currentOrder: '',
        }
    },
    created() {
        this.currentOrder = this.req_order
    },
    methods: {
        changeOrder(event) {
            let url = new URL(window.location.href)
            let newOrder = event.target.value

            if(this.currentOrder == newOrder) {
                return
            }
            
            let orderParams = url.searchParams

            orderParams.set('order', newOrder)

            url.search = orderParams.toString();

            let newUrl = url.toString()

            window.location.href = newUrl
        },
    },
}
</script>