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

        const message = computed(() => store.getters["client/getMessage"]);
        const user = computed(() => store.getters["auth/getAdmin"]);

        return {
            file,
            message,
            submitFile: async () => {
                if (file.value.files.length > 0) {
                    let formData = new FormData();
                    formData.append("files", file.value.files[0]);

                    await store.dispatch("client/import", { formData: formData, user_id: user.value.id, data: "Клиенты" });
                    await store.dispatch("client/index");
                    store.commit("client/setMessage", "");
                    file.value.value = "";
                } else {
                    store.commit("client/setMessage", "Данные не выбраны");
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
