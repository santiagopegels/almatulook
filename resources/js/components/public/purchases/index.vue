<template>
    <div>
        <loading :opacity="opacity" loader="spinner" transition="fade" :active.sync="isLoading" :can-cancel="false"
                 :is-full-page="true" color="#20a8d8" background-color="rgba(0,0,0,0.8)"></loading>

        <a-row style="padding-top: 20px; background: #e0e0db" type="flex" justify="center">
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
        </a-row>
        <a-divider style="margin-top: 1px"></a-divider>

        <a-row style="padding-top: 20px;" type="flex" justify="center">
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
            <div v-if="!bagProducts.length > 0" class="form-dashed">
            <h2>
                No hay productos en su bolsa de compras
            </h2>
                <img width="30%" height="30%" :src="emptyBag" />
            </div>
            <div v-else class="form-dashed">
                <first-step v-if="current == 0" @next-step="next()" />
                <second-step v-if="current == 1"
                             @next-step="next()"
                             @prev-step="prev()"
                             :showPrevStepButton="!this.userLogged.isAuthenticated"
                />
                <third-step v-if="current == 2" @next-step="next()" @prev-step="prev()"/>
                <fourth-step v-if="current == 3" @prev-step="prev"/>
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
    </div>
</template>
<script>
import {mapGetters} from "vuex";
import emptyBag from '../../../../../public/img/shopping-bag.svg'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
    components: {
        FirstStep: () => import(/* webpackChunkName: "js/purchases" */ './wizardSteps/firstStep.vue'),
        SecondStep: () => import(/* webpackChunkName: "js/purchases" */ './wizardSteps/secondStep.vue'),
        ThirdStep: () => import(/* webpackChunkName: "js/purchases" */ './wizardSteps/thirdStep.vue'),
        FourthStep: () => import(/* webpackChunkName: "js/purchases" */ './wizardSteps/fourStep.vue'),
        SummaryPurchase: () => import(/* webpackChunkName: "js/purchases" */ './summary.vue'),
        Loading,
    },
    data() {
        return {
            opacity: 0.3,
            current: 0,
            steps: [
                {
                    title: 'Login',
                    icon: 'user',
                },
                {
                    title: 'Tipo de Envío',
                    icon: 'compass',
                },
                {
                    title: 'Dirección',
                    icon: 'environment',
                },
                {
                    title: 'Pago',
                    icon: 'credit-card',
                },
            ],
            isShowSteps: true,
            emptyBag: emptyBag
        };
    },
    computed: {
        ...mapGetters(['userLogged', 'purchaseInfo', 'bagProducts', 'isLoading'])
    },
    async mounted() {
        await this.loadUserData()
        this.showSteps()
    },
    methods: {
        next() {
            this.current++;
            window.scrollTo(0,0);
        },
        prev(value) {
            value ? this.current = this.current - value : this.current--;
            window.scrollTo(0,0);
        },
        showSteps() {
            window.innerWidth <= 480 ? this.isShowSteps = false : this.isShowSteps = true
        },
        async loadUserData(){
            if (this.userLogged.isAuthenticated){
                if(!this.purchaseInfo.data.profile.contact.address.deliveryAddress){
                    await this.fetchProfile()
                }
                this.current = 1;
            }
        },
        changeStep(current){
            if(current < this.current){
                this.current = current;
            }
        },
        async fetchProfile(){
            await this.$store.dispatch('fetchUserProfile',{
                model: 'profiles'
            })
        },
    },
};
</script>
<style scoped>

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

</style>
