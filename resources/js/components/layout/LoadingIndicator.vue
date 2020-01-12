<template>
	<div class="loading-indicator" :style="{height: height}"></div>
</template>

<script>
	export default {
		name: 'LoadingIndicator',
		props: {
			height: String
		}
	}
</script>

<style scoped>

	.loading-indicator{
		animation: loading-indicator 0.3s ease alternate infinite;
		display: block;
		background: #ddd;
	}

	@keyframes loading-indicator {
		from{
			opacity:0.5;
		}
		to{
			opacity: 1;
		}
	}

</style>
