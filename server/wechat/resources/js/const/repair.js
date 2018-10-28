export const list = [{
    name: '全部',
    type: 0,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '待处理',
    type: 1,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '处理中',
    type: 2,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '待结算',
    type: 3,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '已完成',
    type: 4,
    data: [],
    page: 1,
    finished: false,
    loading: false
}]

export const ORDER_STATUS = '制单中,已受理,待派单,处理中,已取消,已关闭,无法处理'.split(',')
