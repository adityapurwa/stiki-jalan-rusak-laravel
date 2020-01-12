<template>
    <div class="user-status">
        <h4 class="user-title" v-if="currentUser">
            Hi {{ currentUser.name }},
        </h4>
        <form action="logout" method="post" v-if="currentUser">
            <Button label="Keluar" name="logout" type="submit"></Button>
        </form>
        <Button v-if="!currentUser" label="Daftar" name="register" type="button" @click="showRegister"></Button>
        <Button color="primary" v-if="!currentUser" label="Masuk" name="login" type="button"
                @click="showLogin"></Button>
        <LoginForm @close="loginModal = false" :visible="loginModal"></LoginForm>
        <RegisterForm @close="registerModal = false" :visible="registerModal"></RegisterForm>
    </div>
</template>

<script>
    import DefaultAlert from '../../components/alert/DefaultAlert'
    import Button from '../../components/input/Button'
    import LoginForm from './LoginForm'
    import RegisterForm from './RegisterForm'

    export default {
        name: 'UserStatus',
        components: { RegisterForm, LoginForm, Button, DefaultAlert },
        data () {
            return {
                loginModal: false,
                registerModal: false
            }
        },
        computed: {
            currentUser () {
                return this.$store.state.user.user
            },
        },
        methods: {
            logout () {

            },
            showLogin () {
                this.loginModal = true
            },
            showRegister () {
                this.registerModal = true
            }
        }
    }
</script>

<style scoped>

    .user-status {
        background: #FFF;
        padding: 12px 16px;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        box-shadow: var(--l1-shadow);
    }

    .user-status .user-title {
        flex: 1 1 auto;
    }

    .user-status .button {
        flex: 1 1 auto;
    }

    .user-status .button:first-child {
        margin-right: 8px;
    }

</style>
