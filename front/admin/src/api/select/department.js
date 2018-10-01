import {getApi} from '../../libs/api.request'

export function selectDepartment (name, page = 1) {
  return getApi('select/department', {
    name,
    page
  })
}
