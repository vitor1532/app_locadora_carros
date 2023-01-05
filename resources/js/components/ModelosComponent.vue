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
                            :titulos="{
                                marca_id:{titulo: 'Id da Marca', tipo:'text'},
                                id: {titulo: 'ID', tipo:'text'},
                                nome: {titulo: 'Nome', tipo:'text'},
                                imagem: {titulo: 'Imagem', tipo:'img'},
                                numero_portas: {titulo: 'Portas', tipo:'text'},
                                lugares: {titulo: 'Lugares', tipo:'text'},
                                air_bag: {titulo: 'Air Bag', tipo: 'text'},
                                abs: {titulo: 'ABS', tipo: 'text'},
                                created_at: {titulo: 'Data de Criação', tipo:'data'}
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
                        </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="absInput" v-model="absModelo" v-bind:value="absModelo">
                        <label class="custom-control-label" for="absInput">Possui ABS ?</label>
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="salvar()">Inserir Modelo</button>
            </template>

        </modal-component>
        <!-- Fim do Modal de inclusão de marca -->

        <!-- Modal de visualizar marca -->
        <modal-component id="modalVisualizarModelos" title="Modelo">
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component  id="marcaInput" titulo="ID da Marca" foo-help="marcaInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="marcaInput" aria-describedby="marcaInputHelp" placeholder="Informe o nome do modelo" :value="$store.state.item.marca_id" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="modeloIdInput" titulo="ID" foo-help="modeloIdInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="modeloIdInput" aria-describedby="modeloIdInputHelp" placeholder="Informe o nome do modelo" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="modeloInput" titulo="Nome" foo-help="modeloInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="modeloInput" aria-describedby="modeloInputHelp" placeholder="Informe o nome do modelo" :value="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="imagemInput" titulo="Imagem" foo-help="imagemHelp" descricao="Obrigatório.">
                        <img :src="'/storage/'+$store.state.item.imagem" width="80" height="50" v-if="$store.state.item.imagem"/>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="portasInput" titulo="Número de portas" foo-help="portasInputHelp" descricao="Obrigatório.">
                        <input type="number" class="form-control" id="portasInput" aria-describedby="portasInputHelp" placeholder="Informe a quantidade de portas do modelo" :value="$store.state.item.numero_portas" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="lugaresInput" titulo="Número de lugares" foo-help="lugaresInputHelp" descricao="Obrigatório.">
                        <input type="number" class="form-control" id="lugaresInput" aria-describedby="lugaresInputHelp" placeholder="Informe a quantidade de lugares do modelo" :value="$store.state.item.lugares" disabled>
                    </input-container-component>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="airBagsInput" v-model="$store.state.item.air_bag" disabled>
                        <label class="custom-control-label" for="airBagsInput">Possui AirBags ?</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="absInput" v-model="$store.state.item.abs" disabled>
                        <label class="custom-control-label" for="absInput">Possui ABS ?</label>
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
            </template>

        </modal-component>
        <!-- Fim do Modal de visualizar marca -->

        <!-- Modal de edição de marca -->
        <modal-component id="modalEditarModelos" title="Criar Modelos">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso ao tentar cadastrar o modelo" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar o modelo" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>

                <div class="form-group">
                    <input-container-component id="modeloInput" titulo="Nome" foo-help="modeloInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="modeloInput" aria-describedby="modeloInputHelp" placeholder="Informe o nome do modelo" v-model="$store.state.item.nome">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="imagemInputEditar" titulo="Imagem" foo-help="imagemHelp" descricao="Obrigatório.">
                        <input type="file" class="form-control-image" id="imagemInputEditar" placeholder="Selecione uma imagem no formato PNG" @change="carregarImagem($event)">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="portasInput" titulo="Número de portas" foo-help="portasInputHelp" descricao="Obrigatório.">
                        <input type="number" class="form-control" id="portasInput" aria-describedby="portasInputHelp" placeholder="Informe a quantidade de portas do modelo" v-model="$store.state.item.numero_portas">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="lugaresInput" titulo="Número de lugares" foo-help="lugaresInputHelp" descricao="Obrigatório.">
                        <input type="number" class="form-control" id="lugaresInput" aria-describedby="lugaresInputHelp" placeholder="Informe a quantidade de lugares do modelo" v-model="$store.state.item.lugares">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="airBagsInput" v-model="$store.state.item.air_bag">
                        <label class="custom-control-label" for="airBagsInput">Possui AirBags ?</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="absInput" v-model="$store.state.item.abs">
                        <label class="custom-control-label" for="absInput">Possui ABS ?</label>
                    </div>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="salvar()">Inserir Modelo</button>
            </template>

        </modal-component>
        <!-- Fim do Modal de edição de marca -->

        <!-- Início do Modal de deletar modelo -->
        <modal-component id="modalRemoverModelos" title="Remover Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Sucesso ao remover a marca" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro ao tentar remover a marca" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled/>
                </input-container-component>
                <input-container-component titulo="Nome">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled/>
                </input-container-component>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-danger" @click="deletar()" v-if="$store.state.transacao.status != 'sucesso'">Remover marca</button>
            </template>
        </modal-component>
        <!-- Fim do Modal de deletar modelo -->

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
                    //console.log(response.data)
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
        }
    },
    mounted() {
        this.carregarLista()
    }
}

</script>
