import Vue from 'vue'
const Vant = require('vant')

import store from './store'

const api = require('./api/index')
// import api from './api'

import router from './router'

require('./bootstrap');

window.Vue = Vue

Vue.use(Vant)

import 'vant/lib/vant-css/index.css'

import App from './components/App'

Object.defineProperty(Vue.prototype, '$api', {
    value: api
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    router,
    store,
    el: '#app',
    render (h) {
        return h(App)
    }
})
