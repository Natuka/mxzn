import axios from '@/libs/api.request'
import {getApi, postApi} from '../libs/api.request'

export const login = ({userName, password}) => {
  const data = {
    account: userName,
    password
  }

  return postApi('user/login', data)
}

// 实时请求权限是个不错的选择，但是为了性能，可能不能这么进行处理
export const getUserInfo = (token) => {
  return getApi('user/info', {})
}

export const logout = (token) => {
  return axios.request({
    url: 'logout',
    method: 'post'
  })
}
