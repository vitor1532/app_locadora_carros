<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Início do card de busca -->
                <card-component title="Busca de Modelos">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" foo-help = "idHelp" descricao = "Opcional.">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Informe o ID do modelo">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome" id="inputNome" foo-help = "nomeHelp" descricao = "Opcional.">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Informe o nome do modelo">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" name="btn">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->

                <!-- Início listagem de modelos -->
                <card-component title="listagem">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="modelos.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalVisualizarModelos'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalEditarModelos'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalRemoverModelos'}"
                            :titulos="{id: {titulo: 'ID', tipo:'text'}, nome: {titulo: 'Nome', tipo:'text'}, imagem: {titulo: 'Imagem', tipo:'img'}, created_at: {titulo: 'Data de Criação', tipo:'data'}}">
                        </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in modelos.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <!-- Button trigger modal -->
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" name="btn" data-toggle="modal" data-target="#criarModelosModal" @click="getMarcas()">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim listagem de modelos -->


            </div>
        </div>

        <!-- Modal de inclusão de marca -->
        <modal-component id="criarModelosModal" title="Criar Modelos">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso ao tentar cadastrar o modelo" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component  id="marcaInput" titulo="Nome da Marca" foo-help="marcaInputHelp" descricao="Obrigatório.">
                        <select class="custom-select mr-sm-2" id="portasInput" v-model="marcaModelo">
                            <option selected disabled>Nome da marca</option>
                            <option v-for="marca in marcas" :value="marca.id">{{ marca.nome }}</option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="modeloInput" titulo="Nome" foo-help="modeloInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="modeloInput" aria-describedby="modeloInputHelp" placeholder="Informe o nome do modelo" v-model="nomeModelo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="imagemInput" titulo="Imagem" foo-help="imagemHelp" descricao="Obrigatório.">
                        <input type="file" class="form-control-image" id="imagemInput" placeholder="Selecione uma imagem no formato PNG" @change="carregarImagem($event)">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="portasInput" titulo="Número de portas" foo-help="portasInputHelp" descricao="Obrigatório.">
                        <input type="number" class="form-control" id="portasInput" aria-describedby="portasInputHelp" placeholder="Informe a quantidade de portas do modelo" v-model="portasModelo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="lugaresInput" titulo="Número de lugares" foo-help="lugaresInputHelp" descricao="Obrigatório.">
                        <input type="number" class="form-control" id="lugaresInput" aria-describedby="lugaresInputHelp" placeholder="Informe a quantidade de lugares do modelo" v-model="lugaresModelo">
                    </input-container-component>
                </div>

                <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="airBagsInput" v-model="airBagModelo">
                            <label class="custom-control-label" for="airBagsInput">Possui AirBags ?</label>
                            {{airBagModelo}}
                        </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="absInput" v-model="absModelo" v-bind:value="absModelo">
                        <label class="custom-control-label" for="absInput">Possui ABS ?</label>
                        {{absModelo}}
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="salvar()">Inserir Modelo</button>
            </template>

        </modal-component>
        <!-- Fim do Modal de inclusão de marca -->

    </div>

</template>

<script>
import InputContainerComponent from "./InputContainerComponent.vue";
import TableComponent from "./TableComponent.vue";
import ModalComponent from "./ModalComponent.vue";
import CardComponent from "./CardComponent.vue";
import Log from "laravel-mix/src/Log";

export default {
    name: "ModelosComponent",
    components: {InputContainerComponent, TableComponent, ModalComponent, CardComponent},
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/modelo',
            urlPaginacao: '',
            urlFiltro: '',
            marcaModelo: '',
            nomeModelo: '',
            portasModelo: '',
            lugaresModelo: '',
            airBagModelo: false,
            absModelo: false,
            arquivoImagem: [],
            transacaoStatus: '',
            transacaoDetalhes: {},
            modelos: { data: [] },
            busca: { id:'', nome: '' },
            marcas: { data: [] },
        }
    },
    methods: {
        getMarcas() {
            axios.get('http://127.0.0.1:8000/api/v1/marca?get')
                .then(response => {
                    this.marcas = response.data
                    console.log(response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        paginacao(l) {
            if(l.url) {
                //this.urlBase = l.url
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarLista()
            }
        },
        carregarLista() {
            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
                .then(response => {
                    this.modelos = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        carregarImagem(e) {
            this.arquivoImagem = e.target.files
        },
        salvar() {

            this.airBagModelo = Number(this.airBagModelo)
            this.absModelo = Number(this.absModelo)

            let formData = new FormData();
            formData.append('marca_id', this.marcaModelo)
            formData.append('nome', this.nomeModelo)
            formData.append('imagem', this.arquivoImagem[0])
            formData.append('numero_portas', this.portasModelo)
            formData.append('lugares', this.lugaresModelo)
            formData.append('air_bag', this.airBagModelo)
            formData.append('abs', this.absModelo)

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }

            console.log(Object.fromEntries(formData))

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id
                    }
                    this.carregarLista()
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                    //errors.response.data.errors
                })
        },
    },
    mouted() {
        this.carregarLista()
    }
}

</script>
