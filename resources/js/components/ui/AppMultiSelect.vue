<template>
    <select class="form-select" multiple aria-label="multiple select example" v-model="model">
        <slot></slot>
    </select>
</template>

<script>
export default {
    name: "AppMultiSelect",
    props: ["model"],
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
