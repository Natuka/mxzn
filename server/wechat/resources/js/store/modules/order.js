import { order } from '../../const/service-order'
const state = {
    info: {
        ...order
    }
}

const getters = {
    serviceOrder({ info }) {
        return info
    },
    order({ info }) {
        return info
    },
    fault({ info }) {
        if (info.fault.length) {
            return info.fault[0]
        }
        return {}
    },
    equipment({ info }) {
        if (info.fault.length) {
            return info.fault[0].equipment || {}
        }
        return {}
    }
}

const actions = {
    async setServiceOrder({ commit }, info) {
        commit('set_service_order', info)
    }
}

const mutations = {
    set_service_order(state, info) {
        state.info = info
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
