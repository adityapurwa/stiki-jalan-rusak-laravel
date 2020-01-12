<template>
	<ul class="report-list">
		<DefaultAlert v-if="isReportEmpty && !isLoading">
			Belum ada laporan kerusakan jalan yang bisa ditampilkan
		</DefaultAlert>
		<LoadingIndicator v-if="isLoading" height="150px"></LoadingIndicator>
		<ReportItem v-for="report in reports" :key="report.id" :report="report"></ReportItem>
		<div class="list-buttons">
			<Button
				v-if="!isPeak"
				@click="loadMore"
				color="primary"
				type="button"
				label="Selanjutnya"
				name="loadMore"
			></Button>
		</div>
	</ul>
</template>

<script>
	import ReportItem from './ReportItem';
    import axe from 'axios';
	import DefaultAlert from '../../components/alert/DefaultAlert';
	import LoadingIndicator from '../../components/layout/LoadingIndicator';
	import Button from '../../components/input/Button';

	export default {
		name: 'ReportList',
		components: { Button, LoadingIndicator, DefaultAlert, ReportItem },
		computed: {
			isReportEmpty() {
				return !this.reports || this.reports.length === 0;
			},
			isPeak() {
				return (this.page + 1) * this.reportLimit >= this.reportTotal;
			}
		},
		props: {
			search: String,
		},
		data() {
			return {
				reports: [],
				page: 0,
				reportTotal: 0,
				reportLimit: 0,
				isLoading: false
			}
		},
		mounted() {
			window.$bus.$on('report-list.refresh', () => this.loadReports());
			this.loadReports();
		},
		methods: {
			loadReports(isAppend = false) {
				this.isLoading = true;
				axe.get('list-reports', {
					params: {
						search: this.search,
						page: this.page
					}
				}).then(res => {
					this.reportLimit = res.data.per_page;
					this.reportTotal = res.data.total;
					if (!isAppend) {
						this.reports = res.data.data;
					} else {
						this.reports = this.reports.concat(res.data.data);
					}
				}).finally(() => {
					this.isLoading = false;
				})
			},
			loadMore() {
				this.page++;
				this.loadReports(true);
			},
		}
	}
</script>

<style scoped>

	.list-buttons .button {
		display: block;
		width: 100%;
	}

</style>
