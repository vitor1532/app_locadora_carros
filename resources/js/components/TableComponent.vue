<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">{{ headId }}</th>
                <th scope="col">{{ head1 }}</th>
                <th scope="col">{{ head2 }}</th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="o, key in lista.dados" :key="key">
                <!-- v-for="e, key in detalhes.dados" :key="key"         {{ lista.dados }}-->
                <th scope="row"> {{o.id}} </th>
                <td> {{o.nome}} </td>
                <td> {{o.imagem}} </td>
            </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
export default {
    name: "TableComponent",
    props: ['headId', 'head1', 'head2', 'lista'],
}
</script>

<style scoped>

</style>
