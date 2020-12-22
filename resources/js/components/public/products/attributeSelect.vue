<template>
    <div style="margin-bottom: 20px">
        <p style="font-size: 1.4rem; margin-bottom: 0px">{{ attribute[0].attribute }}</p>
        <a-space size="middle">
            <a-row>
                <a-button v-for="(value, index) in attribute" :key="value.value_id" :type="value.type" shape="circle"
                          size="large" style="margin: 5px; padding: 3px" @click="setAttributeSelected(index)">
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
    props: ['attribute'],
    async beforeMount() {
        await this.attribute.forEach(item => Vue.set(item, 'type', 'default'))
    },
    methods: {
        async setAttributeSelected(index) {
            await this.attribute.forEach(item => item.type = 'default')
            this.attribute[index].type = 'primary'
            this.$store.commit('PUSH_ATTRIBUTE_SELECTED_PRODUCT', this.attribute[index])
            this.$emit('change')
        }
    }
}
</script>
