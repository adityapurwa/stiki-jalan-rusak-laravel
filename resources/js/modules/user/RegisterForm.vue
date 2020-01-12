<template>
    <Modal title="Daftar" :visible="visible" @close="$emit('close')">
        <form action="/register" class="register-form" method="post"
        @submit.prevent="handleSubmit">
            <ErrorAlert v-if="errors.server">
                {{ errors.server }}
            </ErrorAlert>
            <TextField name="email" type="email" v-model="email" label="E-mail" :errors="errors.email"></TextField>
            <TextField name="text" type="name" v-model="name" label="Nama" :errors="errors.name"></TextField>
            <TextField
                name="password"
                type="password"
                v-model="password"
                label="Password"
                :errors="errors.password"
            ></TextField>
        </form>
        <template v-slot:footer>
            <Button
                @click="handleSubmit"
                type="submit" label="Daftar" color="primary" name="submit"
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
        name: 'RegisterForm',
        components: { Modal, DefaultAlert, ErrorAlert, Button, TextField },
        props: {
            visible: Boolean
        },
        data () {
            return {
                email: '',
                password: '',
                name: '',
                errors: {},
                isLoading: false
            }
        },
        methods: {
            handleSubmit () {
                this.isLoading = true
                this.errors = {}
                axe.post('/register', {
                    email: this.email,
                    name: this.name,
                    password: this.password
                }).then(res => {
                    this.$store.commit('user/setUser', {
                        user: res.data.user
                    })
                    this.$emit('close')
                    window.$bus.$emit('toast', 'Anda berhasil daftar dan secara otomatis masuk')
                }).catch(err => {
                    if (err.response.status === 400) {
                        this.errors = err.response.data
                    } else if (err.response.status === 500) {
                        this.errors = {
                            server: err.response.data.message ? err.response.data.message : err.response.data.error
                        }
                    }
                }).finally(() => this.isLoading = false)
            }
        }
    }
</script>

<style scoped>
    .register-buttons {
        display: flex;
        text-align: right;
    }

    .register-buttons .circle-button {
        flex: 1 1 auto;
    }

    .register-buttons .circle-button:first-child {
        margin-right: 8px;
    }
</style>
