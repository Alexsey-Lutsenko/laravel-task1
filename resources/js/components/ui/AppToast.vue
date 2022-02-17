<template></template>

<script>
import { defineComponent, computed, watch } from "vue";
import { useStore } from "vuex";
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

export default {
    name: "AppToast",
    setup() {
        const store = useStore();
        const errorMessage = computed(() => store.getters["culture/getErrorMessage"]);
        const errorMessageTimeout = computed(() => store.getters["culture/getErrorMessageTimeout"]);

        watch(errorMessage, (value) => {
            if (value) {
                createToast(errorMessage.value, {
                    type: "danger", // 'info', 'danger', 'warning', 'success', 'default'
                    timeout: errorMessageTimeout.value,
                    showCloseButton: true,
                    position: "top-right", // 'top-left', 'top-right', 'bottom-left', 'bottom-right', 'top-center', 'bottom-center'
                    transition: "slide",
                    hideProgressBar: true,
                    swipeClose: true,
                    onClose: null,
                });
            }
        });
    },
};
</script>

<style>
.mosha__toast {
    top: 80px !important;
}
.mosha__toast__content__text {
    font-family: "Nunito", sans-serif !important;
    font-weight: 500;
    line-height: 1.2;
}
</style>
