<template>
    <div style="padding: 10px; text-align: center">
    <a-card hoverable class="product-card-container" :bodyStyle="{'padding-left': '2'}">
        <a-carousel style="width: 100%; padding: 8px" arrows  slot="cover">
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
            <img v-if="images.length > 0" v-for="image in images" class="carousel-img" :src="image"/>
            <img v-if="images.length == 0" :src="logo"/>
        </a-carousel>
        <a-card-meta class="product-card-title-container">
            <template slot="title">
                <p style="white-space: normal; margin-bottom: 0px">{{ name }}</p>
            </template>
            <template slot="description">
                <h2 class="bold">{{ price | currency}}</h2>
            </template>
        </a-card-meta>
    </a-card>
    </div>
</template>
<script>
import logo from '../../../../../public/img/logo/logo.png'
export default {
    props: ['price','name', 'images'],
    data() {
        return {
            logo: logo,
            show: true
        }
    },
}
</script>
<style scoped>

.ant-carousel >>> .slick-slide {
    text-align: center;
    height: 250px;
    line-height: 250px;
    background: lightgray;
    overflow: hidden;
}

@media only screen and (max-width: 768px) {
    .ant-carousel >>> .slick-slide {
        text-align: center;
        height: 220px;
        line-height: 220px;
        background: lightgray;
        overflow: hidden;
    }
}

@media only screen and (max-width: 540px) and (min-width: 415px){
    .ant-carousel >>> .slick-slide {
        text-align: center;
        height: 140px;
        line-height: 140px;
        background: lightgray;
        overflow: hidden;
    }
}

.ant-carousel >>> .custom-slick-arrow {
    width: 25px;
    height: 25px;
    font-size: 25px;
    color: #fff;
    background-color: rgba(31, 45, 61, 0.11);
    opacity: 0.3;
}

.ant-carousel >>> .custom-slick-arrow:before {
    display: none;
}

.ant-carousel >>> .custom-slick-arrow:hover {
    opacity: 0.5;
}

.ant-carousel >>> .slick-slide h3 {
    color: #fff;
}

.carousel-img
{
    width: 100%;
    height: 100%;
    min-height: 250px;
    object-fit: cover;
}
</style>
