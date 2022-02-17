<template>
    <h5>Культуры</h5>

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
            </tr>
        </template>
    </app-table>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

export default {
    name: "CultureDeleted",
    setup() {
        const loader = ref(true);
        const store = useStore();

        const cultures = computed(() => store.getters["culture/getCulturesDeleted"]);

        onMounted(async () => {
            loader.value = true;
            await store.dispatch("culture/indexDeleted");
            loader.value = false;
        });

        return {
            loader,
            cultures,
        };
    },
};
</script>

<style></style>
