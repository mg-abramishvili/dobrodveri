<template>
    <div class="range">
        <div class="range-slider">
            <span class="range-selected"></span>
        </div>
        <div class="range-input">
            <input type="range" @change="changeMinRange()" v-model="minRange" class="min" min="0" max="100000" step="10">
            <input type="range" @change="changeMaxRange()" v-model="maxRange" class="max" min="0" max="100000" step="10">
        </div>
        <div class="range-price">      
            <label for="min">от</label>
            <input type="number" v-model="minRange" name="min" class="form-control">      
            <label for="max">до</label>
            <input type="number" v-model="maxRange" name="max" class="form-control">      
        </div>
    </div>
</template>

<script>
export default {
    props: ['min', 'max'],
    data() {
        return {
            minRange: 0,
            maxRange: 0,
            rangeMin: 10,
        }
    },
    mounted() {
        this.minRange = this.min
        this.maxRange = this.max

        this.styleRange()
    },
    methods: {
        changeMinRange() {
            if(this.maxRange - this.minRange < this.rangeMin) {
                this.minRange = this.maxRange - this.rangeMin;
            }

            this.$parent.selected.price_from = this.minRange

            this.styleRange()
        },
        changeMaxRange() {
            if(this.maxRange - this.minRange < this.rangeMin) {
                this.maxRange = this.minRange;
            }

            this.$parent.selected.price_to = this.maxRange

            this.styleRange()
        },
        styleRange() {
            const range = document.querySelector(".range-selected")

            range.style.left = (this.minRange / 100000) * 100 + "%"
            range.style.right = 100 - (this.maxRange / 100000) * 100 + "%"
        },
    }
}
</script>
