import {getApi} from '../../libs/api.request'

export function selectDepartment (orgId, Id = 0) {
  return getApi('select/department', {
    org_id: orgId,
    id: Id
  })
}
