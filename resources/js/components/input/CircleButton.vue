<template>
	<button
		@click="$emit('click')"
		v-if="type !== 'link'"
		class="circle-button" :class="{'primary': color === 'primary', 'loading': loading}" :type="type" :name="name"
		:disabled="loading"
	>{{ label }}
	</button>
	<a v-else :href="href" class="circle-button" :class="{'primary': color === 'primary', 'loading': loading}">
		{{ label }}
	</a>
</template>

<script>
	export default {
		name: 'CircleButton',
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
	.circle-button {
		border-radius: 360px;
		background: #eee;
		padding: 8px 15px;
		color: rgba(0, 0, 0, .75);
		font-weight: var(--font-light);
		font-size: 24px;
		border: none;
		transition: all var(--speed-fast) ease;
		outline: none;
		box-shadow: 0 2px 2px rgba(0, 0, 0, .25), 0 8px 18px rgba(0, 0, 0, .25);
	}

	.circle-button:hover, .circle-button:focus {
		background: #ddd;
		color: rgba(0, 0, 0, 0.95);
	}

	.circle-button:active {
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
