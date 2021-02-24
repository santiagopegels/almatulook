<template>
    <div>
        <a-icon type="smile" class="header-icon"/>
        <h1>Invitado</h1>
        <p style="text-align: left">Podes
            <a-button type="link" @click="purchaseAsUser()"><b>INICIAR SESIÓN</b></a-button>
            para recuperar tus datos o ingresar tu correo electrónico para comprar como invitado:
        </p>
        <a-form :form="form" @submit="nextStep">
            <a-form-item>
                <a-input
                    size="large"
                    v-decorator="[
                              'mail',
                              { rules:
                               [
                                   {
                                     type: 'email',
                                     message: 'Ingrese un correo válido.',
                                   },
                                   { required: true, message: 'Debe ingresar el correo.' }
                               ]
                               },
                            ]"
                    placeholder="Correo"
                >
                    <a-icon slot="prefix" type="mail" style="color: rgba(0,0,0,.25)"/>
                </a-input>
            </a-form-item>
            <a-button type="primary" block html-type="submit">Continuar como invitado</a-button>
        </a-form>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data() {
        return {
            form: this.$form.createForm(this, {name: 'coordinated'}),
        };
    },
    mounted(){
        this.form.setFieldsValue({
            mail: this.purchaseInfo.data.user.email,
        });
    },
    computed: {
        ...mapGetters(['purchaseInfo']),
    },
    methods: {
        purchaseAsUser() {
            this.$store.commit('SET_LOGIN_FROM_PURCHASE_VIEW', true)
            let anchorElement = document.createElement('a')
            anchorElement.href = '/login'
            anchorElement.click()
        },
        async nextStep(e) {
            e.preventDefault();
            this.form.validateFields((err, values) => {
                if (!err) {
                    this.$store.commit('SET_PURCHASE_USER_EMAIL', values.mail)
                    this.$emit('next-step')
                }
            });
        }
    }
}
</script>
