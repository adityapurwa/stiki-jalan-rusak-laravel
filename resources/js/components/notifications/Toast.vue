<template>
	<div class="toast-container">
		<transition-group name="fade" tag="div">
			<div class="toast" :key="toast.id" v-for="toast in toasts">
				{{ toast.text }}
			</div>
		</transition-group>
	</div>
</template>

<script>
	export default {
		name: 'Toast',
		data() {
			return {
				lastId: 0,
				toasts: []
			}
		},
		mounted() {
			window.$bus.$on('toast', (text) => {
				const toastId = this.lastId++;
				this.toasts.unshift({
					id: toastId,
					text: text
				});
				setTimeout(() => {
					this.toasts.pop();
				}, 2000);
			});
		}
	}
</script>

<style scoped>
	.toast-container {
		position: fixed;
		width: 320px;
		margin: auto;
		bottom: 32px;
		z-index: 100;
		padding-left: 32px;
	}

	.toast {
		background: #fff;
		box-shadow: 0 2px 4px rgba(0, 0, 0, .2), 0 8px 12px rgba(0, 0, 0, .2);
		padding: 16px;
		color: var(--body-fg);
		margin-bottom: 32px;
		border-radius: 0 4px 4px 0;
		border-left: solid 8px var(--accent);
		transition: all 0.5s ease;
	}

	.fade-enter-active, .fade-leave-active {
		opacity: 1;
	}

	.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
	{
		opacity: 0;
	}

</style>
