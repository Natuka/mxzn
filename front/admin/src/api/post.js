import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getPostList (params) {
  return getApi('post', params)
}

export function addPost (data) {
  return postApi('post', data)
}

export function updatePost (data, id) {
  return putApi('post/' + id, data)
}

export function deletePost () {
  return deleteApi()
}
