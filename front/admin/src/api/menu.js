import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getMenuList (params) {
  return getApi('menu',params)
}

export function addMenu (data) {
  return postApi('menu',data)
}

export function updateMenu (data,id) {
  return patchApi('menu/' + id,data)
}

export function deleteMenu () {
  return deleteApi()
}
