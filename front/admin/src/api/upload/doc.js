import {getApi} from '@/libs/api.request'

export const getDocList = (ids = []) => {
  return getApi('file/doc/list', {ids})
}
