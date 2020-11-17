<template>
    <div>
        <a-menu mode="horizontal" :style="{'background' : '#554B52', 'color':'white'}">
            <a-sub-menu key="mail">
                <span slot="title"><a-icon type="tags"/><span>CATEGORIAS</span></span>
                <a-menu-item key="3">
                    Option 3
                </a-menu-item>
                <a-menu-item key="4">
                    Option 4
                </a-menu-item>
                <a-sub-menu key="sub1-2" title="Submenu">
                    <a-menu-item key="5">
                        Option 5
                    </a-menu-item>
                    <a-menu-item key="6">
                        Option 6
                    </a-menu-item>
                    <a-sub-menu key="sub2-2" title="submenu">
                        <a-menu-item key="5">
                            Option 5
                        </a-menu-item>
                        <a-menu-item key="6">
                            Option 6
                        </a-menu-item>
                    </a-sub-menu>
                </a-sub-menu>
            </a-sub-menu>
        </a-menu>
    </div>
</template>
<script>
export default {
    data() {
        return {
            current: ['mail'],
        };
    },
};
</script>
