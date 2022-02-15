<template>
    <h1>Управление пользователями</h1>
    <div class="d-flex w-50 mt-3 mb-2 justify-content-start" v-if="!loader">
        <app-button-create @create="create">
            Новый пользователь
        </app-button-create>
    </div>
    <div class="d-flex w-100 justify-content-center">
        <app-loader v-if="loader"></app-loader>
    </div>
    <app-table class="w-50" v-if="!loader">
        <template v-slot:thead>
            <tr>
                <th>Пользователь</th>
                <th>Доступ</th>
            </tr>
        </template>
        <template v-slot:tbody>
            <tr v-for="user of users" :key="user.id" class="text-center">
                <td>{{ user.name }}</td>
                <td>{{ user.role }}</td>
                <td>
                    <i
                        class="fa-solid fa-pencil text-primary fs-5"
                        @click="update(user)"
                    ></i>
                </td>
                <td>
                    <i
                        class="fa-regular fa-trash-can text-danger fs-5 pointer-event"
                        @click="remuve(user.id)"
                    ></i>
                </td>
            </tr>
        </template>
    </app-table>

    <Teleport to="body">
        <app-modal
            :show="showModal || errorCount > 0"
            @close="close"
            @submit="save"
        >
            <template #header>
                <h3>Создать нового пользователя</h3>
            </template>
            <template #body>
                <form>
                    <div>
                        <label for="userName">Имя пользователя</label>
                        <app-input
                            id="userName"
                            v-model="newUser.name"
                        ></app-input>
                        <small class="text-danger">{{ errors.name }}</small>
                    </div>

                    <div class="my-2">
                        <label for="role">Право доступа</label>
                        <app-select v-model="newUser.role_id">
                            <option
                                v-for="role of roles"
                                :key="role.id"
                                :value="role.id"
                            >
                                {{ role.role }}
                            </option>
                        </app-select>
                        <small class="text-danger">{{ errors.role_id }}</small>
                    </div>
                </form>
            </template>
        </app-modal>
    </Teleport>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "UserPage",
    components: {},

    setup() {
        const store = useStore();
        const loader = ref(true);
        const newUser = ref({
            id: null,
            name: "",
            role_id: null,
        });
        const showModal = ref(false);
        const typeF = ref(0);
        const users = computed(() => store.getters["user/getUsers"]);
        const errors = computed(() => store.getters["user/getErrors"]);
        const errorCount = computed(() => store.getters["user/getErrorCount"]);
        const roles = computed(() => store.getters["role/getRoles"]);

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("user/index");
            await store.dispatch("role/index");
            loader.value = false;
        });

        const save = async () => {
            if (typeF.value === 1) {
                await store.dispatch("user/store", newUser.value);
                showModal.value = false;
                errorCount.value == 0 ? (newUser.value = {}) : newUser.value;
            } else if (typeF.value === 2) {
                await store.dispatch("user/update", newUser.value);
                showModal.value = false;
                errorCount.value == 0 ? (newUser.value = {}) : newUser.value;
            }
        };

        return {
            users,
            loader,
            roles,
            newUser,
            errors,
            errorCount,
            showModal,
            typeF,
            save,
            create: () => {
                showModal.value = true;
                typeF.value = 1;
            },
            update: (user) => {
                showModal.value = true;
                newUser.value.id = user.id;
                newUser.value.name = user.name;
                newUser.value.role_id = user.role_id;
                console.log(newUser.value);
                typeF.value = 2;
            },
            remuve: async (id) => {
                await store.dispatch("user/remuve", id);
            },
            close: () => {
                showModal.value = false;
                store.commit("user/remuveError");
                newUser.value = {};
            },
        };
    },
};
</script>

<style scoped>
td i:hover {
    cursor: pointer;
}
</style>
