// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import iView from 'iview'
import i18n from '@/locale'
import config from '@/config'
import importDirective from '@/directive'
import 'iview/dist/styles/iview.css'
import './index.less'
import '@/assets/icons/iconfont.css'
import custModal from './components/modal/index.vue'
import MxSelect from './components/select/select.vue'
import RemoteSelect from './components/select/remote-select.vue'
import StaticSelect from './components/select/static-select.vue'

import vSelect from 'vue-select'

// import { Select, Option } from 'element-ui'

// import '@/mock'
// 实际打包时应该不引入mock
/* eslint-disable */
// if (process.env.NODE_ENV !== 'production') require('@/mock')
Vue.component('v-select', vSelect)

Vue.component(custModal.name, custModal)
Vue.component(MxSelect.name, MxSelect)
Vue.component(StaticSelect.name, StaticSelect)
Vue.component(RemoteSelect.name, RemoteSelect)

// Vue.component(Select.name, Select)
// Vue.component(Option.name, Option)

Vue.use(iView, {
  i18n: (key, value) => i18n.t(key, value),
  transfer: true
})
Vue.config.productionTip = false
/**
 * @description 全局注册应用配置
 */
Vue.prototype.$config = config
/**
 * 注册指令
 */
importDirective(Vue)

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  i18n,
  store,
  render: h => h(App)
})
