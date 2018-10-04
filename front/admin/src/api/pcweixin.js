import {getApi, postApi, deleteApi, patchApi} from '../libs/api.request'

export function getRoleList (params) {
  return getApi('pcweixin', params)
}

export function addRole (data) {
  return postApi('pcwexin', data)
}

export function updateRole (data, id) {
  return patchApi('pcwexin/' + id, data)
}

export function deleteRole () {
  return deleteApi()
}
