import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import user from './modules/users'
import order from './modules/order'

export default new Vuex.Store({
  actions: {
    setBreadcrumb (context, breadcrumbdata) {
      //state.breadcrumbdata = breadcrumbdata
      //console.log(breadcrumbdata)
      context.commit('setBreadcrumb', breadcrumbdata)
    },
    async getDaily (context, obj) {
      let data = await dashboard.getDaily(obj)
      context.commit('showdaily', data)
      return Promise.resolve(data)
    },
    async getIncreasePayUser (context, obj) {
      let data = await dashboard.getIncreasePayUser(obj)
      return Promise.resolve(data)
    },
    async getDecreasePayUser (context, obj) {
      let data = await dashboard.getDecreasePayUser(obj)
      return Promise.resolve(data)
    },
    async getUserCharts ({ commit }, obj) {
      let data = await dashboard.getUserCharts(obj)
      return Promise.resolve(data)
    },
    async getStatistics (context, obj) {
      let data = await dashboard.getStatistics(obj)
      context.commit('setStatistics', data)
      return Promise.resolve(data)
    },
    async getCompanies ({ commit }, obj) {
      let data = await dashboard.getCompanies(obj)
      return Promise.resolve(data)
    }
  },
  getters: {
    breadcrumbdata1: state => state.breadcrumbdata,
    dailydata: state => state.dailydata,
    dailytotal: state => state.dailytotal,
    statisticsdata: state => state.statisticsdata,
  },
  state: {
    app: {
      name: ''
    },
    user: {
      username: '',
      roles: [],
      menus: [],
      routes: [],
      apis: []
    },
    breadcrumbdata: [{
      href: '',
      name: 'hah'
    }, {
      href: '',
      name: '测试2'
    }],
    dailydata: [],
    dailytotal: 0,
    statisticsdata: [],
  },
  mutations: {
    save_user_info (state, payload) {
      state.user = payload
    },
    flush_local_user_info (state) {
      state.user = {
        username: '',
        roles: [],
        menus: [],
        routes: [],
        apis: []
      }
    },
    flush_session (state) {

    },
    setBreadcrumb (state, breadcrumbdata) {
      state.breadcrumbdata = breadcrumbdata
    },
    showdaily (state, data) {
      state.dailydata = data.data
      state.dailytotal = data.total
    },
    setStatistics (state, data) {
      state.statisticsdata = data.data
    }
  },
  modules: {
      user,
      order
  }
})
