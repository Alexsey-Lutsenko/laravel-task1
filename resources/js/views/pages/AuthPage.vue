<template>
    <div class="d-flex w-100 h-100 justify-content-center align-items-center flex-column page-auth">
        <div class="my-5">
            <h1>Авторизация</h1>
        </div>
        <form class="form w-25">
            <app-input type="text" placeholder="Логин" v-model="user.login"></app-input>
            <app-input type="password" placeholder="Пароль" v-model="user.password"></app-input>

            <div class="d-flex justify-content-center">
                <app-button-success @click.prevent="login">Войти</app-button-success>
            </div>
        </form>
    </div>
</template>

<script>
import {ref} from "vue"

export default {
    name: "AuthPage",
    setup() {
        const user = ref({
            login: '',
            password: ''
        })

        return {
            user,
            login: () => {
                console.log(user.value)
            }
        }
    }
}
</script>

<style scoped>
.page-auth {
    height: 50vh !important;
}
</style>
