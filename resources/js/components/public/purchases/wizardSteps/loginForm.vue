<template>
    <div>
        <a-icon type="user" class="header-icon"/>
        <h1>Iniciar Sesión</h1>

        <a-form
            id="components-form-demo-normal-login"
            :form="form"
            class="login-form"
            @submit="handleSubmit"
        >
            <a-form-item>
                <a-input
                    size="large"
                    v-decorator="[
                              'mail',
                              { rules: [
                                  { required: true, message: 'Debe ingresar el correo' },
                                  {
                                     type: 'email',
                                     message: 'Ingrese un correo válido.',
                                   }
                                  ] },
                            ]"
                    placeholder="Correo"
                >
                    <a-icon slot="prefix" type="mail" style="color: rgba(0,0,0,.25)"/>
                </a-input>
            </a-form-item>
            <a-form-item>
                <a-input
                    size="large"
                    v-decorator="[
                              'password',
                              { rules: [{ required: true, message: 'Debe ingresar la contraseña' }] },
                            ]"
                    type="password"
                    placeholder="Contraseña"
                >
                    <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)"/>
                </a-input>
            </a-form-item>
            <a-form-item>
                <a-checkbox
                    v-decorator="[
                              'remember',
                              {
                                valuePropName: 'checked',
                                initialValue: true,
                              },
                            ]"
                >
                    Recordarme
                </a-checkbox>
                <a-button type="link">
                    ¿Olvidó su contraseña?
                </a-button>
                <a-button type="primary" html-type="submit" class="login-form-button">
                    Iniciar Sesión
                </a-button>
                <a-button type="link" href="/register">
                    Registrarse
                </a-button>
                <br>
                <a-button @click="purchaseAsGuest()" type="link">
                    Deseo comprar como invitado
                </a-button>
            </a-form-item>
        </a-form>
    </div>
</template>

<script>
export default {
    beforeCreate() {
        this.form = this.$form.createForm(this, {name: 'normal_login'});
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
        purchaseAsGuest(){
            this.$emit('as-guest', true);
        }
    },
};
</script>
<style>
#components-form-demo-normal-login .login-form {
    max-width: 300px;
}


#components-form-demo-normal-login .login-form-button {
    width: 100%;
}
</style>
