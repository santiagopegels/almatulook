<template>
    <div>
        <a-icon type="environment" class="header-icon"/>
        <h1>Dirección de Envío</h1>
        <a-form layout="vertical" @submit="handleSubmit">
            <a-row>
                <a-col :span="11">
                    <a-form-item label="Nombre">
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
                <a-col :span="12" :offset="1">
                    <a-form-item label="Apellido" has-feedback>
                        <a-input
                            size="large"
                            v-decorator="[
                                      'apellido',
                                      {
                                        rules: [
                                          {
                                            required: true,
                                            message: 'Debe ingresar el apellido',
                                          },
                                        ],
                                      },
                                    ]"
                        />
                    </a-form-item>
                </a-col>
            </a-row>
            <a-form-item v-bind="formItemLayout" label="Teléfono">
                <a-input
                    size="large"
                    v-decorator="[
          'phone',
          {
            rules: [{ required: true, message: 'Debe ingresar un número de teléfono' }],
          },
        ]"
                    style="width: 100%"
                >
                    <a-select
                        slot="addonBefore"
                        v-decorator="['prefix', { initialValue: '86' }]"
                        style="width: 70px"
                    >
                        <a-select-option value="86">
                            +86
                        </a-select-option>
                        <a-select-option value="87">
                            +87
                        </a-select-option>
                    </a-select>
                </a-input>
            </a-form-item>
            <a-form-item label="Dirección">
                <a-input
                    size="large"
                    v-decorator="[
                                      'address',
                                      {
                                        rules: [
                                          {
                                            required: true,
                                            message: 'Debe ingresar una dirección',
                                          },
                                        ],
                                      },
                                    ]"
                />
            </a-form-item>
            <a-form-item label="Piso / Departamento / Edificio (Opcional)">
                <a-input
                    size="large"
                />
            </a-form-item>
            <a-form-item label="Ciudad">
                <a-input
                    size="large"
                />
            </a-form-item>
            <a-row>
                <a-col :span="14">
                    <a-form-item label="Provincia" has-feedback>
                        <a-select
                            size="large"
                            v-decorator="[
                                      'select',
                                      { rules: [{ required: true, message: 'Debe seleccionar una provincia' }] },
                                    ]"
                            placeholder="Seleccionar Provincia"
                        >
                            <a-select-option value="misiones">
                                Misiones
                            </a-select-option>
                            <a-select-option value="corrientes">
                                Corrientes
                            </a-select-option>
                        </a-select>
                    </a-form-item>
                </a-col>
                <a-col :span="9" :offset="1">
                    <a-form-item label="CP">
                        <a-input
                            size="large"
                        />
                    </a-form-item>
                </a-col>
            </a-row>
        </a-form>
    </div>
</template>

<script>
export default {
    data() {
        return {

        };
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault();
            this.form.validateFieldsAndScroll((err, values) => {
                if (!err) {
                    console.log('Received values of form: ', values);
                }
            });
        },
    },
};
</script>
