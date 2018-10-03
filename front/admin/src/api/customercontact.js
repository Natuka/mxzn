import {getApi, postApi, deleteApi, patchApi} from '../libs/api.request'

export function getCustomercontactList (params) {
  return getApi('customercontact', params)
}

export function addCustomercontact (data) {
  return postApi('customercontact', data)
}

export function updateCustomercontact (data, id) {
  return patchApi('customercontact/' + id, data)
}

export function deleteCustomercontact () {
  return deleteApi()
}
