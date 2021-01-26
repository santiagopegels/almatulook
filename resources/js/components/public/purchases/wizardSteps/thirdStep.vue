<template>
    <div>
        <previous-button @prev-step="prevStep()"/>
        <a-icon type="environment" class="header-icon"/>
        <h1>Datos de Envío</h1>
        <summary-purchase-step-profile-form v-if="!this.userLogged.isAuthenticated" buttonText="Siguiente" @next-step="nextStep()" @prev-step="prevStep()"/>
        <summary-purchase-step-profile-info v-else @next-step="nextStep()"/>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    computed: {
      ...mapGetters(['selected_shipment_type', 'userLogged'])
    },
    mounted() {
        if(!this.selected_shipment_type.address_required){
            this.nextStep()
        }
    },
    methods: {
        nextStep() {
            this.$emit('next-step')
        },
        prevStep() {
            this.$emit('prev-step')
        },
    },
};
</script>
