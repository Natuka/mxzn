import { getApi,postApi,deleteApi,patchApi } from '../libs/api.request'

export function getFeedbackList (params) {
  return getApi('feedback',params)
}

export function addFeedback (data) {
  return postApi('feedback',data)
}

export function updateFeedback (data,id) {
  return patchApi('feedback/' + id,data)
}

export function deleteFeedback () {
  return deleteApi()
}
