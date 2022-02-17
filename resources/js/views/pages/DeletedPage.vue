<template>
    <h1>Удаленные из системы</h1>

    <ul class="nav nav-tabs my-4 w-50 d-flex justify-content-center">
        <li class="nav-item">
            <button :class="['nav-link', { active: typeData === 'User' }]" @click="typeData = 'User'">
                Пользователи
            </button>
        </li>
        <li class="nav-item">
            <button :class="['nav-link', { active: typeData === 'Client' }]" @click="typeData = 'Client'">
                Клиенты
            </button>
        </li>
        <li class="nav-item">
            <button :class="['nav-link', { active: typeData === 'Culture' }]" @click="typeData = 'Culture'">
                Культуры
            </button>
        </li>
        <li class="nav-item">
            <button :class="['nav-link', { active: typeData === 'Fertilizer' }]" @click="typeData = 'Fertilizer'">
                Удобрения
            </button>
        </li>
    </ul>

    <component :is="typeData + 'Deleted'"></component>
</template>

<script>
import { ref } from "vue";
import ClientDeleted from "../../components/deletedComponent/ClientDeleted";
import CultureDeleted from "../../components/deletedComponent/CultureDeleted";
import FertilizerDeleted from "../../components/deletedComponent/FertilizerDeleted";
import UserDeleted from "../../components/deletedComponent/UserDeleted";

export default {
    name: "DeletedPage",
    setup() {
        const typeData = ref("User");

        return {
            typeData,
        };
    },
    components: {
        ClientDeleted,
        CultureDeleted,
        FertilizerDeleted,
        UserDeleted,
    },
};
</script>

<style scoped>
.active {
    font-weight: 500;
    background-color: rgb(216, 168, 168) !important;
    color: rgb(60, 60, 60) !important;
}
.nav-link {
    color: rgb(60, 60, 60);
}
</style>
