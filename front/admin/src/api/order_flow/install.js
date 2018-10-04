import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getInstallList (params) {
  return getApi('order_flow/install', params)
}

export function addInstall (data) {
  return postApi('order_flow/install', data)
}

export function updateInstall (data, id) {
  return putApi('order_flow/install/' + id, data)
}

export function deleteInstall () {
  return deleteApi()
}
