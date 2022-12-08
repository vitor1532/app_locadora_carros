<template>

    <div id="inputContainer" class="form-group">
        <label :for="id" class="form-label">{{ titulo }}</label>
        <slot></slot>
        <div :id="fooHelp" class="form-text text-secondary">{{ descricao }}</div>
    </div>

</template>

<script>
    export default {
        el: "inputContainer",
        props: ['id', 'titulo', 'fooHelp', 'descricao']
    }
</script>
