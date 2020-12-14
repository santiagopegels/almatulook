<template>
    <div>
        <a-menu mode="horizontal" :style="{'background' : '#554B52', 'color':'white'}">
            <a-cascader :options="categoriesAll"
                        change-on-select
                        @change="onChange"
                        :field-names="{ label: 'name', value: 'id', children: 'children'}"
                        style="margin-left: 0.8rem;"
            >
                <a-button type="ghost" style="border: 0px" ><a-icon type="tags"/><span>CATEGORIAS</span></a-button>
            </a-cascader>
        </a-menu>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'

export default {
    data() {
        return {
            model: "categories",
        }
    },
    mounted() {
        if (!this.categoriesAll.data) {
            this.fetch();
        }
    },
    computed: {
        ...mapGetters(['categoriesAll'])
    },
    methods: {
        async fetch() {
            await this.$store.dispatch("fetchAll", {
                model: this.model,
            })
                .catch(error => this.$toasted.global.ToastedError({message: error.message.message}));
        },
        onChange(value, selectedOptions) {
            let categorySelected = selectedOptions[selectedOptions.length -1]
            this.$store.commit('SET_SELECTED_CATEGORY', categorySelected)
        },
    }
};
</script>
