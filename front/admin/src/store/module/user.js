import {login, logout, getUserInfo} from '@/api/user'
import {setToken, getToken} from '@/libs/util'

export default {
  state: {
    userName: '',
    userId: '',
    avatorImgPath: '',
    token: getToken(),
    access: [],
    info: {}
  },
  getters: {
    hasAccess ({access}) {
      return acc => access.indexOf(acc) > -1
    }
  },
  mutations: {
    setAvator (state, avatorPath) {
      state.avatorImgPath = avatorPath
    },
    setUserId (state, id) {
      state.userId = id
    },
    setUserName (state, name) {
      state.userName = name
    },
    setAccess (state, access) {
      state.access = access
    },
    setToken (state, token) {
      state.token = token
      setToken(token)
    },
    setUserInfo (state, info) {
      state.info = info
    }
  },
  actions: {
    // 登录
    handleLogin ({commit}, {userName, password}) {
      userName = userName.trim()
      return new Promise((resolve, reject) => {
        login({
          userName,
          password
        }).then(res => {
          const data = res.data
          commit('setToken', data.token)
          resolve()
        }).catch(err => {
          reject(err)
        })
      })
    },
    // 退出登录
    handleLogOut ({state, commit}) {
      return new Promise((resolve, reject) => {
        logout(state.token).then(() => {
          commit('setToken', '')
          commit('setAccess', [])
          resolve()
        }).catch(err => {
          reject(err)
        })
        // 如果你的退出登录无需请求接口，则可以直接使用下面三行代码而无需使用logout调用接口
        // commit('setToken', '')
        // commit('setAccess', [])
        // resolve()
      })
    },
    // 获取用户相关信息
    getUserInfo ({state, commit}) {
      return new Promise((resolve, reject) => {
        if (state.info.id && state.info.id > 0) {
          console.log('state.info', state.info)
          resolve(state.info)
          return
        }
        // state.token
        getUserInfo().then(({data, message}) => {
          // const data = res.data
          commit('setAvator', data.avator)
          commit('setUserName', data.user_name)
          commit('setUserId', data.user_id)
          console.log('access', data.access)
          commit('setAccess', data.access)
          commit('setUserInfo', data)
          resolve(data)
        }).catch(err => {
          reject(err)
        })
      })
    }
  }
}
