<template>
    <form method="POST" @submit="handleSubmit" accept-charset="UTF-8">
        <div class="input-prepend input-group">
            <input
                v-model="term"
                id="prependedInput"
                class="form-control"
                size="16"
                type="text"
                placeholder="Buscar atributo por nombre"
            />
            <span class="input-group-append">
				<button type="submit" :disabled="$v.$invalid" class="btn btn-outline-primary">
					<i class="icon-magnifier"></i> Buscar
				</button>
			</span>
            <span class="input-group-append" title="Quitar filtro">
				<button
                    v-if="!$v.$invalid"
                    type="button"
                    :disabled="$v.$invalid"
                    class="btn btn-outline-primary"
                    @click="clearFilter()"
                >
					<i class="icon-close"></i>
				</button>
			</span>
        </div>
    </form>
</template>

<script>
import { required } from "vuelidate/lib/validators";
export default {
    props: {},
    data: function () {
        return {
            submitted: false,
            term: "",
            model: "attributes",
        };
    },
    validations() {
        return {
            term: { required },
        };
    },

    created() {},
    mounted() {},
    computed: {},
    methods: {
        async handleSubmit(e) {
            e.preventDefault();
            this.submitted = true;
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.fetch();
        },
        clearFilter() {
            this.term = "";
            this.fetch();
        },

        async fetch() {
            let params = {
                page: 1,
                model: this.model,
            };
            params.term = this.term;
            await this.$store.dispatch("fetch", params)
                .catch(error => this.$toasted.global.ToastedError({ message: error.message.message }));
        },
    },
};
</script>
