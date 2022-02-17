<template>
    <h5>Удобрения</h5>

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
            </tr>
        </template>
    </app-table>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "FertilizerDeleted",
    setup() {
        const loader = ref(true);
        const store = useStore();

        const fertilizers = computed(() => store.getters["fertilizer/getFertilizersDeleted"]);

        const formatMoney = new Intl.NumberFormat("ru-RU", { currency: "RUB", style: "currency" });

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("fertilizer/indexDeleted");
            loader.value = false;
        });

        return {
            loader,
            fertilizers,
            formatMoney,
        };
    },
};
</script>

<style></style>
