import {getApi} from '../../libs/api.request'

export function selectEngineer (orgId) {
  return getApi('select/engineer', {
    org_id: orgId
  })
}
