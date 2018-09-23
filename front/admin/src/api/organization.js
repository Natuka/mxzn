import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getOrganizationList (params) {
  return getApi('organization', params)
}

export function addOrganization (data) {
  return postApi('organization', data)
}

export function updateOrganization (data, id) {
  return putApi('organization/' + id, data)
}

export function deleteOrganization () {
  return deleteApi()
}
