<template>
    <div>
        <previous-button @prev-step="prevStep()"/>
        <a-icon type="credit-card" class="header-icon"/>
        <h1>Realizar Pago</h1>
        <img style="padding: 5px" :src="mercadopagoLogo" class="responsive"/>
        <a-button type="primary" block size="large" :loading="!linkToPay">
            <a :href="linkToPay"> Pagar con MercadoPago</a>
        </a-button>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import mercadopagoLogo from "../../../../../../public/img/mercadopago.png"
export default {
    computed: {
        ...mapGetters(['selected_shipment_type'])
    },
    data() {
        return {
            linkToPay: null,
            mercadopagoLogo: mercadopagoLogo
        }
    },
    async mounted() {
        await this.generatePaymentId()
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault();
            this.form.validateFields((err, values) => {
                if (!err) {
                    console.log('Received values of form: ', values);
                }
            });
        },
        prevStep() {
            let arg = null
            if (!this.selected_shipment_type.address_required) {
                arg = 2
            }
            this.$emit('prev-step', arg)
        },
        async generatePaymentId() {
            await this.$store.dispatch('generatePaymentId').then(result => {
                this.linkToPay = result.message
            })
        }
    },
};
</script>

<style>
.responsive {
    max-width: 100%;
    height: auto;
}
</style>
