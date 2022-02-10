<template>
    <div class="page-error w-100 d-flex justify-content-center align-items-center flex-column">
        <h1>404 - Страница не найдена!</h1>
        <router-link :to="'/'">Вернуться на главную</router-link>
    </div>
</template>

<script>
export default {
    name: "NotFound"
}
</script>

<style scoped>
.page-error {
    height: 50vh;
}
</style>
