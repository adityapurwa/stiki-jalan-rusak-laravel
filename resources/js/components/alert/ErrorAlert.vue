<template>
	<div class="error-alert">
		<slot></slot>
	</div>
</template>

<script>
	export default {
		name: 'ErrorAlert'
	}
</script>

<style scoped>
	.error-alert {
		display: block;
		background: var(--error-bg);
		color: var(--error-fg);
		padding: 8px;
		margin: 8px 0;
		font-size: var(--font-small);
		opacity: 0.85;
	}
</style>
