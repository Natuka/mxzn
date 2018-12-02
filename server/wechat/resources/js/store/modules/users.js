const state = {
    info: {}
}

const getters = {
    user({ info }) {
        return info
    },
    isAdmin({ info }) {
        return info.is_admin
    },
    isCustomer({ info }) {
        return ingo.is_customer
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
    }
}

const actions = {
    async setUser({ commit }, info) {
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
