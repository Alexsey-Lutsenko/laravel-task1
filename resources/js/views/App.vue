<template>
    <component :is="layout + '-layout'" v-if="layout"></component>
</template>

<script>
import { computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import MainLayout from "./layout/MainLayout";
import AdminLayout from "./layout/AdminLayout";

export default {
    name: "App",
    setup() {
        const store = useStore();
        const route = useRoute();

        onMounted(() => store.dispatch("auth/getAdmin"));

        return {
            layout: computed(() => route.meta.layout),
        };
    },
    components: {
        MainLayout,
        AdminLayout,
    },
};
</script>

<style scoped></style>
