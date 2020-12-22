<template>
    <div>
        <product-attribute-select v-for="attribute in availableAttributes" :key="attribute.value" :attribute="attribute"
                                  @change="getAvailableAttributes" :attributeNumber="attributesSelected"/>
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
            attributesSelected: 0,
            attributesWithStock: [],
            availableAttributes: []
        }
    },
    async mounted() {
        this.totalOfAttributes = this.selected_product.attributes[0].attributes.length
        await this.getAvailableAttributes();
    },
    methods: {
        async getAvailableAttributes() {
            if (this.attributesSelected < this.totalOfAttributes) {
                await this.availableAttributes.push(await this.getNextListAttribute())
                this.attributesSelected += 1
            }
        },
        async getNextListAttribute(){
            this.attributesWithStock = await this.selected_product.attributes.filter(attribute => attribute.stock > 0)
            let result = await this.attributesWithStock.reduce((unique, attribute) => {
                if (!unique.some(obj => obj.attributes[this.attributesSelected].value === attribute.attributes[this.attributesSelected].value)) {
                    unique.push(attribute);
                }
                return unique;
            }, []).map(attribute => attribute.attributes[this.attributesSelected]);
            return result
        }
    }
}
</script>
