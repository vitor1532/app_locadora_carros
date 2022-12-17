<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo == 'text'">{{valor}}</span>
                    <span v-if="titulos[chaveValor].tipo == 'data'">{{'...'+valor}}</span>
                    <span v-if="titulos[chaveValor].tipo == 'img'">
                        <img :src="'/storage/'+valor" width="30" height="30">
                    </span>
                </td>
            </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
export default {
    name: "TableComponent",
    props: ['titulos', 'dados'],
    computed: {
        dadosFiltrados() {

            let campos = Object.keys(this.titulos)
            let dadosFiltrados = []

            this.dados.map((i, key) => {

                let itemFiltrado = {}

                campos.forEach(campo => {
                    itemFiltrado[campo] = i[campo] // utilizar a sintaxe de arrays para atribuir valores a objetos
                })
                dadosFiltrados.push(itemFiltrado)
            })

            console.log(dadosFiltrados)

            return dadosFiltrados
        }
    }
    //
}
</script>

<style scoped>

</style>
