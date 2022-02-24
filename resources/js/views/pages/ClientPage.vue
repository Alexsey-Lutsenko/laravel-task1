<template>
    <h1>Управление клиентами</h1>

    <div class="d-flex w-50 mt-3 mb-2 justify-content-between" v-if="!loader">
        <div>
            <app-button-create @create="create"> Новый клиент </app-button-create>
            <div class="mt-1">
                <client-import></client-import>
            </div>
        </div>
        <div class="d-flex">
            <div>
                <button class="btn btn-primary" @click="showModalFilter = true">
                    <i class="fa-solid fa-filter"></i>
                </button>
            </div>
            <div class="ml-2" v-if="isFilter">
                <button class="btn btn-danger" @click="deleteFilter">
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex w-100 justify-content-center">
        <app-loader v-if="loader"></app-loader>
    </div>

    <app-table class="w-50" v-if="!loader">
        <template v-slot:thead>
            <tr>
                <th>Наименование</th>
                <th>Дата договора</th>
                <th>Стоимость поставки</th>
                <th>Регион</th>
            </tr>
        </template>
        <template v-slot:tbody>
            <tr v-for="client of clients" :key="client.id" class="text-center">
                <td>{{ client.client }}</td>
                <td>{{ formatDate(client.agreementDate) }}</td>
                <td>{{ formatMoney.format(client.purchase) }}</td>
                <td>{{ client.region }}</td>
                <td>
                    <i class="fa-solid fa-pencil text-primary fs-5" @click="update(client)"></i>
                </td>
                <td>
                    <i class="fa-regular fa-trash-can text-danger fs-5 pointer-event" @click="remuve(client.id)"></i>
                </td>
            </tr>
        </template>
    </app-table>

    <Teleport to="body">
        <app-modal :show="showModal || errorCount > 0" @close="close" @submit="save">
            <template #header>
                <h3>Создать нового клиента</h3>
            </template>
            <template #body>
                <form>
                    <div>
                        <label for="clientName">Клиент</label>
                        <app-input id="clientName" v-model.trim="clientModel.client"></app-input>
                        <small class="text-danger">{{ errors.client }}</small>
                    </div>
                    <div class="my-2">
                        <label for="agreementDate">Дата договора</label>
                        <app-calendar id="agreementDate" v-model="clientModel.agreementDate"></app-calendar>
                        <small class="text-danger">{{ errors.agreementDate }}</small>
                    </div>
                    <div class="my-2">
                        <label for="purchase">Сумма покупки, Руб</label>
                        <app-input id="purchase" v-model.number="clientModel.purchase"></app-input>
                        <small class="text-danger">{{ errors.purchase }}</small>
                    </div>
                    <div class="my-2">
                        <label for="region">Регион</label>
                        <app-input id="region" v-model.trim="clientModel.region"></app-input>
                        <small class="text-danger">{{ errors.region }}</small>
                    </div>
                </form>
            </template>
        </app-modal>
    </Teleport>

    <client-filter :showModal="showModalFilter" @close="closeFilter" @save="saveFilter"></client-filter>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import dateFormat, { masks } from "dateformat";
import ClientFilter from "../../components/filterComponent/ClientFilter.vue";
import ClientImport from "../../components/importComponent/ClientImport.vue";

export default {
    name: "ClientPage",
    setup() {
        const store = useStore();
        const loader = ref(true);
        const showModal = ref(false);
        const showModalFilter = ref(false);
        const typeSave = ref(0);
        const clientModel = ref({
            agreementDate: new Date(),
        });
        const countErrorFilter = ref(1);

        const formatMoney = new Intl.NumberFormat("ru-RU", { currency: "RUB", style: "currency" });

        const clients = computed(() => store.getters["client/getClients"]);
        const errorCount = computed(() => store.getters["client/getErrorCount"]);
        const errors = computed(() => store.getters["client/getErrors"]);
        const isFilter = computed(() => store.getters["clientFilter/getIsFilter"]);

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("client/index");
            loader.value = false;
        });

        const save = async () => {
            if (typeSave.value === 1) {
                await store.dispatch("client/store", clientModel.value);
                showModal.value = false;
                errorCount.value == 0 ? (clientModel.value = { agreementDate: new Date() }) : clientModel.value;
            } else if (typeSave.value === 2) {
                await store.dispatch("client/update", clientModel.value);
                showModal.value = false;
                errorCount.value == 0 ? (clientModel.value = {}) : clientModel.value;
            }
        };

        return {
            store,
            loader,
            clients,
            showModal,
            showModalFilter,
            clientModel,
            typeSave,
            errorCount,
            countErrorFilter,
            errors,
            save,
            formatMoney,
            isFilter,
            formatDate: (date) => dateFormat(date, "dd.mm.yyyy"),
            create: () => {
                showModal.value = true;
                typeSave.value = 1;
            },
            close: () => {
                showModal.value = false;
                store.commit("client/remuveError");
                clientModel.value = {};
            },
            closeFilter: () => {
                showModalFilter.value = false;
            },
            update: (client) => {
                client.agreementDate = new Date(client.agreementDate);
                showModal.value = true;
                clientModel.value = Object.assign({}, client);
                typeSave.value = 2;
            },
            remuve: async (id) => await store.dispatch("client/destroy", id),
            saveFilter: () => {
                showModalFilter.value = false;
            },
            deleteFilter: async () => {
                store.commit("clientFilter/remuveFilter");
            },
        };
    },
    components: { ClientFilter, ClientImport },
};
</script>

<style scoped>
td i:hover {
    cursor: pointer;
}
.ml-2 {
    margin-left: 5px;
}
</style>
