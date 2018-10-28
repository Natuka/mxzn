import fans from '../../api/fans'

const state = {
    all:[],
    total:0,
    accounts:[]
}

const getters = {
    allFans:state => state.all,
    fansCount:state => state.total,
    getAccounts:state =>state.accounts
}

const actions = {
    async getAllFans({commit}, obj){
        let res = await fans.getAllFans(obj)
        commit('recieve_fans', {res})
        return Promise.resolve(res)
    },
    async getAccounts({commit}, query){
        let res = await fans.getAccounts(query)
            commit('get_accounts', {res})
        return Promise.resolve(res)
        
    },
    async getFan({commit}, query){
        let res = await fans.getFan(query)
        return Promise.resolve(res)
    },
    async saveFan({commit}, obj){
        let res = await fans.saveFan(obj)
        return Promise.resolve(res)
    }
}

const mutations = {
    recieve_fans(state, {res}){
        state.all = res.data;
        state.total = res.total;
    },
    get_accounts(state, {accounts}){
        state.accounts = accounts
    }
}

export default{
    state,
    getters,
    actions,
    mutations
}