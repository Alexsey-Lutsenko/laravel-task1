<template>
    <button class="btn btn-primary" @click="$emit('create')">
        <i class="fa-solid fa-square-plus mx-1"></i>
        <slot>Новая запись</slot>
    </button>
</template>

<script>
export default {
    name: "AppButtonCreate",
    emits: ["create"],
};
</script>

<style scoped></style>
