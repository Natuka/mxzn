import {postApi} from '../util/axios'


export function login (mobile, code) {
    return postApi('login', {mobile, code})
}

export function bind (mobile, sms) {
    return postApi('bind', {mobile, sms})
}
