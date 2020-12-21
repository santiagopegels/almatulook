<template>
    <div style="margin-bottom: 20px">
        <p style="font-size: 1.4rem; margin-bottom: 0px">{{ attribute[0].attribute }}</p>
        <a-space size="middle">
            <a-row>
                <a-button type="default" shape="circle"
                          size="large">
                    S
                </a-button>
            </a-row>
        </a-space>
    </div>
</template>
<script>
export default {
    props: ['attribute']
}
</script>
