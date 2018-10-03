import {getApi, postApi, deleteApi, patchApi} from '../libs/api.request'

export function getMachineList (params) {
  return getApi('machine', params)
}

export function addMachine (data) {
  return postApi('machine', data)
}

export function updateMachine (data, id) {
  return patchApi('machine/' + id, data)
}

export function deleteMachine () {
  return deleteApi()
}
