<template>
	<div class="default-alert">
		<slot></slot>
	</div>
</template>

<script>
	export default {
		name: 'DefaultAlert'
	}
</script>

<style scoped>
	.default-alert {
		display: block;
		background: var(--body-bg);
		color: var(--body-fg);
		padding: 8px;
		margin: 8px 0;
		font-size: var(--font-small);
		opacity: 0.85;
	}
</style>
