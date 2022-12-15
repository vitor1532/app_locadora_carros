<template>

    <div :class="estilo" role="alert">
        <h5 class="font-weight-bold">{{ titulo }}</h5>
        <hr>
        <span v-if="detalhes.data.message">{{ detalhes.data.message }} </span><br>
        <span v-if="detalhes.data.id">{{'ID do registro: ' + detalhes.data.id }} </span><br>
        <ul v-if="detalhes.data.errors">
            <li v-for="e, key in detalhes.data.errors" :key="key"> {{ e[0] }}</li>
        </ul>
    </div>

</template>

<script>
export default {
    name: "AlertComponent",
    props:['tipo', 'titulo', 'detalhes'],
    computed: {
        estilo() {
            return 'alert alert-'+this.tipo
        },
    }
}
</script>

<style scoped>

</style>
