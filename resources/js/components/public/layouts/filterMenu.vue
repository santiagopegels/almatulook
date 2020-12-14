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
                        Precio más bajos
                    </a-select-option>
                    <a-select-option value="higher">
                        Precio más altos
                    </a-select-option>
                </a-select>
            </a-form-item>
        </a-row>
        <a-row style="padding: 5px; margin-left: 15px;">
            <a-form-item>
                <h3>Talles</h3>
                <a-checkbox-group
                    style="width: 100%;"
                >
                    <a-row>
                        <a-col :span="24">
                            <a-checkbox value="A">
                                XS
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24">
                            <a-checkbox value="B">
                                S
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24">
                            <a-checkbox value="C">
                                M
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24">
                            <a-checkbox value="D">
                                L
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24">
                            <a-checkbox value="E">
                                XL
                            </a-checkbox>
                        </a-col>
                    </a-row>
                </a-checkbox-group>
            </a-form-item>
        </a-row>
        <a-row style="padding: 5px; margin-left: 15px;">
            <a-form-item>
                <h3>Colores</h3>
                <a-checkbox-group
                    style="width: 100%;"
                >
                    <a-row>
                        <a-col :span="24">
                            <a-checkbox value="A">
                                Rojo
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24">
                            <a-checkbox value="B">
                                Azul
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24">
                            <a-checkbox value="C">
                                Verde
                            </a-checkbox>
                        </a-col>
                        <a-col :span="24">
                            <a-checkbox value="D">
                                Amarillo
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
            orderBy: 'launching'
        }
    },
    computed:{
      ...mapGetters(['orderProducts'])
    },
    watch: {
      orderBy: function (value){
          this.$store.commit('SET_ORDER_PRODUCTS', value)
      }
    },
}
</script>
