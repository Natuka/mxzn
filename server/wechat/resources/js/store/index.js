import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import user from './modules/users'
import order from './modules/order'
import init from './modules/init'

export default new Vuex.Store({
  modules: {
      user,
      order,
      init
  }
})
