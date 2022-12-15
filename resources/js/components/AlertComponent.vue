<template>

    <div :class="estilo" role="alert">
        <slot name="mensagemSuccess"></slot>
        <slot name="mensagemErro"></slot>
    </div>

</template>

<script>
export default {
    name: "AlertComponent",
    props:['tipo'],
    computed: {
        estilo() {
            return 'alert alert-'+this.tipo
        }
    }
}
</script>

<style scoped>

</style>
