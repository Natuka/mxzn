import {getApi} from '../../libs/api.request'

export function selectServiceOrder ({number, page = 1, ...args}) {
  return getApi('select/serviceorder', {
    number,
    page
  })
}
