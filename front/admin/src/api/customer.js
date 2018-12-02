import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getCustomerList (params) {
  return getApi('customer', params)
}

export function addCustomer (data) {
  return postApi('customer', data)
}

export function updateCustomer (data, id) {
  return putApi('customer/' + id, data)
}

export function deleteCustomer () {
  return deleteApi()
}
