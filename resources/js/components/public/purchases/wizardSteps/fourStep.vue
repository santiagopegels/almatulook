<template>
    <div>
        <previous-button @prev-step="prevStep()"/>
        <a-icon type="credit-card" class="header-icon"/>
        <h1>Realizar Pago</h1>
        <img style="background: grey;width: 200px; height: 200px">
        <p>Escaneá el QR y pagá tu compra con MercadoPago</p>
        <a-button type="primary" block size="large">
            Pagar con Tarjeta
        </a-button>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters(['selected_shipment_type'])
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
        prevStep(){
            let arg = null
            if(!this.selected_shipment_type.address_required){
                arg = 2
            }
            this.$emit('prev-step', arg)
        }
    },
};
</script>
