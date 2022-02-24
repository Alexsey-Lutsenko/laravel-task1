<template>
    <p>
        <input type="file" ref="file" id="file" />
        <input type="submit" value="Отправить" @click.prevent="submitFile" />
        <small class="mx-2" v-if="fileMessage">{{ fileMessage }}</small>
    </p>
</template>

<script>
import { ref } from "vue";
import { useStore } from "vuex";

export default {
    name: "ClientImport",
    emits: ["submitFile"],
    setup(props, { emit }) {
        const store = useStore();
        const file = ref(null);
        const fileMessage = ref("");

        return {
            file,
            fileMessage,
            submitFile: async () => {
                emit("submitFile");

                if (file.value.files.length > 0) {
                    fileMessage.value = "";
                    let formData = new FormData();
                    formData.append("files", file.value.files[0]);
                    await store.dispatch("client/import", formData);
                    fileMessage.value = "Данные успешно добавлены";
                    setTimeout(() => {
                        fileMessage.value = "";
                    }, 3000);
                    file.value.value = "";
                } else {
                    fileMessage.value = "Выберите файлы для отправки";
                }
            },
        };
    },
};
</script>

<style></style>
