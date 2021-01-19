<template>
    <div style="display: flex; justify-content: left">
        <a-button type="default" @click="prevStep()">
            <a-icon type="left"/>
        </a-button>
    </div>
</template>
<script>
export default {
    methods: {
        prevStep() {
            this.$emit('prev-step')
        }
    }
}
</script>
