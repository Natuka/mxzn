import { fetchGeo } from '../../api/login'
const state = {
    info: {},
    geo: {
        lng: '',
        lat: '',
        address: '',
        city: '',
        province: '',
        street: '',
        district: ''
    }
}

const getters = {
    user({ info }) {
        return info
    },
    isAdmin({ info }) {
        return info.is_admin
    },
    isCustomer({ info }) {
        return info.is_customer
    },
    isEngineer({ info }) {
        return info.is_engineer
    },
    customer({ info }) {
        if (!info.is_customer) {
            return null
        }

        if (!info.info || !info.info.customer) {
            return null
        }

        return info.info.customer
    },
    geo({ geo }) {
        return geo
    }
}

const actions = {
    async setUser({ commit }, info) {
        commit('set_user', info)
    },
    fetchGeo({ commit, state }) {
        fetchGeo(state.geo.lng, state.geo.lat).then(data => {
            if (!data || data.status !== 0) {
                return
            }

            const {
                result: {
                    addressComponent: {
                        adcode,
                        country,
                        district,
                        province,
                        street
                    },
                    formatted_address: address
                }
            } = data

            commit('setGeo', {
                lng: state.geo.lng,
                lat: state.geo.lat,
                country,
                district,
                province,
                street,
                adcode,
                address
            })
        })
    }
}

const mutations = {
    set_user(state, info) {
        localStorage.userId = info.id
        state.info = info
    },
    setGeo(state, geo) {
        console.log('setGeo', geo)
        state.geo = geo
    },
    setLng(state, lng) {
        state.geo.lng = lng
    },
    setLat(state, lat) {
        state.geo.lat = lat
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
