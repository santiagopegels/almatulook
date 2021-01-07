<template>
    <div>
        <div style="display: flex; justify-content: left">
            <a-button type="default" @click="prevStep()">
                <a-icon type="left"/>
            </a-button>
        </div>
        <a-icon type="environment" class="header-icon"/>
        <h1>Dirección de Envío</h1>
        <a-form layout="vertical" :form="form" @submit="nextStep">
            <a-row>
                <a-col :span="11">
                    <a-form-item label="Nombre" class="purchase-address-form-item">
                        <a-input
                            size="large"
                            v-decorator="[
                                      'name',
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
                    <a-form-item label="Apellido" class="purchase-address-form-item">
                        <a-input
                            size="large"
                            v-decorator="[
                                      'lastName',
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
            <a-form-item label="Celular" class="purchase-address-form-item">
                <a-input-number
                    size="large"
                    v-decorator="[
                                  'phone',
                                  {
                                    rules: [
                                        {
                                        required: true,
                                        message: 'Debe ingresar un número de teléfono'
                                        },
                                        {
                                            type: 'number',
                                            message: 'Debe ingresar solo números',
                                         },
                                        ],
                                  },
                                ]"
                    style="width: 100%"
                    class="purchase-address-form-item"
                >
                </a-input-number >
            </a-form-item>
            <a-form-item label="Dirección" class="purchase-address-form-item">
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
            <a-form-item label="Piso / Departamento / Edificio (Opcional)" class="purchase-address-form-item">
                <a-input
                    size="large"
                    v-decorator="['flat']"
                />
            </a-form-item>
            <a-form-item label="Ciudad" class="purchase-address-form-item">
                <a-input
                    class="purchase-address-form-item"
                    size="large"
                    v-decorator="[
                                      'city',
                                      {
                                        rules: [
                                          {
                                            required: true,
                                            message: 'Debe ingresar una Ciudad',
                                          },
                                        ],
                                      },
                                    ]"
                />
            </a-form-item>
            <a-row>
                <a-col :span="14">
                    <a-form-item label="Provincia" class="purchase-address-form-item">
                        <a-select
                            size="large"
                            v-decorator="[
                                      'province',
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
                            v-decorator="['cp']"
                        />
                    </a-form-item>
                </a-col>
            </a-row>
            <a-button type="primary" block html-type="submit">Siguiente</a-button>
        </a-form>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data() {
        return {
        };
    },
    created() {
        this.form = this.$form.createForm(this, {
            onFieldsChange: (_, changedFields) => {
                this.$emit('change', changedFields);
            },
            mapPropsToFields: () => {
                return {
                    name: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.personalInfo.name,
                    }),
                    lastName: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.personalInfo.lastName,
                    }),
                    phone: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.contact.cellphone,
                    }),
                    address: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.contact.address.deliveryAddress,
                    }),
                    flat: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.contact.address.flat,
                    }),
                    city: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.contact.address.city,
                    }),
                    province: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.contact.address.province,
                    }),
                    cp: this.$form.createFormField({
                        value: this.purchaseInfo.data.profile.contact.address.cp,
                    }),
                };
            },
            onValuesChange: (_, values) => {
                console.log(values)
                let key = Object.keys(values)[0];
                switch(key){
                    case 'name':
                        this.purchaseInfo.data.profile.personalInfo.name = values[key]
                        break;
                    case 'lastName':
                        this.purchaseInfo.data.profile.personalInfo.lastName = values[key]
                        break;
                    case 'phone':
                        this.purchaseInfo.data.profile.contact.cellphone = values[key]
                        break;
                    case 'address':
                        this.purchaseInfo.data.profile.contact.address.deliveryAddress = values[key]
                        break;
                    case 'flat':
                        this.purchaseInfo.data.profile.contact.address.flat = values[key]
                        break;
                    case 'city':
                        this.purchaseInfo.data.profile.contact.address.city = values[key]
                        break;
                    case 'province':
                        this.purchaseInfo.data.profile.contact.address.province = values[key]
                        break;
                    case 'cp':
                        this.purchaseInfo.data.profile.contact.address.cp = values[key]
                        break;
                }
            },
        });
    },
    computed: {
        ...mapGetters(['purchaseInfo']),
    },
    lastName() {
        return this.purchaseInfo.data.profile.personalInfo.lastName;
    },
    watch: {
        lastName(val) {
            console.log(val);
            this.form.setFieldsValue({ lastName: val });
        },
    },
    methods: {
        nextStep(e) {
            e.preventDefault();
            this.form.validateFieldsAndScroll((err, values) => {
                if (!err) {
                    this.$emit('next-step')
                }
            });
        },
        prevStep(){
            this.$emit('prev-step')
        }
    },
};
</script>
