<template>
    <div class="card card-accent-primary">
        <div class="card-header">
            Información de pago
            <span class="float-right">
            <span class="badge badge-warning">
                ID
                <strong>{{ selected_purchase.payment.id }}</strong>
            </span>
        </span>
        </div>
        <div class="card-body">
            <form accept-charset="UTF-8">
                <div class="form-group">
                    <label for="payment_id">ID de Pago</label>
                    <input type="text" v-model="selected_purchase.payment.payment_id" readonly="true" name="payment_id" id="payment_id"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="status">Estado</label>
                    <input type="text" v-model="selected_purchase.payment.status" readonly="true" name="status" id="status"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="payment_type">Tipo de Pago</label>
                    <input type="text" v-model="selected_purchase.payment.payment_type" readonly="true" name="payment_type" id="payment_type"
                           class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="created_date">Fecha última actualización</label>
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
                return this.$date(this.selected_purchase.payment.updated_at).format('DD-MM-YYYY');
            }
        }
    },
}
</script>
