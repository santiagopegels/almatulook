<template>
    <a-row type="flex" style="box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1); margin-bottom:20px; padding: 10px; border: solid lightgrey 0.2px">
        <a-col class="cart-resume-product-row-content-img">
            <img class="cart-resume-product-row-img"
                 src="https://os.alipayobjects.com/rmsportal/QBnOOoLaAfKPirc.png"/>
        </a-col>
        <a-col flex="auto" class="cart-resume-product-row-info-content">
            <div style="display: flex; justify-content: space-between">
                <p class="cart-resume-product-title">Remera Riki Sarkani algo mas</p>
                <a-icon type="delete" class="cart-resume-product-content-delete-icon" @click="showConfirm"/>
            </div>

            <div style="display: flex; justify-content: space-between">
                <div>
                    <ul class="cart-resume-product-row-info-content-list-attribute">
                        <li>
                            Talle L
                        </li>
                        <li>
                            Color Rojo
                        </li>
                    </ul>
                </div>
                <div style="display: flex;">
                <div style="margin-right: 10px">
                    <h5 style="margin-bottom: 0">Cantidad:</h5>
                    <a-select default-value="1" style="width: 60px">
                        <a-select-option v-for="num in 10" :key="num" :value="num">{{ num }}
                        </a-select-option>
                    </a-select>
                </div>
                <div class="cart-resume-product-row-info-quantity-price">
                    <h5 style="margin-bottom: 0">Total:</h5>
                    <h3 class="bold">$2.039,99</h3>
                </div>
                </div>
            </div>
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
                onCancel() {
                },
            });
        },
    }
}
</script>
