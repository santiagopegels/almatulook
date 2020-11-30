<template>
    <a-row type="flex" style="margin-bottom:20px; padding: 10px; border: solid lightgrey 0.2px">
        <a-col flex="100px">
            <img class="cart-resume-product-row-img"
                 src="https://os.alipayobjects.com/rmsportal/QBnOOoLaAfKPirc.png"/>
        </a-col>
        <a-col flex="auto">
            <a-row type="flex" justify="space-between">
                <a-col :span="24">
                    <a-row type="flex" justify="space-between">
                        <p class="cart-resume-product-title">Remera Riki Sarkani</p>
                        <a-icon type="delete" class="cart-drawer-content-delete-icon" @click="showConfirm"/>
                    </a-row>
                </a-col>
                <a-col :span="24">
                    <a-row type="flex">
                        <a-col :flex="4">
                            <ul class="purchase-summary-product-attribute-list ">
                                <li>
                                    Talle L
                                </li>
                                <li>
                                    Color Rojo
                                </li>
                            </ul>
                        </a-col>
                        <a-col :flex="2" style="display: flex">
                            <div style="margin-right: 10px">
                                <h5 style="margin-bottom: 0">Cantidad:</h5>
                            <a-select default-value="1" style="width: 60px">
                                <a-select-option v-for="num in 10" :key="num" :value="num">{{num}}</a-select-option>
                            </a-select>
                            </div>
                            <div>
                                <h5 style="margin-bottom: 0">Total:</h5>
                                <h3 class="bold">$2.039,99</h3>
                            </div>
                        </a-col>
                    </a-row>
                </a-col>
            </a-row>
        </a-col>
    </a-row>
</template>
<script>
export default {
    methods: {
        showConfirm() {
            this.$confirm({
                title: 'Do you want to delete these items?',
                content: 'When clicked the OK button, this dialog will be closed after 1 second',
                onOk() {
                    return new Promise((resolve, reject) => {
                        setTimeout(Math.random() > 0.5 ? resolve : reject, 1000);
                    }).catch(() => console.log('Oops errors!'));
                },
                onCancel() {},
            });
        },
    }
}
</script>
