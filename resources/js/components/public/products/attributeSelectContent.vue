<template>
    <div >
    <product-attribute-select v-for="n in 2" :key="n"/>
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
            attributesWithStock: []
        }
    },
    async mounted() {
        await this.initialized();
    },
    methods: {
        async initialized() {
            this.totalOfAttributes = this.selected_product.attributes[0].attributes.length
            this.attributesWithStock = await this.selected_product.attributes.filter(attribute => attribute.stock > 0)

            let result = this.attributesWithStock.reduce((unique, attribute) => {
                if(!unique.some(obj => obj.attributes[0].value === attribute.attributes[0].value )) {
                    unique.push(attribute);
                }
                return unique;
            },[]).map(attribute => attribute.attributes[0]);
            console.log(result)
        }
    }
}
</script>
