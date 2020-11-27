<template>
    <div>
        <a-card title="Resumen de Compra" style="width:360px">
            <a slot="extra" href="#">Editar</a>
            <p>6 Items</p>
            <summary-purchase-product />
            <summary-purchase-product />
            <summary-purchase-product />
            <a-divider></a-divider>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    Subtotal
                </a-col>
                <a-col>
                    $2080,90
                </a-col>
            </a-row>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    Costo de envío
                </a-col>
                <a-col>
                    $249,00
                </a-col>
            </a-row>
            <a-divider></a-divider>
            <a-row type="flex" justify="space-between" class="bold">
                <a-col>
                    <h1>Total</h1>
                </a-col>
                <a-col>
                    <h1>$4249,00</h1>
                </a-col>
            </a-row>
        </a-card>
    </div>
</template>
