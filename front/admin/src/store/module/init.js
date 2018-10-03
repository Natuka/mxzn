let actions = {
  init ({dispatch, commit}) {
    dispatch('initProvince')
    dispatch('initCities')
  }
}

export default {
  actions
}
