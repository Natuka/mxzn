import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

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
