<template>
    <div class="text-field">
        <label :for="name" class="text-label">{{ label }}</label>
        <label v-if="errors" v-for="error in errorsAsArray" :for="name" class="error-label">{{ error }}</label>
        <input
            @keypress="$emit('keypress', $event)"
            :type="type" :name="name" class="text-input"
            :class="{
				'with-shadow': shadow,
				'borderless': borderless,
			}"
            :value="value"
            @input="onInput"
        >
    </div>
</template>

<script>
    export default {
        name: 'TextField',
        props: {
            name: String,
            label: String,
            type: {
                type: String,
                default: 'text'
            },
            shadow: Boolean,
            borderless: Boolean,
            value: String,
            errors: Array
        },
        computed: {
            errorsAsArray () {
                return this.errors
            }
        },
        methods: {
            onInput (evt) {
                this.$emit('input', evt.target.value)
            }
        }
    }
</script>

<style scoped>

    .text-field {
        margin: 4px 0 12px;
    }

    .text-field:first-child {
        margin-top: 0;
    }

    .text-label {
        display: block;
        font-weight: var(--font-heavy);
        margin-bottom: 4px;
    }

    .text-input {
        background: #fff;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, .08);
        width: 100%;
        border: solid 1px #ccc;
        border-radius: var(--border-radius);
        padding: 8px;
        outline: none;
        transition: all var(--speed-fast) ease;
    }

    .text-input.with-shadow {
        box-shadow: var(--l1-shadow);
    }

    .text-input.borderless {
        border: solid 1px transparent;
    }

    .text-input:hover, .text-input:active, .text-input:focus {
        border: solid 1px var(--accent-a50);
    }

    .error-label {
        background: var(--error-bg);
        color: var(--error-fg);
        padding: 8px;
        font-size: var(--font-small);
        margin: 4px 0;
        display: block;
        opacity: 0.85;
    }

</style>
