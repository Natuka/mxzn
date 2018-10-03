import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getOrderProgressList (params) {
  return getApi('order-progress',params)
}

export function addOrderProgress (data) {
  return postApi('order-progress',data)
}

export function updateOrderProgress (data,id) {
  return patchApi('order-progress/' + id,data)
}

export function deleteOrderProgress () {
  return deleteApi()
}
