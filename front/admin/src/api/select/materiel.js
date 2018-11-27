import {getApi} from '../../libs/api.request'

export function selectMateriel ({name, page = 1, ...args}) {
  return getApi('select/materiel', {
    name,
    page
  })
}
