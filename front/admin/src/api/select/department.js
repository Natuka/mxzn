import {getApi} from '../../libs/api.request'

export function selectDepartment (orgId) {
  return getApi('select/department', {
    org_id: orgId
  })
}
