import {getApi, postApi, deleteApi, patchApi} from '../libs/api.request'

export function getStaffList (params) {
  return getApi('staff', params)
}

export function addStaff (data) {
  return postApi('staff', data)
}

export function updateStaff (data, id) {
  return patchApi('staff/' + id, data)
}

export function deleteStaff () {
  return deleteApi()
}
