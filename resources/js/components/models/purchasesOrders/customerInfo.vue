<template>
    <div class="card card-accent-primary">
        <div class="card-header">
            Información del cliente
            <span class="float-right">
            <span class="badge badge-warning">
                ID
                <strong>{{ selected_purchase.profile.id }}</strong>
            </span>
        </span>
        </div>
        <div class="card-body">
            <form accept-charset="UTF-8">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" v-model="selected_purchase.profile.name" readonly="true" name="name" id="name"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="lastname">Apellido</label>
                    <input type="text" v-model="selected_purchase.profile.lastname" readonly="true" name="lastname" id="lastname"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="cellphone">Teléfono</label>
                    <input type="text" v-model="selected_purchase.profile.cellphone" readonly="true" name="cellphone" id="cellphone"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="delivery_address">Dirección de Envío</label>
                    <input type="text" v-model="selected_purchase.profile.deliveryAddress" readonly="true" name="delivery_address" id="delivery_address"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="flat">Información de Piso</label>
                    <input type="text" v-model="selected_purchase.profile.flat" readonly="true" name="flat" id="flat"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="city">Ciudad</label>
                    <input type="text" v-model="selected_purchase.profile.city" readonly="true" name="city" id="city"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="province">Provincia</label>
                    <input type="text" v-model="selected_purchase.profile.province" readonly="true" name="province" id="province"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="cp">CP</label>
                    <input type="text" v-model="selected_purchase.profile.cp" readonly="true" name="cp" id="cp"
                           class="form-control"/>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import {mapGetters} from "vuex";
export default {
    computed: {
        ...mapGetters(['selected_purchase']),
    },
}
</script>
