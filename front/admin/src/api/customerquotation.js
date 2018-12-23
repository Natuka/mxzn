import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getCustomerquotationList (params) {
  return getApi('customerquotation', params)
}

export function addCustomerquotation (data) {
  return postApi('customerquotation', data)
}

export function updateCustomerquotation (data, id) {
  return putApi('customerquotation/' + id, data)
}

export function deleteCustomerquotation () {
  return deleteApi()
}

/**
 * 审核
 * @param {[type]} data [description]
 */
export function customerquotationAuditing (data) {
  return postApi('customerquotation/auditing', data)
}

/**
 * 转工单
 * @param {[type]} data [description]
 */
export function customerquotationToOrder (data) {
  return postApi('customerquotation/toorder', data)
}

/**
 * 复制
 * @param {[type]} data [description]
 */
export function customerquotationCopy (data) {
  return postApi('customerquotation/copy', data)
}

// 创建
export function addMaterielAction (data, quotationId, type = 'materiel') {
  return postApi(`customerquotation/${quotationId}/${type}`, data)
}

// 更新
export function updateMaterielAction (data, id, quotationId, type = 'materiel') {
  console.log('onSubmit IN34556', quotationId, type)
  return putApi(`customerquotation/${quotationId}/${type}/${id}`, data)
}

// 删除
export function deleteMaterielAction (id, quotationId, type = 'materiel') {
  return deleteApi(`customerquotation/${quotationId}/${type}/${id}`)
}
