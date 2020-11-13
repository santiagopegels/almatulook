<template>
    <a-card hoverable style="width: 240px" @mouseover="changeImage()">
        <img
            style="padding: 10px"
            slot="cover"
            alt="example"
            :src="image"
        />
        <a-card-meta title="Remera Ricky Sarkani">
            <template slot="description">
                <h2 style="font-weight: bold;">$10.99</h2>
            </template>
        </a-card-meta>
    </a-card>
</template>
<script>
export default {
    data(){
        return {
          image: 'https://os.alipayobjects.com/rmsportal/QBnOOoLaAfKPirc.png'
        }
    },
    methods: {
        changeImage() {
            this.image = 'https://d35uzl96cmnmq2.cloudfront.net/processed/Round_Trip_Airfare_A_1600.jpg'
        }
    }
}
</script>
