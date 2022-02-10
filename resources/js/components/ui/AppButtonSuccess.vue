<template>
    <button class="btn btn-success">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "AppButtonSuccess"
}
</script>

<style scoped>
.btn {
    padding: 0.4rem 2rem;
}
</style>
