<template>
    <li class="report-item">
        <div class="report-text">
            <div class="report-meta">
                <div class="report-author">
                    {{ report.user_name }}
                </div>
                <time class="report-time">
                    {{ report.created_at | date }}
                </time>
                <div class="report-support">
                    {{ report.cache_votes }} dukungan
                    <template v-if="report.my_vote === 'positive'">
                        - Anda mendukung laporan ini
                    </template>
                    <template v-if="report.my_vote === 'negative'">
                        - Anda melaporkan laporan ini sebagai palsu
                    </template>
                </div>
            </div>
            <address class="report-address">
                {{ report.address }}
            </address>
            <div class="report-actions" v-if="isLoggedIn">
                <Button
                    v-if="!report.my_vote"
                    @click="downvote"
                    :loading="isLoading"
                    type="button"
                    name="report"
                    label="Tandai Palsu"
                ></Button>
                <Button
                    v-if="!report.my_vote"
                    @click="upvote"
                    :loading="isLoading"
                    color="primary"
                    type="button"
                    name="report"
                    label="Dukung"
                ></Button>
                <Button
                    v-if="report.my_vote === 'positive'"
                    @click="clearvote(-1)"
                    :loading="isLoading"
                    type="button"
                    name="report"
                    label="Batalkan Dukungan"
                ></Button>
                <Button
                    v-if="report.my_vote === 'negative'"
                    @click="clearvote(1)"
                    :loading="isLoading"
                    type="button"
                    name="report"
                    label="Batalkan Laporan Palsu"
                ></Button>
            </div>
        </div>
        <img class="report-image" :src="getReportImageUrl" @click="imageZoomed = true"/>
        <Modal :title="report.address" :visible="imageZoomed" @close="imageZoomed = false">
            <img class="report-image-zoomed" :src="getReportImageUrl"/>
        </Modal>
    </li>
</template>

<script>
    import Button from '../../components/input/Button'
    import Modal from '../../components/layout/Modal'
    import axe from 'axios'

    export default {
        name: 'ReportItem',
        components: { Modal, Button },
        data () {
            return {
                imageZoomed: false,
                isLoading: false,
            }
        },
        props: {
            report: Object
        },
        computed: {
            getReportImageUrl () {
                return `/storage/${this.report.photo}`
            },
            isLoggedIn () {
                return !!this.$store.state.user.user
            }
        },
        filters: {
            date: function (val) {
                const date = new Date(val)
                const dateFormat = new Intl.DateTimeFormat('id-ID')
                return `${dateFormat.format(date)}, ${date.getHours()}:${date.getMinutes()}`
            }
        },
        methods: {
            upvote () {
                this.isLoading = true
                axe.post('vote-report', {
                    report_id: this.report.id,
                    type: 'positive'
                }).then(res => {
                    this.report.my_vote = 'positive'
                    this.report.cache_votes++
                }).catch(err => {

                }).finally(() => {
                    this.isLoading = false

                })
            },
            downvote () {
                this.isLoading = true
                axe.post('vote-report', {
                    report_id: this.report.id,
                    type: 'negative'
                }).then(res => {
                    this.report.my_vote = 'negative'
                    this.report.cache_votes--
                }).catch(err => {

                }).finally(() => {
                    this.isLoading = false
                })
            },
            clearvote (delta) {
                this.isLoading = true
                axe.post('vote-report', {
                    report_id: this.report.id,
                    type: 'clear'
                }).then(res => {
                    this.report.my_vote = null
                    this.report.cache_votes += delta
                }).catch(err => {
                }).finally(() => {
                    this.isLoading = false
                })
            }
        }
    }
</script>

<style scoped>
    .report-item {
        display: flex;
        border: solid 1px rgba(0, 0, 0, .1);
        margin: 24px 0;
    }

    .report-item:first-child {
        margin-top: 0;
    }

    .report-item:last-child {
        margin-bottom: 0;
    }

    .report-text {
        flex: 0 0 45%;
        padding: 16px;
    }

    .report-author {
        font-weight: var(--font-heavy);
    }

    .report-time, .report-support {
        font-size: var(--font-small);
        color: rgba(0, 0, 0, .5);
    }

    .report-address {
        margin: 8px 0;
        font-size: var(--font-normal);
        font-style: normal;
        color: rgba(0, 0, 0, .75);
    }

    .report-actions {
        display: flex;
    }

    .report-actions .button {
        flex: 1 1 50%;
    }

    .report-actions .button:first-child {
        margin-right: 16px;
    }

    .report-image {
        flex: 1 1 auto;
        width: 0;
        background: var(--body-bg);
        height: 140px;
        object-fit: cover;
    }

    .report-image-zoomed {
        width: 400px;
        height: 400px;
        object-fit: contain;
        background: #555;
        box-shadow: inset 0 8px 8px rgba(0, 0, 0, .25);
    }
</style>
