<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
                    <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel">...</th>
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
                <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                    <button v-if="visualizar.visivel" class="btn btn-outline-success btn-sm" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget" @click="setStore(obj)">Visualizar</button>
                    <button v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget" @click="setStore(obj)">Editar</button>
                    <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(obj)">Deletar</button>
                </td>
            </tr>
            </tbody>
        </table>


    </div>
</template>

<script>
export default {
    name: "TableComponent",
    props: ['titulos', 'dados', 'visualizar', 'atualizar', 'remover'],
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
        setStore(obj) {
            //console.log(obj)
            this.$store.state.item = obj
        },
    }
    //
}
</script>

<style scoped>

</style>
