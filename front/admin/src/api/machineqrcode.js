import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getMachineqrcodetList (params) {
  return getApi('machineqrcode', params)
}

export function addMachineqrcode (data) {
  return postApi('machineqrcode', data)
}

export function updateMachineqrcode (data, id) {
  return putApi('machineqrcode/' + id, data)
}

export function deleteMachineqrcode () {
  return deleteApi()
}
