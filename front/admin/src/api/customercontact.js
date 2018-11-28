import {getApi, postApi, deleteApi, patchApi, putApi} from '../libs/api.request'

export function getCustomercontactList (params) {
  return getApi('customercontact', params)
}

export function addCustomercontact (data) {
  return postApi('customercontact', data)
}

export function updateCustomercontact (data, id) {
  return putApi('customercontact/' + id, data)
}

export function deleteCustomercontact () {
  return deleteApi()
}
