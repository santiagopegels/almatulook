<template>
    <a-menu
        mode="inline"
        style="height: 100%"
    >
        <a-row style="padding: 5px;margin-left: 15px; margin-top: 10px;">
            <a-form-item>
                <a-select size="large" style="width: 80%" v-model="orderBy">
                    <a-select-option value="launching">
                        Lanzamientos
                    </a-select-option>
                    <a-select-option value="lower">
                        Precio más bajo
                    </a-select-option>
                    <a-select-option value="higher">
                        Precio más alto
                    </a-select-option>
                </a-select>
            </a-form-item>
        </a-row>
        <a-row style="padding: 5px; margin-left: 15px;" v-for="attribute in attributesAll" :key="attribute.id">
            <a-form-item>
                <h3>{{attribute.name}}</h3>
                <a-checkbox-group
                    style="width: 100%;"
                    :name="attribute.name"
                >
                    <a-row>
                        <a-col :span="24" v-for="value in attribute.values" :key="value.id">
                            <a-checkbox :value="value.pivot.id" @change="onChange(value.pivot.id)"

                            >
                                {{value.name}}
                            </a-checkbox>
                        </a-col>
                    </a-row>
                </a-checkbox-group>
            </a-form-item>
        </a-row>
    </a-menu>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
            orderBy: 'launching',
        }
    },
    async mounted(){
        if(!this.attributesAll.length > 0){
          await this.fetchAttributesAll()
      }
    },
    computed:{
      ...mapGetters(['orderProducts', 'attributesAll', 'selectedValuesToFilter'])
    },
    watch: {
      orderBy: function (value){
          this.$store.commit('SET_ORDER_PRODUCTS', value)
      }
    },
    methods:{
        async fetchAttributesAll() {
            await this.$store.dispatch("fetchAllPublic", {
                model: 'attributes',
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
        async onChange(checkedValue) {
            if(this.selectedValuesToFilter.includes(checkedValue)){
                await this.$store.commit('REMOVE_SELECTED_VALUES_FILTER', checkedValue)
            } else {
                await this.$store.commit('PUSH_SELECTED_VALUES_FILTER', checkedValue)
            }
        },
    }
}
</script>
