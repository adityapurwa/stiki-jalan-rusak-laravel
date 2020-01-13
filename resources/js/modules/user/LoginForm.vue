<template>
    <Modal title="Login" :visible="visible" @close="$emit('close')">
        <form action="" class="login-form" @submit.prevent="handleSubmit"
              @keypress.enter="handleSubmit">
            <DefaultAlert>
                Masuk untuk membuat laporan kerusakan jalan.
            </DefaultAlert>
            <ErrorAlert v-if="errors.server">
                {{ errors.server }}
            </ErrorAlert>
            <ErrorAlert v-if="errors.login">
                {{ errors.login }}
            </ErrorAlert>
            <TextField name="email" type="email" v-model="email" label="E-mail" :errors="errors.email"></TextField>
            <TextField
                name="password"
                type="password"
                v-model="password"
                label="Password"
                :errors="errors.password"
            ></TextField>
        </form>
        <template class="login-buttons" v-slot:footer="footer">
            <Button
                @click="handleSubmit"
                type="submit" label="Masuk" color="primary" name="submit"
                :loading="isLoading"
            ></Button>
        </template>
    </Modal>
</template>

<script>
    import axe from 'axios'
    import TextField from '../../components/input/TextField'
    import Button from '../../components/input/Button'
    import ErrorAlert from '../../components/alert/ErrorAlert'
    import DefaultAlert from '../../components/alert/DefaultAlert'
    import Modal from '../../components/layout/Modal'

    export default {
        name: 'LoginForm',
        components: { Modal, DefaultAlert, ErrorAlert, Button, TextField },
        props: {
            visible: Boolean
        },
        data () {
            return {
                email: '',
                password: '',
                errors: {},
                isLoading: false
            }
        },
        methods: {
            handleSubmit () {
                this.isLoading = true
                this.errors = {}
                axe.post('login', {
                    email: this.email,
                    password: this.password
                }).then(res => {
                    this.$store.commit('user/setUser', {
                        user: res.data.user
                    })
                    this.$emit('close')
                    window.$bus.$emit('toast', 'Anda berhasil masuk')
                }).catch(err => {
                    if (err.response.status === 422) {
                        this.errors = err.response.data.errors
                    } else if (err.response.status === 400) {
                        this.errors = err.response.data
                    } else if (err.response.status === 500 || err.response.status === 403) {
                        this.errors = {
                            server: err.response.data.error
                        }
                    }
                }).finally(() => this.isLoading = false)
            }
        }
    }
</script>

<style scoped>

</style>
