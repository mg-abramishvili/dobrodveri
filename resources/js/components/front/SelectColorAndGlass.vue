<template>
    <ul>
        <li v-for="color in product.colors">
            {{ color }}
        </li>

        <li v-for="color in product.glasses">
            {{ glass }}
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['product', 'color', 'glass', 'innerdecor'],
    }
</script>