import {getApi, postApi, deleteApi, patchApi} from '../../libs/api.request'

const PATH = 'job'

export function getJobList (params) {
  return getApi(PATH, params)
}

export function addJob (data) {
  return postApi(PATH, data)
}

export function updateJob (data, id) {
  return patchApi(PATH + '/' + id, data)
}

export function deleteJob () {
  return deleteApi()
}
