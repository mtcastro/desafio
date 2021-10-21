<template>
    <div class="form-group" ref="group" v-bind:class="{ 'is-invalid': error }">
        <label class="form-label" v-bind:class="{'sr-only':srOnly}" v-if="label">{{ label }}</label>
        <slot></slot>
        <div class="invalid-feedback" v-show="error">
            <div><i class="fas fa-times fa-fw" aria-hidden="true"></i> <span v-html="errorMessage"></span></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FormGroup",
        
        props: {
            error: [String, Array],
            label: String,
            labelFor: String,
            srOnly: Boolean,
        },
        computed: {
            errorMessage: function() {
                // Caso o erro venha em formato de array, usa-se a primeira posição
                return Object.prototype.toString.call(this.error) === '[object Array]' ? this.error[0] : this.error;
            }
        },
        watch: {
            error: function(value) {
                const items = this.$refs.group.querySelectorAll(".input-group, .form-control, .btn-group, .custom-select");
                items.forEach(function(item) { item.classList.toggle("is-invalid", value); });
            }
        }
    }
</script>

<style lang="scss">
    .form-group{
        .form-label{
            font-family: $headings-font-family;
            font-style: normal;
            font-weight: 500;
            font-size: 12px;
            line-height: 16px;
            letter-spacing: 0.4px;
            color: #262626;
        }
    }
</style>