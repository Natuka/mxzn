import {getApi, postApi, deleteApi, patchApi} from '../libs/api.request'

export function getCustomerequipmentList (params) {
  return getApi('customerequipment', params)
}

export function addCustomerequipment (data) {
  return postApi('customerequipment', data)
}

export function updateCustomerequipment (data, id) {
  return patchApi('customerequipment/' + id, data)
}

export function deleteCustomerequipment () {
  return deleteApi()
}
