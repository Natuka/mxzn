import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getDisposeList (params) {
  return getApi('order_flow/dispose', params)
}

export function addDispose (data) {
  return postApi('order_flow/dispose', data)
}

export function updateDispose (data, id) {
  return putApi('order_flow/dispose/' + id, data)
}

export function deleteDispose () {
  return deleteApi()
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function disposeNext (data) {
  return postApi('order_flow/dispose/next', data)
}

// 创建
export function addDisposeAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/dispose/${orderId}/${type}`, data)
}

// 更新
export function updateDisposeAction (data, id, orderId, type = 'attendance') {
  return postApi(`order_flow/dispose/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteDisposeAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/dispose/${orderId}/${type}/${id}`)
}
