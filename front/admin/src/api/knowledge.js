import {getApi, postApi, deleteApi, putApi} from '../libs/api.request'

export function getKnowledgeList (params) {
  return getApi('knowledge', params)
}

export function addKnowledge (data) {
  return postApi('knowledge', data)
}

export function updateKnowledge (data, id) {
  return putApi('knowledge/' + id, data)
}

export function deleteKnowledge () {
  return deleteApi()
}
