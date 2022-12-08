<template>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="criarMarcasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="mb-3">

                            <input-container-component id="nameInput" titulo="Nome" fooHelp="nameHelp" descricao="Obrigatório.">
                                <input type="text" class="form-control" id="nameInput" aria-describedby="nameHelp" placeholder="Informe o nome da marca">
                            </input-container-component>

                            <input-container-component id="imageInput" titulo="Imagem" fooHelp="imageHelp" descricao="Obrigatório.">
                                <input type="file" class="form-control-file" id="imageInput">
                            </input-container-component>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                    <button type="button" class="btn btn-primary">Inserir Marca</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

    import InputContainerComponent from "./InputContainerComponent.vue";


    export default {
        name: "ModalComponent",
        components: {InputContainerComponent},
        props: ['title']
    }
</script>
