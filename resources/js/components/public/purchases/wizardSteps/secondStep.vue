<template>
    <div>
        <div style="display: flex; justify-content: left">
            <a-button type="default" @click="prevStep()">
                <a-icon type="left"/>
            </a-button>
        </div>
        <a-icon type="environment" class="header-icon"/>
        <h1>Dirección de Envío</h1>
        <summary-purchase-step-profile-form buttonText="Siguiente" @next-step="nextStep()" @prev-step="prevStep()"/>
    </div>
</template>

<script>
export default {
    methods: {
        nextStep() {
            this.$emit('next-step')
        },
        prevStep() {
            this.$emit('prev-step')
        }
    },
};
</script>
