import {getApi} from '../libs/api.request'

/**
 * 搜寻条件
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
export function areas (data = {}) {
  return getApi('areas', data)
}

/**
 * 添加
 * @param {[type]} data [description]
 */
export function provinces (data) {
  return getApi('areas/provinces')
}

/**
 * 添加
 * @param {[type]} data [description]
 */
export function cities (parentId = 0, level = 1) {
  parentId = parentId || 0
  return getApi(`areas/${parentId}/list/${level}`)
}

/**
 * 添加
 * @param {[type]} data [description]
 */
export function allCities () {
  return getApi(`areas/cities`)
}
