import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getCustomerList (params) {
  return getApi('customer',params)
}

export function addCustomer (data) {
  return postApi('customer',data)
}

export function updateCustomer (data,id) {
  return patchApi('customer/' + id,data)
}

export function deleteCustomer () {
  return deleteApi()
}
