<template>
    <div>
        <summary-purchase-step-login-form v-if="showLoginForm" @as-guest="handleGuestForm()"/>
        <summary-purchase-step-guest-form
            v-if="showGuestForm"
            @as-user="handleLoginForm()"
            @next-step="nextStep"
        />
    </div>
</template>
<script>
import {mapGetters} from "vuex";

export default {
    data() {
        return {
            showLoginForm: false,
            showGuestForm: true
        }
    },
    mounted() {
        if(this.userLogged.isAuthenticated){
            this.nextStep()
        }
    },
    computed:{
        ...mapGetters(['userLogged', 'purchaseInfo', 'bagProducts'])
    },
    methods: {
        handleLoginForm() {
            this.showLoginForm = true
            this.showGuestForm = false
        },
        handleGuestForm() {
            this.showLoginForm = false
            this.showGuestForm = true
        },
        nextStep(){
            this.$emit('next-step')
        }
    }
}
</script>


