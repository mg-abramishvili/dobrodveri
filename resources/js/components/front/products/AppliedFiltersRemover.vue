<template>
    <div class="applied-filters-remover">
        <ul>
            <template v-if="filterParams.colors.length">
                <li v-for="color in filterParams.colors">
                    {{ colorName(color) }}
                    
                    <button @click="remove('colors', color)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </button>
                </li>
            </template>

            <template v-if="filterParams.glasses.length">
                <li v-for="glass in filterParams.glasses">
                    {{ glassName(glass) }}
                
                    <button @click="remove('glasses', glass)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </button>
                </li>
            </template>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['filterParams'],
    methods: {
        colorName(slug) {
            let color = this.$parent.colors.find(c => c.slug == slug)

            if(color) {
                return color.name
            }
        },
        glassName(slug) {
            let glass = this.$parent.glasses.find(g => g.slug == slug)

            if(glass) {
                return glass.name
            }
        },
        remove(param, slug) {
            let paramsCount = document.querySelectorAll('.applied-filters-remover ul li').length

            if(paramsCount == 1) {
                return this.$parent.resetFilter()
            }

            this.$parent.filterParams[param] = this.$parent.filterParams[param].filter(function(i) {
                return i !== slug
            })

            this.$parent.loadProductSKUs()
        },
    },
}
</script>