<template>
    <div>
        <a-icon type="credit-card" class="header-icon"/>
        <h1>Realizar Pago</h1>
        <a-form layout="vertical" @submit="handleSubmit">
            <a-row>
                <a-col :span="12">
                    <a-form-item label="Mostrar codigo QR">
                        <a-input
                            size="large"
                            v-decorator="[
                                      'nombre',
                                      {
                                        rules: [
                                          {
                                            required: true,
                                            message: 'Debe ingresar el nombre',
                                          },
                                        ],
                                      },
                                    ]"
                        />
                    </a-form-item>
                </a-col>
            </a-row>
        </a-form>
        <a-button type="primary" block size="large">
            Pagar con Tarjeta de Crédito
        </a-button>
    </div>
</template>

<script>
export default {
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
