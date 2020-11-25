<template>
    <a-layout>
        <a-layout-footer style="margin-top: 10px; background: white; box-shadow: inset 1px 4px 7px -6px;">
            <a-row type="flex" justify="space-between" align="middle">
                <a-col>
                    <h3>ENCONTRANOS</h3>
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d885.7356954359516!2d-55.89734757075276!3d-27.377502308037393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9457be4c02db2367%3A0xe56353233df6f293!2sCmte.%20Rebollo%201961%2C%20N3301IZC%20Posadas%2C%20Misiones!5e0!3m2!1ses!2sar!4v1592313917862!5m2!1ses!2sar"
                        frameborder="0"
                        allowfullscreen="true"
                        aria-hidden="false"
                        height="120px"
                        tabindex="0">

                    </iframe>

                </a-col>
                <a-col>
                    <router-link :to="{ name: 'home'}">
                        <img :src="logo" height="90px"/>
                    </router-link>
                    <div style="display:flex; justify-content: space-between; margin-top: 5px;">
                        <a href="https://api.whatsapp.com/send?phone=5493764675330&text=Consulte%20Precios%20en%20AlmaTuLook&source=&data="
                           class="social-button whatsApp" target="_blank">
                            <whatsapp-icon :style="{ fontSize: '32px' }"/>
                        </a>
                        <a href="https://www.instagram.com/almatulook/?hl=es-la" class="social-button instagram"
                           target="_blank">
                            <a-icon type="instagram"/>
                        </a>
                    </div>
                </a-col>
                <a-col>
                    <h3>CONTACTANOS</h3>
                    <ul class="list-unstyled bold">
                        <a-space direction="vertical">
                            <li>
                                <a-icon type="phone" theme="twoTone" two-tone-color="#9E7B1A"/>
                                +543764675330
                            </li>
                            <li>
                                <a-icon type="mail" theme="twoTone" two-tone-color="#9E7B1A"/>
                                almatulook@hotmail.com
                            </li>
                            <li>
                                <a-icon type="environment" theme="twoTone" two-tone-color="#9E7B1A"/>
                                Rebollo 1961
                            </li>
                        </a-space>
                    </ul>
                </a-col>
            </a-row>
        </a-layout-footer>
    </a-layout>
</template>
<script>
import logo from "../../../../../public/img/logo/logo.png";
import WhatsappIcon from '../../generals/icons/whatsappIcon'

export default {
    components: {
        WhatsappIcon
    },
    data: function () {
        return {
            logo: logo,
        };
    },
}
</script>
