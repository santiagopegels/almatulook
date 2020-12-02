<template>
    <a-menu
        mode="inline"
        style="height: 100%"
    >
        <a-row style="padding: 5px;margin-left: 15px; margin-top: 10px;">
            <a-form-item>
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
            </a-form-item>
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
</template>
