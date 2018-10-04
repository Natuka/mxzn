import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

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
