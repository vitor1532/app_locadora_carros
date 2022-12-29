<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
                    <th v-if="visualizarBotao || atualizarBotao || removerBotao">...</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo == 'text'">{{valor}}</span>
                    <span v-if="titulos[chaveValor].tipo == 'data'">{{valor.substring(0, 10)}}</span>
                    <span v-if="titulos[chaveValor].tipo == 'img'">
                        <img :src="'/storage/'+valor" width="30" height="30">
                    </span>
                </td>
                <td v-if="visualizarBotao || atualizarBotao || removerBotao">
                    <button v-if="visualizarBotao" class="btn btn-outline-success btn-sm">Visualizar</button>
                    <button v-if="atualizarBotao" class="btn btn-outline-primary btn-sm">Editar</button>
                    <button v-if="removerBotao" class="btn btn-outline-danger btn-sm" @click="deleteRegistro()">Deletar</button>
                </td>
            </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
export default {
    name: "TableComponent",
    props: ['titulos', 'dados', 'visualizarBotao', 'atualizarBotao', 'removerBotao'],
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

            return dadosFiltrados
        }
    },
    methods: {
        deleteRegistro() {

        }
    }
    //
}
</script>

<style scoped>

</style>
