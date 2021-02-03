<template>
    <div>
        <previous-button @prev-step="prevStep()"/>
        <a-icon type="credit-card" class="header-icon"/>
        <h1>Realizar Pago</h1>
        <img style="background: grey;width: 200px; height: 200px">
        <p>Escaneá el QR y pagá tu compra con MercadoPago</p>
        <a :href="linkToPay">
            <a-button type="primary" block size="large">
                Pagar con Tarjeta en MercadoPago
            </a-button>
        </a>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters(['selected_shipment_type'])
    },
    data() {
        return {
            linkToPay: null,
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
