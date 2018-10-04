import {getApi, postApi, deleteApi, patchApi} from '../../libs/api.request'

const PATH = 'post'

export function getPostList (params) {
  return getApi(PATH, params)
}

export function addPost (data) {
  return postApi(PATH, data)
}

export function updatePost (data, id) {
  return patchApi(PATH + '/' + id, data)
}

export function deletePost () {
  return deleteApi()
}
