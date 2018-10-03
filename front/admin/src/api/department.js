import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getDepartmentList (params) {
  return getApi('department', params)
}

export function addDepartment (data) {
  return postApi('department', data)
}

export function updateDepartment (data, id) {
  return putApi('department/' + id, data)
}

export function deleteDepartment () {
  return deleteApi()
}
