<template>
    <div>
        <div v-if="show">
        <product-attribute-select v-for="(attributes, index) in availableAttributes" :key="index"
                                  :attribute="attributes"
                                  @change="getNextListAttribute" :attributeNumber="index"/>
        </div>
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
            availableAttributes: [],
            treeAttributes: [],
            show: false
        }
    },
    async mounted() {
        this.totalOfAttributes = this.selected_product.attributes[0].attributes.length
        await this.initialized();
    },
    methods: {
        //Convert from List of attributes to tree of attributes
        async initialized() {
            this.attributesWithStock = await this.selected_product.attributes.filter(attribute => attribute.stock > 0)
            await this.attributesWithStock.forEach(item => {
                let attributeItarated = []

                item.attributes.forEach((attribute, index) => {
                    if (index == 0) {
                        if (!this.treeAttributes.some(item => item.value_id == attribute.value_id)) {
                            attribute.children = []
                            this.treeAttributes.push(attribute)
                        }
                        attributeItarated.push(attribute.value_id)
                    }
                    if (index > 0) {
                        this.addNewNode(this.treeAttributes, attributeItarated, 0, index, attribute)
                    }
                })
            })

            this.availableAttributes[0] = new Array(this.treeAttributes.length)
            this.treeAttributes.forEach((attribute, index) => {
                this.availableAttributes[0][index] = attribute
            })
            this.show = true
        },

        async addNewNode(nodes, valuesIds, index, deepLevel, attribute) {
            for (let i = 0; i < nodes.length; i++) {
                if (nodes[i].value_id == valuesIds[index]) {
                    if (index == deepLevel-1) {
                        if (!nodes[i].children) {
                            nodes[i].children = []
                        }
                        if (!nodes[i].children.some(item => item.value_id == attribute.value_id)) {
                            nodes[i].children.push(attribute)
                        }
                        valuesIds.push(attribute.value_id)
                        break;
                    } else {
                        await this.addNewNode(nodes[i].children, valuesIds, index + 1, deepLevel, attribute)
                    }
                }
            }
        },

        async getNextListAttribute(attributeSelected) {
            this.attributesSelected = attributeSelected.attributeSelectedIndex + 1;
            if (this.attributesSelected < this.totalOfAttributes) {
                await this.removeOtherAttributesWhenChangeAttributeSelected(attributeSelected.attributeSelectedIndex);
                await this.availableAttributes.push(attributeSelected.children)
            }
        },

        async removeOtherAttributesWhenChangeAttributeSelected(attributeSelectedIndex) {
            for (let i = this.availableAttributes.length; i > attributeSelectedIndex + 1; i--) {
                this.availableAttributes.pop()
            }
        },
    }
}
</script>
