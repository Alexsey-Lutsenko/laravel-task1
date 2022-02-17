<template>
    <div class="d-flex">
        <div class="admin-menu">
            <ul class="nav-menu top-nav-menu">
                <li>
                    <i class="fa-solid fa-person icon-custom"></i>
                    <router-link :to="'/client'">Клиенты</router-link>
                </li>
                <li>
                    <i class="fa-solid fa-leaf icon-custom"></i>
                    <router-link :to="'/culture'">Культуры</router-link>
                </li>
                <li>
                    <i class="fa-solid fa-paw icon-custom"></i>
                    <router-link :to="'/fertilizer'">Удобрения</router-link>
                </li>
            </ul>
            <ul class="mt-auto nav-menu py-0">
                <li>
                    <i class="fa-solid fa-screwdriver-wrench icon-custom"></i>
                    <router-link :to="'/user'">Пользователи</router-link>
                </li>
                <li>
                    <i class="fa-solid fa-trash-can-arrow-up icon-custom-remuve"></i>
                    <router-link :to="'/deleted'">Удаленное</router-link>
                </li>
            </ul>
        </div>
        <div class="container-fluid d-flex p-5 align-items-center flex-column value-pd mt-5">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminPage",
};
</script>

<style scoped lang="scss">
.active {
    font-weight: 800;
}
.top-nav-menu {
    min-height: 60%;
}
.nav-menu a {
    text-decoration: none;
    color: #000000;
    font-size: 20px;
}
.admin-menu {
    width: 230px;
    height: 100%;
    position: fixed;
    z-index: 1;
    top: 55px;
    left: 0;
    background-color: var(--app-color-green-light);
    padding-top: 20px;
}
.value-pd {
    margin-left: 230px;
}
.admin-menu ul {
    padding: 2rem 1rem;
    list-style-type: none;
}
.admin-menu ul li {
    font-size: 20px;
    margin-bottom: 10px;
}
.icon-custom {
    margin-right: 5px;
    color: var(--app-color-green);
}
.icon-custom-remuve {
    margin-right: 5px;
    color: rgb(192, 93, 93);
}
.fa-person.icon-custom {
    font-size: 25px;
    padding: 0 3px;
}
</style>
