const state = {
    info: {}
}

const getters = {
    user({info}) {
        return info
    }
}

const actions = {
    async setUser ({commit}, info) {
        commit('set_user', info)
    }
}

const mutations = {
    set_user(state, info) {
        localStorage.userId = info.id
        state.info = info
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
