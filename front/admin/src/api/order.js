import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getOrderList (params) {
  return getApi('order',params)
}

export function addOrder (data) {
  return postApi('order',data)
}

export function updateOrder (data,id) {
  return patchApi('order/' + id,data)
}

export function deleteOrder () {
  return deleteApi()
}
