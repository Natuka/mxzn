import {getApi, postApi, deleteApi, patchApi} from '../libs/api.request'

export function getRoleList (params) {
  return getApi('role', params)
}

export function addRole (data) {
  return postApi('role', data)
}

export function updateRole (data, id) {
  return patchApi('role/' + id, data)
}

export function deleteRole () {
  return deleteApi()
}
