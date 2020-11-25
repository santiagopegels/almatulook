<template>
    <a-layout>
        <a-layout-sider width="300"
                        style="box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1); text-align: left; margin-left: 10px; margin-top: 10px;">
            <a-menu
                mode="inline"
                style="height: 100%"
            >
                <a-row style="padding: 5px;margin-left: 15px; margin-top: 10px;">
                    <a-select size="large" default-value="relevantes" style="width: 80%">
                        <a-select-option value="relevantes">
                            Más relevantes
                        </a-select-option>
                        <a-select-option value="vendidos">
                            Más vendidos
                        </a-select-option>
                        <a-select-option value="lanzamientos">
                            Lanzamientos
                        </a-select-option>
                        <a-select-option value="bajos">
                            Precio más bajos
                        </a-select-option>
                        <a-select-option value="altos">
                            Precio más altos
                        </a-select-option>
                    </a-select>
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
        </a-layout-sider>

        <a-layout-content :style="{ padding: '0 24px', maxWidth:'1400px', margin: 'auto'}">
            <a-row type="flex" justify="center" v-if="!show">
            <a-spin style="padding:5px;" size="large" />
            </a-row>
            <fade-transition :duration="800">

                <a-row type="flex" justify="center" v-if="show">

                    <router-link :to="{name: 'publicProductIndex'}">
                        <home-product-card/>
                    </router-link>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                    <home-product-card></home-product-card>
                </a-row>
            </fade-transition>

        </a-layout-content>
    </a-layout>
</template>
<script>
import {FadeTransition} from 'vue2-transitions'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    components: {
        FadeTransition,
        Loading
    },
    data() {
        return {
            opacity: 0.3,
            isLoading: true,
            show: false
        }
    },
    mounted() {
        setTimeout(() => {
            this.isLoading = false
            this.show = true
        }, 2000)
    }
}
</script>
