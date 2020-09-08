<template>
    <div class="form-group">
        <label>Subcategorías
            <button type="button" class="btn" @click="addSubcategory()">
                <i class="fa fa-plus-circle text-success fa-lg" aria-hidden="true"></i>
            </button>
        </label>
        <div v-for="(subcategory, index) in children" class="form-group" :key="index">
        <input type="text"
               class="form-control" placeholder="Subcategoría"
               :class="{ 'is-invalid': $v.selected_category.name.$error }"/>
        </div>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import {
    required,
    integer,
} from "vuelidate/lib/validators";

export default {
    props: {
        children: {
            type: Array,
            default: () => [],
        },
    },
    validations() {
        if (this.hasSelectedId()) {
            return {
                selected_category: {
                    id: {
                        required,
                        integer
                    },
                    name: {
                        required
                    },
                },
            };
        } else {
            return {
                selected_category: {
                    name: {
                        required
                    },
                },
            };
        }
    },

    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading", "selected_category", "page"]),
        hasId() {
            return Boolean(this.hasSelectedId());
        },
    },
    methods: {
        hasSelectedId() {
            if (!Boolean(this.selected_category)) return false;
            return Boolean(this.selected_category.id > 0);
        },

        async addSubcategory(){
            const child = {
                id: 0,
                name:"",
                slug:""
            };
            await this.selected_category.children.push(child)
        }

    },
};
</script>
