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

    </div>
</template>

<script>
export default {
    name: "TableComponent",
    props: ['headId', 'head1', 'head2'],
}
</script>

<style scoped>

</style>
