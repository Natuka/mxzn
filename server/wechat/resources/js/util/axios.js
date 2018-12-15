import config from '../config/api-config'
import axios from 'axios'
import util from './util'
import auth from '../auth'
import url from 'url'
import store from '../store'

import { Toast } from 'vant'

const instance = axios.create({
    baseURL: config.host,
    timeout: 15000,
    maxRedirects: 0,
    headers: { Authorization: 'Bearer ' + localStorage.token }
})
// 无需做权限拦截的 uri 列表
const except_api_uris = []
// 拦截所有的 api 请求，未来可做缓存/代理等
instance.interceptors.request.use(
    config => {
        let target_url = config.url
        let target = url.parse(target_url)

        // TODO 发向站外的 ajax 请求暂时无法做权限拦截
        if (target.hostname !== location.hostname) {
            return config
        }

        let target_api_uri = target.pathname.substring(
            '/'.length,
            target.pathname.length
        )
        if (except_api_uris.includes(target_api_uri)) {
            return config
        }

        /*
    let user_has_api = store.state.user.apis.some(use_api => user_api_uri === target_api_uri)
    if(!user_has_api){
        Message.info({
            content:'抱歉，你没有权限',
            duration:3
        })
        return Promise.reject('cancelled locally')
    }*/
        // loading
        return config
    },
    error => {
        return Promise.reject(error)
    }
)
// 拦截所有的 api 响应，此处会检查会话是否已过期
instance.interceptors.response.use(
    response => {
        const json_response = response.data

        if (typeof json_response === 'object' && !('code' in json_response)) {
            return Promise.resolve(json_response)
        }

        if (json_response.code === 0) {
            return Promise.resolve(json_response.data)
        }

        Toast({
            message: json_response.message,
            duration: 3000
        })

        if (json_response.code === 1001) {
            store.dispatch('flush_local_user_info')
            return Promise.reject(json_response)
        }

        return Promise.reject(json_response)
    },
    error => {
        if (error === 'cancelled locally') {
            return Promise.reject(error)
        }
        console.log(error)
        if (error.response.status === 429) {
            Toast({
                message: '你的请求频率太快啦',
                duration: 3
            })
            return Promise.reject(error)
        }

        Toast({
            message: '网络异常，请稍后再试！',
            duration: 3
        })
        return Promise.reject(error)
    }
)

export default instance

export function postApi(path, data = {}) {
    return instance.post(path, data)
}

export function getApi(path, params = {}) {
    return instance.get(path, {
        params
    })
}
