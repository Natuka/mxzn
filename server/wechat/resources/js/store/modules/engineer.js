import { repair } from '../../config/repair'

const state = {
    list: []
}

const getters = {
    isSelectedEngineer({ list }) {
        return item => list.find(el => el.id === item.id)
    },
    engineers({ list }) {
        return list
    }
}

const actions = {}

const mutations = {
    reset(state) {
        state.data = { ...repair }
        state.project = {}
        state.part = {}
    },
    toggleEngineer(state, item) {
        const index = state.list.findIndex(el => el.id === item.id)
        if (index >= 0) {
            state.list.splice(index, 1)
        } else {
            state.list.push(item)
        }
    },
    removeEngineer(state, index) {
        state.list.splice(index, 1)
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
