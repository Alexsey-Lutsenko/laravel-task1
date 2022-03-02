<template>
    <div class="d-flex align-items-center">
        <input class="form-control" type="file" ref="file" id="file" />
        <input class="btn btn-success" id="btn-upload" type="submit" value="Отправить" @click.prevent="submitFile" />
        <small class="mx-2" v-if="message">{{ message }}</small>
    </div>
</template>

<script>
import { computed, ref } from "vue";
import { useStore } from "vuex";

export default {
    name: "FertilizerImport",
    setup(props, { emit }) {
        const store = useStore();
        const file = ref(null);

        const message = computed(() => store.getters["fertilizer/getMessage"]);
        const user = computed(() => store.getters["auth/getAdmin"]);

        return {
            file,
            message,
            submitFile: async () => {
                if (file.value.files.length > 0) {
                    let formData = new FormData();
                    formData.append("files", file.value.files[0]);
                    formData.append("user_id", user.value.id);
                    formData.append("data", "Клиенты");

                    await store.dispatch("fertilizer/import", { formData: formData, user_id: user.value.id, data: "Удобрения" });
                    await store.dispatch("fertilizer/index");
                    store.commit("fertilizer/setMessage", "Импорт завершен");
                    file.value.value = "";
                    setTimeout(() => store.commit("fertilizer/setMessage", ""), 2000);
                } else {
                    store.commit("fertilizer/setMessage", "Данные не выбраны");
                }
            },
        };
    },
};
</script>

<style>
#file {
    width: 230px !important;
    border-radius: 5px 0 0 5px;
}
#btn-upload {
    border-radius: 0 5px 5px 0;
}
</style>
