<template>
    <Teleport to="body">
        <app-modal :show="showModal || errorCount > 0" @close="close" @submit="save">
            <template #header>
                <h3>Фильтрация клиентов</h3>
            </template>
            <template #body>
                <form>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckDefault" v-model="filter.orderByClient" />
                            <label class="form-check-label" for="flexCheckDefault">Наименование от А до Я</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" v-model="filter.orderByPurchase" />
                            <label class="form-check-label" for="flexCheckChecked">Стоимость поставки от А до Я</label>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="clientName">Клиент</label>
                        <app-input id="clientName" v-model.trim="filter.client"></app-input>
                        <small class="text-danger">{{ errorsFilter.client }}</small>
                    </div>
                    <div class="my-2 d-flex">
                        <div>
                            <label for="agreementDateFrom">Дата договора от:</label>
                            <app-calendar id="agreementDateFrom" v-model="filter.agreementDateFrom"></app-calendar>
                        </div>
                        <div class="ml-2">
                            <label for="agreementDateTo">Дата договора до:</label>
                            <app-calendar id="agreementDateTo" v-model="filter.agreementDateTo"></app-calendar>
                        </div>
                        <small class="text-danger">{{ errorsFilter.agreementDate }}</small>
                    </div>
                    <div class="my-2 d-flex">
                        <div>
                            <label for="purchase">Сумма покупки, Руб от:</label>
                            <app-input id="purchase" v-model.number="filter.purchaseFrom"></app-input>
                            <small class="text-danger">{{ errorsFilter.purchase }}</small>
                        </div>
                        <div class="ml-2">
                            <label for="purchase">Сумма покупки, Руб до:</label>
                            <app-input id="purchase" v-model.number="filter.purchaseTo"></app-input>
                            <small class="text-danger">{{ errorsFilter.purchase }}</small>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="region">Регион</label>
                        <app-multi-select v-model="filter.region">
                            <option v-for="region of regions" :key="region">
                                {{ region }}
                            </option>
                        </app-multi-select>
                        <small class="text-danger">{{ errorsFilter.region }}</small>
                    </div>
                </form>
            </template>
        </app-modal>
    </Teleport>
</template>

<script>
import { ref, computed } from "vue";
import { useStore } from "vuex";
import dateFormat, { masks } from "dateformat";

export default {
    name: "ClientFilter",
    emits: ["close", "save"],
    props: {
        showModal: {
            type: Boolean,
        },
    },
    setup(props, { emit }) {
        const store = useStore();
        const errorCount = ref(0);
        const errorsFilter = ref({});
        const purchase = ref([]);
        const agreementDate = ref([]);
        const params = ref({});

        const regions = computed(() => store.getters["client/getRegions"]);
        const filter = computed(() => store.getters["clientFilter/getFilter"]);

        const getFilter = async () => {
            purchase.value = [];
            agreementDate.value = [];
            params.value = {};

            purchase.value.push(filter.value.purchaseFrom ? filter.value.purchaseFrom : 0);
            purchase.value.push(filter.value.purchaseTo ? filter.value.purchaseTo : 999999999);
            agreementDate.value.push(filter.value.agreementDateFrom ? dateFormat(filter.value.agreementDateFrom, "dd.mm.yyyy") : "01.01.0001");
            agreementDate.value.push(filter.value.agreementDateTo ? dateFormat(filter.value.agreementDateTo, "dd.mm.yyyy") : "31.12.9999");

            filter.value.client ? (params.value["client"] = filter.value.client) : params.value;
            filter.value.orderByClient ? (params.value["orderByClient"] = "orderByClient") : params.value;
            filter.value.orderByPurchase ? (params.value["orderByPurchase"] = "orderByPurchase") : params.value;
            filter.value.agreementDateFrom || filter.value.agreementDateTo ? (params.value["agreementDate"] = agreementDate.value) : params.value;
            filter.value.purchaseFrom || filter.value.purchaseTo ? (params.value["purchase"] = purchase.value) : params.value;
            filter.value.region ? (params.value["region"] = filter.value.region) : params.value;

            console.log(params.value);

            store.commit("clientFilter/addFilter", filter.value);
            await store.dispatch("client/index", params.value);
        };

        return {
            errorCount,
            filter,
            errorsFilter,
            regions,
            close: () => {
                emit("close");
            },
            save: () => {
                emit("save");
                getFilter();
            },
        };
    },
};
</script>

<style scoped>
.ml-2 {
    margin-left: 5px;
}
</style>
