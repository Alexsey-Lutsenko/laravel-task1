<template>
    <select
        :value="modelValue"
        @input="updateInput"
        class="form-select"
        aria-label="Default select example"
    >
        <option disabled value="">Выберите один из вариантов</option>
        <slot></slot>
    </select>
</template>

<script>
export default {
    name: "AppSelect",
    props: {
        modelValue: [String, Number],
    },
    methods: {
        updateInput(event) {
            this.$emit("update:modelValue", event.target.value);
        },
    },
};
</script>

<style scoped>
select {
    width: 100%;
    padding: 0.375rem 0.75rem;
    background-clip: padding-box;
    border: 1px solid var(--app-color-green);
    border-radius: 0.25rem;
}
select:focus {
    outline: 0;
    border: 1px solid var(--app-color-green);
    box-shadow: 0 0 0 0.2rem rgba(163, 196, 153, 0.3);
}
</style>
