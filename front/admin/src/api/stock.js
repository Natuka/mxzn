import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getStockList (params) {
  return getApi('stock',params)
}

export function addStock (data) {
  return postApi('stock',data)
}

export function updateStock (data,id) {
  return patchApi('stock/' + id,data)
}

export function deleteStock () {
  return deleteApi()
}
