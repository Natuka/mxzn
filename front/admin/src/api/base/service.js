import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

const PATH = 'service'

export function getServiceList (params) {
  return getApi(PATH, params)
}

export function addService (data) {
  return postApi(PATH, data)
}

export function updateService (data, id) {
  return putApi(PATH + '/' + id, data)
}

export function deleteService () {
  return deleteApi()
}
