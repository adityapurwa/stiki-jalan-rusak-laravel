require('./bootstrap')

import Vue from 'vue'

import App from './modules/App'

import store from './data/store'

window.$bus = new Vue()

const app = new Vue({
    el: '#app',
    store: store,
    render: h => h(App),
    mounted () {
    }
})

