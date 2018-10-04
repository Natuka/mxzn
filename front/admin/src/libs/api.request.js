import HttpRequest from '@/libs/axios'
import config from '@/config'
import {getToken} from './util'

const baseUrl = process.env.NODE_ENV === 'development' ? config.baseUrl.dev : config.baseUrl.pro

const axios = new HttpRequest(baseUrl)
export default axios

// POST 请求
export function postApi (url, data, headers = {}) {
  return axios.request({
    url,
    data,
    headers: withHeaders(headers),
    method: 'post'
  })
}

// 替换
export function putApi (url, data, headers = {}) {
  return axios.request({
    url,
    data,
    headers: withHeaders(headers),
    method: 'put'
  })
}

// 部分修改
export function patchApi (url, data, headers = {}) {
  return axios.request({
    url,
    data,
    headers: withHeaders(headers),
    method: 'patch'
  })
}

// 获取
export function getApi (url, params = {}, headers = {}) {
  return axios.request({
    url,
    params,
    method: 'get',
    headers: withHeaders(headers)
  })
}

export function deleteApi(url, params = {}, headers = {}) {
  return axios.request({
    url,
    params,
    method: 'delete',
    headers: withHeaders(headers)
  })
}

// 添加上头部验证
export function withHeaders (headers) {
  return {
    Authorization: `Bearer ${getToken()}`,
    ...headers
  }
}
