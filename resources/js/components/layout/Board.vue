<template>
	<div class="board">
		<slot></slot>
	</div>
</template>

<script>
	export default {
		name: 'Board'
	}
</script>

<style scoped>
	.board {
		background: #fff;
		border-radius: var(--border-radius);
		padding: 24px;
		height: 100%;
		box-shadow: var(--l1-shadow);
	}
</style>
