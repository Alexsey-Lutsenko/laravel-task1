<template>
    <nav class="navbar navbar-expand-lg navbar-light justify-content-between">
        <div class="d-flex align-items-center mx-3">
            <i class="fa-solid fa-seedling mx-1"></i>
            <a class="navbar-brand fw-bold" href="#">Farmer CRM - Админ</a>
        </div>
        <div class="mx-5 nav-menu">
            <router-link :to="'/auth'" @click.prevent="logout">Выйти</router-link>
        </div>
    </nav>
    <router-view></router-view>
</template>

<script>
import { useStore } from "vuex";

export default {
    name: "MainLayout",
    setup() {
        const store = useStore();

        return {
            logout: () => store.commit("auth/logout"),
        };
    },
};
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
    background: #9bcbb5;
    position: fixed;
    width: 100%;
}
.fa-seedling {
    font-size: 25px;
    padding-bottom: 8px;
    color: var(--app-color-green);
}
</style>
