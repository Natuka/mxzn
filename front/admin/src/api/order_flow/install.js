import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getInstallList (params) {
  return getApi('order_flow/install', params)
}

export function addInstall (data) {
  return postApi('order_flow/install', data)
}

export function updateInstall (data, id) {
  return putApi('order_flow/install/' + id, data)
}

export function deleteInstall () {
  return deleteApi()
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function installNext (data) {
  return postApi('order_flow/install/next', data)
}

// 创建
export function addInstallAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/install/${orderId}/${type}`, data)
}

// 更新
export function updateInstallAction (data, id, orderId, type = 'attendance') {
  return postApi(`order_flow/install/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteInstallAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/install/${orderId}/${type}/${id}`)
}
