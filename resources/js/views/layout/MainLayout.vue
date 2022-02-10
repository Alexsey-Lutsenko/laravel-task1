<template>
    <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
        <div class="d-flex align-items-center mx-3">
            <i class="fa-solid fa-seedling mx-1"></i>
            <a class="navbar-brand fw-bold" href="#">Farmer CRM</a>
        </div>
        <div class="mx-5 nav-menu">
            <router-link :to="'/auth'">Вход</router-link>
        </div>
    </nav>
    <router-view></router-view>
</template>

<script>

export default {
    name: "MainLayout"
}
</script>

<style scoped lang="scss">
    .active {
        font-weight: 800;
    }
    .nav-menu a {
        text-decoration: none;
        color: #000000;
        font-size: 20px;
    }
    .navbar {
        background: var(--app-color-green-light);
    }
    .fa-seedling {
        font-size: 25px;
        padding-bottom: 8px;
        color: var(--app-color-green);
    }
</style>
