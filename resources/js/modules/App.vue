<template>
    <div class="app">
        <Toast></Toast>
        <header>
            <h1>
                Lapor Jalan Rusak
            </h1>
            <UserStatus></UserStatus>
        </header>
        <main class="content">
            <section class="main-board">
                <div class="search-box">
                    <TextField @keypress.enter="refreshList" v-model="search" name="search" label="Pencarian"
                               :shadow="true" :borderless="true"></TextField>
                </div>
                <div class="report-feeds">
                    <Board>
                        <header class="report-header">
                            <h4 class="report-header-title">
                                Laporan Terkini
                            </h4>
                            <div class="report-header-buttons" v-if="loggedIn">
                                <Button @click="showReportForm" label="Buat Laporan Baru" name="create"
                                        color="primary"></Button>
                            </div>
                        </header>
                        <ReportList :search="search"></ReportList>
                    </Board>
                </div>
            </section>
        </main>

        <ReportForm
            @close="reportFormVisible = false"
            :visible="reportFormVisible"
            v-if="getLeftBoardContent === 'report' && reportFormVisible"
        ></ReportForm>

    </div>
</template>

<style scoped>
    header {
        display: flex;
        align-items: center;
    }

    header h1 {
        font-size: var(--font-h1);
        font-weight: var(--font-light);
        flex: 1 1 auto;
    }

    header .user-status {
        flex: 0 0 30%;
    }

    footer {
        margin-top: 24px;
        color: rgba(0, 0, 0, .5);
    }

    .app {
        width: 960px;
        margin: 32px auto;
    }

    .content {
        margin: 16px 0;
        display: flex;
    }

    .left-board {
        display: none;
        flex: 0 0 420px;
        margin-right: 24px;
        height: auto;
    }

    .left-board .board {
        height: auto;
    }

    .main-board {
        flex: 1 1 auto;
        height: auto;
        display: flex;
        flex-direction: column;
    }

    .search-box {
        margin-bottom: 8px;
    }

    .search-box input {
        flex: 1 1 auto;
    }

    .report-feeds {
        flex: 1 1 auto;
    }

    .report-header {
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }

    .report-header-title {
        flex: 1 1 auto;
    }

    .report-header-buttons {
        flex: 0 0 auto;
    }

</style>
<script>
    import Board from '../components/layout/Board'
    import TextField from '../components/input/TextField'
    import ReportForm from './report/ReportForm'
    import TermsNotice from './TermsNotice'
    import ReportItem from './report/ReportItem'
    import RegisterForm from './user/RegisterForm'

    import axe from 'axios'
    import UserStatus from './user/UserStatus'
    import LoginForm from './user/LoginForm'
    import CircleButton from '../components/input/CircleButton'
    import Button from '../components/input/Button'
    import ReportList from './report/ReportList'
    import Toast from '../components/notifications/Toast'
    import store from '../data/store'

    export default {
        components: {
            Toast,
            ReportList,
            Button,
            CircleButton,
            LoginForm,
            UserStatus,
            RegisterForm,
            ReportItem,
            TermsNotice,
            ReportForm,
            TextField,
            Board
        },
        data () {
            return {
                userMode: 'register',
                reportFormVisible: false,
                search: ''
            }
        },
        computed: {
            getLeftBoardContent () {
                if (this.loggedIn) {
                    return 'report'
                }
                return this.userMode
            },
            loggedIn () {
                return !!this.$store.state.user.user
            },
            currentUserName () {
                return this.$store.state.user.user.name
            }
        },
        methods: {
            switchUserMode (mode) {
                this.userMode = mode
            },
            showReportForm () {
                this.reportFormVisible = true
            },
            refreshList () {
                window.$bus.$emit('report-list.refresh')
            }
        },
        mounted () {
            if (window.$auth) {
                const userData = window.$auth.user
                if (userData) {
                    console.dir(userData)
                    store.commit('user/setUser', { user: userData })
                }
            }
        }
    }
</script>
