<template>
    <div>
        <previous-button v-if="showPrevStepButton" @prev-step="prevStep()"/>
        <a-icon type="compass" class="header-icon"/>
        <h1>Tipo de Envío</h1>
        <a-radio-group v-model="selected_shipment_type.id" @change="onChange">
            <a-row v-for="(shipmentType, index) in shipmentTypes" :key="index" type="flex" justify="space-between"
                   style="box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1); margin-bottom:20px; padding: 20px; border: solid lightgrey 0.2px">
                <a-col style="margin-right: 20px">
                    <div style="display: flex;">
                        <a-radio :value="shipmentType.id">
                        </a-radio>
                        <p class="cart-resume-product-title">{{ shipmentType.name }}</p>
                    </div>
                    <div>
                        {{ shipmentType.description }}
                    </div>
                </a-col>
                <a-col>
                    <h3 class="bold">{{ shipmentType.cost | currency }}</h3>
                </a-col>
            </a-row>
        </a-radio-group>
        <a-button :disabled="!selected_shipment_type.id" type="primary" block @click="nextStep()">Siguiente</a-button>
    </div>

</template>
<script>
import {mapGetters} from 'vuex'

export default {
    data() {
        return {
            model: 'shipment_types',
            value: null,
        };
    },
    computed: {
        ...mapGetters(['shipmentTypes', 'selected_shipment_type']),
    },
    props: ['showPrevStepButton'],
    async mounted() {
        if (!this.shipmentTypes.length > 0) {
            await this.fetchShipmentTypesAll()
        }
    },
    methods: {
        async fetchShipmentTypesAll() {
            await this.$store.dispatch("fetchAllPublic", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
        async onChange(e) {
            let shipmentTypeSelected = await this.shipmentTypes.filter(item => item.id == e.target.value)[0]
            this.$store.commit('SET_SELECTED_SHIPMENT_TYPE', {
                id: shipmentTypeSelected.id,
                cost: shipmentTypeSelected.cost,
                name: shipmentTypeSelected.name,
                description: shipmentTypeSelected.description,
                address_required: shipmentTypeSelected.address_required,
                created_at: shipmentTypeSelected.created_at,
                deleted_at: shipmentTypeSelected.deleted_at,
                updated_at: shipmentTypeSelected.updated_at,
            })
        },
        prevStep() {
            this.$emit('prev-step')
        },
        nextStep() {
            if (this.selected_shipment_type.id) {
                this.$emit('next-step')
            }
        },
    }
};
</script>
