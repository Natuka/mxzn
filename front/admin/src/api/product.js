import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getProductList (params) {
  return getApi('product',params)
}

export function addProduct (data) {
  return postApi('product',data)
}

export function updateProduct (data,id) {
  return patchApi('product/' + id,data)
}

export function deleteProduct () {
  return deleteApi()
}
