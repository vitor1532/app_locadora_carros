<template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Inicio do card de busca -->
                <div class="card">
                    <div class="card-header">Busca de marcas</div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="col mb-3">
                                <input-container-component
                                    titulo="ID"
                                    id="inputId"
                                    type="number"
                                    foo-help = "idHelp"
                                    descricao = "Opcional."
                                >
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Informe o ID da marca">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component
                                    titulo="Nome"
                                    id="inputNome"
                                    type="text"
                                    foo-help = "nomeHelp"
                                    descricao = "Opcional."
                                >
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Informe o nome da marca">
                                </input-container-component>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer"><button type="submit" class="btn btn-primary btn-sm float-right">Pesquisar</button></div>
                </div>
                <!-- Fim do card de busca -->

                <!-- Inicio do card de listagem -->
                <div class="card mt-3">
                    <div class="card-header">Listagem de marcas</div>

                    <div class="card-body">
                        <table-component></table-component>
                    </div>

                    <div class="card-footer"><button type="button" class="btn btn-primary btn-sm float-right">Adicionar</button></div>
                </div>
                <!-- Fim do card de listagem -->

            </div>
        </div>
    </div>

</template>

<script>
import InputContainerComponent from "./InputContainerComponent.vue";

export default {
    name: "MarcasComponent",
    components: {InputContainerComponent}
}
</script>

<style scoped>

</style>
