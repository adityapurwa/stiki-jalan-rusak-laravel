<template>
	<button
		@click="$emit('click')"
		v-if="type !== 'link'"
		class="button" :class="{'primary': color === 'primary', 'loading': loading}" :type="type" :name="name"
		:disabled="loading"
	>{{ label }}
	</button>
	<a v-else :href="href" class="button" :class="{'primary': color === 'primary', 'loading': loading}">
		{{ label }}
	</a>
</template>

<script>
	export default {
		name: 'Button',
		props: {
			label: String,
			name: String,
			type: String,
			color: String,
			href: String,
			loading: Boolean
		}
	}
</script>

<style scoped>
	.button {
		border-radius: 4px;
		background: #eee;
		padding: 8px 12px;
		color: rgba(0, 0, 0, .75);
		font-weight: var(--font-heavy);
		font-size: 12px;
		border: none;
		transition: all var(--speed-fast) ease;
		outline: none;
	}

	.button:hover, .button:focus {
		background: #ddd;
		color: rgba(0, 0, 0, 0.95);
	}

	.button:active {
		background: #ccc;
		color: rgba(0, 0, 0, 0.95);
		transform: translateY(1px) scale(0.995);
	}

	.primary {
		background: var(--accent);
		color: rgba(255, 255, 255, 0.95);
	}

	.primary:hover, .primary:focus {
		background: var(--accent-light);
		color: rgba(255, 255, 255, 0.95);
	}

	.primary:active {
		background: var(--accent-dark);
		color: rgba(255, 255, 255, 0.95);
	}

	.loading {
		animation: loading var(--speed-fast) ease alternate infinite;
	}

	@keyframes loading {
		from {
			opacity: 0.25;
		}
		to {
			opacity: 0.5;
		}
	}
</style>
