<template>
    <div>
        <div class="card mb-3">
            <div class="card-header">.: {{ title }}</div>

            <div class="card-body">
                <slot name="conteudo"></slot>
            </div>

            <div class="card-footer">
                <slot name="rodape"></slot>
                <!-- <div class="card-footer"><button :type="btnType" class="btn btn-primary btn-sm float-right">{{ btnText }}</button></div> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CardComponent",
    props: ['title'],
}
</script>

<style scoped>

</style>
