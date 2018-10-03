import {getApi} from '../../libs/api.request'

export async function baseConfig (name, page = 1) {
  return getApi(`base/${name}`, {
    page
  })
}

// 获取职位
export async function basePost () {
  return baseConfig('post')
}

// 获取职务
export async function baseJob () {
  return baseConfig('job')
}

// TODO 学历
export async function baseEducation () {
  return baseConfig('education')
}
