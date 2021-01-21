<template>
    <div style="margin-bottom: 20px">
        <p style="font-size: 1.4rem; margin-bottom: 0px">{{ attribute[0].attribute }}</p>
        <a-space size="middle">
            <a-row>
                <a-button v-for="(value, index) in attribute" :key="value.value_id" :type="value.type"
                          size="large" style="margin: 5px;" @click="setAttributeSelected(value)">
                    {{ value.value }}
                </a-button>
            </a-row>
        </a-space>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    computed: {
        ...mapGetters(['selected_product'])
    },
    props: ['attribute', 'attributeNumber'],
    async beforeMount() {
        await this.attribute.forEach(item => Vue.set(item, 'type', 'default'))
    },
    methods: {
        async setAttributeSelected(valueObject) {
            await this.attribute.forEach(item => item.type = 'default')
            valueObject.type = 'primary'
            let {value_id, attribute_id, value, attribute} = valueObject
            await this.$store.commit('PUSH_ATTRIBUTE_SELECTED_PRODUCT', {
                value: {value_id, attribute_id, value, attribute},
                attributeIndex: this.attributeNumber
            })
            this.$emit('change', {
                attributeSelectedIndex: this.attributeNumber,
                children: valueObject.children ? valueObject.children : null
            })
        }
    }
}
</script>
