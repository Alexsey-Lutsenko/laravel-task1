<template>
    <datepicker :locale="locale" inputFormat="dd.MM.yyyy"></datepicker>
</template>

<script>
import Datepicker from "vue3-datepicker";
import { ru } from "date-fns/locale";

export default {
    name: "AppCalendar",
    setup() {
        const locale = ru;

        return {
            locale,
        };
    },
    components: { Datepicker },
};
</script>

<style>
.v3dp__input_wrapper input {
    width: 100%;
    padding: 0.375rem 0.75rem;
    background-clip: padding-box;
    border: 1px solid var(--app-color-green);
    border-radius: 0.25rem;
}

.v3dp__input_wrapper input:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(163, 196, 153, 0.3);
}
</style>
