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
            <tr>
                <th scope="row"> marcasID </th>
                <td> nome </td>
                <td> imagem </td>
            </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary btn-sm float-right" name="btn" @click="getMarca()">get</button>

    </div>
</template>

<script>
export default {
    name: "TableComponent",
    props: ['headId', 'head1', 'head2'],
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/marca',
            nomeMarca: '',
            arquivoImagem: []
        }
    },
    methods: {
        getMarca() {
            axios.get(this.urlBase)
                .then(response => {
                    console.log(response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        }
    }
}
</script>

<style scoped>

</style>
