import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getDispatchList (params) {
  return getApi('order_flow/dispatch', params)
}

export function addDispatch (data) {
  return postApi('order_flow/dispatch', data)
}

export function updateDispatch (data, id) {
  return putApi('order_flow/dispatch/' + id, data)
}

export function deleteDispatch () {
  return deleteApi()
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function dispatchNext (data) {
  return postApi('order_flow/dispatch/next', data)
}

// 创建
export function addDispatchAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/dispatch/${orderId}/${type}`, data)
}

// 更新
export function updateDispatchAction (data, id, orderId, type = 'attendance') {
  return postApi(`order_flow/dispatch/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteDispatchAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/dispatch/${orderId}/${type}/${id}`)
}
