<template>
    <div class="d-flex">
        <div class="admin-menu">
            <ul class="nav-menu">
                <li>
                    <i class="fa-solid fa-person icon-custom"></i>
                    <router-link :to="'/client'">Клиенты</router-link>
                </li>
                <li>
                    <i class="fa-solid fa-paw icon-custom"></i>
                    <router-link :to="'/fertilizer'">Удобрения</router-link>
                </li>
            </ul>
        </div>
        <div class="container-fluid d-flex p-5 align-items-center flex-column">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdminPage"
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
.admin-menu {
    width: 230px;
    height: 94vh;
    background: var(--app-color-green-light);
}
.admin-menu ul {
    padding: 2rem 2rem;
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
.fa-person.icon-custom {
    font-size: 25px;
    padding: 0 3px;
}
</style>
