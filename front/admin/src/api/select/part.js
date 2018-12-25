import {getApi} from '../../libs/api.request'

export function selectPart ({name, page = 1, ...args}) {
  return getApi('select/part', {
    name,
    page
  })
}
