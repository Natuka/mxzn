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
