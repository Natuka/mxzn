import {getApi, postApi, deleteApi, putApi} from '../../libs/api.request'

export function getReviewList (params) {
  return getApi('order_flow/review', params)
}

export function addReview (data) {
  return postApi('order_flow/review', data)
}

export function updateReview (data, id) {
  return putApi('order_flow/review/' + id, data)
}

export function deleteReview () {
  return deleteApi()
}

/**
 * 下一站
 * @param {[type]} data [description]
 */
export function reviewNext (data) {
  return postApi('order_flow/review/next', data)
}

// 创建
export function addReviewAction (data, orderId, type = 'attendance') {
  return postApi(`order_flow/review/${orderId}/${type}`, data)
}

// 更新
export function updateReviewAction (data, id, orderId, type = 'attendance') {
  return postApi(`order_flow/review/${orderId}/${type}/${id}`, data)
}

// 删除
export function deleteReviewAction (id, orderId, type = 'attendance') {
  return deleteApi(`order_flow/review/${orderId}/${type}/${id}`)
}
