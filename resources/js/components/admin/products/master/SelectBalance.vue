<template>
    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Наличие</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.selected.balance" class="form-select">
                <option value="В наличии в Уфе">В наличии в Уфе</option>
                <option value="3-7 дней">3-7 дней</option>
                <option value="7-14 дней">7-14 дней</option>
                <option value="15-30 дней">15-30 дней</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            //
        }
    },
}
</script>