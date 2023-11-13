<template>
    <p>Цвет</p>
    <ul>
        <li v-for="color in product.colors">
            {{ color }}
        </li>
    </ul>

    <p>Остекление</p>
    <ul>
        <li v-for="glass in product.glasses">
            {{ glass }}
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['product', 'color', 'glass', 'innerdecor'],
    }
</script>