import { getApi, postApi } from '../util/axios'

export function repairList(params = {}) {
    return getApi('repair/list', params)
}

// 创建工单
export function repairCreate(params = {}) {
    return postApi('repair/create', params)
}

// 工单处理
export function repairCreateRepair(serviceOrderId, params = {}) {
    return postApi(`repair/${serviceOrderId}/repair`, params)
}

// 获取信息
export function repairInfo(serviceOrderId, params) {
    return getApi(`repair/${serviceOrderId}/info`, params)
}

// 编辑
export function repairEdit(serviceOrderId, params) {
    return postApi(`repair/${serviceOrderId}`, params)
}

// 切换
export function repairSwitch(serviceOrderId, data) {
    return postApi(`repair/${serviceOrderId}/switch`, data)
}

// 取消
export function repairCancel(serviceOrderId, data) {
    return postApi(`repair/${serviceOrderId}/cancel`, data)
}

// 设备
export function repairEquipment(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/equipment`)
}

// 服务
export function repairService(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/service`)
}

// 签到
export function repairAttendance(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/attendance`)
}

// 操作日志
export function repairLog(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/log`)
}

// 催单
export function repairFollowUp(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/follow-up`)
}
