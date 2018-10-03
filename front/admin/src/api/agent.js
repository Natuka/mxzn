import {getApi, postApi, deleteApi, patchApi} from '../libs/api.request'

export function getRoleList (params) {
  return getApi('agent', params)
}

export function addRole (data) {
  return postApi('agent', data)
}

export function updateRole (data, id) {
  return patchApi('agent/' + id, data)
}

export function deleteRole () {
  return deleteApi()
}
