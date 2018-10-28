import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getMaintainList (params) {
  return getApi('order_flow/maintain', params)
}

export function addMaintain (data) {
  return postApi('order_flow/maintain', data)
}

export function updateMaintain (data, id) {
  return putApi('order_flow/maintain/' + id, data)
}

export function deleteMaintain () {
  return deleteApi()
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function maintainNext (data) {
  return postApi('order_flow/maintain/next', data)
}

// 创建
export function addMaintainAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/maintain/${orderId}/${type}`, data)
}

// 更新
export function updateMaintainAction (data, id, orderId, type = 'attendance') {
  return postApi(`order_flow/maintain/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteMaintainAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/maintain/${orderId}/${type}/${id}`)
}
