import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import user from './modules/users'
import order from './modules/order'
import repair from './modules/repair'
import engineer from './modules/engineer'
import init from './modules/init'

export default new Vuex.Store({
    modules: {
        user,
        order,
        repair,
        engineer,
        init
    }
})
