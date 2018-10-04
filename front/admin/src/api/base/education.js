import {getApi, postApi, deleteApi, patchApi} from '../../libs/api.request'

const PATH = 'education'

export function getEducationList (params) {
  return getApi(PATH, params)
}

export function addEducation (data) {
  return postApi(PATH, data)
}

export function updateEducation (data, id) {
  return patchApi(PATH + '/' + id, data)
}

export function deleteEducation () {
  return deleteApi()
}
