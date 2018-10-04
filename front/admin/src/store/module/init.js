let actions = {
  // 初始化数据，与用户无关
  init ({dispatch, commit}) {
    dispatch('initProvinces')
    dispatch('initCities')
    dispatch('getJob')
    dispatch('getPost')
    dispatch('getEducation')
  }
}

export default {
  actions
}
