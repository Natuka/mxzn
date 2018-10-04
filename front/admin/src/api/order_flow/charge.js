import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getChargeList (params) {
  return getApi('order_flow/charge', params)
}

export function addCharge (data) {
  return postApi('order_flow/charge', data)
}

export function updateCharge (data, id) {
  return putApi('order_flow/charge/' + id, data)
}

export function deleteCharge () {
  return deleteApi()
}
