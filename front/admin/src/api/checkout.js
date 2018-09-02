import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getCheckoutList (params) {
  return getApi('checkout',params)
}

export function addCheckout (data) {
  return postApi('checkout',data)
}

export function updateCheckout (data,id) {
  return patchApi('checkout/' + id,data)
}

export function deleteCheckout () {
  return deleteApi()
}
