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
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Informe o ID da marca">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome" id="inputNome" foo-help = "nomeHelp" descricao = "Opcional.">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Informe o nome da marca">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-right" name="btn">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->

                <!-- Inicio do card de listagem -->
                <card-component title="Listagem de marcas">

                    <template v-slot:conteudo>

                        <table-component
                            headId="ID"
                            head1="Nome da Marca"
                            head2="Foto"
                        >

                        </table-component>



                    </template>
                    <template v-slot:rodape>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm float-right" name="btn" data-toggle="modal" data-target="#criarMarcasModal">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim do card de listagem -->
                <button type="button" class="btn btn-primary btn-sm float-right" name="btn" @click="carregarLista()">get</button>
            </div>
        </div>

        <!-- Modal -->
        <modal-component id="criarMarcasModal" title="Criar Marcas">

            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Sucesso ao tentar cadastrar a marca" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component id="marcaInput" titulo="Nome" fooHelp="marcaInputHelp" descricao="Obrigatório.">
                        <input type="text" class="form-control" id="marcaInput" aria-describedby="marcaInputHelp" placeholder="Informe o nome da marca" v-model="nomeMarca">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component id="imagemInput" titulo="Imagem" fooHelp="imagemHelp" descricao="Obrigatório.">
                        <input type="file" class="form-control-image" id="imagemInput" placeholder="Selecione uma imagem no formato PNG" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                <button type="submit" class="btn btn-primary" @click="salvar()">Inserir marca</button>
            </template>

        </modal-component>
        <!-- Fim do Modal -->

    </div>

</template>

<script>
    import InputContainerComponent from "./InputContainerComponent.vue";
    import TableComponent from "./TableComponent.vue";
    import CardComponent from "./CardComponent.vue";
    import ModalComponent from "./ModalComponent.vue";

    export default {
        name: "MarcasComponent",
        computed: {
            token() {
                let token = document.cookie.split(';').find(i => {
                    return i.includes('token=')
                })

                token = token.split('=')[1]

                token = 'Bearer ' + token

                return token
            }
        },
        components: {InputContainerComponent, TableComponent, ModalComponent, CardComponent},
        data() {
            return {
                urlBase: 'http://127.0.0.1:8000/api/v1/marca',
                nomeMarca: '',
                arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {}
            }
        },
        methods: {
            carregarLista() {
                axios.get(this.urlBase)
                    .then(response => {
                        console.log(response)
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
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                console.log(this.arquivoImagem[0], this.nomeMarca, config, formData, this.urlBase);

                axios.post(this.urlBase, formData, config)
                    .then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
                            mensagem: 'ID do registro: ' + response.data.id
                        }
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

        }
    }
</script>
