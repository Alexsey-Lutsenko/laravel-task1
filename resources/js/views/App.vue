<template>
    <component :is="layout + '-layout'" v-if="layout"></component>
</template>

<script>
import {computed} from "vue"
import {useRoute} from "vue-router"
import MainLayout from "./layout/MainLayout";
import AdminLayout from "./layout/AdminLayout";

export default {
    name: "App",
    setup() {
        const route = useRoute();

        return {
            layout: computed(() => route.meta.layout)
        }
    },
    components: {
        MainLayout, AdminLayout
    }
}
</script>

<style scoped>

</style>
