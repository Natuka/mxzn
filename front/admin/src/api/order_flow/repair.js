import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getOrderFlowRepairList (params) {
  return getApi('order_flow/repair', params)
}

export function addRepair (data) {
  return postApi('order_flow/repair', data)
}

export function updateRepair (data, id) {
  return putApi('order_flow/repair/' + id, data)
}

export function deleteRepair () {
  return deleteApi()
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function repairNext (data) {
  return postApi('order_flow/repair/next', data)
}

/**
 * 完工
 * @param {[type]} data [description]
 */
export function repairFinished (data) {
  return postApi('order_flow/repair/finished', data)
}

// 创建
export function addRepairAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/repair/${orderId}/${type}`, data)
}

// 更新
export function updateRepairAction (data, id, orderId, type = 'attendance') {
  console.log('onSubmit IN', orderId, type)
  return putApi(`order_flow/repair/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteRepairAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/repair/${orderId}/${type}/${id}`)
}
