<template>
    <div class="admin-menu">
        <ul>
            <li>
                <i class="fa-solid fa-paw icon-custom"></i>
                Удобрения
            </li>
            <li>
                <i class="fa-solid fa-person icon-custom"></i>
                Клиенты
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AdminPage"
}
</script>

<style scoped lang="scss">
.admin-menu {
    width: 220px;
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
