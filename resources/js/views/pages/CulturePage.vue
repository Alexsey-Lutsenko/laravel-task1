<template>
    <h1>Управление культурами</h1>
    <div class="d-flex w-50 mt-3 mb-2 justify-content-start" v-if="!loader">
        <app-button-create @create="create"> Новая культура </app-button-create>
    </div>

    <div class="d-flex w-100 justify-content-center">
        <app-loader v-if="loader"></app-loader>
    </div>

    <app-table class="w-50" v-if="!loader">
        <template v-slot:thead>
            <tr>
                <th>Культура</th>
            </tr>
        </template>
        <template v-slot:tbody>
            <tr v-for="culture of cultures" :key="culture.id" class="text-center">
                <td>{{ culture.culture }}</td>
                <td>
                    <i class="fa-solid fa-pencil text-primary fs-5" @click="update(culture)"></i>
                </td>
                <td>
                    <i class="fa-regular fa-trash-can text-danger fs-5 pointer-event" @click="remuve(culture.id)"></i>
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
                        <label for="cultureName">Название культуры</label>
                        <app-input id="cultureName" v-model.trim="cultureModel.culture"></app-input>
                        <small class="text-danger">{{ errors.culture }}</small>
                    </div>
                </form>
            </template>
        </app-modal>
    </Teleport>

    <app-toast></app-toast>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "CulturePage",
    setup() {
        const loader = ref(true);
        const showModal = ref(false);
        const typeSave = ref(0);
        const store = useStore();
        const cultureModel = ref({});

        const cultures = computed(() => store.getters["culture/getCultures"]);
        const errorCount = computed(() => store.getters["culture/getErrorCount"]);
        const errors = computed(() => store.getters["culture/getErrors"]);

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("culture/index");
            loader.value = false;
        });

        const save = async () => {
            if (typeSave.value === 1) {
                await store.dispatch("culture/store", cultureModel.value);
                showModal.value = false;
                errorCount.value == 0 ? (cultureModel.value = {}) : cultureModel.value;
            } else if (typeSave.value === 2) {
                await store.dispatch("culture/update", cultureModel.value);
                showModal.value = false;
                errorCount.value == 0 ? (cultureModel.value = {}) : cultureModel.value;
            }
        };

        return {
            loader,
            cultures,
            errorCount,
            showModal,
            errors,
            cultureModel,
            save,
            create: () => {
                showModal.value = true;
                typeSave.value = 1;
            },
            close: () => {
                showModal.value = false;
                store.commit("culture/remuveError");
                cultureModel.value = {};
            },
            remuve: async (id) => {
                await store.dispatch("culture/destroy", id);
            },
            update: (culture) => {
                showModal.value = true;
                cultureModel.value = Object.assign({}, culture);
                typeSave.value = 2;
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
