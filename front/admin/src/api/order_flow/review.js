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
