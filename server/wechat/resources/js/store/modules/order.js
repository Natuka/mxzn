const state = {
    info: {}
}

const getters = {
    sreviceOrder({ info }) {
        return info
    },
    order({ info }) {
        return info
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
