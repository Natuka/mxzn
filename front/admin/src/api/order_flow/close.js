import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getCloseList (params) {
  return getApi('order_flow/close', params)
}

export function addClose (data) {
  return postApi('order_flow/close', data)
}

export function updateClose (data, id) {
  return putApi('order_flow/close/' + id, data)
}

export function deleteClose () {
  return deleteApi()
}

/**
 * 退回
 * @param {[type]} data [description]
 */
export function closeBack (data) {
  return postApi('order_flow/close/back', data)
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function closeNext (data) {
  return postApi('order_flow/close/next', data)
}

// 创建
export function addCloseAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/close/${orderId}/${type}`, data)
}

// 更新
export function updateCloseAction (data, id, orderId, type = 'attendance') {
  return postApi(`order_flow/close/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteCloseAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/close/${orderId}/${type}/${id}`)
}
