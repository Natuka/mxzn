import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getJobList (params) {
  return getApi('job', params)
}

export function addJob (data) {
  return postApi('job', data)
}

export function updateJob (data, id) {
  return putApi('job/' + id, data)
}

export function deleteJob () {
  return deleteApi()
}
