import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

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
