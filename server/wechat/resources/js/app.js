import Vue from 'vue'
const Vant = require('vant')

import store from './store'

const api = require('./api/index')
// import api from './api'

import router from './router'

import userMixin from './mixins/user'

import './component'

require('./bootstrap')

window.Vue = Vue

Vue.use(Vant)

Vue.mixin(userMixin)

import WxJssdk from '@defy/wx-jssdk'
import VueWxJssdk from '@defy/vue-wx-jssdk'

Vue.use(VueWxJssdk, WxJssdk)

import 'vant/lib/vant-css/index.css'

import App from './components/App'

Object.defineProperty(Vue.prototype, '$api', {
    value: api
})

window.router = router
window.store = store

window.setDocumentTitle = function(title) {
    document.title = title
    if (/ip(hone|od|ad)/i.test(navigator.userAgent)) {
        var i = document.createElement('iframe')
        i.src = '/favicon.ico'
        i.style.display = 'none'
        i.onload = function() {
            setTimeout(function() {
                i.remove()
            }, 9)
        }
        document.body.appendChild(i)
    }
}

Object.defineProperty(Vue.prototype, '$docTitle', {
    value: setDocumentTitle
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
    render(h) {
        return h(App)
    }
})

window.app = app
