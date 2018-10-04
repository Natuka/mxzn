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
