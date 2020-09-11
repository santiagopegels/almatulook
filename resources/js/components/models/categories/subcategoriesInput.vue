<template>
    <div class="form-group">
        <label>Subcategorías
            <button type="button" class="btn" @click="addSubcategory()">
                <i class="fa fa-plus-circle text-success fa-lg" aria-hidden="true"></i>
            </button>
        </label>
        <div v-for="(subcategory, index) in subcategories" class="form-group mb-2" :value="index" :key="index">
            <div class="input-group">
                <input type="text"
                       v-model="subcategory.name"
                       v-capitalize
                       :name="'subcategory['+index+']name'"
                       :id="'subcategory_'+index+'_name'"
                       :class="{'is-invalid': validate && $v.subcategories.$each[index].name.$error}"
                       class="form-control" placeholder="Subcategoría"/>
                <div class="input-group-append ml-2">
                    <button class="close" type="button" title="Eliminar" @click="deleteSubcategory(subcategory)">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div v-if="validate && !$v.subcategories.$each[index].name.required" id="error" class="d-block invalid-feedback">El nombre de la
                    subcategoría es requerido..</div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";
import {
    required,
    minLength,
} from "vuelidate/lib/validators";


export default {
    props: {
        subcategories: {
            type: Array,
            default: () => [],
        },
        validate: {
            type: Boolean,
            default: () => false,
        },
    },
    validations() {
        return {
            subcategories: {
                $each: {
                    name: {
                        required,
                        minLength: minLength(2),
                    },
                },
            },
        };
    },

    created() {
    },
    mounted() {
    },
    computed: {
        ...mapGetters(["isLoading","selected_category", "page"]),
    },
    watch: {
        validate() {
            if (this.validate) {
                this.$v.$touch();
            }
        }
    },
    methods: {
        async addSubcategory() {
            const subcategory = {
                id: 0,
                name: "",
                slug: "",
                icon: "icon-tag"
            };
            this.selected_category.id > 0
                ?
                await this.selected_category.addChild(subcategory)
                :
                await this.selected_category.children.push(subcategory)
        },

        deleteSubcategory(_subcategory) {
            const index = this.subcategories.findIndex((subcategory) => subcategory.id === _subcategory.id);
            if (index < 0) return;
            this.subcategories.splice(index, 1);
        },

    },
};
</script>
