<template>
    <table class="table table-hover">
        <thead class="text-center">
            <slot name="thead"></slot>
        </thead>
        <tbody>
            <slot name="tbody"></slot>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "AppTable",
    components: {}

}
</script>

<style scoped>

</style>
