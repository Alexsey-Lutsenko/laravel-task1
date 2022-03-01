<template>
    <h1>Импортированные данные</h1>

    <div class="d-flex w-100 justify-content-center">
        <app-loader v-if="loader"></app-loader>
    </div>

    <app-table class="w-50 mt-3" v-if="!loader">
        <template v-slot:thead>
            <tr>
                <th>Статус</th>
                <th>Таблица</th>
                <th>Пользователь</th>
                <th>Дата статуса</th>
            </tr>
        </template>
        <template v-slot:tbody>
            <tr v-for="i of imports.data" :key="i.id" class="text-center">
                <td>{{ i.status }}</td>
                <td>{{ i.data }}</td>
                <td>{{ i.user }}</td>
                <td>{{ formatDate(i.created_at) }}</td>
            </tr>
        </template>
    </app-table>
    <div class="d-flex w-100 justify-content-center">
        <Pagination :data="imports" @pagination-change-page="getResults" />
    </div>
</template>

<script>
import { onMounted, computed, ref } from "vue";
import { useStore } from "vuex";
import dateFormat, { masks } from "dateformat";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
    setup() {
        const store = useStore();
        const loader = ref(true);

        const imports = computed(() => store.getters["importStatus/getImportStatuses"]);
        onMounted(async () => {
            loader.value = true;
            await store.dispatch("importStatus/index");
            loader.value = false;
        });

        return {
            loader,
            imports,
            formatDate: (date) => dateFormat(date, "dd.mm.yyyy HH:MM:ss"),
            getResults: (page = 1) => {
                store.dispatch("importStatus/index", page);
            },
        };
    },
    components: {
        Pagination: LaravelVuePagination,
    },
};
</script>

<style></style>
