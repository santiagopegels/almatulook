<template>
    <div>
        <summary-purchase-step-login-form v-if="showLoginForm" @as-guest="handleGuestForm()"/>
        <summary-purchase-step-guest-form v-if="showGuestForm" @as-user="handleLoginForm()"/>
    </div>
</template>
<script>
export default {
    data() {
        return {
            showLoginForm: false,
            showGuestForm: true
        }
    },
    methods: {
        handleLoginForm() {
            this.showLoginForm = true
            this.showGuestForm = false
        },
        handleGuestForm() {
            this.showLoginForm = false
            this.showGuestForm = true
        }
    }
}
</script>


