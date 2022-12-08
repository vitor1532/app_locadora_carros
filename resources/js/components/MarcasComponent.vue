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
                        <table-component></table-component>
                    </template>
                    <template v-slot:rodape>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm float-right" name="btn" data-toggle="modal" data-target="#criarMarcasModal">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim do card de listagem -->
            </div>
        </div>
        <!-- Modal -->
        <modal-component id="criarMarcasModal" title="Criar Marcas"></modal-component>

    </div>

</template>

<script>
    import InputContainerComponent from "./InputContainerComponent.vue";
    import TableComponent from "./TableComponent.vue";
    import CardComponent from "./CardComponent.vue";
    import ModalComponent from "./ModalComponent.vue";

    export default {
        name: "MarcasComponent",
        components: {InputContainerComponent, TableComponent, ModalComponent, CardComponent}
    }
</script>
