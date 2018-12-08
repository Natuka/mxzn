import {getApi} from '../../libs/api.request'

export function selectStaff ({name, page = 1, ...args}) {
  return getApi('select/staff', {
    name,
    page
  })
}
