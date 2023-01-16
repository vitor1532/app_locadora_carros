<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Inicio do card de busca -->
                <card-component title="Busca de Locações">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" foo-help = "idHelp" descricao = "Opcional.">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Informe o ID da locação" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome" id="inputNome" foo-help = "nomeHelp" descricao = "Opcional.">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Informe o nome do cliente" v-model="busca.cliente">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" name="btn" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->

                <!-- Inicio do card de listagem -->
                <card-component title="Listagem de locações">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="locacoes.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalVisualizarMarca'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalEditarMarca'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalRemoverMarca'}"
                            :titulos="{id: {titulo: 'ID', tipo:'text'}, nome: {titulo: 'Nome', tipo:'text'}}">
                        </table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in locacoes.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <!-- Button trigger modal -->
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" name="btn" data-toggle="modal" data-target="#criarLocacoesModal" @click="dismissForm()">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim do card de listagem -->

            </div>
        </div>

        <!-- Modal de inclusão -->
        <modal-component id="criarLocacoesModal" title="Criar Locações">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso ao tentar cadastrar a marca" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-row">

                    <div class="col mb-3">
                        <input-container-component id="dataInicioInput" titulo="Data Inicial" foo-help="dataInicioInputHelp" descricao="Obrigatório.">
                            <input type="date" class="form-control" id="dataInicioInput" aria-describedby="dataInicioInputHelp" placeholder="Informe a data inicial do aluguel" v-model="dataInicio">
                        </input-container-component>
                    </div>

                    <div class="col mb-3">
                        <input-container-component id="dataEntregaInput" titulo="Data de entrega" foo-help="dataEntregaInputHelp" descricao="Obrigatório.">
                            <input type="date" class="form-control" id="dataEntregaInput" aria-describedby="dataEntregaInputHelp" placeholder="Informe a data de entrega" v-model="dataEntrega">
                        </input-container-component>
                    </div>
                </div>
                <div class="form-group">
                    <input-container-component id="clienteInput">
                        <input type="hidden" :value="clienteId">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component  id="modeloInput" titulo="Nome do Modelo" foo-help="modeloInputHelp" descricao="Obrigatório.">
                        <select class="custom-select mr-sm-2" id="modeloInput" v-model="modeloCarro" @change="getCarros()">
                            <option v-for="modelo in modelos" :value="modelo.id">{{ modelo.nome }}</option>
                        </select>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component  id="modeloInput" titulo="Nome do Modelo" foo-help="modeloInputHelp" descricao="Obrigatório.">
                        <select class="custom-select mr-sm-2" id="modeloInput" v-model="carroId" @change="getCarroCompleto()">
                            <option v-for="carro in carros" :value="carro.id">{{ carro.placa }}</option>
                        </select>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="salvar()">Inserir</button>
            </template>

        </modal-component>
        <!-- Fim do Modal de inclusão -->

    </div>

</template>

<script>
import InputContainerComponent from "./InputContainerComponent.vue";
import TableComponent from "./TableComponent.vue";
import ModalComponent from "./ModalComponent.vue";
import CardComponent from "./CardComponent.vue";

export default {
    components: {InputContainerComponent, TableComponent, ModalComponent, CardComponent},
    props: ['clienteId'],
    data() {
        return {
            cliente: '',
            disponivel: '',
            modeloCarro: '',
            carroId: '',
            carroSelected: { data: [] },
            transacaoDetalhes: {},
            transacaoStatus: '',
            dataInicio: '',
            dataEntrega: '',
            locacoes: { data: [] },
            busca: { id:'', cliente: '' },
            modelos: { data: [] },
            carros: { data: [] },
        }
    },
    methods: {
        pesquisar() {
            console.log('io')
        },
        paginacao(l) {
            if(l.url) {
                //this.urlBase = l.url
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarLista()
            }
        },
        dismissForm() {
          console.log('opt')
        },
        salvar() {

            let formData = new FormData();
            formData.append('cliente_id', this.clienteId)
            formData.append('modelo_id', this.modeloCarro)
            formData.append('carro_id', this.carroId)
            formData.append('data_inicio_periodo', this.dataInicio)
            formData.append('data_final_previsto_periodo', this.dataEntrega)
            formData.append('km_inicial', this.carroSelected.km)

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }

            console.log(Object.fromEntries(formData))

            // axios.post(this.urlBase, formData, config)
            //     .then(response => {
            //         this.transacaoStatus = 'adicionado'
            //         this.transacaoDetalhes = {
            //             mensagem: 'ID do registro: ' + response.data.id
            //         }
            //         this.carregarLista()
            //     })
            //     .catch(errors => {
            //         this.transacaoStatus = 'erro'
            //         this.transacaoDetalhes = {
            //             mensagem: errors.response.data.message,
            //             dados: errors.response.data.errors
            //         }
            //         //errors.response.data.errors
            //     })
        },
        getModelos() {
            let url = 'http://127.0.0.1:8000/api/v1/modelo?get'

            axios.get(url)
                .then(response => {
                    console.log(response.data)
                    this.modelos = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        getCarros() {

            let url = 'http://127.0.0.1:8000/api/v1/carro?get&filtro=modelo_id:like:'+ this.modeloCarro

            axios.get(url)
                .then(response => {
                    this.carros = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        getCarroCompleto() {
            let url = 'http://127.0.0.1:8000/api/v1/carro/'+ this.modeloCarro

            axios.get(url)
                .then(response => {
                    this.carroSelected = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
            //console.log(this.carroSelected)
        },
        teste() {
            console.log('modelo_id: '+this.modeloCarro)
        }
    },
    mounted() {
        this.getModelos()
    }
}
</script>
