import {getApi} from '../../libs/api.request'

export function selectCustomer ({id, name, page = 1, ...args}) {
  return getApi('select/customer', {
    id,
    name,
    page
  })
}
