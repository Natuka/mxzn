import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getConfirmList (params) {
  return getApi('order_flow/confirm', params)
}

export function addConfirm (data) {
  return postApi('order_flow/confirm', data)
}

export function updateConfirm (data, id) {
  return putApi('order_flow/confirm/' + id, data)
}

export function deleteConfirm () {
  return deleteApi()
}

/**
 * 退回
 * @param {[type]} data [description]
 */
export function confirmBack (data) {
  return postApi('order_flow/confirm/back', data)
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function confirmNext (data) {
  return postApi('order_flow/confirm/next', data)
}

// 创建
export function addConfirmAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/confirm/${orderId}/${type}`, data)
}

// 更新
export function updateConfirmAction (data, id, orderId, type = 'attendance') {
  return putApi(`order_flow/confirm/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteConfirmAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/confirm/${orderId}/${type}/${id}`)
}
