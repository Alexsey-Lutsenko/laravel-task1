<template>
    <Teleport to="body">
        <app-modal :show="showModal">
            <template #header>
                <h3>Данные для входа в систему</h3>
            </template>
            <template #body>
                <div>
                    Логин: {{ admin.email }}
                    <tr></tr>
                    Пароль: {{ admin.password }}
                </div>
            </template>
            <template #footer>
                <app-button-close @click="close">Закрыть</app-button-close>
            </template>
        </app-modal>
    </Teleport>
</template>

<script>
import { computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "AdminLoginAuth",
    emits: ["close"],
    props: {
        showModal: {
            type: Boolean,
        },
    },
    setup(props, { emit }) {
        const store = useStore();
        const admin = computed(() => store.getters["auth/getAdmin"]);

        return {
            admin,
            close: () => emit("close"),
        };
    },
};
</script>

<style></style>
