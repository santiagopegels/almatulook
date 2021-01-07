<template>
    <a-row style="padding-top: 20px;" type="flex" justify="center">
        <a-col
               :xs="{span: 18, offset: 6}"
               :sm="{span: 15, offset: 9}"
               :md="{span: 24, offset: 5}"
               :lg="{span: 21, offset: 3}"
               :xxl="{span: 21, offset: 3}">
            <router-link to="/">
            <p style="font-size: 2rem; margin: 0; padding: 5px">AlmaTuLook</p>
            </router-link>
        </a-col>
        <a-divider></a-divider>
        <a-col :xs="{span: 22}"
               :sm="{span: 22}"
               :md="{span: 11, offset: 1}"
               :lg="{span: 11, offset: 1}"
               :xxl="{span: 11, offset: 1}">

            <a-steps :current="current" v-show="isShowSteps" @change="changeStep">
                <a-step v-for="item in steps" :key="item.title" :title="item.title">
                    <a-icon slot="icon" :type="item.icon" />
                </a-step>
            </a-steps>
            <div class="steps-content" style="box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.1);">
                <first-step v-if="current == 0" @next-step="next()" />
                <second-step v-if="current == 1" @next-step="next()" @prev-step="prev()"/>
                <third-step v-if="current == 2" @prev-step="prev()"/>
            </div>
        </a-col>
        <a-col class="summary-content"
               :xs="{span: 24}"
               :sm="{span: 12}"
               :md="{span: 9, offset: 1}"
               :lg="{span: 9, offset: 3}"
               :xxl="{span: 9, offset: 3}">
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
            isShowSteps: true
        };
    },
    mounted() {
        this.showSteps()
    },
    methods: {
        next() {
            this.current++;
            window.scrollTo(0,0);
        },
        prev() {
            this.current--;
            window.scrollTo(0,0);
        },
        showSteps() {
            window.innerWidth <= 480 ? this.isShowSteps = false : this.isShowSteps = true
        },
        changeStep(current){
            if(current < this.current){
                this.current = current;
            }
        }
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
    padding: 40px;
}

.steps-action {
    margin-top: 24px;
}

.summary-content {
    margin-top: 50px;
    width: 352px;
}

@media only screen and (max-width: 767px) {
    .summary-content {
        margin-top: 10px;
        width: 90%;
    }
}

@media only screen and (max-width: 480px) {
    .steps-content {
        margin-top: 0px;
        border: 1px dashed #e9e9e9;
        border-radius: 6px;
        background-color: #fafafa;
        min-height: 200px;
        text-align: center;
        padding: 40px;
    }
}

</style>
