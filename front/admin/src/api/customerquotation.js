import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getCustomerquotationList (params) {
  return getApi('customerquotation', params)
}

export function addCustomerquotation (data) {
  return postApi('customerquotation', data)
}

export function updateCustomerquotation (data, id) {
  return putApi('customerquotation/' + id, data)
}

export function deleteCustomerquotation () {
  return deleteApi()
}
