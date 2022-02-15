<template>
    <button class="btn btn-secondary">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "AppButtonClose"
}
</script>

<style scoped>
.btn {
    padding: 0.4rem 2rem;
}
</style>
