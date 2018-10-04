import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getRepairList (params) {
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
