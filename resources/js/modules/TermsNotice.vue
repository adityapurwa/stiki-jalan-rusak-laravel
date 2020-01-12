<template>
	<section class="terms-notice">
		<h3 class="terms-title">Syarat dan Ketentuan Penggunaan</h3>
		<p class="terms-paragraph">
			Dengan menggunakan aplikasi ini, anda setuju bahwa pembuat aplikasi ini tidak bertanggung jawab atas kerugian yang
			ditimbulkan akibat penggunaan aplikasi ini. Aplikasi ini disediakan apa adanya tanpa garansi dan tanggung jawab
			dari pembuat aplikasi.
		</p>
		<p class="terms-paragraph">
			Anda setuju bahwa data yang anda kirimkan adalah benar data milik anda sendiri, dan pembuat aplikasi berhak
			menggunakan data tersebut untuk digunakan di aplikasi, atau penggunaan lainnya.
		</p>
	</section>
</template>

<script>
	export default {
		name: 'TermsNotice'
	}
</script>

<style scoped>
	.terms-notice {
		margin-top: 16px;
		color: rgba(0, 0, 0, .5);
	}

	.terms-title {
		font-size: var(--font-normal);
		font-weight: var(--font-heavy);
	}

	.terms-paragraph {
		font-size: var(--font-normal);
		margin-bottom: 8px;
	}
</style>
