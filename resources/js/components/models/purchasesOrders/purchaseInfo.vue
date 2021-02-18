<template>
    <div class="card card-accent-primary">
        <div class="card-header">
            Información de la compra
            <span class="float-right">
            <span class="badge badge-warning">
                ID
                <strong>{{ selected_purchase.id }}</strong>
            </span>
        </span>
        </div>
        <div class="card-body">
            <form accept-charset="UTF-8">
                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="text" v-model="selected_purchase.total" v-currency readonly="true" name="total" id="total"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="shipment_type">Tipo de Envío</label>
                    <input type="text" v-model="selected_purchase.shipment.name" readonly="true" name="shipment_type" id="shipment_type"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="shipment_cost">Costo de Envío</label>
                    <input type="text" v-model="selected_purchase.shipment_cost" v-currency readonly="true" name="shipment_cost" id="shipment_cost"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="created_date">Fecha de Compra</label>
                    <input type="text" v-model="created_date" readonly="true" name="created_date" id="created_date"
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
        created_date: {
            get(){
               return this.$date(this.selected_purchase.created_at).format('DD-MM-YYYY');
            }
        }
    },
}
</script>
