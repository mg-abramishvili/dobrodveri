<template>
    <p>Цвет</p>
    <ul>
        <li v-for="color in product.colors">
            <button @click="selectColor(color)">
                {{ color }}
            </button>
        </li>
    </ul>

    <p>Остекление</p>
    <ul>
        <li v-for="glass in product.glasses">
            <button @click="selectGlass(glass)">
                {{ glass }}
            </button>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['product', 'color', 'glass', 'innerdecor'],
        methods: {
            selectColor(color) {
                this.emitter.emit('product-color-select', color)
            },
            selectGlass(glass) {
                this.emitter.emit('product-glass-select', glass)
            },
        }
    }
</script>