<template>
    <div>
        <a-row type="flex" justify="space-between">
            <img class="cart-drawer-content-item-list-img"
                 src="https://os.alipayobjects.com/rmsportal/QBnOOoLaAfKPirc.png"/>

            <h3>Remera Riki Sarkani</h3>

            <h3 style="font-weight: bold">$1050.99</h3>
        </a-row>
        <a-row type="flex" justify="end">
            <a-icon type="delete" class="cart-drawer-content-delete-icon" @click="showConfirm"/>
        </a-row>
        <a-divider></a-divider>
    </div>
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
