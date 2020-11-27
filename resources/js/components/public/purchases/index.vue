<template>
    <a-row>
        <a-col :span="12">
            <a-steps :current="current">
                <a-step v-for="item in steps" :key="item.title" :title="item.title">
                    <a-icon slot="icon" :type="item.icon" />
                </a-step>
            </a-steps>
            <div class="steps-content">
                <first-step v-if="current == 0"/>
                <second-step v-if="current == 1"/>
                <third-step v-if="current == 2"/>
            </div>
            <div class="steps-action">
                <a-button v-if="current < steps.length - 1" type="primary" @click="next">
                    Next
                </a-button>
                <a-button
                    v-if="current == steps.length - 1"
                    type="primary"
                    @click="$message.success('Processing complete!')"
                >
                    Done
                </a-button>
                <a-button v-if="current > 0" style="margin-left: 8px" @click="prev">
                    Previous
                </a-button>
            </div>
        </a-col>
        <a-col :span="9" :offset="3">
            <summary-purchase />
        </a-col>
    </a-row>
</template>
<script>
export default {
    data() {
        return {
            current: 0,
            steps: [
                {
                    title: 'Login',
                    icon: 'user',
                },
                {
                    title: 'Envío',
                    icon: 'environment',
                },
                {
                    title: 'Pago',
                    icon: 'credit-card',
                },
            ],
        };
    },
    methods: {
        next() {
            this.current++;
        },
        prev() {
            this.current--;
        },
    },
};
</script>
<style scoped>
.steps-content {
    margin-top: 16px;
    border: 1px dashed #e9e9e9;
    border-radius: 6px;
    background-color: #fafafa;
    min-height: 200px;
    text-align: center;
    padding: 15px;
}

.steps-action {
    margin-top: 24px;
}
</style>
