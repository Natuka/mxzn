import { postApi } from '../util/axios'

export function login(mobile, code) {
    return postApi('login', { mobile, code })
}

export function bindMobile(mobile, sms) {
    return postApi('mobile/bind', { mobile, sms })
}
