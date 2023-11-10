<template>
    <div class="form-check">
        <input v-model="$parent.hit" class="form-check-input" type="checkbox" id="hit">
        <label class="form-check-label" for="hit">
            Хит
        </label>
    </div>

    <div class="form-check">
        <input v-model="$parent.discount" class="form-check-input" type="checkbox" id="discount">
        <label class="form-check-label" for="discount">
            Скидка
        </label>
    </div>

    <div class="form-check">
        <input v-model="$parent.sale" class="form-check-input" type="checkbox" id="sale">
        <label class="form-check-label" for="sale">
            Распродажа
        </label>
    </div>

    <div class="form-check">
        <input v-model="$parent.special" class="form-check-input" type="checkbox" id="special">
        <label class="form-check-label" for="special">
            Акция
        </label>
    </div>
</template>