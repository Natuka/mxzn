import {provinces, allCities, allDistricts} from '../../api/area'

let state = {
  provinces: [],
  areas: [],
  cities: [],
  districts: [],
  citiesByProvinceId: {}
}

let getters = {
  provinces ({provinces}) {
    return provinces
  },
  areas ({areas}) {
    return areas
  },
  cities ({cities}) {
    return cities
  },
  districts ({districts}) {
    return districts
  },
  getCities ({citiesByProvinceId}) {
    return (provinceId) => {
      return citiesByProvinceId[provinceId] || []
    }
  }
}

let actions = {
  // 初始化省份
  async initProvinces ({commit, state}) {
    if (state.provinces.length) {
      return Promise.resolve(state.provinces)
    }
    let {data} = await provinces({})
    commit('setProvinces', data)
    return data
  },
  async initCities ({commit}) {
    let {data} = await allCities({})
    commit('setAllCities', data)
    return data
  },
  async allDistricts ({commit}) {
    let {data} = await allDistricts({})
    commit('setAllDistricts', data)
    return data
  }
}

let mutations = {
  setProvinces (state, data) {
    state.provinces = data
  },
  setAllCities (state, data) {
    state.cities = data
    state.citiesByProvinceId = formatCities(data)
  },
  setAllDistricts (state, data) {
    state.districts = data
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}

const formatCities = (cities) => {
  let ret = {}
  cities.forEach((info) => {
    if (!ret[info.parent_id]) {
      ret[info.parent_id] = []
    }
    ret[info.parent_id].push(info)
  })

  return ret
}
