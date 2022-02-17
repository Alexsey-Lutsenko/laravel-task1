<template>
    <h5>Пользователи</h5>

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
            </tr>
        </template>
    </app-table>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "UserDeleted",
    setup() {
        const store = useStore();
        const loader = ref(true);
        const users = computed(() => store.getters["user/getUsersDeleted"]);

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("user/indexDeleted");
            loader.value = false;
        });

        return {
            loader,
            users,
            click: () => {
                console.log("click");
            },
        };
    },
};
</script>

<style></style>
