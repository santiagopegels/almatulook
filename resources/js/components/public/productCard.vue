<template>
    <div style="padding: 10px;">
    <a-card hoverable class="product-card-container">
        <img
            style="padding: 10px"
            slot="cover"
            :src="images[imageIndex]"
            @click="changeImage"
        />
        <a-card-meta title="Remera Ricky Sarkani">
            <template slot="description">
                <h2 style="font-weight: bold;">$10.99</h2>
            </template>
        </a-card-meta>
    </a-card>
    </div>
</template>
<script>
export default {
    data() {
        return {
            images: ['https://os.alipayobjects.com/rmsportal/QBnOOoLaAfKPirc.png',
                'https://d35uzl96cmnmq2.cloudfront.net/processed/Round_Trip_Airfare_A_1600.jpg'
            ],
            imageIndex: 0,
            show: true
        }
    },
    methods: {
        async changeImage() {
            this.imageIndex < this.images.length -1 ? this.imageIndex++ : this.imageIndex = 0
        }
    },
}
</script>
