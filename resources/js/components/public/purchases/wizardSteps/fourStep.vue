<template>
    <div>
        <previous-button @prev-step="prevStep()"/>
        <a-icon type="credit-card" class="header-icon"/>
        <h1>Realizar Pago</h1>
        <img style="padding: 5px" :src="mercadopagoLogo" class="responsive"/>
        <a-button type="primary" block size="large" :loading="!linkToPay" @click="generatePurchase">
            Pagar con MercadoPago
        </a-button>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import mercadopagoLogo from "../../../../../../public/img/mercadopago.png"

export default {
    computed: {
        ...mapGetters(['selected_shipment_type', 'bagProducts', 'purchaseInfo', 'selected_shipment_type'])
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
            await this.$store.dispatch('generatePaymentId', {
                products: this.bagProducts,
                payer: this.purchaseInfo,
                shipment_cost: this.selected_shipment_type.cost
            }).then(result => {
                this.linkToPay = result.message
            })
        },
       async generatePurchase() {
           await this.$store.dispatch('storePurchase', {
                products: this.bagProducts,
                payer: this.purchaseInfo,
                shipment: this.selected_shipment_type.id
            }).then(response => {
                if(response.message.id && response.status){
                    this.createAndGoPaymentLink()
                }
           })
        },
        createAndGoPaymentLink() {
            let anchorElement = document.createElement('a')
            anchorElement.href = this.linkToPay
            anchorElement.click()
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
