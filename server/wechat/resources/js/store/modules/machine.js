import { repair } from '../../config/repair'

const state = {
    list: [],
    info: {}
}

const getters = {
    machines({ list }) {
        return item => list.find(el => el.id === item.id)
    },
    machine({ info }) {
        return info
    }
}

const actions = {}

const mutations = {
    set_machine_info(state, info) {
        state.info = info
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
