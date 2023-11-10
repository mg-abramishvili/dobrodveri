<template>
    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Толщина полотна</label>
        </div>
        <div class="col-12 col-lg-7">
            <input v-model="$parent.tolschina_polotna" class="form-control">
        </div>
    </div>

    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Толщина металла</label>
        </div>
        <div class="col-12 col-lg-7">
            <input v-model="$parent.tolschina_metalla" class="form-control">
        </div>
    </div>

    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Внутренняя панель</label>
        </div>
        <div class="col-12 col-lg-7">
            <input v-model="$parent.vnutr_panel" class="form-control">
        </div>
    </div>

    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Замок</label>
        </div>
        <div class="col-12 col-lg-7">
            <input v-model="$parent.zamok" class="form-control">
        </div>
    </div>

    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Терморазрыв</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.termorazryv" class="form-select">
                <option value="">Не выбрано</option>
                <option value="Да">Да</option>
                <option value="Нет">Нет</option>
            </select>
        </div>
    </div>

    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Ночная задвижка</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.noch_zadvizh" class="form-select">
                <option value="">Не выбрано</option>
                <option value="Да">Да</option>
                <option value="Нет">Нет</option>
            </select>
        </div>
    </div>

    <div class="row align-items-center my-4">
        <div class="col-12 col-lg-5">
            <label class="form-label">Ребра жесткости</label>
        </div>
        <div class="col-12 col-lg-7">
            <select v-model="$parent.rebra_zh" class="form-select">
                <option value="">Не выбрано</option>
                <option value="Да">Да</option>
                <option value="Нет">Нет</option>
            </select>
        </div>
    </div>
</template>