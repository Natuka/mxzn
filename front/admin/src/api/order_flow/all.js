import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getAllList (params) {
  return getApi('order_flow/all', params)
}

export function addAll (data) {
  return postApi('order_flow/all', data)
}

export function updateAll (data, id) {
  return putApi('order_flow/all/' + id, data)
}

export function deleteAll () {
  return deleteApi()
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function allNext (data) {
  return postApi('order_flow/all/next', data)
}

// 创建
export function addAllAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/all/${orderId}/${type}`, data)
}

// 更新
export function updateAllAction (data, id, orderId, type = 'attendance') {
  return putApi(`order_flow/all/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteAllAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/all/${orderId}/${type}/${id}`)
}
