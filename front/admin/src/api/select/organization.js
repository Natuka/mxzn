import {getApi} from '../../libs/api.request'

export function selectOrganization (name, page = 1) {
  return getApi('select/organization', {
    name,
    page
  })
}
