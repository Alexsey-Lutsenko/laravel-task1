<template>
    <h5>Клиенты</h5>

    <div class="d-flex w-100 justify-content-center">
        <app-loader v-if="loader"></app-loader>
    </div>
    <div class="w-50" v-if="!loader">
        <app-table>
            <template v-slot:thead>
                <tr>
                    <th>Наименование</th>
                    <th>Дата договора</th>
                    <th>Стоимость поставки</th>
                    <th>Регион</th>
                </tr>
            </template>
            <template v-slot:tbody>
                <tr v-for="client of clients.data" :key="client.id" class="text-center">
                    <td>{{ client.client }}</td>
                    <td>{{ formatDate(client.agreementDate) }}</td>
                    <td>{{ formatMoney.format(client.purchase) }}</td>
                    <td>{{ client.region }}</td>
                </tr>
            </template>
        </app-table>
        <div class="d-flex w-100 justify-content-center">
            <Pagination :data="clients" @pagination-change-page="getResults" />
        </div>
    </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import dateFormat, { masks } from "dateformat";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
    name: "ClientDeleted",

    setup() {
        const store = useStore();
        const loader = ref(true);
        const clients = computed(() => store.getters["client/getClientsDeleted"]);

        const formatMoney = new Intl.NumberFormat("ru-RU", { currency: "RUB", style: "currency" });

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("client/indexDeleted");
            loader.value = false;
        });

        return {
            loader,
            clients,
            formatMoney,
            formatDate: (date) => dateFormat(date, "dd.mm.yyyy"),
            getResults: (page = 1) => {
                store.dispatch("client/indexDeleted", page);
            },
        };
    },
    components: { Pagination: LaravelVuePagination },
};
</script>

<style></style>
