import {getApi} from '../../libs/api.request'

export function selectCustomer ({name, page = 1, ...args}) {
  return getApi('select/customer', {
    name,
    page
  })
}
