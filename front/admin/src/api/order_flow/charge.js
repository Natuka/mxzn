import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getChargeList (params) {
  return getApi('order_flow/charge', params)
}

export function addCharge (data) {
  return postApi('order_flow/charge', data)
}

export function updateCharge (data, id) {
  return putApi('order_flow/charge/' + id, data)
}

export function deleteCharge () {
  return deleteApi()
}

/**
 * 退回
 * @param {[type]} data [description]
 */
export function chargeBack (data) {
  return postApi('order_flow/charge/back', data)
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function chargeNext (data) {
  return postApi('order_flow/charge/next', data)
}

// 创建
export function addChargeAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/charge/${orderId}/${type}`, data)
}

// 更新
export function updateChargeAction (data, id, orderId, type = 'attendance') {
  return putApi(`order_flow/charge/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteChargeAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/charge/${orderId}/${type}/${id}`)
}
