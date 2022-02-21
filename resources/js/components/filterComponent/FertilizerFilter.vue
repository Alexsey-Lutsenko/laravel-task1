<template>
    <Teleport to="body">
        <app-modal :show="showModal" @close="close" @submit="save">
            <template #header>
                <h3>Фильтрация удобрений</h3>
            </template>
            <template #body>
                <form>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckDefault" v-model="filter.orderByFertilizer" />
                            <label class="form-check-label" for="flexCheckDefault">Наименование от А до Я</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="flexCheckChecked" v-model="filter.orderByPrice" />
                            <label class="form-check-label" for="flexCheckChecked">Стоимость от А до Я</label>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="fertilizer">Удобрение</label>
                        <app-input id="fertilizer" v-model.trim="filter.fertilizer"></app-input>
                    </div>

                    <div class="my-2 d-flex">
                        <div>
                            <label for="normNFrom">Норма N от:</label>
                            <app-input id="normNFrom" v-model.number="filter.normNFrom"></app-input>
                        </div>
                        <div class="ml-2">
                            <label for="normNTo">Норма N до:</label>
                            <app-input id="normNTo" v-model.number="filter.normNTo"></app-input>
                        </div>
                    </div>

                    <div class="my-2 d-flex">
                        <div>
                            <label for="normPFrom">Норма P от:</label>
                            <app-input id="normPFrom" v-model.number="filter.normPFrom"></app-input>
                        </div>
                        <div class="ml-2">
                            <label for="normPTo">Норма P до:</label>
                            <app-input id="normPTo" v-model.number="filter.normPTo"></app-input>
                        </div>
                    </div>

                    <div class="my-2 d-flex">
                        <div>
                            <label for="normKFrom">Норма K от:</label>
                            <app-input id="normKFrom" v-model.number="filter.normKFrom"></app-input>
                        </div>
                        <div class="ml-2">
                            <label for="normKTo">Норма K до:</label>
                            <app-input id="normKTo" v-model.number="filter.normKTo"></app-input>
                        </div>
                    </div>

                    <div class="my-2">
                        <label for="culture">Культура</label>
                        <app-multi-select v-model="filter.culture" :model="filter.culture || []">
                            <option v-for="culture of cultures" :key="culture.id" :value="culture.id">
                                {{ culture.culture }}
                            </option>
                        </app-multi-select>
                    </div>

                    <div class="my-2">
                        <label for="region">Регион</label>
                        <app-multi-select v-model="filter.region" :model="filter.region || []">
                            <option v-for="region of regions" :key="region">
                                {{ region }}
                            </option>
                        </app-multi-select>
                    </div>

                    <div class="my-2 d-flex">
                        <div>
                            <label for="priceFrom">Цена от:</label>
                            <app-input id="priceFrom" v-model.number="filter.priceFrom"></app-input>
                        </div>
                        <div class="ml-2">
                            <label for="priceTo">Цена до:</label>
                            <app-input id="priceTo" v-model.number="filter.priceTo"></app-input>
                        </div>
                    </div>
                    <div class="my-2">
                        <label for="description">Описание</label>
                        <app-input id="description" v-model.trim="filter.description"></app-input>
                    </div>
                    <div class="my-2">
                        <label for="purpose">Назначение</label>
                        <app-input id="purpose" v-model.trim="filter.purpose"></app-input>
                    </div>
                </form>
            </template>
        </app-modal>
    </Teleport>
</template>

<script>
import { ref, computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "FertilizerFilter",
    emits: ["close", "save"],
    props: {
        showModal: {
            type: Boolean,
        },
    },
    setup(props, { emit }) {
        const store = useStore();

        const regions = computed(() => store.getters["fertilizer/getRegions"]);
        const cultures = computed(() => store.getters["fertilizer/getCultures"]);
        const filter = computed(() => store.getters["fertilizerFilter/getFilter"]);

        const getFilter = async () => {
            const min = 0;
            const max = 999999999;

            const normN = [];
            const normP = [];
            const normK = [];
            const price = [];
            const params = {};

            normN.push(filter.value.normNFrom ? filter.value.normNFrom : min);
            normN.push(filter.value.normNTo ? filter.value.normNTo : max);
            normP.push(filter.value.normPFrom ? filter.value.normPFrom : min);
            normP.push(filter.value.normPTo ? filter.value.normPTo : max);
            normK.push(filter.value.normKFrom ? filter.value.normKFrom : min);
            normK.push(filter.value.normKTo ? filter.value.normKTo : max);
            price.push(filter.value.priceFrom ? filter.value.priceFrom : min);
            price.push(filter.value.priceTo ? filter.value.priceTo : max);

            filter.value.fertilizer ? (params["fertilizer"] = filter.value.fertilizer) : params;
            filter.value.orderByFertilizer ? (params["orderByFertilizer"] = "orderByFertilizer") : params;
            filter.value.orderByPrice ? (params["orderByPrice"] = "orderByPrice") : params;
            filter.value.normNFrom || filter.value.normNTo ? (params["normN"] = normN) : params;
            filter.value.normPFrom || filter.value.normPTo ? (params["normP"] = normP) : params;
            filter.value.normKFrom || filter.value.normKTo ? (params["normK"] = normK) : params;
            filter.value.priceFrom || filter.value.priceTo ? (params["price"] = price) : params;
            filter.value.region ? (params["region"] = filter.value.region) : params;
            filter.value.culture ? (params["culture_id"] = filter.value.culture) : params;
            filter.value.description ? (params["description"] = filter.value.description) : params;
            filter.value.purpose ? (params["purpose"] = filter.value.purpose) : params;

            store.commit("fertilizerFilter/addFilter", filter.value);
            await store.dispatch("fertilizer/index", params);
        };

        return {
            regions,
            cultures,
            filter,
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
