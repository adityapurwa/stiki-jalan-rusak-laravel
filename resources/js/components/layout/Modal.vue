<template>
	<div class="modal-backdrop" @click.self="$emit('close')" :class="{visible}">
		<div class="modal">
			<header class="modal-header">
				<h4 class="modal-title">
					{{ title }}
				</h4>
			</header>
			<div class="modal-content">
				<slot></slot>
			</div>
			<footer class="modal-footer">
				<slot name="footer"></slot>
			</footer>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'Modal',
		props: {
			title: String,
			visible: Boolean
		},
	}
</script>

<style scoped>
	.modal-backdrop {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 10;
		background: rgba(0, 0, 0, .15);
		display: flex;
		align-items: center;
		justify-content: center;
		visibility: hidden;
		opacity: 0;
		transition: all var(--speed-fast) ease;
	}

	.modal-backdrop.visible {
		visibility: visible;
		opacity: 1;
	}

	.modal-content {
		margin: 16px 0;
	}

	.modal {
		flex: 0 0 auto;
		min-width: 400px;
		min-height: 300px;
		max-width: 600px;
		background: #fff;
		border-radius: var(--border-radius);
		padding: 24px;
		z-index: 11;
		box-shadow: 0 8px 32px rgba(12, 25, 80, 0.25);
	}

	.modal-footer {
		text-align: right;
	}
</style>
