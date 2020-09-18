<template>
    <div class="content-dashed">
        <div class="form-row justify-content-center">
            <div class="form-group col-lg-3 col-xs-12">
                <label class="text-justify text-dark" for="first_name">Nombre</label>
                <input name="first_name" class="form-control" type="text" placeholder="Nombre"/>
            </div>
            <div class="form-group col-lg-3 col-xs-12">
                <label class="text-justify text-dark" for="last_name">Apellido</label>
                <input name="last_name" class="form-control" type="text" placeholder="Apellido"/>
            </div>
            <div class="form-group col-lg-1 col-xs-12">
                <label class="text-justify text-dark" for="last_name">Stock</label>
                <input name="last_name" class="form-control" type="text" placeholder="Stock"/>
            </div>
        </div>
        <div class="text-center">
            <button type="submit"
                    class="btn btn-success">
                Agregar Stock
            </button>
        </div>
    </div>
</template>

<script>
import {
    mapGetters
} from "vuex";

export default {
    computed: {
        ...mapGetters(["selected_category", "isLoading", "page"]),
        hasCategories() {
            return Boolean(this.selected_category.id > 0);
        },
    },
    watch: {
        selected_category: function (newVal, oldVal) {
            if (newVal.id !== oldVal.id) {
                console.log('cargar atributos')
            }
        }
    },
    methods: {}
}
</script>
