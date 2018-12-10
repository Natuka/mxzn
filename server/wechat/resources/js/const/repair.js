export const list = [
    {
        name: '全部',
        type: 0,
        data: [],
        page: 1,
        finished: false,
        loading: false
    },
    {
        name: '待处理',
        type: 1,
        data: [],
        page: 1,
        finished: false,
        loading: false
    },
    {
        name: '处理中',
        type: 2,
        data: [],
        page: 1,
        finished: false,
        loading: false
    },
    {
        name: '待结算',
        type: 3,
        data: [],
        page: 1,
        finished: false,
        loading: false
    },
    {
        name: '已完成',
        type: 4,
        data: [],
        page: 1,
        finished: false,
        loading: false
    }
]

export const ORDER_LEVEL = '请选择,A级,B级,C级,D级'.split(',')
export const ORDER_STATUS = '制单中,已受理,待派单,处理中,已取消,已关闭,无法处理'.split(
    ','
)
export const ORDER_DEGREE = '请选择,非常紧急,紧急,一般'.split(',')
export const ORDER_TYPE = '请选择,安装工单,保养工单,维修工单,投诉工单,巡检工单,移机调试,工艺调试,试焊申请,设备整改,培训工单'.split(
    ','
)
export const FAULT_TYPE = '无,系统,单机,配件,损耗件,其他'.split(',')
export const SEQUENCE_TYPE = '无,偶尔发生,经常出现,一直出现'.split(',')
export const LINE_BROKEN = '否,是,未知'.split(',')
export const PART_BROKEN = '否,是,未知'.split(',')
export const MACHINE_TYPE = '请选择,软件故障,硬件故障,软硬件故障,待定'.split(
    ','
)

// 处理进度
export const REPAIR_PROCESS = '请选择,故障检测中,配件维修中,等待配件更换,测试观察中,已处理完成,不能处理,其他'.split(
    ','
)
export const REPAIR_NEXT = '暂不关闭,完工关闭,内部派工,派给网点'.split(',')
