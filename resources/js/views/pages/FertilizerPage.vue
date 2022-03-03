<template>
    <h1>Управление удобрениями</h1>

    <div class="d-flex w-75 mt-3 mb-2 justify-content-between" v-if="!loader">
        <div class="d-flex">
            <app-button-create @create="create"> Новое удобрение </app-button-create>
            <div class="mx-2">
                <fertilizer-import></fertilizer-import>
            </div>
        </div>
        <div class="d-flex">
            <app-button-success @click="download"><i class="fa-solid fa-file-export"></i></app-button-success>
            <div class="ml-2">
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

    <app-table class="w-75" v-if="!loader">
        <template v-slot:thead>
            <tr>
                <th>Удобрение</th>
                <th>Норма N</th>
                <th>Норма P</th>
                <th>Норма K</th>
                <th>Культура</th>
                <th>Регион</th>
                <th>Цена</th>
                <th>Описание</th>
                <th>Назначение</th>
            </tr>
        </template>
        <template v-slot:tbody>
            <tr v-for="fertilizer of fertilizers" :key="fertilizer.id" class="text-center">
                <td>{{ fertilizer.fertilizer }}</td>
                <td>{{ fertilizer.normN }}</td>
                <td>{{ fertilizer.normP }}</td>
                <td>{{ fertilizer.normK }}</td>
                <td>{{ fertilizer.culture }}</td>
                <td>{{ fertilizer.region }}</td>
                <td>{{ formatMoney.format(fertilizer.price) }}</td>
                <td>{{ fertilizer.description }}</td>
                <td>{{ fertilizer.purpose }}</td>
                <td>
                    <i class="fa-solid fa-pencil text-primary fs-5" @click="update(fertilizer)"></i>
                </td>
                <td>
                    <i class="fa-regular fa-trash-can text-danger fs-5 pointer-event" @click="remuve(fertilizer.id)"></i>
                </td>
            </tr>
        </template>
    </app-table>

    <Teleport to="body">
        <app-modal :show="showModal || errorCount > 0" @close="close" @submit="save">
            <template #header>
                <h3>Создать новую культуру</h3>
            </template>
            <template #body>
                <form>
                    <div>
                        <label for="fertilizerName">Название удобрения</label>
                        <app-input id="fertilizerName" v-model.trim="fertilizerModel.fertilizer"></app-input>
                        <small class="text-danger">{{ errors.fertilizer }}</small>
                    </div>
                    <div class="mt-2">
                        <label for="normaN">Норма N</label>
                        <app-input id="normaN" v-model.trim="fertilizerModel.normN"></app-input>
                        <small class="text-danger">{{ errors.normN }}</small>
                    </div>
                    <div class="mt-2">
                        <label for="normaP">Норма P</label>
                        <app-input id="normaP" v-model.trim="fertilizerModel.normP"></app-input>
                        <small class="text-danger">{{ errors.normP }}</small>
                    </div>
                    <div class="mt-2">
                        <label for="normaK">Норма K</label>
                        <app-input id="normaK" v-model.trim="fertilizerModel.normK"></app-input>
                        <small class="text-danger">{{ errors.normK }}</small>
                    </div>
                    <div class="my-2">
                        <label for="culture">Культура</label>
                        <app-select id="culture" v-model="fertilizerModel.culture_id">
                            <option v-for="culture of cultures" :key="culture.id" :value="culture.id">
                                {{ culture.culture }}
                            </option>
                        </app-select>
                        <small class="text-danger">{{ errors.culture_id }}</small>
                    </div>
                    <div>
                        <label for="region">Регион</label>
                        <app-input id="region" v-model.trim="fertilizerModel.region"></app-input>
                        <small class="text-danger">{{ errors.region }}</small>
                    </div>
                    <div class="mt-2">
                        <label for="price">Цена</label>
                        <app-input id="price" v-model.number="fertilizerModel.price"></app-input>
                        <small class="text-danger">{{ errors.price }}</small>
                    </div>
                    <div class="mt-2">
                        <label for="description">Описание</label>
                        <app-input id="description" v-model.trim="fertilizerModel.description"></app-input>
                        <small class="text-danger">{{ errors.description }}</small>
                    </div>
                    <div class="mt-2">
                        <label for="purpose">Назначение</label>
                        <app-input id="purpose" v-model.trim="fertilizerModel.purpose"></app-input>
                        <small class="text-danger">{{ errors.purpose }}</small>
                    </div>
                </form>
            </template>
        </app-modal>
    </Teleport>

    <fertilizer-filter :showModal="showModalFilter" @close="closeFilter" @save="saveFilter"></fertilizer-filter>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import FertilizerFilter from "../../components/filterComponent/FertilizerFilter.vue";
import FertilizerImport from "../../components/importComponent/FertilizerImport.vue";

export default {
    name: "FertilizerPage",
    setup() {
        const store = useStore();
        const loader = ref(true);
        const showModal = ref(false);
        const typeSave = ref(0);
        const fertilizerModel = ref({});
        const showModalFilter = ref(false);

        const fertilizers = computed(() => store.getters["fertilizer/getFertilizers"]);
        const cultures = computed(() => store.getters["culture/getCultures"]);
        const errorCount = computed(() => store.getters["fertilizer/getErrorCount"]);
        const errors = computed(() => store.getters["fertilizer/getErrors"]);
        const isFilter = computed(() => store.getters["fertilizerFilter/getIsFilter"]);

        const formatMoney = new Intl.NumberFormat("ru-RU", { currency: "RUB", style: "currency" });

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("fertilizer/index");
            await store.dispatch("culture/index");
            loader.value = false;
        });

        const save = async () => {
            if (typeSave.value === 1) {
                await store.dispatch("fertilizer/store", fertilizerModel.value);
                showModal.value = false;
                errorCount.value == 0 ? (fertilizerModel.value = {}) : fertilizerModel.value;
            } else if (typeSave.value === 2) {
                await store.dispatch("fertilizer/update", fertilizerModel.value);
                showModal.value = false;
                errorCount.value == 0 ? (fertilizerModel.value = {}) : fertilizerModel.value;
            }
        };

        return {
            store,
            loader,
            fertilizerModel,
            save,
            showModal,
            fertilizers,
            cultures,
            errorCount,
            errors,
            formatMoney,
            showModalFilter,
            isFilter,
            create: () => {
                showModal.value = true;
                typeSave.value = 1;
            },
            close: () => {
                showModal.value = false;
                store.commit("fertilizer/remuveError");
                fertilizerModel.value = {};
            },
            remuve: async (id) => {
                await store.dispatch("fertilizer/destroy", id);
            },
            update: (fertilizer) => {
                showModal.value = true;
                fertilizerModel.value = Object.assign({}, fertilizer);
                typeSave.value = 2;
            },
            saveFilter: () => {
                showModalFilter.value = false;
            },
            deleteFilter: async () => {
                store.commit("fertilizerFilter/remuveFilter");
            },
            closeFilter: () => {
                showModalFilter.value = false;
            },
            download: () => store.dispatch("fertilizer/download"),
        };
    },
    components: { FertilizerFilter, FertilizerImport },
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
