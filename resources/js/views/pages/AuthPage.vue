<template>
    <div class="d-flex w-100 h-100 justify-content-center align-items-center flex-column page-auth">
        <div class="my-5">
            <h1>Авторизация</h1>
            <div class="d-flex justify-content-center mt-1">
                <small class="text-danger" v-if="authenticatedError">{{ authenticatedError }}</small>
            </div>
        </div>

        <form class="form w-25">
            <div class="mb-3">
                <app-input type="text" placeholder="Логин" v-model.trim="user.email"></app-input>
                <small class="text-danger">{{ errors.email }}</small>
            </div>
            <div class="mb-3">
                <app-input type="password" placeholder="Пароль" v-model.trim="user.password"></app-input>
                <small class="text-danger">{{ errors.password }}</small>
            </div>

            <div class="d-flex justify-content-center">
                <app-button-success @click.prevent="login">Войти</app-button-success>
                <app-button-success class="mx-2" @click.prevent="showModalAdmin = true">Админ</app-button-success>
            </div>
        </form>
    </div>

    <admin-login-auth :showModal="showModalAdmin" @close="showModalAdmin = false"></admin-login-auth>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import AdminLoginAuth from "../../components/authComponent/AdminLoginAuth.vue";

export default {
    name: "AuthPage",
    setup() {
        const router = useRouter();
        const store = useStore();
        const user = ref({});
        const showModalAdmin = ref(false);

        const errors = computed(() => store.getters["auth/getErrors"]);
        const authenticatedError = computed(() => store.getters["auth/getIsAuthenticatedError"]);

        onMounted(() => {
            store.dispatch("auth/getAdmin");
        });

        return {
            user,
            errors,
            showModalAdmin,
            authenticatedError,
            login: async () => {
                await store.dispatch("auth/isLogin", user.value);
                if (authenticatedError) {
                    user.value = {};
                }
                router.push("/");
            },
        };
    },
    components: { AdminLoginAuth },
};
</script>

<style scoped>
.page-auth {
    height: 50vh !important;
}
</style>
