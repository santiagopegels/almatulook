<template>
    <div>
        <a-icon type="smile" class="header-icon" />
        <h1>Invitado</h1>
        <p style="text-align: left">Podes <a-button type="link" @click="purchaseAsUser()"><b>INICIAR SESIÓN</b></a-button> para recuperar tus datos o ingresar tu correo electrónico para comprar como invitado:</p>
        <a-form-item>
            <a-input
                size="large"
                v-decorator="[
                              'mail',
                              { rules: [{ required: true, message: 'Debe ingresar el correo!' }] },
                            ]"
                placeholder="Correo"
            >
                <a-icon slot="prefix" type="mail" style="color: rgba(0,0,0,.25)"/>
            </a-input>
        </a-form-item>
        <a-button type="primary" block @click="nextStep()">Siguiente</a-button>
    </div>
</template>

<script>
export default {
    methods: {
        purchaseAsUser(){
            this.$emit('as-user', true);
        },
        nextStep(){
            this.$emit('next-step')
        }
    }
}
</script>
