import {getApi} from '../../libs/api.request'

export function selectStaff ({id, name, page = 1, ...args}) {
  return getApi('select/staff', {
    id,
    name,
    page
  })
}
