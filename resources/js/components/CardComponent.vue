<template>
    <div>
        <div class="card mb-3">
            <div class="card-header">{{ title }}</div>

            <div class="card-body">
                <slot></slot>
            </div>

            <div class="card-footer"><button :type="btnType" class="btn btn-primary btn-sm float-right">{{ btnText }}</button></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CardComponent",
    props: ['title', 'btnText', 'btnType'],
}
</script>

<style scoped>

</style>
