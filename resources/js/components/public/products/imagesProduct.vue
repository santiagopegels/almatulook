<template>
    <a-carousel style="width: 95%;" arrows>
        <div
            slot="prevArrow"
            slot-scope="props"
            class="custom-slick-arrow"
            style="left: 10px;zIndex: 1"
        >
            <a-icon type="left-circle"/>
        </div>
        <div slot="nextArrow" slot-scope="props" class="custom-slick-arrow" style="right: 10px">
            <a-icon type="right-circle"/>
        </div>
        <img v-if="selected_product.images.length > 0" v-for="image in selected_product.images" class="carousel-img" :src="image"/>
        <img v-if="selected_product.images.length == 0" :src="logo"/>
    </a-carousel>
</template>
<script>
import logo from "../../../../../public/img/logo/logo.png";
import {mapGetters} from 'vuex'
export default {
    computed: {
      ...mapGetters(['selected_product'])
    },
    data() {
        return {
            logo: logo,
        }
    },
};
</script>
<style scoped>

.ant-carousel >>> .slick-slide {
    text-align: center;
    height: 85vh;
    line-height: 85vh;
    background: lightgray;
    overflow: hidden;
}

@media only screen and (max-width: 576px) {
    .ant-carousel >>> .slick-slide {
        text-align: center;
        height: 550px;
        line-height: 550px;
        background: lightgray;
        overflow: hidden;
    }
}

.ant-carousel >>> .custom-slick-arrow {
    width: 50px;
    height: 50px;
    font-size: 50px;
    color: #000;
    background-color: rgba(31, 45, 61, 0.11);
    opacity: 0.3;
}

.ant-carousel >>> .custom-slick-arrow:before {
    display: none;
}

.ant-carousel >>> .custom-slick-arrow:hover {
    opacity: 0.7;
}

.ant-carousel >>> .slick-slide h3 {
    color: #fff;
}

.carousel-img
{
    width: 100%;
    height: 100%;
    min-height: 550px;
    object-fit: cover;
}
</style>
