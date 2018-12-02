import { getApi, postApi } from '../util/axios'

// 获取
export function saveEvaluate(orderId = 0, params) {
    return postApi(`repair/evaluate/${orderId}`, params)
}
