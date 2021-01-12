<template>
    <div>
        <header-layout/>
        <header-menu/>
        <cart-drawer/>
        <a-row style="padding-top: 15px;" type="flex" justify="center">
            <a-icon type="form" class="header-icon"/>
            <h1 style="margin: 0 0 0 5px">Mis Datos</h1>
        </a-row>
        <a-row style="padding-bottom: 10px;" type="flex" justify="center">
            <a-col :xs="{span: 22}"
                   :sm="{span: 22}"
                   :md="{span: 15}"
                   :lg="{span: 15}"
                   :xxl="{span: 13}">
                <div class="form-dashed" style="padding: 10px;">
                    <summary-purchase-step-profile-form buttonText="Actualizar" @next-step="update" v-if="showForm"/>
                </div>
            </a-col>
        </a-row>
        <footer-layout/>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    data(){
        return {
            model: 'profiles',
            showForm: false
        }
    },
    computed: {
        ...mapGetters(['purchaseInfo'])
    },
    async mounted() {
        await this.fetchProfile()
    },
    methods: {
        async fetchProfile(){
            await this.$store.dispatch('fetchUserProfile',{
                model: this.model
            })
            this.showForm = true
        },
        async update() {
            await this.$store.dispatch('updateProfileUser', {
                model: this.model,
                data: {
                    name: this.purchaseInfo.data.profile.personalInfo.name,
                    lastname: this.purchaseInfo.data.profile.personalInfo.lastName,
                    cellphone: this.purchaseInfo.data.profile.contact.cellphone,
                    deliveryAddress: this.purchaseInfo.data.profile.contact.address.deliveryAddress,
                    flat: this.purchaseInfo.data.profile.contact.address.flat,
                    city: this.purchaseInfo.data.profile.contact.address.city,
                    province: this.purchaseInfo.data.profile.contact.address.province,
                    cp: this.purchaseInfo.data.profile.contact.address.cp
                }
            })
                .then(result => {
                this.$toasted.global.ToastedSuccess({message: result.message});
            })
                .catch(error => this.$toasted.global.ToastedError({ message: error.message}))
        }
    }
}
</script>
