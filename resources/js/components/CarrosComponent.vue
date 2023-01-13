<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <card-component title="Busca de Carros">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" foo-help = "idHelp" descricao = "Opcional.">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Informe o ID do carro">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome" id="inputNome" foo-help = "nomeHelp" descricao = "Opcional.">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Informe o nome do carro">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" name="btn">Pesquisar</button>
                    </template>
                </card-component>

                <card-component title="Listagem de Carros">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="carros.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalVisualizarCarros'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalEditarCarros'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalRemoverCarros'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo:'text'},
                                placa: {titulo: 'Placa', tipo: 'text'},
                                disponivel: {titulo: 'Disponível', tipo: 'boolean'},
                                km: {titulo: 'Km', tipo: 'text'}
                            }">
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
                                <button type="button" class="btn btn-primary btn-sm float-right" name="btn" data-toggle="modal" data-target="#criarCarrosModal" @click="dismissForm()">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
            </div>
        </div>

        <!-- Modal Criação de carros -->
            <modal-component id="criarCarrosModal" title="Adicionar Carro">
                <template v-slot:alertas>
                    <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso ao tentar cadastrar o modelo" v-if="transacaoStatus == 'adicionado'"></alert-component>
                    <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'erro'"></alert-component>
                </template>

                <template v-slot:conteudo>
                    <div class="form-group">
                        <input-container-component  id="modeloInput" titulo="Nome da Marca" foo-help="modeloInputHelp" descricao="Obrigatório.">
                            <select class="custom-select mr-sm-2" id="modeloInput" v-model="modeloCarro">
                                <option v-for="modelo in modelos" :value="modelo.id">{{ modelo.nome }}</option>
                            </select>
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component id="placaInput" titulo="Placa" foo-help="placaInputHelp" descricao="Obrigatório.">
                            <input type="text" class="form-control" id="placaInput" aria-describedby="placaInputHelp" placeholder="Informe o número da placa" v-model="placa">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component id="kmInput" titulo="Km" foo-help="kmInputHelp" descricao="Obrigatório.">
                            <input type="number" class="form-control" id="kmInput" aria-describedby="kmInputHelp" placeholder="Informe os km rodados" v-model="km">
                        </input-container-component>
                    </div>
                </template>

                <template v-slot:footer>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-primary" @click="salvar()">Inserir Modelo</button>
                </template>
            </modal-component>
        <!-- Fim do Modal Criação de carros -->

        <!-- Início do Modal de deletar Marca -->
        <modal-component id="modalRemoverCarros" title="Remover Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Sucesso ao remover a marca" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro ao tentar remover a marca" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled/>
                </input-container-component>
                <input-container-component titulo="Placa">
                    <input type="text" class="form-control" :value="$store.state.item.placa" disabled/>
                </input-container-component>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-danger" @click="deletar()" v-if="$store.state.transacao.status != 'sucesso'">Remover carro</button>
            </template>
        </modal-component>
        <!-- Fim do Modal de deletar marca -->

        <!-- Modal Visualização de carros -->
        <modal-component id="modalVisualizarCarros" title="Adicionar Carro">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso ao tentar cadastrar o modelo" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component  id="modeloInput" titulo="ID do Carro" foo-help="modeloInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="modeloInput" aria-describedby="modeloInputHelp" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="placaInput" titulo="Placa" foo-help="placaInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="placaInput" aria-describedby="placaInputHelp" placeholder="Informe o número da placa" :value="$store.state.item.placa" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="kmInput" titulo="Km" foo-help="kmInputHelp" descricao="Obrigatório.">
                        <input type="number" class="form-control" id="kmInput" aria-describedby="kmInputHelp" placeholder="Informe os km rodados" :value="$store.state.item.km" disabled>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="teste()">teste</button>
            </template>
        </modal-component>
        <!-- Fim do Modal Visualização de carros -->

    </div>

</template>

<script>
import ModalComponent from "./ModalComponent.vue";

export default {
    name: "CarrosComponent",
    components: {ModalComponent},
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/carro',
            urlPaginacao: '',
            urlFiltro: '',
            transacaoStatus: '',
            transacaoDetalhes: {},
            modeloCarro: '',
            placa: '',
            modelos: { data: [] },
            carros: { data: [] },
            km: '',
            disponivel: true,
        }
    },
    methods: {
        deletar() {
            let confirmacao = confirm('Tem certeza que deseja remover esse registro ?')

            if(!confirmacao) {
                return false;
            }

            let formData = new FormData()
            formData.append("_method", "delete")

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }
            let url = this.urlBase + '/' + this.$store.state.item.id

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = response.data.msg
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.erro
                })
        },
        salvar() {
            this.disponivel = Number(this.disponivel)

            let formData = new FormData();
            formData.append('modelo_id', this.modeloCarro)
            formData.append('placa', this.placa)
            formData.append('disponivel', this.disponivel)
            formData.append('km', this.km)

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }

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
        dismissForm() {
            console.log('dismiss')
        },
        getModelos() {
            axios.get('http://127.0.0.1:8000/api/v1/modelo?get')
                .then(response => {
                    this.modelos = response.data
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
                    this.carros = response.data
                    //console.log('data: '+JSON.stringify(this.carros))
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        teste() {
            console.log(this.$store.state.item)
        }
    },
    mounted() {
        this.getModelos()
        this.carregarLista()
    }
}
</script>
