import Vue from 'vue'
import Vuex from 'vuex'

import user from './module/user'
import app from './module/app'
import base from './module/base'
import area from './module/area'
import init from './module/init'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    //
  },
  mutations: {
    //
  },
  actions: {
    //
  },
  modules: {
    user,
    app,
    base,
    area,
    init
  }
})
