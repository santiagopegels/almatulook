<template>
    <div>
        <header-layout/>
        <header-menu/>
        <cart-drawer/>
        <main-content/>
        <footer-layout/>
    </div>
</template>
<script>
export default {
    mounted() {
        if(this.$route.query.status){
            this.openNotification()
        }
    },
    methods: {
        openNotification() {
            if(this.$route.query.status == 'approved') {
                this.$toasted.show(`Gracias por su compra. El comprobante de pago es ${this.$route.query.payment_id}`, {
                    theme: "outline",
                    position: "top-right",
                    action: {
                        text: 'CERRAR',
                        onClick: (e, toastObject) => {
                            toastObject.goAway(0);
                        }
                    },
                })
            }
        },
    },
}
</script>
