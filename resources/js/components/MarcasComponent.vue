<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Inicio do card de busca -->
                <card-component title="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" foo-help = "idHelp" descricao = "Opcional.">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Informe o ID da marca" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome" id="inputNome" foo-help = "nomeHelp" descricao = "Opcional.">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Informe o nome da marca" v-model="busca.nome">
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
                <card-component title="Listagem de marcas">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="marcas.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalVisualizarMarca'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalEditarMarca'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalRemoverMarca'}"
                            :titulos="{id: {titulo: 'ID', tipo:'text'}, nome: {titulo: 'Nome', tipo:'text'}, imagem: {titulo: 'Imagem', tipo:'img'}, created_at: {titulo: 'Data de Criação', tipo:'data'}}">
                        </table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in marcas.links" :key="key" :class="l.active ? 'page-item active' : 'page-item'" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <!-- Button trigger modal -->
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-right" name="btn" data-toggle="modal" data-target="#criarMarcasModal" @click="dismissForm()">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim do card de listagem -->
            </div>
        </div>

        <!-- Modal de inclusão de marca -->
        <modal-component id="criarMarcasModal" title="Criar Marcas">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso ao tentar cadastrar a marca" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component id="marcaInput" titulo="Nome" foo-help="marcaInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="marcaInput" aria-describedby="marcaInputHelp" placeholder="Informe o nome da marca" v-model="nomeMarca">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="imagemInput" titulo="Imagem" foo-help="imagemHelp" descricao="Obrigatório.">
                        <input type="file" class="form-control-image" id="imagemInput" placeholder="Selecione uma imagem no formato PNG" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="salvar()">Inserir marca</button>
            </template>

        </modal-component>
        <!-- Fim do Modal de inclusão de marca -->

        <!-- Modal de visualização de marca -->
        <modal-component id="modalVisualizarMarca" title="Vizualizar Marca">
            <template v-slot:alertas>
            </template>

            <template v-slot:conteudo>
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled/>
                </input-container-component>
                <input-container-component titulo="Nome">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled/>
                </input-container-component>
                <input-container-component titulo="Imagem">
                    <br><img :src="'/storage/'+$store.state.item.imagem" width="50" height="50" v-if="$store.state.item.imagem">
                </input-container-component>
                <input-container-component titulo="Data Criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled/>
                </input-container-component>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
            </template>
        </modal-component>
        <!-- Fim do Modal de visualização de marca -->

        <!-- Inicio do Modal de Edição de marca -->
        <modal-component id="modalEditarMarca" title="Editar Marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Sucesso ao editar a marca" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro ao tentar editar a marca" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <strong>{{$store.state.item.nome}}</strong><br>
                <input-container-component titulo="Nome" id="nomeInputEditar" foo-help="imagemEditarHelp">
                    <input type="text" class="form-control" v-model="$store.state.item.nome"/>
                </input-container-component>
                <input-container-component id="imagemInputEditar" titulo="Imagem" foo-help="imagemEditarHelp" descricao="Obrigatório.">
                    <input type="file" class="form-control-image" id="imagemInputEditar" placeholder="Selecione uma imagem no formato PNG" @change="carregarImagem($event)">
                </input-container-component>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="atualizar()">Atualizar marca</button>
            </template>
        </modal-component>
        <!-- Fim do Modal de Edição de marca -->

        <!-- Início do Modal de deletar Marca -->
        <modal-component id="modalRemoverMarca" title="Remover Marca">
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
        <!-- Fim do Modal de deletar marca -->

    </div>

</template>

<script>
    import InputContainerComponent from "./InputContainerComponent.vue";
    import TableComponent from "./TableComponent.vue";
    import CardComponent from "./CardComponent.vue";
    import ModalComponent from "./ModalComponent.vue";
    import KonamiCode from 'vue-konami-code';

    export default {

        name: "MarcasComponent",
        components: {InputContainerComponent, TableComponent, ModalComponent, CardComponent},
        data() {
            return {
                urlBase: 'http://127.0.0.1:8000/api/v1/marca',
                urlPaginacao: '',
                urlFiltro: '',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
                marcas: { data: [] },
                busca: { id:'', nome: '' },
            }
        },
        methods: {
            dismissForm() {
                this.nomeMarca = ''
                document.getElementById('imagemInput').value = []
                this.transacaoStatus = ''
                this.transacaoDetalhes = {}
            },
            pesquisar(){
                //console.log(this.busca)

                let filtro = ''

                for(let chave in this.busca) {

                    if(this.busca[chave]) {
                        if(filtro != '') {
                            filtro += ';'
                        }
                        if(chave === 'nome') {
                            filtro += chave + ':like:' + this.busca[chave] + '%'
                        } else {
                            filtro += chave + ':like:' + this.busca[chave]
                        }
                    }
                }
                if(filtro != '') {
                    this.urlPaginacao = 'page=1'
                    this.urlFiltro = '&filtro='+filtro
                } else {
                    this.urlFiltro = ''
                }

                this.carregarLista()
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
                        this.marcas = response.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            salvar() {

                let formData = new FormData();
                formData.append('nome', this.nomeMarca)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }

                //console.log(this.arquivoImagem[0], this.nomeMarca, config, formData, this.urlBase);

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
            atualizar() {

                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('nome', this.$store.state.item.nome)

                if(this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0])
                }

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },

                }
                let url = this.urlBase+'/'+this.$store.state.item.id

                axios.post(url, formData, config)
                    .then(response => {
                        imagemInputEditar.value = ''
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro atualizado com sucesso'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        console.log(errors.response)
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
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
