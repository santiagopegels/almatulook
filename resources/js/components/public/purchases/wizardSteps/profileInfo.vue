<template>
    <a-form layout="inline" :form="form" @submit="nextStep" >
       <div style="box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1); margin-bottom:20px; padding: 20px; border: solid lightgrey 0.2px">
        <a-form-item label="Nombre" class="purchase-address-form-item">
            <span>{{ this.purchaseInfo.data.profile.personalInfo.name }}</span>
        </a-form-item>
        <a-form-item label="Apellido" class="purchase-address-form-item">
            <span>{{ this.purchaseInfo.data.profile.personalInfo.lastName }}</span>
        </a-form-item>
        <a-form-item label="Celular" class="purchase-address-form-item">
            <span>{{ this.purchaseInfo.data.profile.contact.cellphone }}</span>
        </a-form-item>
        <a-form-item label="Dirección" class="purchase-address-form-item">
            <span>{{ this.purchaseInfo.data.profile.contact.address.deliveryAddress }}</span>
        </a-form-item>
        <a-form-item label="Piso / Departamento / Edificio (Opcional)" class="purchase-address-form-item">
            <span>{{ this.purchaseInfo.data.profile.contact.address.flat }}</span>
        </a-form-item>
        <a-form-item label="Ciudad" class="purchase-address-form-item">
            <span>{{ this.purchaseInfo.data.profile.contact.address.city }}</span>
        </a-form-item>
        <a-form-item label="Provincia" class="purchase-address-form-item">
            <span>{{ this.purchaseInfo.data.profile.contact.address.province }}</span>
        </a-form-item>
        <a-form-item label="CP">
            <span>{{ this.purchaseInfo.data.profile.contact.address.cp }}</span>
        </a-form-item>
           <a-row>
               <a-button type="secondary"><a-icon type="form"/>Editar</a-button>
           </a-row>
       </div>
        <a-button type="primary" block html-type="submit">Siguiente</a-button>
    </a-form>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters(['purchaseInfo']),
    },
    data() {
        return {
            form: this.$form.createForm(this, {name: 'coordinated'}),
        }
    },
    methods: {
        nextStep(e) {
            e.preventDefault();
            this.$emit('next-step')
        },
        prevStep() {
            this.$emit('prev-step')
        }
    },
};
</script>
