import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getAssetsList (params) {
  return getApi('assets',params)
}

export function addAssets (data) {
  return postApi('assets',data)
}

export function updateAssets (data,id) {
  return patchApi('assets/' + id,data)
}

export function deleteAssets () {
  return deleteApi()
}
