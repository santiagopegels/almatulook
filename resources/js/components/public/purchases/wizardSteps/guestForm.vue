<template>
    <a-button type="primary" @click="purchaseAsUser()">Inciar Sesion</a-button>
</template>

<script>
export default {
    methods: {
        purchaseAsUser(){
            this.$emit('as-user', true);
        }
    }
}
</script>
