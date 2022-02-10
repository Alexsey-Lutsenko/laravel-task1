<template>
    <input :value="modelValue" @input="updateInput" type="text">
</template>

<script>
export default {
    name: "AppInput",
    props: {
        modelValue: [String, Number]
    },
    methods: {
        updateInput(event) {
            this.$emit("update:modelValue", event.target.value)
        }
    }
}
</script>

<style scoped lang="scss">

input {
    width: 100%;
    padding: 0.375rem 0.75rem;
    background-clip: padding-box;
    border: 1px solid var(--app-color-green);
    border-radius: 0.25rem;
    margin-bottom: 25px;
}

input:focus {
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(163, 196, 153, 0.3);
}

</style>

