import {getApi} from '../../libs/api.request'

export function selectCode ({name, page = 1, ...args}) {
  return getApi('select/materiel', {
    name,
    page
  })
}
