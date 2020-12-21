<template>
    <div >
    <product-attribute-select v-for="attribute in attributesOtro" :key="attribute.value" :attribute="attribute"/>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters(['selected_product'])
    },
    data() {
        return {
            totalOfAttributes: 0,
            attributesOtro: []
        }
    },
    async mounted() {
        await this.initialized();
    },
    methods: {
        async initialized() {
            this.totalOfAttributes = this.selected_product.attributes[0].attributes.length
            this.attributesWithStock = await this.selected_product.attributes.filter(attribute => attribute.stock > 0)

            let result = await this.attributesWithStock.reduce((unique, attribute) => {
                if(!unique.some(obj => obj.attributes[0].value === attribute.attributes[0].value )) {
                    unique.push(attribute);
                }
                return unique;
            },[]).map(attribute => attribute.attributes[0]);

            console.log(result)
           this.attributesOtro.push(result)
            console.log(this.attributesOtro)
        }
    }
}
</script>
