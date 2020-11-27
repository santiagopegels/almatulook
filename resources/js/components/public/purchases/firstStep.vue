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
                              'userName',
                              { rules: [{ required: true, message: 'Debe ingresar el usuario!' }] },
                            ]"
                    placeholder="Usuario"
                >
                    <a-icon slot="prefix" type="user" style="color: rgba(0,0,0,.25)"/>
                </a-input>
            </a-form-item>
            <a-form-item>
                <a-input
                    size="large"
                    v-decorator="[
                              'password',
                              { rules: [{ required: true, message: 'Debe ingresar la contraseña!' }] },
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
                <a class="login-form-forgot" href="">
                    ¿Olvidó su contraseña?
                </a>
                <a-button type="primary" html-type="submit" class="login-form-button">
                    Iniciar Sesión
                </a-button>
                <a href="">
                    Registrarse
                </a>
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
