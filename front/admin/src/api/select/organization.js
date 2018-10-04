import {getApi} from '../../libs/api.request'

export function selectOrganization ({name, page = 1, ...args}) {
  return getApi('select/organization', {
    name,
    page
  })
}
